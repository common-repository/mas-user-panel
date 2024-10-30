<?php
function mup_general_options() {
    $default = [
        'panel_slug' => false,
        'lost_pass_slug' => false,
        'reset_pass_slug' => false,
        'admin_bar_access' => [],
        'admin_area_access' => [],
        'panel_style' => false,
        'reg_style' => false,
        'login_style' => false,
    ];

    return wp_parse_args( get_option( 'mup_general' ), $default );
}

function mup_register_options() {
    $default_reg_email = '<p>' . __( 'New user with this email:', 'mas-user-panel' ) . '</p>';
    $default_reg_email .= '<p>[user_email]</p>';
    $default_reg_email .= '<p>' . __( 'registered on your site.', 'mas-user-panel' ) . '</p>';
    $default_reg_email .= '<p style="font-size: 12px"><a href="' . site_url() . '">' . get_bloginfo( 'name' ) . '</a></p>';

    $activation_email = '<p>' . __( 'Click on the account activation link below.', 'mas-user-panel' ) . '</p>';
    $activation_email .= '<p>[activation_link]</p>';

    $default = [
        'register_slug' => false,
        'default_register' => false,
        'pass_strength' => true,
        'reg_email_subject' => __( 'New user registration', 'mas-user-panel' ),
        'reg_email_content' => $default_reg_email,
        'register_activation' => true,
        'activation_email_subject' => __( 'Account Activation', 'mas-user-panel' ),
        'activation_email' => $activation_email,
    ];

    return wp_parse_args( get_option( 'mup_register' ), $default );
}

function mup_login_options() {
    $default = [
        'login_slug' => false,
        'default_login' => false,
        'after_login' => false,
        'reset_pass_slug' => false,
        'after_logout' => false,
    ];

    return wp_parse_args( get_option( 'mup_login' ), $default );
}

function mup_panel_options() {
    $default_ticket_email = __( 'Your ticket as "[ticket_title]" was answered on [site_name].', 'mas-user-panel' );

    $default = [
        'display_top_sidebar' => true,
        'upload_avatar' => true,
        'avatar_size' => 100,
        'notifications_per_page' => 8,
        'comments_per_page' => 8,
        'tickets_per_page' => 8,
        'ticket_replies_per_page' => 8,
        'ticket_email_subject' => __( 'Subject', 'mas-user-panel' ),
        'ticket_email_content' => $default_ticket_email,
    ];

    return wp_parse_args( get_option( 'mup_panel' ), $default );
}

function mup_def_panel_menus_options() {
    $default = [
        'dash_order' => 0,
        'dash_title' => __( 'Dashboard', 'mas-user-panel' ),
        'dash_icon' => 'dashicons dashicons-dashboard',

        'home_order' => 1,
        'home_display' => true,
        'home_title' => __( 'Home Page', 'mas-user-panel' ),
        'home_icon' => 'dashicons dashicons-admin-home',

        'user_edit_order' => 2,
        'user_edit_display' => true,
        'user_edit_title' => __( 'Edit Profile', 'mas-user-panel' ),
        'user_edit_icon' => 'dashicons dashicons-edit-page',

        'notifications_order' => 3,
        'notifications_display' => true,
        'notifications_title' => __( 'Notifications', 'mas-user-panel' ),
        'notifications_icon' => 'dashicons dashicons-megaphone',

        'comments_order' => 4,
        'comments_display' => true,
        'comments_title' => __( 'Comments', 'mas-user-panel' ),
        'comments_icon' => 'dashicons dashicons-admin-comments',

        'new_ticket_order' => 5,
        'new_ticket_display' => true,
        'new_ticket_title' => __( 'New Ticket', 'mas-user-panel' ),
        'new_ticket_icon' => 'dashicons dashicons-edit-large',

        'tickets_order' => 6,
        'tickets_display' => true,
        'tickets_title' => __( 'Tickets', 'mas-user-panel' ),
        'tickets_icon' => 'dashicons dashicons-id',

        'logout_order' => 7,
        'logout_title' => __( 'Logout', 'mas-user-panel' ),
        'logout_icon' => 'dashicons dashicons-exit',
    ];

    return wp_parse_args( get_option( 'mup_default_menus' ), $default );
}