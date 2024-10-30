<?php $login = mup_login_options(); ?>

<form id="mup-login-settings-form" method="post">
    <?php wp_nonce_field( 'login_nonce', 'login_nonce' ); ?>

    <table class="form-table">
        <tr>
            <th>
                <label for="mup-login-page">
                    <?php _e( 'Login page', 'mas-user-panel' ); ?>
                </label>
            </th>

            <td>
                <?php $pages = get_pages( [ 'post_status' => [ 'publish', 'draft' ] ] ); ?>

                <?php if ( count( $pages ) > 0 ): ?>
                    <select id="mup-login-page" name="login_page">
                        <option <?php selected( ! $login['login_slug'] ) ?>>
                            <?php _e( 'Default', 'mas-user-panel' ); ?>
                        </option>

                        <?php foreach ( $pages as $page ): ?>
                            <?php $page_name = empty( $page->post_title ) ? __( 'Untitled', 'mas-user-panel' ) : $page->post_title; ?>

                            <option value="<?php esc_attr_e( $page->ID ); ?>" <?php selected( $login['login_slug'], $page->ID ); ?>>
                                <?php esc_html_e( "$page_name ($page->post_name)" ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <span><?php _e( 'There is no page.', 'mas-user-panel' )?></span>
                <?php endif; ?>

                <p><?php _e( 'If you select the "Redirect default login" option, users will be redirected to this page, so make sure you have this page and the plugin login shortcode in it.', 'mas-user-panel' ); ?></p>
            </td>
        </tr>

        <?php if ( $login['login_slug'] ): ?>
            <tr>
                <th>
                    <label for="mup-disable-default-login">
                        <?php _e( 'Redirect default login to plugin login', 'mas-user-panel' ); ?>
                    </label>
                </th>

                <td>
                    <input id="mup-disable-default-login" type="checkbox" name="default_login" <?php checked( $login['default_login'] ); ?>/>
                </td>
            </tr>
        <?php endif; ?>

        <tr>
            <th>
                <label for="mup-after-login">
                    <?php _e( 'After login page', 'mas-user-panel' ); ?>
                </label>
            </th>

            <td>
                <?php if ( count( $pages ) > 0 ): ?>
                    <select id="mup-after-login" name="after_login">
                        <option <?php selected( ! $login['after_login'] ) ?>>
                            <?php _e( 'Default', 'mas-user-panel' ); ?>
                        </option>

                        <?php foreach ( $pages as $page): ?>
                            <?php $page_name = empty( $page->post_title ) ? __( 'Untitled', 'mas-user-panel' ) : $page->post_title; ?>

                            <option value="<?php esc_attr_e( $page->ID ); ?>" <?php selected( $login['after_login'], $page->ID ); ?>>
                                <?php esc_html_e( "$page_name ($page->post_name)" ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <span><?php _e( 'There is no page.', 'mas-user-panel' )?></span>
                <?php endif; ?>

                <p class="description">
                    <?php _e( 'This option is related to logging in through the plugin login form and for non-administrator users.', 'mas-user-panel' ); ?>
                </p>
            </td>
        </tr>

        <tr>
            <th>
                <label for="mup-reset-pass-page">
                    <?php _e( 'Reset password page', 'mas-user-panel' ); ?>
                </label>
            </th>

            <td>
                <?php $pages = get_pages( [ 'post_status' => [ 'publish', 'draft' ] ] ); ?>

                <?php if ( count( $pages ) > 0 ): ?>
                    <select id="mup-reset-pass-page" name="reset_pass_page">
                        <option <?php selected( ! $login['reset_pass_slug'] ) ?>>
                            <?php _e( 'Default', 'mas-user-panel' ); ?>
                        </option>

                        <?php foreach ( $pages as $page ): ?>
                            <?php $page_name = empty( $page->post_title ) ? __( 'Untitled', 'mas-user-panel' ) : $page->post_title; ?>

                            <option value="<?php esc_attr_e( $page->ID ); ?>" <?php selected( $login['reset_pass_slug'], $page->ID ); ?>>
                                <?php esc_html_e( "$page_name ($page->post_name)" ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <span><?php _e( 'There is no page.', 'mas-user-panel' )?></span>
                <?php endif; ?>

                <p><?php _e( 'Proper selection of this page and login page can be required for the correct password recovery actions of the plugin.', 'mas-user-panel' ); ?></p>
            </td>
        </tr>

        <tr>
            <th>
                <label for="mup-after-login">
                    <?php _e( 'After logout page', 'mas-user-panel' ); ?>
                </label>
            </th>

            <td>
                <?php if ( count( $pages ) > 0 ): ?>
                    <select id="mup-after-logout" name="after_logout">

                        <option <?php selected( ! $login['after_logout'] ) ?>>
                            <?php _e( 'Default', 'mas-user-panel' ); ?>
                        </option>

                        <?php foreach ( $pages as $page): ?>
                            <?php $page_name = empty( $page->post_title ) ? __( 'Untitled', 'mas-user-panel' ) : $page->post_title; ?>

                            <option value="<?php esc_attr_e( $page->ID ); ?>" <?php selected( $login['after_logout'], $page->ID ); ?>>
                                <?php esc_html_e( "$page_name ($page->post_name)" ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <span><?php _e( 'There is no page.', 'mas-user-panel' )?></span>
                <?php endif; ?>
            </td>
        </tr>
    </table>

    <p>
        <input class="button button-primary" type="submit" name="login" value="<?php _e( 'Save Settings', 'mas-user-panel' ); ?>"/>
    </p>
</form>