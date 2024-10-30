<?php
function mup_first_name_settings() {
    $default = [
        'placeholder' => __( 'Firstname', 'mas-user-panel' ),
        'required' => false,
        'min' => 0,
        'info' => '',
    ];

    return wp_parse_args( MUPRegField::fields_settings( 'first_name' ), $default );
}

function mup_last_name_settings() {
    $default = [
        'placeholder' => __( 'Lastname', 'mas-user-panel' ),
        'required' => false,
        'min' => 0,
        'info' => ''
    ];

    return wp_parse_args( MUPRegField::fields_settings( 'last_name' ), $default );
}

function mup_display_name_settings() {
    $default = [
        'placeholder' => __( 'Display name', 'mas-user-panel' ),
        'required' => false,
        'min' => 0,
        'info' => ''
    ];

    return wp_parse_args( MUPRegField::fields_settings( 'display_name' ), $default );
}

function mup_user_login_settings() {
    $default = [
        'placeholder' => __( 'Username', 'mas-user-panel' ),
        'min' => 5,
        'info' => ''
    ];

    return wp_parse_args( MUPRegField::fields_settings( 'user_login' ), $default );
}

function mup_user_email_settings() {
    $default = [
        'placeholder' => __( 'Email', 'mas-user-panel' ),
        'info' => ''
    ];

    return wp_parse_args( MUPRegField::fields_settings( 'user_email' ), $default );
}

function mup_user_pass_settings() {
    $default = [
        'placeholder' => __( 'Password', 'mas-user-panel' ),
        'conf_placeholder' => __( 'Confirm Password', 'mas-user-panel' ),
        'info' => '',
        'min' => 8
    ];

    return wp_parse_args( MUPRegField::fields_settings( 'user_pass' ), $default );
}

function mup_user_url_settings() {
    $default = [
        'placeholder' => __( 'Website', 'mas-user-panel' ),
        'required' => false,
        'info' => '',
    ];

    return wp_parse_args( MUPRegField::fields_settings( 'user_url' ), $default );
}