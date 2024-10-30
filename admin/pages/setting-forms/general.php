<?php $general = mup_general_options(); ?>

<form id="mup-general-form" method="post">
    <?php wp_nonce_field( 'general_nonce', 'general_nonce' ); ?>

    <table class="form-table">
        <tr>
            <th>
                <label for="mup-panel-page">
                    <?php _e( 'Panel page', 'mas-user-panel' ); ?>
                </label>
            </th>

            <td>
                <?php $pages = get_pages( [ 'post_status' => [ 'publish', 'draft' ] ] ); ?>

                <?php if ( count( $pages ) > 0 ): ?>
                    <select id="mup-panel-page" name="mup_panel_page">
                        <option <?php selected( ! $general['panel_slug'] ) ?>>
                            <?php _e( 'None', 'mas-user-panel' ); ?>
                        </option>

                        <?php foreach ( $pages as $page): ?>
                            <?php $page_name = empty( $page->post_title ) ? __( 'Untitled', 'mas-user-panel' ) : $page->post_title; ?>

                            <option value="<?php esc_attr_e( $page->ID ); ?>" <?php selected( $general['panel_slug'], $page->ID ); ?>>
                                <?php esc_html_e( "$page_name ($page->post_name)" ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <span><?php _e( 'There is no page.', 'mas-user-panel' )?></span>
                <?php endif; ?>
            </td>
        </tr>

        <tr>
            <th>
                <label for="mup-lost-pass">
                    <?php _e( 'Lost password page', 'mas-user-panel' ); ?>
                </label>
            </th>

            <td>
                <?php if ( count( $pages ) > 0 ): ?>
                    <select id="mup-lost-pass" name="lost_pass_page">
                        <option <?php selected( ! $general['lost_pass_slug'] ) ?>>
                            <?php _e( 'None', 'mas-user-panel' ); ?>
                        </option>

                        <?php foreach ( $pages as $page): ?>
                            <?php $page_name = empty( $page->post_title ) ? __( 'Untitled', 'mas-user-panel' ) : $page->post_title; ?>

                            <option value="<?php esc_attr_e( $page->ID ); ?>" <?php selected( $general['lost_pass_slug'], $page->ID ); ?>>
                                <?php esc_html_e( "$page_name ($page->post_name)" ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <span><?php _e( 'There is no page.', 'mas-user-panel' )?></span>
                <?php endif; ?>
            </td>
        </tr>

        <tr>
            <th>
                <label for="mup-admin-bar-access">
                    <?php _e( 'Disable admin bar for', 'mas-user-panel' ); ?>
                </label>
            </th>

            <td>
                <select id="mup-admin-bar-access" name="admin_bar_access[]" multiple>
                    <?php foreach ( $roles as $role => $details ): ?>
                        <option value="<?php esc_attr_e( $role ); ?>" <?php selected( in_array( $role, $general['admin_bar_access'] ) ); ?>>
                            <?php esc_html_e( $details['name'] ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>

        <tr>
            <th>
                <label for="mup-admin-area-access">
                    <?php _e( 'Disable wp admin for', 'mas-user-panel' ); ?>
                </label>
            </th>

            <td>
                <select id="mup-admin-area-access" name="admin_area_access[]" multiple>
                    <?php foreach ( $roles as $role => $details ): ?>
                        <option value="<?php esc_attr_e( $role ); ?>" <?php selected( in_array( $role, $general['admin_area_access'] ) ); ?>>
                            <?php esc_html_e( $details['name'] ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>

        <tr>
            <th>
                <label for="mup-disable-panel-styles">
                    <?php _e( 'Disable panel styles', 'mas-user-panel' ); ?>
                </label>
            </th>

            <td>
                <input id="mup-disable-panel-styles" type="checkbox" name="disable_panel_styles" <?php checked( $general['panel_style'] ); ?>/>
            </td>
        </tr>

        <tr>
            <th>
                <label for="mup-disable-register-styles">
                    <?php _e( 'Disable register styles', 'mas-user-panel' ); ?>
                </label>
            </th>

            <td>
                <input id="mup-disable-register-styles" type="checkbox" name="disable_register_styles" <?php checked( $general['reg_style'] ); ?>/>
            </td>
        </tr>

        <tr>
            <th>
                <label for="mup-disable-login-styles">
                    <?php _e( 'Disable login styles', 'mas-user-panel' ); ?>
                </label>
            </th>

            <td>
                <input id="mup-disable-login-styles" type="checkbox" name="disable_login_styles" <?php checked( $general['login_style'] ); ?>/>
            </td>
        </tr>
    </table>

    <p>
        <input class="button button-primary" type="submit" name="general" value="<?php _e( 'Save Settings', 'mas-user-panel' ); ?>"/>
    </p>
</form>