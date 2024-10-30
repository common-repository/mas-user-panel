<?php
$update_def_menus = false;
$update_menus = false;
$delete_menus = false;

if ( isset( $_POST['submit'] ) ) {
    $def_menus = [
        'dash_order' => intval( $_POST['dash_order'] ),
        'dash_icon' => sanitize_text_field( $_POST['dash_icon'] ),

        'home_display' => isset( $_POST['show_home'] ),
        'home_order' => intval( $_POST['home_order'] ),
        'home_icon' => sanitize_text_field( $_POST['home_icon'] ),

        'user_edit_display' => isset( $_POST['show_user_edit'] ),
        'user_edit_order' => intval( $_POST['user_edit_order'] ),
        'user_edit_icon' => sanitize_text_field( $_POST['user_edit_icon'] ),

        'notifications_display' => isset( $_POST['show_notifications'] ),
        'notifications_order' => intval( $_POST['notifications_order'] ),
        'notifications_icon' => sanitize_text_field( $_POST['notifications_icon'] ),

        'comments_display' => isset( $_POST['show_comments'] ),
        'comments_order' => intval( $_POST['comments_order'] ),
        'comments_icon' => sanitize_text_field( $_POST['comments_icon'] ),

        'new_ticket_display' => isset( $_POST['show_new_ticket'] ),
        'new_ticket_order' => intval( $_POST['new_ticket_order'] ),
        'new_ticket_icon' => sanitize_text_field( $_POST['new_ticket_icon'] ),

        'tickets_display' => isset( $_POST['show_tickets'] ),
        'tickets_order' => intval( $_POST['tickets_order'] ),
        'tickets_icon' => sanitize_text_field( $_POST['tickets_icon'] ),

        'logout_order' => intval( $_POST['logout_order'] ),
        'logout_icon' => sanitize_text_field( $_POST['logout_icon'] ),
    ];

    if ( ! empty( $_POST['dash_menu_title'] ) ) {
        $def_menus['dash_title'] = sanitize_text_field( $_POST['dash_menu_title'] );
    }

    if ( ! empty( $_POST['home_menu_title'] ) ) {
        $def_menus['home_title'] = sanitize_text_field( $_POST['home_menu_title'] );
    }

    if ( ! empty( $_POST['user_edit_menu_title'] ) ) {
        $def_menus['user_edit_title'] = sanitize_text_field( $_POST['user_edit_menu_title'] );
    }

    if ( ! empty( $_POST['notifications_menu_title'] ) ) {
        $def_menus['notifications_title'] = sanitize_text_field( $_POST['notifications_menu_title'] );
    }

    if ( ! empty( $_POST['comments_menu_title'] ) ) {
        $def_menus['comments_title'] = sanitize_text_field( $_POST['comments_menu_title'] );
    }

    if ( ! empty( $_POST['new_ticket_menu_title'] ) ) {
        $def_menus['new_ticket_title'] = sanitize_text_field( $_POST['new_ticket_menu_title'] );
    }

    if ( ! empty( $_POST['tickets_menu_title'] ) ) {
        $def_menus['tickets_title'] = sanitize_text_field( $_POST['tickets_menu_title'] );
    }

    if ( ! empty( $_POST['logout_menu_title'] ) ) {
        $def_menus['logout_title'] = sanitize_text_field( $_POST['logout_menu_title'] );
    }

    $update_def_menus = update_option( 'mup_default_menus', $def_menus );

    $order = [];
    $icon = [];
    $display = [];
    $type = [];
    $title = [];
    $content = [];

    if ( isset( $_POST['menu_title'] ) and isset( $_POST['menu_content'] ) and isset( $_POST['menu_type'] ) ) {
        for ( $i = 0; $i < count( $_POST['menu_type'] ); $i++ ) {
            $order[] = intval( $_POST['menu_order'][$i] );
            $icon[] = sanitize_text_field( $_POST['menu_icon'][$i] );
            $display[] = ( $_POST['show_menu'][$i] === 'show' ) ? 'show' : 'hide';
            $type[] = ( $_POST['menu_type'][$i] === 'link' ) ? 'link' : 'shortcode';
            $title[] = sanitize_text_field( $_POST['menu_title'][$i] );
            $content[] = sanitize_text_field( $_POST['menu_content'][$i] );
        }

        $data = [
            'menu_order' => $order,
            'menu_icon' => $icon,
            'show_menu' => $display,
            'menu_type' => $type,
            'menu_title' => $title,
            'menu_content' => $content,
        ];

        $update_menus = update_option( 'mup_panel_menus', $data );
    } else {
        $delete_menus = delete_option( 'mup_panel_menus' );
    }
}
?>

<div id="mup-wrap" class="wrap">
    <h1><?php _e( 'Panel Menus', 'mas-user-panel' ); ?></h1>

    <?php if ( isset( $error ) ): ?>
        <div class="notice notice-error is-dismissible">
            <p><strong><?php esc_html_e( $error ); ?></strong></p>
        </div>
    <?php endif; ?>

    <?php if ( $update_def_menus or $update_menus or $delete_menus): ?>
        <div class="notice notice-success is-dismissible">
            <p>
                <strong><?php _e( 'Settings Changed.', 'mas-user-panel' ); ?></strong>
            </p>
        </div>
    <?php endif; ?>

    <form id="mup-panel-menus-form" method="post" enctype="multipart/form-data">
        <?php wp_nonce_field( 'panel_menus', 'panel_menus_nonce' ); ?>

        <div class="notice notice-info is-dismissible">
            <p>
                <?php _e( 'You can add a custom menu to display in the user panel menus. You can also change the display status and title of the default menus.', 'mas-user-panel' ); ?>

                <strong>
                    <?php _e( 'To display custom menus in the user panel, the menu title and content should not be empty.', 'mas-user-panel' ); ?>
                </strong>
            </p>

            <p>
                <?php _e( 'You can use dashicon classes as menu icon in ', 'mas-user-panel' ); ?>

                <strong>
                    <a href="https://developer.wordpress.org/resource/dashicons/" target="_blank">
                        <?php _e( 'this address ', 'mas-user-panel' ); ?>
                    </a>
                </strong>

                <?php _e( '(eg: dashicons dashicons-menu) Also, if your theme uses font awesome icons, you can use fontawesome css classes (eg: far fa-user)', 'mas-user-panel' ); ?>
            </p>
        </div>

        <?php
        $def_menus = mup_def_panel_menus_options();
        $menus = get_option( 'mup_panel_menus' );
        ?>

        <div id="mup-menu-fields-wrap">
            <div style="order: <?php esc_attr_e( $def_menus['dash_order'] ); ?>">
                <div class="mup-menu-fields">
                    <h3><?php _e( 'Dashboard', 'mas-user-panel' ); ?></h3>
                    
                    <div class="mup-input-wrap">
                        <label><?php _e( 'Menu Order', 'mas-user-panel' ); ?></label>
                        <input class="mup-menu-order small-text" type="number" name="dash_order" value="<?php esc_attr_e( $def_menus['dash_order'] ); ?>" min="0"/>
                    </div>

                    <div class="mup-input-wrap">
                        <label><?php _e( 'Icon Classes', 'mas-user-panel' ); ?></label>
                        <input type="text" name="dash_icon" value="<?php esc_attr_e( $def_menus['dash_icon'] ); ?>" min="0"/>
                    </div>

                    <div class="mup-input-wrap">
                        <label><?php _e( 'Title', 'mas-user-panel' ); ?></label>
                        <input class="mup-menu-title" type="text" name="dash_menu_title" placeholder="<?php _e( 'Title Menu', 'mas-user-panel' ); ?>" value="<?php esc_attr_e( $def_menus['dash_title'] ); ?>"/>
                    </div>
                </div>
            </div>

            <div style="order: <?php esc_attr_e( $def_menus['home_order'] ); ?>">
                <div class="mup-menu-fields">
                    <h3><?php _e( 'Home Page', 'mas-user-panel' ); ?></h3>

                    <div class="mup-input-wrap">
                        <label><?php _e( 'Menu Order', 'mas-user-panel' ); ?></label>
                        <input class="mup-menu-order small-text" type="number" name="home_order" value="<?php esc_attr_e( $def_menus['home_order'] ); ?>" min="0"/>
                    </div>

                    <div class="mup-input-wrap">
                        <label><?php _e( 'Icon Classes', 'mas-user-panel' ); ?></label>
                        <input type="text" name="home_icon" value="<?php esc_attr_e( $def_menus['home_icon'] ); ?>" min="0"/>
                    </div>

                    <div class="mup-input-wrap">
                        <input id="mup-show-home" type="checkbox" name="show_home" <?php checked( $def_menus['home_display'] ); ?>/>
                        <label for="mup-show-home"><?php _e( 'Show in panel', 'mas-user-panel' ); ?></label>
                    </div>

                    <div class="mup-input-wrap">
                        <label><?php _e( 'Title', 'mas-user-panel' ); ?></label>
                        <input class="mup-menu-title" type="text" name="home_menu_title" placeholder="<?php _e( 'Title Menu', 'mas-user-panel' ); ?>" value="<?php esc_attr_e( $def_menus['home_title'] ); ?>"/>
                    </div>
                </div>
            </div>

            <div style="order: <?php esc_attr_e( $def_menus['user_edit_order'] ); ?>">
                <div class="mup-menu-fields">
                    <h3><?php _e( 'Edit Profile', 'mas-user-panel' ); ?></h3>
                    
                    <div class="mup-input-wrap">
                        <label><?php _e( 'Menu Order', 'mas-user-panel' ); ?></label>
                        <input class="mup-menu-order small-text" type="number" name="user_edit_order" value="<?php esc_attr_e( $def_menus['user_edit_order'] ); ?>" min="0"/>
                    </div>

                    <div class="mup-input-wrap">
                        <label><?php _e( 'Icon Classes', 'mas-user-panel' ); ?></label>
                        <input type="text" name="user_edit_icon" value="<?php esc_attr_e( $def_menus['user_edit_icon'] ); ?>" min="0"/>
                    </div>

                    <div class="mup-input-wrap">
                        <input id="mup-show-user-edit" type="checkbox" name="show_user_edit" <?php checked( $def_menus['user_edit_display'] ); ?>/>
                        <label for="mup-show-user-edit"><?php _e( 'Show in panel', 'mas-user-panel' ); ?></label>
                    </div>

                    <div class="mup-input-wrap">
                        <label><?php _e( 'Title', 'mas-user-panel' ); ?></label>
                        <input class="mup-menu-title" type="text" name="user_edit_menu_title" placeholder="<?php _e( 'Title Menu', 'mas-user-panel' ); ?>" value="<?php esc_attr_e( $def_menus['user_edit_title'] ); ?>"/>
                    </div>
                </div>
            </div>

            <div style="order: <?php esc_attr_e( $def_menus['notifications_order'] ); ?>">
                <div class="mup-menu-fields">
                    <h3><?php _e( 'Notifications', 'mas-user-panel' ); ?></h3>

                    <div class="mup-input-wrap">
                        <label><?php _e( 'Menu Order', 'mas-user-panel' ); ?></label>
                        <input class="mup-menu-order small-text" type="number" name="notifications_order" value="<?php esc_attr_e( $def_menus['notifications_order'] ); ?>" min="0"/>
                    </div>

                    <div class="mup-input-wrap">
                        <label><?php _e( 'Icon Classes', 'mas-user-panel' ); ?></label>
                        <input type="text" name="notifications_icon" value="<?php esc_attr_e( $def_menus['notifications_icon'] ); ?>" min="0"/>
                    </div>

                    <div class="mup-input-wrap">
                        <input id="mup-show-notifications" type="checkbox" name="show_notifications" <?php checked( $def_menus['notifications_display'] ); ?>/>
                        <label for="mup-show-notifications"><?php _e( 'Show in panel', 'mas-user-panel' ); ?></label>
                    </div>
                    
                    <div class="mup-input-wrap">
                        <label><?php _e( 'Title', 'mas-user-panel' ); ?></label>
                        <input class="mup-menu-title" type="text" name="notifications_menu_title" placeholder="<?php _e( 'Title Menu', 'mas-user-panel' ); ?>" value="<?php esc_attr_e( $def_menus['notifications_title'] ); ?>"/>
                    </div>
                </div>
            </div>

            <div style="order: <?php esc_attr_e( $def_menus['comments_order'] ); ?>">
                <div class="mup-menu-fields">
                    <h3><?php _e( 'Comments', 'mas-user-panel' ); ?></h3>

                    <div class="mup-input-wrap">
                        <label><?php _e( 'Menu Order', 'mas-user-panel' ); ?></label>
                        <input class="mup-menu-order small-text" type="number" name="comments_order" value="<?php esc_attr_e( $def_menus['comments_order'] ); ?>" min="0"/>
                    </div>

                    <div class="mup-input-wrap">
                        <label><?php _e( 'Icon Classes', 'mas-user-panel' ); ?></label>
                        <input type="text" name="comments_icon" value="<?php esc_attr_e( $def_menus['comments_icon'] ); ?>" min="0"/>
                    </div>

                    <div class="mup-input-wrap">
                        <input id="mup-show-comments" type="checkbox" name="show_comments" <?php checked( $def_menus['comments_display'] ); ?>/>
                        <label for="mup-show-comments"><?php _e( 'Show in panel', 'mas-user-panel' ); ?></label>
                    </div>
                    
                    <div class="mup-input-wrap">
                        <label><?php _e( 'Title', 'mas-user-panel' ); ?></label>
                        <input class="mup-menu-title" type="text" name="comments_menu_title" placeholder="<?php _e( 'Title Menu', 'mas-user-panel' ); ?>" value="<?php esc_attr_e( $def_menus['comments_title'] ); ?>"/>
                    </div>
                </div>
            </div>

            <div style="order: <?php esc_attr_e( $def_menus['new_ticket_order'] ); ?>">
                <div class="mup-menu-fields">
                    <h3><?php _e( 'New Ticket', 'mas-user-panel' ); ?></h3>

                    <div class="mup-input-wrap">
                        <label><?php _e( 'Menu Order', 'mas-user-panel' ); ?></label>
                        <input class="mup-menu-order small-text" type="number" name="new_ticket_order" value="<?php esc_attr_e( $def_menus['new_ticket_order'] ); ?>" min="0"/>
                    </div>

                    <div class="mup-input-wrap">
                        <label><?php _e( 'Icon Classes', 'mas-user-panel' ); ?></label>
                        <input type="text" name="new_ticket_icon" value="<?php esc_attr_e( $def_menus['new_ticket_icon'] ); ?>" min="0"/>
                    </div>

                    <div class="mup-input-wrap">
                        <input id="mup-show-new-ticket" type="checkbox" name="show_new_ticket" <?php checked( $def_menus['new_ticket_display'] ); ?>/>
                        <label for="mup-show-new-ticket"><?php _e( 'Show in panel', 'mas-user-panel' ); ?></label>
                    </div>
                    
                    <div class="mup-input-wrap">
                        <label><?php _e( 'Title', 'mas-user-panel' ); ?></label>
                        <input class="mup-menu-title" type="text" name="new_ticket_menu_title" placeholder="<?php _e( 'Title Menu', 'mas-user-panel' ); ?>" value="<?php esc_attr_e( $def_menus['new_ticket_title'] ); ?>"/>
                    </div>
                </div>
            </div>

            <div style="order: <?php esc_attr_e( $def_menus['tickets_order'] ); ?>">
                <div class="mup-menu-fields">
                    <h3><?php _e( 'Tickets', 'mas-user-panel' ); ?></h3>

                    <div class="mup-input-wrap">
                        <label><?php _e( 'Menu Order', 'mas-user-panel' ); ?></label>
                        <input class="mup-menu-order small-text" type="number" name="tickets_order" value="<?php esc_attr_e( $def_menus['tickets_order'] ); ?>" min="0"/>
                    </div>

                    <div class="mup-input-wrap">
                        <label><?php _e( 'Icon Classes', 'mas-user-panel' ); ?></label>
                        <input type="text" name="tickets_icon" value="<?php esc_attr_e( $def_menus['tickets_icon'] ); ?>" min="0"/>
                    </div>

                    <div class="mup-input-wrap">
                        <input id="mup-show-tickets" type="checkbox" name="show_tickets" <?php checked( $def_menus['tickets_display'] ); ?>/>
                        <label for="mup-show-tickets"><?php _e( 'Show in panel', 'mas-user-panel' ); ?></label>
                    </div>
                    
                    <div class="mup-input-wrap">
                        <label><?php _e( 'Title', 'mas-user-panel' ); ?></label>
                        <input class="mup-menu-title" type="text" name="tickets_menu_title" placeholder="<?php _e( 'Title Menu', 'mas-user-panel' ); ?>" value="<?php esc_attr_e( $def_menus['tickets_title'] ); ?>"/>
                    </div>
                </div>
            </div>

            <div style="order: <?php esc_attr_e( $def_menus['logout_order'] ); ?>">
                <div class="mup-menu-fields">
                    <h3><?php _e( 'Logout', 'mas-user-panel' ); ?></h3>
                   
                    <div class="mup-input-wrap">
                        <label><?php _e( 'Menu Order', 'mas-user-panel' ); ?></label>
                        <input class="mup-menu-order small-text" type="number" name="logout_order" value="<?php esc_attr_e( $def_menus['logout_order'] ); ?>" min="0"/>
                    </div>

                    <div class="mup-input-wrap">
                        <label><?php _e( 'Icon Classes', 'mas-user-panel' ); ?></label>
                        <input type="text" name="logout_icon" value="<?php esc_attr_e( $def_menus['logout_icon'] ); ?>" min="0"/>
                    </div>
                    
                    <div class="mup-input-wrap">
                        <label><?php _e( 'Title', 'mas-user-panel' ); ?></label>
                        <input class="mup-menu-title" type="text" name="logout_menu_title" placeholder="<?php _e( 'Title Menu', 'mas-user-panel' ); ?>" value="<?php esc_attr_e( $def_menus['logout_title'] ); ?>"/>
                    </div>
                </div>
            </div>

            <?php if ( $menus ): ?>
                <?php for ( $i = 0; $i < count( $menus['menu_type'] ); $i++ ): ?>
                    <div style="order: <?php esc_attr_e( $menus['menu_order'][$i] ); ?>">
                        <div class="mup-menu-fields">
                            <h3><?php _e( 'Custom Menu', 'mas-user-panel' ); ?></h3>

                            <div class="mup-menu-display-status">
                                <div class="mup-input-wrap">
                                    <label><?php _e( 'Menu Order', 'mas-user-panel' ); ?></label>
                                    <input class="mup-menu-order small-text" type="number" name="menu_order[]" value="<?php esc_attr_e( $menus['menu_order'][$i] ); ?>" min="0">
                                </div>

                                <div class="mup-input-wrap">
                                    <label><?php _e( 'Icon Classes', 'mas-user-panel' ); ?></label>
                                    <input type="text" name="menu_icon[]" value="<?php esc_attr_e( $menus['menu_icon'][$i] ); ?>" min="0"/>
                                </div>

                                <div class="mup-input-wrap">
                                    <select name="show_menu[]">
                                        <option value="show" <?php selected( $menus['show_menu'][$i], 'show' ); ?>>
                                            <?php _e( 'Show in panel', 'mas-user-panel' ); ?>
                                        </option>

                                        <option value="hide" <?php selected( $menus['show_menu'][$i], 'hide' ); ?>>
                                            <?php _e( 'Hide in panel', 'mas-user-panel' ); ?>
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="mup-input-wrap">
                                <select class="mup-menu-type" name="menu_type[]">
                                    <option>
                                        <?php _e( 'Select content type', 'mas-user-panel' ); ?>
                                    </option>

                                    <option value="link" <?php selected( $menus['menu_type'][$i], 'link' )?>>
                                        <?php _e( 'Link to other page', 'mas-user-panel' ); ?>
                                    </option>

                                    <option value="shortcode" <?php selected( $menus['menu_type'][$i], 'shortcode' )?>>
                                        <?php _e( 'Shortcode', 'mas-user-panel' ); ?>
                                    </option>
                                </select>
                            </div>

                            <div class="mup-input-wrap">
                                <label><?php _e( 'Title', 'mas-user-panel' ); ?></label>
                                <input class="mup-menu-title" type="text" name="menu_title[]" placeholder="<?php _e( 'Title Menu', 'mas-user-panel' ); ?>" value="<?php esc_attr_e( $menus['menu_title'][$i] ); ?>"/>
                            </div>

                            <input class="mup-menu-content" type="text" name="menu_content[]" placeholder="<?php _e( 'Shortcode', 'mas-user-panel' ); ?>" value="<?php esc_attr_e( $menus['menu_content'][$i] ); ?>"/>
                        
                            <div class="mup-actions">
                                <a class="mup-remove-menu" href="#">
                                    <?php _e( 'Delete', 'mas-user-panel' ); ?>
                                </a>
                            </div>  
                        </div>
                    </div>
                <?php endfor; ?>
            <?php endif; ?>
        </div>

        <p>
            <input id="mup-add-menu-btn" class="button-primary" type="button" value="<?php _e( 'Add New Menu', 'mas-user-panel' ); ?>">
            <input class="button-primary" type="submit" name="submit" value="<?php _e( 'Save Settings', 'mas-user-panel' ); ?>">
        </p>
    </form>
</div>