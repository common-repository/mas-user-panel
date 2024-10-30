<?php
if ( isset( $_POST['register'] ) ) {
    if ( ! isset( $_POST['register_nonce'] ) or ! wp_verify_nonce( $_POST['register_nonce'], 'register_nonce' ) ) {
        $error = __( 'Invalid Request.', 'mas-user-panel' );
    } else {
        if ( isset( $_POST['register_page'] ) ) {
            $register_data['register_slug'] = mup_allowed_pages( $_POST['register_page'] );
        }

        $register_data['default_register'] = isset( $_POST['default_register'] );
        $register_data['pass_strength'] = isset( $_POST['pass_strength'] );
        $register_data['reg_email_subject'] = sanitize_text_field( $_POST['reg_email_subject'] );
        $register_data['reg_email_content'] = wp_kses( $_POST['reg_email_content'], 'post' );
        $register_data['register_activation'] = isset( $_POST['register_activation'] );
        $register_data['activation_email_subject'] = sanitize_text_field( $_POST['activation_email_subject'] );
        $register_data['activation_email'] = wp_kses( $_POST['activation_email'], 'post' );

        $update = update_option( 'mup_register', $register_data );

        if ( $update ) {
            $success = __( 'Settings Changed.', 'mas-user-panel' );
        }
    }
}