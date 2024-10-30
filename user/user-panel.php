<div id="mup-user-panel">
    <aside id="mup-sidebar">
        <?php $panel = mup_panel_options(); ?>

        <?php if ( $panel['display_top_sidebar'] ): ?>
            <div id="mup-top-sidebar">
                <?php
                $user_id = get_current_user_id();
                $user = get_user_by( 'ID', $user_id );
                ?>

                <?php echo get_avatar( $user->ID, '40' ); ?>
                <span>
                    <?php
                    if ( ! empty( $user->first_name ) and ! empty( $user->last_name ) ) {
                        esc_attr_e( $user->first_name . ' ' . $user->last_name );
                    } else {
                        esc_attr_e( $user->display_name );
                    }
                    ?>
                </span>
            </div>
        <?php endif; ?>

        <nav id="mup-nav" style="display: flex; flex-direction: column">
            <?php
            $sections = [];
            $default_menus = mup_def_panel_menus_options();
            $panel_menus = get_option( 'mup_panel_menus' );
            $dashboard_active = '';
            $remove_args = ['paged', 'del-avatar', 'ticket'];

            if ( $default_menus['user_edit_display'] ) $sections[] = 'user-edit';
            if ( $default_menus['notifications_display'] ) $sections[] = 'notifications';
            if ( $default_menus['comments_display'] ) $sections[] = 'comments';
            if ( $default_menus['new_ticket_display'] ) $sections[] = 'new-ticket';

            if ( $default_menus['tickets_display'] ) {
                $sections[] = 'ticket-list';
                $sections[] = 'single-ticket';
            }

            if ( $panel_menus ) {
                for ($i = 0; $i < count( $panel_menus['menu_type'] ); $i++) {
                    if ( ! empty( $panel_menus['menu_type'][$i] ) and ! empty( $panel_menus['menu_title'][$i] ) and ! empty( $panel_menus['menu_content'][$i] ) ) {
                        if ( $panel_menus['menu_type'][$i] === 'shortcode' ) {
                            $sections[] = 'section-' . ( $i + 1 );
                        }
                    }
                }
            }

            if ( ! isset( $_GET['section'] ) or empty( $_GET['section'] ) or ! in_array( $_GET['section'], $sections ) ) {
                $dashboard_active = 'class=mup-active';
            }
            ?>

            <a <?php echo $dashboard_active; ?> href="<?php echo esc_url( add_query_arg( 'section', 'dashboard', remove_query_arg( $remove_args ) ) ); ?>" style="order: <?php esc_attr_e( $default_menus['dash_order'] ); ?>">
                <?php if ( ! empty( $default_menus['dash_icon'] ) ): ?>
                    <i class="<?php esc_html_e( $default_menus['dash_icon'] ); ?>"></i>
                <?php endif; ?>

                <span><?php esc_html_e( $default_menus['dash_title'] ); ?></span>
            </a>

            <?php if ( $default_menus['home_display'] ): ?>
                <a href="<?php echo esc_url( home_url() ); ?>" style="order: <?php esc_attr_e( $default_menus['home_order'] ); ?>">
                    <?php if ( ! empty( $default_menus['home_icon'] ) ): ?>
                        <i class="<?php esc_html_e( $default_menus['home_icon'] ); ?>"></i>
                    <?php endif; ?>

                    <span><?php esc_html_e( $default_menus['home_title'] ); ?></span>
                </a>
            <?php endif; ?>

            <?php if ( $default_menus['user_edit_display'] ): ?>
                <a <?php mup_active_section( 'user-edit' ); ?> href="<?php echo esc_url( add_query_arg( 'section', 'user-edit', remove_query_arg( $remove_args ) ) ); ?>" style="order: <?php esc_attr_e( $default_menus['user_edit_order'] ); ?>">
                    <?php if ( ! empty( $default_menus['user_edit_icon'] ) ): ?>
                        <i class="<?php esc_html_e( $default_menus['user_edit_icon'] ); ?>"></i>
                    <?php endif; ?>

                    <span><?php esc_html_e( $default_menus['user_edit_title'] ); ?></span>
                </a>
            <?php endif; ?>

            <?php if ( $default_menus['notifications_display'] ): ?>
                <a id="mup-notice-link"<?php mup_active_section( 'notifications' ); ?> href="<?php echo esc_url( add_query_arg( 'section', 'notifications', remove_query_arg( $remove_args ) ) ); ?>" style="order: <?php esc_attr_e( $default_menus['notifications_order'] ); ?>">
                    <?php if ( ! empty( $default_menus['notifications_icon'] ) ): ?>
                        <i class="<?php esc_html_e( $default_menus['notifications_icon'] ); ?>"></i>
                    <?php endif; ?>

                    <span><?php esc_html_e( $default_menus['notifications_title'] ); ?></span>

                    <?php
                    if ( mup_notice_count() ) {
                        echo '<span class="mup-unread-count">' . esc_html( mup_notice_count() ) . '</span>';
                    }
                    ?>
                </a>
            <?php endif; ?>

            <?php if ( $default_menus['comments_display'] ): ?>
                <a <?php mup_active_section( 'comments' ); ?> href="<?php echo esc_url( add_query_arg( 'section', 'comments', remove_query_arg( $remove_args ) ) ); ?>" style="order: <?php esc_attr_e( $default_menus['comments_order'] ); ?>">
                    <?php if ( ! empty( $default_menus['comments_icon'] ) ): ?>
                        <i class="<?php esc_html_e( $default_menus['comments_icon'] ); ?>"></i>
                    <?php endif; ?>

                    <span><?php esc_html_e( $default_menus['comments_title'] ); ?></span>
                </a>
            <?php endif; ?>

            <?php if ( $default_menus['new_ticket_display'] ): ?>
                <a <?php mup_active_section( 'new-ticket' ); ?> href="<?php echo esc_url( add_query_arg( 'section', 'new-ticket', remove_query_arg( $remove_args ) ) ); ?>" style="order: <?php esc_attr_e( $default_menus['new_ticket_order'] ); ?>">
                    <?php if ( ! empty( $default_menus['new_ticket_icon'] ) ): ?>
                        <i class="<?php esc_html_e( $default_menus['new_ticket_icon'] ); ?>"></i>
                    <?php endif; ?>

                    <span><?php esc_html_e( $default_menus['new_ticket_title'] ); ?></span>
                </a>
            <?php endif; ?>

            <?php if ( $default_menus['tickets_display'] ): ?>
                <a <?php mup_active_section( 'ticket-list' ); mup_active_section( 'single-ticket' ); ?> href="<?php echo esc_url( add_query_arg( 'section', 'ticket-list', remove_query_arg( $remove_args ) ) ); ?>" style="order: <?php esc_attr_e( $default_menus['tickets_order'] ); ?>">
                    <?php if ( ! empty( $default_menus['tickets_icon'] ) ): ?>
                        <i class="<?php esc_html_e( $default_menus['tickets_icon'] ); ?>"></i>
                    <?php endif; ?>

                    <span><?php esc_html_e( $default_menus['tickets_title'] ); ?></span>

                    <?php
                    if ( mup_ticket_notice_count() ) {
                        echo '<span class="mup-unread-count">' . esc_html( mup_ticket_notice_count() ) . '</span>';
                    }
                    ?>
                </a>
            <?php endif; ?>

            <?php if ( $panel_menus ): ?>
                <?php for ( $i = 0; $i < count( $panel_menus['menu_type'] ); $i++ ): ?>
                    <?php if ( $panel_menus['show_menu'][$i] === 'show' and ! empty( $panel_menus['menu_type'][$i] ) and ! empty( $panel_menus['menu_title'][$i] ) and ! empty( $panel_menus['menu_content'][$i] ) ): ?>
                        <?php if ( $panel_menus['menu_type'][$i] === 'shortcode' ): ?>
                            <?php $menu_slug = 'section-' . ( $i + 1 ); ?>

                            <a <?php mup_active_section( $menu_slug ); ?> href="<?php echo esc_url( add_query_arg( 'section', $menu_slug, remove_query_arg( $remove_args ) ) ); ?>" style="order: <?php esc_attr_e( $panel_menus['menu_order'][$i] ); ?>">
                                <?php if ( ! empty( $panel_menus['menu_icon'][$i] ) ): ?>
                                    <i class="<?php esc_html_e( $panel_menus['menu_icon'][$i] ); ?>"></i>
                                <?php endif; ?>

                                <span><?php esc_html_e( $panel_menus['menu_title'][$i] ); ?></span>
                            </a>
                        <?php else: ?>
                            <a href="<?php echo esc_url( $panel_menus['menu_content'][$i] ); ?>" target="_blank" style="order: <?php esc_attr_e( $panel_menus['menu_order'][$i] ); ?>">
                                <?php if ( ! empty( $panel_menus['menu_icon'][$i] ) ): ?>
                                    <i class="<?php esc_html_e( $panel_menus['menu_icon'][$i] ); ?>"></i>
                                <?php endif; ?>

                                <span><?php esc_html_e( $panel_menus['menu_title'][$i] ); ?></span>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endfor; ?>
            <?php endif; ?>

            <?php
            $login = mup_login_options();
            $after_logout = $login['after_logout'] ? wp_logout_url( $login['after_logout'] ) : wp_logout_url();
            ?>

            <a id="mup-logout" href="<?= esc_url( $after_logout ); ?>" style="order: <?php esc_attr_e( $default_menus['logout_order'] ); ?>">
                <?php if ( ! empty( $default_menus['logout_icon'] ) ): ?>
                    <i class="<?php esc_html_e( $default_menus['logout_icon'] ); ?>"></i>
                <?php endif; ?>

                <span><?php esc_html_e( $default_menus['logout_title'] ); ?></span>
            </a>
        </nav>
    </aside>

    <div id="mup-content">
        <?php
        $menus = [];

        if ( $panel_menus ) {
            for ($i = 0; $i < count( $panel_menus['menu_type'] ); $i++) {
                if ( ! empty( $panel_menus['menu_type'][$i] ) and ! empty( $panel_menus['menu_title'][$i] ) and ! empty( $panel_menus['menu_content'][$i] ) ) {
                    if ( $panel_menus['menu_type'][$i] === 'shortcode' ) $menus[] = 'section-' . ( $i + 1 );
                }
            }
        }

        if ( isset( $_GET['section'] ) ) {
            $section = $_GET['section'];

            if( $section === 'dashboard' ) {
                include_once MUP_USER_PATH . 'panel-sections/dashboard.php';
            } elseif( $default_menus['user_edit_display'] and $section === 'user-edit' ) {
                include_once MUP_USER_PATH . 'panel-sections/user-edit.php';
            } elseif ( $default_menus['comments_display'] and $section === 'comments' ) {
                include_once MUP_USER_PATH . 'panel-sections/comments.php';
            } elseif ( $default_menus['new_ticket_display'] and $section === 'new-ticket' ) {
                include_once MUP_USER_PATH . 'panel-sections/new-ticket.php';
            } elseif ( $default_menus['tickets_display'] and $section === 'ticket-list' ) {
                include_once MUP_USER_PATH . 'panel-sections/ticket-list.php';
            } elseif ( $default_menus['tickets_display'] and $section === 'single-ticket' and isset( $_GET['ticket'] ) and ! empty( $_GET['ticket'] ) ) {
                include_once MUP_USER_PATH . 'panel-sections/single-ticket.php';
            } elseif ( $default_menus['notifications_display'] and $section === 'notifications' ) {
                include_once MUP_USER_PATH . 'panel-sections/notifications.php';
            } elseif ( in_array( $section, $menus ) ) {
                $explode = explode('-', $section);
                $i = intval( $explode[1] ) - 1;

                echo do_shortcode( $panel_menus['menu_content'][$i] );
            } else {
                include_once MUP_USER_PATH . 'panel-sections/dashboard.php';
            }
        } else {
            include_once MUP_USER_PATH . 'panel-sections/dashboard.php';
        }
        ?>
    </div>
</div>