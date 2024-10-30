<?php
$errors = [];

if ( isset( $_POST['new_ticket'] ) and isset( $_POST['new_ticket_nonce'] ) ) {
    if ( wp_verify_nonce( $_POST['new_ticket_nonce'], 'new_ticket' ) ) {
        if ( empty( $_POST['ticket_subject'] ) ) {
            $errors[] = __( 'Title must not be empty.', 'mas-user-panel' );
        }

        if ( empty( $_POST['ticket_content'] ) ) {
            $errors[] = __( 'Message must not be empty.', 'mas-user-panel' );
        }

        if ( ! count( $errors ) > 0 ) {
            $insert = wp_insert_post([
                'post_type' => 'mup_ticket',
                'post_status' => 'publish',
                'post_title'=> sanitize_text_field( wp_strip_all_tags( $_POST['ticket_subject'] ) ),
                'post_content' => wp_kses( $_POST['ticket_content'], 'post' ),
                'meta_input' => [
                    'mup_ticket_priority' => sanitize_text_field( $_POST['ticket_priority'] ),
                    'mup_admin_ticket_read' => 'admin_unread',
                ],
            ]);

            if ( ! is_wp_error( $insert ) ) {
                $success = __( 'Ticket created. To view the ticket, go to the "Tickets" section.', 'mas-user-panel' );
            }
        }
    }
}
?>

<div id="mup-new-ticket">
    <?php
    if ( count( $errors ) > 0 ) {
        mup_show_message( $errors, 'error' );
    }

    if ( isset( $success ) ) {
        mup_show_message( $success, 'success' );
    }
    ?>

    <form id="mup-new-ticket-form" method="post">
        <?php wp_nonce_field( 'new_ticket', 'new_ticket_nonce' ); ?>

        <p>
            <input type="text" name="ticket_subject" placeholder="<?php esc_attr_e('Subject', 'mas-user-panel'); ?>">
        </p>

        <p>
            <label for="mup-ticket-priority"><?php _e( 'Priority', 'mas-user-panel' ); ?></label>

            <select id="mup-ticket-priority" name="ticket_priority">
                <option value="low"><?php _e( 'Low', 'mas-user-panel' ); ?></option>
                <option value="normal" selected><?php _e( 'Normal', 'mas-user-panel' ); ?></option>
                <option value="high"><?php _e( 'High', 'mas-user-panel' ); ?></option>
            </select>
        </p>

        <p>
            <?php
            $args = [
                'media_buttons' => false,
                'textarea_name' => 'ticket_content',
                'textarea_rows' => 5,
                'quicktags' => false,
                'tinymce' => [
                    'toolbar1' => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink,undo,redo',
                    'toolbar2' => '',
                    'toolbar3' => '',
                ],
            ];

            wp_editor( __( 'Your Message', 'mas-user-panel' ), 'mup-ticket-content', $args );
            ?>
        </p>

        <input type="submit" name="new_ticket" value="<?php esc_attr_e('Send Message', 'mas-user-panel'); ?>"/>
    </form>
</div>