<?php
$roles = get_editable_roles();

if ( isset( $_POST['general'] ) ) {
    if ( ! isset( $_POST['general_nonce'] ) or ! wp_verify_nonce( $_POST['general_nonce'], 'general_nonce' ) ) {
        $error = __( 'Invalid Request.', 'mas-user-panel' );
    } else {
        $general_data = [
            'panel_style' => isset( $_POST['disable_panel_styles'] ),
            'reg_style' => isset( $_POST['disable_register_styles'] ),
            'login_style' => isset( $_POST['disable_login_styles'] ),
        ];

        if ( isset( $_POST['admin_bar_access'] ) ) {
            $general_data['admin_bar_access'] = mup_access_prepare( $_POST['admin_bar_access'] );
        }

        if ( isset( $_POST['admin_area_access'] ) ) {
            $general_data['admin_area_access'] = mup_access_prepare( $_POST['admin_area_access'] );
        }

        if ( isset( $_POST['mup_panel_page'] ) ) {
            $general_data['panel_slug'] = mup_allowed_pages( $_POST['mup_panel_page'] );
        }

        if ( isset( $_POST['lost_pass_page'] ) ) {
            $general_data['lost_pass_slug'] = mup_allowed_pages( $_POST['lost_pass_page'] );
        }

        $update = update_option( 'mup_general', $general_data );

        if ( $update ) {
            $success = __( 'Settings Changed.', 'mas-user-panel' );
        }
    }
}
