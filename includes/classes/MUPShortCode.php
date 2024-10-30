<?php


class MUPShortCode {
    static public function init() {
        add_action( 'wp_enqueue_scripts', [ __CLASS__, 'enqueue_panel_scripts' ] );
        add_shortcode( 'mup_user_panel', [ __CLASS__, 'mup_user_panel' ] );
        add_shortcode( 'mup_register_form', [ __CLASS__, 'mup_register_form' ] );
        add_shortcode( 'mup_login_form', [ __CLASS__, 'mup_login_form' ] );
        add_shortcode( 'mup_lost_password_form', [ __CLASS__, 'mup_lost_password_form' ] );
        add_shortcode( 'mup_reset_password_form', [ __CLASS__, 'mup_reset_password_form' ] );
    }

    static public function enqueue_panel_scripts() {
        if ( ! is_admin() ) {
            wp_register_style( 'mup_front_style', MUP_USER_URL . 'assets/css/main.css' );
            wp_register_script( 'mup_main', MUP_USER_URL . 'assets/js/main.js', [ 'jquery' ], '', true );
            wp_register_script( 'mup_password_strength', MUP_USER_URL . 'assets/js/password-strength.js', [ 'password-strength-meter' ], '', true );
        }
    }

    static public function mup_user_panel() {
        $general = mup_general_options();

        if ( ! $general['panel_style'] ) {
            wp_enqueue_style( 'mup_front_style' );
        }

        wp_enqueue_script( 'mup_main' );

        $user = get_user_by( 'ID', get_current_user_id() );

        if ( $user and in_array( $user->roles[0], $general['admin_bar_access'] ) ) {
            wp_enqueue_style('dashicons');
        }

        ob_start();

        if ( is_user_logged_in() ) {
            require_once MUP_USER_PATH . 'user-panel.php';
        } else {
            mup_show_message( __( 'Log in to your account.', 'mas-user-panel' ), 'info' );
        }

        return ob_get_clean();
    }

    static public function mup_register_form() {
        $general = mup_general_options();
        $register = mup_register_options();
        if ( ! $general['reg_style'] ) {
            wp_enqueue_style('mup_front_style');
        }

        wp_enqueue_script( 'password-strength-meter' );

        if ( $register['pass_strength'] ) {
            wp_enqueue_script( 'mup_password_strength' );
        }

        ob_start();

        if ( ! is_user_logged_in() ) {
            if ( ! MUPRegField::field_exist('user_login') or ! MUPRegField::field_exist('user_email') or ! MUPRegField::field_exist('user_pass')) {
                mup_show_message( __( 'The registration form is not ready.', 'mas-user-panel' ), 'error' );
            } else {
                require_once MUP_USER_PATH . 'register-form.php';
            }
        } else {
            mup_show_message( __( 'You are logged in to your account.', 'mas-user-panel' ), 'info' );
        }

        return ob_get_clean();
    }

    static public function mup_login_form() {
        $general = mup_general_options();

        if ( ! $general['login_style'] ) {
            wp_enqueue_style('mup_front_style');
        }

        ob_start();

        if ( ! is_user_logged_in() ) {
            require_once MUP_USER_PATH . 'login-form.php';
        } else {
            mup_show_message( __( 'You are logged in to your account.', 'mas-user-panel' ), 'info' );
        }

        return ob_get_clean();
    }

    static public function mup_lost_password_form() {
        wp_enqueue_style( 'mup_front_style' );

        ob_start();

        if ( ! is_user_logged_in() ) {
            require_once MUP_USER_PATH . 'lost-password-form.php';
        } else {
            mup_show_message( __( 'You are logged in to your account.', 'mas-user-panel' ), 'info' );
        }

        return ob_get_clean();
    }

    static public function mup_reset_password_form() {
        wp_enqueue_style( 'mup_front_style' );

        ob_start();

        if ( ! is_user_logged_in() ) {
            if ( isset( $_REQUEST['login'] ) and isset( $_REQUEST['key'] ) ) {
                require_once MUP_USER_PATH . 'reset-password-form.php';
            } else {
                mup_show_message( __( 'Invalid Request.', 'mas-user-panel' ), 'error' );
            }
        } else {
            mup_show_message( __( 'Log in to your account.', 'mas-user-panel' ), 'info' );
        }

        return ob_get_clean();
    }
}

MUPShortCode::init();