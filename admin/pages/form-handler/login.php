<?php
if ( isset( $_POST['login'] ) ) {
    if ( ! isset( $_POST['login_nonce'] ) or ! wp_verify_nonce( $_POST['login_nonce'], 'login_nonce' ) ) {
        $error = __( 'Invalid Request.', 'mas-user-panel' );
    } else {
        if ( isset( $_POST['login_page'] ) ) {
            $login_data['login_slug'] = mup_allowed_pages( $_POST['login_page'] );
        }

        if ( isset( $_POST['after_login'] ) ) {
            $login_data['after_login'] = mup_allowed_pages( $_POST['after_login'] );
        }
        
        if ( isset( $_POST['reset_pass_page'] ) ) {
            $login_data['reset_pass_slug'] = mup_allowed_pages( $_POST['reset_pass_page'] );
        }

        if ( isset( $_POST['after_logout'] ) ) {
            $login_data['after_logout'] = mup_allowed_pages( $_POST['after_logout'] );
        }

        $login_data['default_login'] = isset( $_POST['default_login'] );

        $update = update_option( 'mup_login', $login_data );

        if ( $update ) {
            $success = __( 'Settings Changed.', 'mas-user-panel' );
        }
    }
}
