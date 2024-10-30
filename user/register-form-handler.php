<?php
$errors = [];

if ( isset( $_POST['register'] ) ) {
    $user = [];

    if ( ! isset( $_POST['mup_register_nonce'] ) or ! wp_verify_nonce( $_POST['mup_register_nonce'], 'register_nonce' ) ) {
        $errors[] = __( 'Invalid Request.', 'mas-user-panel' );
    }

    if ( isset( $_POST['first_name'] ) ) {
        $first_name = mup_first_name_settings();

        if ( $first_name['required'] and empty( $_POST['first_name'] ) ) {
            $errors[] = __( 'Firstname must not be empty.', 'mas-user-panel' );
        }

        if ( $first_name['required'] and strlen( $_POST['first_name'] ) < $first_name['min'] ) {
            $errors[] = sprintf( __( 'Minimum firstname letters must be %d', 'mas-user-panel' ), $first_name['min'] );
        }

        $user['first_name'] = sanitize_text_field( $_POST['first_name'] );
    }

    if ( isset( $_POST['last_name'] ) ) {
        $last_name = mup_last_name_settings();

        if ( $last_name['required'] and empty( $_POST['last_name'] ) ) {
            $errors[] = __( 'Lastname must not be empty.', 'mas-user-panel' );
        }

        if ( $last_name['required'] and strlen( $_POST['last_name'] ) < $last_name['min'] ) {
            $errors[] = sprintf( __( 'Minimum lastname letters must be %d', 'mas-user-panel' ), $last_name['min'] );
        }

        $user['last_name'] = sanitize_text_field( $_POST['last_name'] );
    }

    if ( isset( $_POST['display_name'] ) ) {
        $display_name = mup_display_name_settings();

        if ( $display_name['required'] and empty( $_POST['display_name'] ) ) {
            $errors[] = __( 'Display name must not be empty.', 'mas-user-panel' );
        }

        if ( $display_name['required'] and strlen( $_POST['display_name'] ) < $display_name['min'] ) {
            $errors[] = sprintf( __( 'Minimum display name letters must be %d', 'mas-user-panel' ), $display_name['min'] );
        }

        $user['display_name'] = sanitize_text_field( $_POST['display_name'] );
    }

    if ( isset( $_POST['user_login'] ) ) {
        $last_name = mup_user_login_settings();

        if ( empty( $_POST['user_login'] ) ) {
            $errors[] = __( 'Username must not be empty.', 'mas-user-panel' );
        }

        if ( strlen( $_POST['user_login'] ) < $last_name['min'] ) {
            $errors[] = sprintf( __( 'Minimum username name letters must be %d', 'mas-user-panel' ), $last_name['min'] );
        }

        if ( username_exists( $_POST['user_login'] ) ) {
            $errors[] = __( 'Username already exist.', 'mas-user-panel' );
        }

        $user['user_login'] = sanitize_text_field( $_POST['user_login'] );
    }

    if ( isset( $_POST['user_email'] ) ) {
        $user_email = mup_user_email_settings();

        if ( empty( $_POST['user_email'] ) ) {
            $errors[] = __( 'Email must not be empty.', 'mas-user-panel' );
        }

        if ( ! is_email( $_POST['user_email'] ) ) {
            $errors[] = __( 'Invalid Email', 'mas-user-panel' );
        }

        if ( email_exists( $_POST['user_email'] ) ) {
            $errors[] = __( 'Email already exist.', 'mas-user-panel' );
        }

        $user['user_email'] = sanitize_email( $_POST['user_email'] );
    }

    if ( isset( $_POST['user_pass'] ) ) {
        $user_pass = mup_user_pass_settings();

        if ( empty( $_POST['user_pass'] ) ) {
            $errors[] = __( 'Password must not be empty.', 'mas-user-panel' );
        }

        if ( $_POST['user_pass_confirm'] !== $_POST['user_pass'] ) {
            $errors[] = __( 'Two passwords do not match.', 'mas-user-panel' );
        }

        if ( strlen( $_POST['user_pass'] ) < $user_pass['min'] ) {
            $errors[] = sprintf( __( 'Minimum password letters must be %d', 'mas-user-panel' ), $user_pass['min'] );
        }

        $user['user_pass'] = sanitize_text_field( $_POST['user_pass'] );
    }

    if ( isset( $_POST['user_url'] ) ) {
        $user_url = mup_user_url_settings();

        if ( $user_url['required'] and empty( $_POST['user_url'] ) ) {
            $errors[] = __( 'Website must not be empty.', 'mas-user-panel' );
        }

        $user['user_url'] = sanitize_text_field( $_POST['user_url'] );
    }

    if ( ! count( $errors ) > 0 ) {
        $register = mup_register_options();

        if ( $register['register_activation'] ) {
            $salt = wp_generate_password( 20 );
            $key = sha1($salt . $_POST['user_email'] . uniqid( time(), true ) );
            $user['user_activation_key'] = $key;
        }

        $user_id = wp_insert_user( $user );

        if ( is_wp_error( $user_id ) ) {
            $errors[] = __( 'There is a problem with registration.', 'mas-user-panel' );
        } else {
            if ( $register['register_activation'] ) {
                add_user_meta( $user_id, 'mup_user_status', 0 );
            }

            $user = get_user_by( 'ID', $user_id );
            $email_subject = sanitize_text_field( $register['reg_email_subject'] );
            $headers = [ 'Content-Type: text/html; charset=UTF-8' ];

            $search = [
                '[first_name]',
                '[last_name]',
                '[user_login]',
                '[user_email]',
                '[site_name]',
                '[site_url]',
                '[activation_link]',
            ];

            $replace = [
                $user->first_name,
                $user->last_name,
                $user->user_login,
                $user->user_email,
                get_bloginfo( 'name' ),
                '<a href="' . esc_url( site_url() ) . '">' . site_url() . '</a>',
            ];

            $change = str_replace( $search, $replace, $register['reg_email_content'] );
            
            wp_mail( get_bloginfo( 'admin_email' ), $email_subject, mup_email_template( $change ), $headers );

            $login = mup_login_options();

            if ( $register['register_activation'] and $login['login_slug'] ) {
                $login_page = get_post( $login['login_slug'] );
                $replace[] = '<a href="' . esc_url( home_url( $login_page->post_name . '?email=' . $_POST['user_email'] . '&key=' . $key ) ) . '">' . __( 'activation link', 'mas-user-panel' ) . '</a>';
                $change = str_replace( $search, $replace, $register['activation_email'] );

                wp_mail( $_POST['user_email'], $register['activation_email_subject'], mup_email_template( $change ), $headers );

                $success = __( 'Registration completed successfully. An account activation link was sent to your email.', 'mas-user-panel' );
            } else {
                $success = __( 'Registration completed successfully.', 'mas-user-panel' );
            }
        }
    }
}