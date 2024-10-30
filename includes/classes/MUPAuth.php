<?php


class MUPAuth {
    static public function init() {
        add_action( 'init', [ __CLASS__, 'mup_redirect_default_register' ] );
        add_action( 'init', [ __CLASS__, 'mup_redirect_default_login' ] );
        add_filter( 'logout_redirect', [ __CLASS__, 'mup_after_logout_page' ] );
        add_filter( 'after_setup_theme', [ __CLASS__, 'mup_do_login' ] );
        add_filter( 'retrieve_password_message', [ __CLASS__, 'mup_retrieve_password_message' ], 10, 4 );
        
        $login = mup_login_options();

        if ( $login['login_slug'] and $login['reset_pass_slug'] ) {
            add_action( 'login_form_lostpassword', [ __CLASS__, 'mup_do_password_lost' ] );
            add_action( 'login_form_rp', [ __CLASS__, 'mup_redirect_password_reset' ] );
            add_action( 'login_form_resetpass', [ __CLASS__, 'mup_redirect_password_reset' ] );
            add_action( 'login_form_rp', [ __CLASS__, 'mup_do_password_reset' ] );
            add_action( 'login_form_resetpass', [ __CLASS__, 'mup_do_password_reset' ] );
        }
    }

    static public function mup_redirect_default_register() {
        global $pagenow;
        $register = mup_register_options();

        if ( $register['default_register'] and $register['register_slug'] ) {
            $page = get_post( $register['register_slug'] );

            if( $pagenow === 'wp-login.php' and isset( $_GET['action'] ) and $_GET['action'] === 'register' ) {
                wp_safe_redirect( $page->post_name );
                exit();
            }
        }
    }

    static public function mup_redirect_default_login() {
        global $pagenow;
        $login = mup_login_options();

        if ( $login['default_login'] and $login['login_slug'] ) {
            $page = get_post( $login['login_slug'] );

            if( 'wp-login.php' === $pagenow and $_GET['action'] !== 'register' and $_GET['action'] !== 'logout' and $_GET['action'] !== 'lostpassword' ) {
                wp_safe_redirect( $page->post_name );
                exit();
            }
        }
    }

    static public function mup_do_login() {
        if ( isset( $_POST['mup_submit_login'] ) and isset( $_POST['mup_login_slug'] ) ) {
            if ( ! isset( $_POST['mup_login_nonce'] ) or ! wp_verify_nonce( $_POST['mup_login_nonce'], 'login_nonce' ) ) {
                wp_redirect( add_query_arg( 'error', 'invalid_request', esc_url( home_url( $_POST['mup_login_slug'] ) ) ) );
                exit;
            }

            if ( empty( $_POST['user_login'] ) ) {
                wp_redirect( add_query_arg( 'error', 'empty_username', esc_url( home_url( $_POST['mup_login_slug'] ) ) ) );
                exit;
            }

            if ( empty( $_POST['user_pass'] ) ) {
                wp_redirect( add_query_arg( 'error', 'empty_pass', esc_url( home_url( $_POST['mup_login_slug'] ) ) ) );
                exit;
            }

            $register = mup_register_options();

            if ( $register['register_activation'] ) {
                $user = get_user_by( 'login', sanitize_text_field( $_POST['user_login'] ) );
                $status = get_user_meta( $user->ID, 'mup_user_status', true );
                $cap = user_can( $user->ID, 'administrator' );

                if ( ! $user or ( ! $status and ! $cap ) ) {
                    wp_redirect( add_query_arg( 'error', 'activation', esc_url( home_url( $_POST['mup_login_slug'] ) ) ) );
                    exit;
                }
            }

            $creds = array(
                'user_login' => sanitize_text_field( $_POST['user_login'] ),
                'user_password' => sanitize_text_field( $_POST['user_pass'] ),
                'remember' => isset( $_POST['remember'] )
            );

            $user = wp_signon( $creds, true );

            if ( is_wp_error( $user ) ) {
                wp_redirect( add_query_arg( 'error', 'login_error', esc_url( home_url( $_POST['mup_login_slug'] ) ) ) );
                exit;
            }

            if ( user_can( $user->ID, 'administrator' ) ) {
                wp_redirect( admin_url() );
                exit;
            }

            $general = mup_login_options();

            if ( ! $general['after_login'] ) {
                wp_redirect( home_url() );
                exit;
            }

            $post = get_post( $general['after_login'] );

            wp_redirect( home_url( $post->post_name ) );
            exit;
        }
    }

    static public function mup_after_logout_page( $redirect_to ) {
        $login = mup_login_options();

        if ( $login['after_logout'] ) {
            $page = get_post( $login['after_logout'] );
            return esc_url( home_url( $page->post_name ) );
        }

        return $redirect_to;
    }

    static public function mup_do_password_lost() {
        if ( 'POST' === $_SERVER['REQUEST_METHOD'] ) {
            $errors = retrieve_password();
            $login = mup_login_options();
            $page = get_post( $login['login_slug'] );
            $login_slug = $page->post_name;                

            if ( is_wp_error( $errors ) ) {
                $redirect_url = esc_url( home_url( $login_slug ) );
                $redirect_url = add_query_arg( 'errors', join( ',', $errors->get_error_codes() ), $redirect_url );
            } else {
                $redirect_url = esc_url( home_url( $login_slug ) );
                $redirect_url = add_query_arg( 'checkemail', 'confirm', $redirect_url );
            }

            wp_redirect( $redirect_url );
            exit;
        }
    }

    static public function mup_retrieve_password_email_content_type() {
        return 'text/html';
    }

    static public function mup_retrieve_password_message( $message, $key, $user_login, $user_data ) {
        add_filter( 'wp_mail_content_type', [ __CLASS__, 'mup_retrieve_password_email_content_type' ] );

        $msg  = __( 'Hello!', 'mas-user-panel' ) . "\r\n\r\n";
        $msg .= sprintf( __( 'You asked us to reset your password for your account using the email address %s.', 'mas-user-panel' ), $user_login ) . "\r\n\r\n";
        $msg .= __( "If this was a mistake, or you didn't ask for a password reset, just ignore this email and nothing will happen.", 'mas-user-panel' ) . "\r\n\r\n";
        $msg .= __( 'To reset your password, visit the following address:', 'mas-user-panel' ) . "\r\n\r\n";
        $msg .= site_url( "wp-login.php?action=rp&key=$key&login=" . rawurlencode( $user_login ), 'login' ) . "\r\n\r\n";
        $msg .= __( 'Thanks!', 'mas-user-panel' ) . "\r\n";

        return mup_email_template( $msg );
    }

    static public function mup_redirect_password_reset() {
        if ( 'GET' == $_SERVER['REQUEST_METHOD'] ) {
            // Verify key / login combo
            $key = sanitize_text_field( $_REQUEST['key'] );
            $login = sanitize_text_field( $_REQUEST['login'] );
            $user = check_password_reset_key( $key, $login );
            $login_options = mup_login_options();
            $page = get_post( $login_options['login_slug'] );
            $login_slug = $page->post_name;
            $reset_page = get_post( $login_options['reset_pass_slug'] );

            if ( ! $user or is_wp_error( $user ) ) {
                if ( $user and $user->get_error_code() === 'expired_key' ) {
                    wp_redirect( esc_url( home_url( "$login_slug?login=expiredkey" ) ) );
                } else {
                    wp_redirect( esc_url( home_url( "$login_slug?login=invalidkey" ) ) );
                }

                exit;
            }

            $redirect_url = esc_url( home_url( $reset_page->post_name ) );
            $redirect_url = add_query_arg( 'login', $key, $redirect_url );
            $redirect_url = add_query_arg( 'key', $login, $redirect_url );

            wp_redirect( $redirect_url );
            exit;
        }
    }

    static public function mup_do_password_reset() {
        if ( 'POST' == $_SERVER['REQUEST_METHOD'] ) {
            $rp_key = sanitize_text_field( $_REQUEST['rp_key'] );
            $rp_login = sanitize_text_field( $_REQUEST['rp_login'] );
            $user = check_password_reset_key( $rp_key, $rp_login );
            $login = mup_login_options();
            $page = get_post( $login['login_slug'] );
            $login_slug = $page->post_name;
            $reset_page = get_post( $login['reset_pass_slug'] );
            

            if ( ! $user or is_wp_error( $user ) ) {
                if ( $user and $user->get_error_code() === 'expired_key' ) {
                    wp_redirect( esc_url( home_url( "$login_slug?login=expiredkey" ) ) );
                } else {
                    wp_redirect( esc_url( home_url( "$login_slug?login=invalidkey" ) ) );
                }

                exit;
            }

            if ( isset( $_POST['pass1'] ) ) {
                if ( empty( $_POST['pass1'] ) ) {
                    // Password is empty
                    $redirect_url = esc_url( home_url( $reset_page->post_name ) );
                    $redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
                    $redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
                    $redirect_url = add_query_arg( 'error', 'password_reset_empty', $redirect_url );

                    wp_redirect( $redirect_url );
                    exit;
                }
                
                if ( $_POST['pass1'] != $_POST['pass2'] ) {
                    // Passwords don't match
                    $redirect_url = esc_url( home_url( $reset_page->post_name ) );
                    $redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
                    $redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
                    $redirect_url = add_query_arg( 'error', 'password_reset_mismatch', $redirect_url );

                    wp_redirect( $redirect_url );
                    exit;
                }

                $pass = mup_user_pass_settings();

                if ( strlen( $_POST['pass1'] ) < $pass['min'] ) {
                    // Passwords don't match
                    $redirect_url = esc_url( home_url( $reset_page->post_name ) );
                    $redirect_url = add_query_arg( 'key', $rp_key, $redirect_url );
                    $redirect_url = add_query_arg( 'login', $rp_login, $redirect_url );
                    $redirect_url = add_query_arg( 'error', 'password_reset_min', $redirect_url );

                    wp_redirect( $redirect_url );
                    exit;
                }

                // Parameter checks OK, reset password
                reset_password( $user, sanitize_text_field( $_POST['pass1'] ) );
                wp_redirect( esc_url( home_url( "$login_slug?password=changed" ) ) );
                exit;
            } else {
                $redirect_url = esc_url( home_url( $reset_page->post_name ) );
                $redirect_url = add_query_arg( 'error', 'invalid_request', $redirect_url );

                wp_redirect( $redirect_url );
                exit;
            }
        }
    }
}

MUPAuth::init();