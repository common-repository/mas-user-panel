<?php $register = mup_register_options(); ?>

<form id="mup-register-settings-form" method="post">
    <?php wp_nonce_field( 'register_nonce', 'register_nonce' ); ?>

    <table class="form-table">
        <tr>
            <th>
                <label for="mup-register-page">
                    <?php _e( 'Register page', 'mas-user-panel' ); ?>
                </label>
            </th>

            <td>
                <?php $pages = get_pages( [ 'post_status' => [ 'publish', 'draft' ] ] ); ?>

                <?php if ( count( $pages ) > 0 ): ?>
                    <select id="mup-register-page" name="register_page">
                        <option <?php selected( ! $register['register_slug'] ) ?>>
                            <?php _e( 'None', 'mas-user-panel' ); ?>
                        </option>

                        <?php foreach ( $pages as $page): ?>
                            <?php $page_name = empty( $page->post_title ) ? __( 'Untitled', 'mas-user-panel' ) : $page->post_title; ?>

                            <option value="<?php esc_attr_e( $page->ID ); ?>" <?php selected( $register['register_slug'], $page->ID ); ?>>
                                <?php esc_html_e( "$page_name ($page->post_name)" ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <span><?php _e( 'There is no page.', 'mas-user-panel' ); ?></span>
                <?php endif; ?>

                <p><?php _e( 'If you select the "Redirect default register" option, users will be redirected to this page.', 'mas-user-panel' ); ?></p>
            </td>
        </tr>

        <?php if ( $register['register_slug'] ): ?>
            <tr>
                <th>
                    <label for="mup-disable-default-register">
                        <?php _e( 'Redirect default register', 'mas-user-panel' ); ?>
                    </label>
                </th>

                <td>
                    <input id="mup-disable-default-register" type="checkbox" name="default_register" <?php checked( $register['default_register'] ); ?>/>
                </td>
            </tr>
        <?php endif; ?>

        <tr>
            <th>
                <label for="mup-enable-pass-strength">
                    <?php _e( 'Enable password strength', 'mas-user-panel' ); ?>
                </label>
            </th>

            <td>
                <input id="mup-enable-pass-strength" type="checkbox" name="pass_strength" <?php checked( $register['pass_strength'] ); ?>/>
            </td>
        </tr>

        <tr>
            <th>
                <label for="mup-register-activation">
                    <?php _e( 'Require user to activate account by email', 'mas-user-panel' ); ?>
                </label>
            </th>

            <td>
                <input id="mup-register-activation" type="checkbox" name="register_activation" <?php checked( $register['register_activation'] ); ?>/>
            </td>
        </tr>

        <tr>
            <th>
                <label for="mup-reg-email-subject"><?php _e( 'Registration notification email subject', 'mas-user-panel' ); ?></label>
            </th>

            <td>
                <input id="mup-reg-email-subject" class="regular-text" name="reg_email_subject" type="text" value="<?php esc_attr_e( $register['reg_email_subject'] ); ?>"/>
            </td>
        </tr>

        <tr>
            <th>
                <label for="mup-user-reg-email-content"><?php _e( 'Registration notification email text', 'mas-user-panel' ); ?></label>
            </th>

            <td>
                <?php
                $args = [
                    'wpautop' => true,
                    'media_buttons' => false,
                    'textarea_name' => 'reg_email_content',
                    'textarea_rows' => 8,
                    'quicktags' => true,
                    'tinymce' => [
                        'toolbar1' => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink,undo,redo',
                        'toolbar2' => '',
                        'toolbar3' => '',
                    ],
                ];

                wp_editor( $register['reg_email_content'], 'mup-user-reg-email-content', $args );
                ?>

                <p class="description">
                    <?php _e( 'Codes that can be used in the text of the email: ', 'mas-user-panel' ); ?>

                    <code>[first_name]</code>
                    <code>[last_name]</code>
                    <code>[user_login]</code>
                    <code>[user_email]</code>
                    <code>[site_name]</code>
                    <code>[site_url]</code>
                </p>
            </td>
        </tr>

        <tr>
            <th>
                <label for="mup-activation-email-subject"><?php _e( 'Account activation email subject', 'mas-user-panel' ); ?></label>
            </th>

            <td>
                <input id="mup-activation-email-subject" class="regular-text" name="activation_email_subject" type="text" value="<?php esc_attr_e( $register['activation_email_subject'] ); ?>"/>
            </td>
        </tr>

        <tr>
            <th>
                <label for="mup-activation-email"><?php _e( 'Account activation email text', 'mas-user-panel' ); ?></label>
            </th>

            <td>
                <?php
                $args = [
                    'wpautop' => true,
                    'media_buttons' => false,
                    'textarea_name' => 'activation_email',
                    'textarea_rows' => 8,
                    'quicktags' => true,
                    'tinymce' => [
                        'toolbar1' => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink,undo,redo',
                        'toolbar2' => '',
                        'toolbar3' => '',
                    ],
                ];

                wp_editor( $register['activation_email'], 'mup-activation-email', $args );
                ?>

                <p class="description">
                    <?php _e( 'Codes that can be used in the text of the email: ', 'mas-user-panel' ); ?>

                    <code>[first_name]</code>
                    <code>[last_name]</code>
                    <code>[user_login]</code>
                    <code>[user_email]</code>
                    <code>[site_name]</code>
                    <code>[site_url]</code>
                    <code>[activation_link]</code>
                </p>
            </td>
        </tr>
    </table>

    <p>
        <input class="button button-primary" type="submit" name="register" value="<?php _e( 'Save Settings', 'mas-user-panel' ); ?>"/>
    </p>
</form>