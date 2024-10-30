<?php
if ( isset( $_POST['panel'] ) ) {
    if ( ! isset( $_POST['panel_nonce'] ) or ! wp_verify_nonce( $_POST['panel_nonce'], 'panel_nonce' ) ) {
        $error = __( 'Invalid Request.', 'mas-user-panel' );
    } else {
        $avatar_size = intval( $_POST['avatar_size'] ) >= 100 ? $_POST['avatar_size'] : 100;

        $panel_data['display_top_sidebar'] = isset( $_POST['display_top_sidebar'] );
        $panel_data['upload_avatar'] = isset( $_POST['enable_upload_avatar'] );
        $panel_data['avatar_size'] = $avatar_size;
        $panel_data['notifications_per_page'] = intval( $_POST['notifications_per_page'] );
        $panel_data['comments_per_page'] = intval( $_POST['comments_per_page'] );
        $panel_data['tickets_per_page'] = intval( $_POST['tickets_per_page'] );
        $panel_data['ticket_replies_per_page'] = intval( $_POST['ticket_replies_per_page'] );
        $panel_data['ticket_email_subject'] = sanitize_text_field( $_POST['ticket_email_subject'] );
        $panel_data['ticket_email_content'] = wp_kses( $_POST['ticket_email_content'], 'post' );
        $panel_data['ticket_replies_per_page'] = intval( $_POST['ticket_replies_per_page'] );
        $update = update_option( 'mup_panel', $panel_data );

        if ( $update ) {
            $success = __( 'Settings Changed.', 'mas-user-panel' );
        }
    }
}
