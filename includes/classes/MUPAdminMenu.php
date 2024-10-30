<?php


class MUPAdminMenu {
    static public function init() {
        if ( is_admin() ) {
            add_action( 'admin_enqueue_scripts', [ __CLASS__, 'admin_assets' ] );
            add_action( 'admin_menu', [ __CLASS__, 'admin_menus' ] );
        }
    }

    public static function admin_menus() {
        add_menu_page(
            __( 'Mas Panel', 'mas-user-panel' ),
            __( 'Mas Panel', 'mas-user-panel' ),
            'manage_options',
            'mas-user-panel',
            '',
            'dashicons-admin-users'
        );

        add_submenu_page(
            'mas-user-panel',
            __( 'Settings', 'mas-user-panel' ),
            __( 'Settings', 'mas-user-panel' ),
            'manage_options',
            'mup-settings',
            [ __CLASS__, 'settings_menu_page' ]
        );

        add_submenu_page(
            'mas-user-panel',
            __( 'Notifications', 'mas-user-panel' ),
            __( 'Notifications', 'mas-user-panel' ),
            'manage_options',
            'edit.php?post_type=mup_notifications',
            false
        );

        $count = mup_admin_ticket_notice_count();

        add_submenu_page(
        'mas-user-panel',
            __( 'Tickets', 'mas-user-panel' ),
            $count ? __( 'Tickets', 'mas-user-panel' ) . '<span class="awaiting-mod" style="margin: 0 5px">' . esc_html( $count ) . '</span>' : __( 'Tickets', 'mas-user-panel' ),
            'manage_options',
            'mup-tickets',
            [ __CLASS__, 'tickets_menu_page' ]
        );

        add_submenu_page(
            'mas-user-panel',
            __( 'Register Fields', 'mas-user-panel' ),
            __( 'Register Fields', 'mas-user-panel' ),
            'manage_options',
            'mup-register-fields',
            [ __CLASS__, 'register_form_builder_menu_page' ]
        );

        add_submenu_page(
            'mas-user-panel',
            __( 'Panel Menus', 'mas-user-panel' ),
            __( 'Panel Menus', 'mas-user-panel' ),
            'manage_options',
            'mup-panel-menus',
            [ __CLASS__, 'panel_menus' ]
        );

        add_submenu_page(
            'mas-user-panel',
            __( 'Plugin Info', 'mas-user-panel' ),
            __( 'Plugin Info', 'mas-user-panel' ),
            'manage_options',
            'mup-info',
            [ __CLASS__, 'info' ]
        );

        remove_submenu_page( 'mas-user-panel', 'mas-user-panel' );
    }

    public static function tickets_menu_page() {
        if ( isset( $_GET['single-ticket'] ) and ! empty( $_GET['single-ticket'] ) ) {
            include_once MUP_ADMIN_PATH . 'pages/single-ticket.php';
        } else {
            include_once MUP_ADMIN_PATH . 'pages/ticket-list.php';
        }
    }

    public static function settings_menu_page() {
        include_once MUP_ADMIN_PATH . '/pages/settings.php';
    }

    public static function register_form_builder_menu_page() {
        include_once MUP_ADMIN_PATH . '/pages/register-form-builder.php';
    }

    public static function panel_menus() {
        include_once MUP_ADMIN_PATH . '/pages/panel-menus.php';
    }

    public static function info() {
        include_once MUP_ADMIN_PATH . '/pages/info.php';
    }

    public static function admin_assets() {
        $pages = [ 'mup-tickets', 'mup-settings', 'mup-panel-menus', 'mup-register-fields', 'mup-info' ];

        if ( isset( $_GET['page'] ) and ! empty( $_GET['page'] ) and in_array( $_GET['page'], $pages ) ) {
            wp_enqueue_style( 'mup_admin_styles', MUP_ADMIN_URL . 'assets/css/main.css' );
            wp_enqueue_script( 'mup_main', MUP_ADMIN_URL . 'assets/js/main.js', [ 'jquery' ], '', true );
            wp_localize_script( 'mup_main', 'mupMain', [
                'panel_menus' => [
                    'fields' => mup_panel_menu_option_html_fields(),
                    'linkPlaceholder' => __( 'eg: https://google.com', 'mas-user-panel' ),
                    'shortCodePlaceholder' => __( 'Shortcode', 'mas-user-panel' ),
                ]
            ]);
        }

        if ( isset( $_GET['page'] ) and ! empty( $_GET['page'] ) and $_GET['page'] === 'mup-register-fields' ) {
            wp_enqueue_script( 'mup_register_fields', MUP_ADMIN_URL . 'assets/js/register-fields.js', [ 'jquery' ], '', true );

            wp_localize_script( 'mup_register_fields', 'mupRegFields', [
                'fields' => MUPRegField::fields(),
                'first_name' => mup_first_name_setting_fields(),
                'last_name' => mup_last_name_setting_fields(),
                'display_name' => mup_display_name_setting_fields(),
                'user_login' => mup_user_login_setting_fields(),
                'user_email' => mup_user_email_setting_fields(),
                'user_pass' => mup_user_pass_setting_fields(),
                'user_url' => mup_user_url_setting_fields(),
            ]);
        }
    }
}

MUPAdminMenu::init();