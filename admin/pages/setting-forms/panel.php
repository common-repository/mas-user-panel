<?php $panel = mup_panel_options(); ?>

<form id="mup-panel-settings-form" method="post">
    <?php wp_nonce_field( 'panel_nonce', 'panel_nonce' ); ?>

    <table class="form-table">
        <tr>
            <th>
                <label for="mup-display-top-sidebar"><?php _e( 'Show top panel section', 'mas-user-panel' ); ?></label>
            </th>

            <td>
                <input id="mup-display-top-sidebar" type="checkbox" name="display_top_sidebar" <?php checked( $panel['display_top_sidebar'] ); ?>/>
            </td>
        </tr>

        <tr>
            <th>
                <label for="mup-enable-upload-avatar"><?php _e( 'Enable upload avatar', 'mas-user-panel' ); ?></label>
            </th>

            <td>
                <input id="mup-enable-upload-avatar" type="checkbox" name="enable_upload_avatar" <?php checked( $panel['upload_avatar'] ); ?>/>
            </td>
        </tr>

        <tr>
            <th>
                <label for="mup-avatar-size"><?php _e( 'Avatar image size in kilobytes', 'mas-user-panel' ); ?></label>
            </th>

            <td>
                <input id="mup-avatar-size" class="small-text" type="number" name="avatar_size" value="<?php esc_attr_e( $panel['avatar_size'] ); ?>" min="100" <?php checked( $panel['avatar_size'] ); ?>/>
            </td>
        </tr>

        <tr>
            <th>
                <label for="mup-notice-per-page"><?php _e( 'Notifications per page', 'mas-user-panel' ); ?></label>
            </th>

            <td>
                <input id="mup-notice-per-page" class="small-text" type="number" name="notifications_per_page" step="1" min="1" value="<?php esc_attr_e( $panel['notifications_per_page'] ); ?>"/>
            </td>
        </tr>

        <tr>
            <th>
                <label for="mup-comments-per-page"><?php _e( 'Comments per page', 'mas-user-panel' ); ?></label>
            </th>

            <td>
                <input id="mup-comments-per-page" class="small-text" type="number" name="comments_per_page" min="1" value="<?php esc_attr_e( $panel['comments_per_page'] ); ?>"/>
            </td>
        </tr>

        <tr>
            <th>
                <label for="mup-tickets-per-page"><?php _e( 'Tickets per page', 'mas-user-panel' ); ?></label>
            </th>

            <td>
                <input id="mup-tickets-per-page" class="small-text" type="number" name="tickets_per_page" min="1" value="<?php esc_attr_e( $panel['tickets_per_page'] ); ?>"/>
            </td>
        </tr>

        <tr>
            <th>
                <label for="mup-ticket-replies-per-page"><?php _e( 'Ticket replies per page', 'mas-user-panel' ); ?></label>
            </th>

            <td>
                <input id="mup-ticket-replies-per-page" class="small-text" type="number" name="ticket_replies_per_page" min="1" value="<?php esc_attr_e( $panel['ticket_replies_per_page'] ); ?>"/>
            </td>
        </tr>

        <tr>
            <th>
                <label for="mup-ticket-email-subject"><?php _e( 'Ticket notification email subject', 'mas-user-panel' ); ?></label>
            </th>

            <td>
                <input id="mup-ticket-email-subject" class="regular-text" name="ticket_email_subject" type="text" value="<?php esc_attr_e( $panel['ticket_email_subject'] ); ?>"/>
            </td>
        </tr>

        <tr>
            <th>
                <label for="mup-ticket-email-text"><?php _e( 'Ticket notification email text', 'mas-user-panel' ); ?></label>
            </th>

            <td>
                <?php
                $args = [
                    'media_buttons' => false,
                    'textarea_name' => 'ticket_email_content',
                    'textarea_rows' => 8,
                    'quicktags' => false,
                    'tinymce' => [
                        'toolbar1' => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink,undo,redo',
                        'toolbar2' => '',
                        'toolbar3' => '',
                    ],
                ];

                wp_editor( $panel['ticket_email_content'], 'mup-ticket-email-text', $args );
                ?>

                <p class="description">
                    <?php _e( 'Codes that can be used in the text of the email: ', 'mas-user-panel' ); ?>
                    <code>[site_name]</code>
                    <code>[site_url]</code>
                    <code>[ticket_title]</code>
                </p>
            </td>
        </tr>
    </table>

    <p>
        <input class="button button-primary" type="submit" name="panel" value="<?php _e( 'Save Settings', 'mas-user-panel' ); ?>"/>
    </p>
</form>