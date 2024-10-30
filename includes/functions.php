<?php
function mup_plugin_activate() {
    mup_generate_pages();
    mup_generate_required_reg_fields();
}

function mup_generate_pages() {
    if ( ! current_user_can( 'activate_plugins' ) ) return;

    global $wpdb;

    $q = "SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'mup-panel'";

    if ( null === $wpdb->get_row( $q, 'ARRAY_A' ) ) {
        $page = array(
            'post_title'  => __( 'User Panel', 'mas-user-panel' ),
            'post_name' => 'mup-panel',
            'post_content' => '[mup_user_panel]',
            'post_status' => 'publish',
            'post_author' => get_current_user_id(),
            'post_type'   => 'page',
        );

        wp_insert_post( $page );
    }

    $q = "SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'mup-register'";

    if ( null === $wpdb->get_row( $q, 'ARRAY_A' ) ) {
        $page = array(
            'post_title'  => __( 'Register', 'mas-user-panel' ),
            'post_name' => 'mup-register',
            'post_content' => '[mup_register_form]',
            'post_status' => 'publish',
            'post_author' => get_current_user_id(),
            'post_type'   => 'page',
        );

        wp_insert_post( $page );
    }

    $q = "SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'mup-login'";

    if ( null === $wpdb->get_row( $q, 'ARRAY_A' ) ) {
        $page = array(
            'post_title'  => __( 'Login', 'mas-user-panel' ),
            'post_name' => 'mup-login',
            'post_content' => '[mup_login_form]',
            'post_status' => 'publish',
            'post_author' => get_current_user_id(),
            'post_type'   => 'page',
        );

        wp_insert_post( $page );
    }

    $q = "SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'mup-lost-password'";

    if ( null === $wpdb->get_row( $q, 'ARRAY_A' ) ) {
        $page = array(
            'post_title'  => __( 'Lost Password', 'mas-user-panel' ),
            'post_name' => 'mup-lost-password',
            'post_content' => '[mup_lost_password_form]',
            'post_status' => 'publish',
            'post_author' => get_current_user_id(),
            'post_type'   => 'page',
        );

        wp_insert_post( $page );
    }

    $q = "SELECT post_name FROM {$wpdb->prefix}posts WHERE post_name = 'mup-reset-password'";

    if ( null === $wpdb->get_row( $q, 'ARRAY_A' ) ) {
        $page = array(
            'post_title'  => __( 'Reset Password', 'mas-user-panel' ),
            'post_name' => 'mup-reset-password',
            'post_content' => '[mup_reset_password_form]',
            'post_status' => 'publish',
            'post_author' => get_current_user_id(),
            'post_type'   => 'page',
        );

        wp_insert_post( $page );
    }
}

function mup_generate_required_reg_fields() {
    // user_login
    if ( ! MUPRegField::field_exist( 'user_login' ) ) {
        $settings = [
            'placeholder' => __( 'Firstname', 'mas-user-panel' ),
            'min' => 5,
            'info' => ''
        ];

        $field_data = [
            'post_title' => 'user_login',
            'post_type' => 'mup_reg_field',
            'post_content' => maybe_serialize( $settings ),
            'menu_order' => 0,
            'post_status' => 'publish',
        ];

        wp_insert_post( $field_data );
    }
   
    // email
    if ( ! MUPRegField::field_exist( 'user_email' ) ) {
        $settings = [
            'placeholder' => __( 'Email', 'mas-user-panel' ),
            'info' => ''
        ];

        $field_data = [
            'post_title' => 'user_email',
            'post_type' => 'mup_reg_field',
            'post_content' => maybe_serialize( $settings ),
            'menu_order' => 1,
            'post_status' => 'publish',
        ];

        wp_insert_post( $field_data );
    }
    
    //password
    if ( ! MUPRegField::field_exist( 'user_pass' ) ) {
        $settings = [
            'placeholder' => __( 'Password', 'mas-user-panel' ),
            'conf_placeholder' => __( 'Confirm Pasword', 'mas-user-panel' ),
            'info' => '',
            'min' => 8
        ];

        $field_data = [
            'post_title' => 'user_pass',
            'post_type' => 'mup_reg_field',
            'post_content' => maybe_serialize( $settings ),
            'menu_order' => 2,
            'post_status' => 'publish',
        ];

        wp_insert_post( $field_data );
    }
}

register_activation_hook( MUP_DIR_PATH . 'mas-user-panel.php', 'mup_plugin_activate' );

function mup_disable_admin_bar() {
    $general = mup_general_options();

    if ( ! current_user_can( 'administrator' ) and ! is_admin() ) {
        $user = get_user_by( 'ID', get_current_user_id() );

        if ( $user and in_array( $user->roles[0], $general['admin_bar_access'] ) ) {
            show_admin_bar( false );
        }
    }
}

add_action( 'after_setup_theme', 'mup_disable_admin_bar' );

function mup_redirect_admin_area() {
    $general = mup_general_options();

    if ( ! current_user_can( 'manage_options' ) and ! wp_doing_ajax() ) {
        $user = get_user_by( 'ID', get_current_user_id() );

        if ( in_array( $user->roles[0], $general['admin_area_access'] ) ) {
            wp_safe_redirect(home_url());
            exit;
        }
    }
}

add_action( 'admin_init', 'mup_redirect_admin_area' );

function mup_allowed_pages( $page_id ) {
    $page_id = intval( $page_id );
    $allowed = [];
    $pages = get_pages( [ 'post_status' => [ 'publish', 'draft' ] ] );

    foreach ( $pages as $page ) {
        $allowed[] = $page->ID;
    }

    return in_array( $page_id, $allowed ) ? $page_id : false;
}

function mup_admin_ticket_notice_count( $post_parent = 0 ) {
    if ( ! empty( $post_parent ) and $post_parent > 0 ) {
        $posts = get_posts([
            'post_type' => 'mup_ticket',
            'publish' => true,
            'post_parent' => $post_parent,
            'meta_query' => [
                [ 'key' => 'mup_admin_ticket_read', 'value' => 'admin_unread' ]
            ]
        ]);
    } else {
        $posts = get_posts([
            'post_type' => 'mup_ticket',
            'publish' => true,
            'meta_query' => [
                [ 'key' => 'mup_admin_ticket_read', 'value' => 'admin_unread' ]
            ]
        ]);
    }

    $count = 0;

    while ( $count < count( $posts ) ) $count++;

    return $count;
}

function mup_ticket_notice_count( $post_parent = 0 ) {
    if ( ! empty( $post_parent ) and $post_parent > 0 ) {
        $posts = get_posts([
            'post_type' => 'mup_ticket',
            'publish' => true,
            'post_parent' => $post_parent,
            'meta_query' => [
                [ 'key' => 'mup_ticket_read', 'value' => 'user_unread' ]
            ]
        ]);
    } else {
        $posts = get_posts([
            'post_type' => 'mup_ticket',
            'publish' => true,
            'meta_query' => [
                [ 'key' => 'mup_ticket_read', 'value' => 'user_unread' ]
            ]
        ]);
    }

    $count = 0;

    foreach ( $posts as $post ) {
        $parent = get_post( $post->post_parent );
        if ( $parent->post_author == get_current_user_id() ) $count++;
    }

    return $count;
}

function mup_delete_ticket( $post_id ) {
    $posts = get_posts([
        'numberposts' => -1,
        'post_type' => 'mup_ticket',
        'post_parent' => $post_id
    ]);

    if ( is_array( $posts ) and count( $posts ) > 0 ) {
        foreach ( $posts as $post ) {
            wp_delete_post( $post->ID, true );
        }
    }

    wp_delete_post( $post_id, true );
}

function mup_panel_menu_option_html_fields() {
    ob_start(); ?>

    <div>
        <div class="mup-menu-fields">
            <h3><?php _e( 'Custom Menu', 'mas-user-panel' ); ?></h3>

            <div class="mup-menu-display-status">
                <div class="mup-input-wrap">
                    <label><?php _e( 'Menu Order', 'mas-user-panel' ); ?></label>
                    <input class="mup-menu-order small-text" type="number" name="menu_order[]" min="0"/>
                </div>

                <div class="mup-input-wrap">
                    <label><?php _e( 'Icon Classes', 'mas-user-panel' ); ?></label>
                    <input type="text" name="menu_icon[]" min="0"/>
                </div>

                <select name="show_menu[]">
                    <option value="show" selected>
                        <?php _e( 'Show in panel', 'mas-user-panel' ); ?>
                    </option>

                    <option value="hide">
                        <?php _e( 'Hide in panel', 'mas-user-panel' ); ?>
                    </option>
                </select>
            </div>

            <div class="mup-input-wrap">
                <select class="mup-menu-type" name="menu_type[]">
                    <option><?php _e( 'Content Type', 'mas-user-panel' ); ?></option>
                    <option value="link"><?php _e( 'Link to other page', 'mas-user-panel' ); ?></option>
                    <option value="shortcode"><?php _e( 'Shortcode', 'mas-user-panel' ); ?></option>
                </select>
            </div>

            <div class="mup-input-wrap">
                <label><?php _e( 'Title', 'mas-user-panel' ); ?></label>
                <input class="mup-menu-title" type="text" name="menu_title[]" placeholder="<?php _e( 'Menu Title', 'mas-user-panel' ); ?>" value=""/>
            </div>
            
            <input class="mup-menu-content" type="text" name="menu_content[]" placeholder="<?php _e( 'Shortcode', 'mas-user-panel' ); ?>" value=""/>

            <div class="mup-actions">
                <a class="mup-remove-menu" href="#">
                    <?php _e( 'Delete Menu', 'mas-user-panel' ); ?>
                </a>
            </div>
        </div>
    </div>

    <?php return ob_get_clean();
}

function mup_active_section( $section ) {
    if ( isset( $_GET['section'] ) and ! empty( $_GET['section'] ) ) {
        if ( $_GET['section'] === $section ) echo 'class=mup-active';
    }
}

function mup_upload_pro_pic( $img_file ) {
    $allowed_ext = [ 'image/jpeg', 'image/jpg', 'image/png' ];
    $panel = mup_panel_options();

    if ( ! in_array( $img_file['type'], $allowed_ext ) ) {
        $error = __( 'Image format is not allowed.', 'mas-user-panel' );
    } elseif ( $img_file['size'] > ( 1204 * $panel['avatar_size'] ) ) {
        $error = sprintf( __( 'Maximum avatar image size is %d KB.', 'mas-user-panel' ), $panel['avatar_size'] );
    } else {
        if ( ! function_exists( 'wp_handle_upload' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }

        $upload = wp_handle_upload( $img_file, [ 'test_form' => false ] );

        if ( $upload and ! isset( $upload['error'] ) ) {
            $user_id = get_current_user_id();
            $get_previous_url = get_user_meta( $user_id, 'mup_profile_img', true );
            $file_path = wp_get_upload_dir()['basedir'] . wp_get_upload_dir()['subdir'] . '/' . basename( $get_previous_url );

            wp_delete_file( $file_path );
            update_user_meta( $user_id, 'mup_profile_img', $upload['url'] );

            $error = false;
        } else {
            $error = __( 'There is a problem uploading avatar.', 'mas-user-panel' );
        }
    }

    return $error;
}

function mup_display_profile_pic( $avatar, $id_or_email, $size, $default, $alt ) {
    $profile_img_url = '';

    if ( is_object( $id_or_email ) ) {
        $user = get_user_by( 'email', $id_or_email->comment_author_email );

        if ( $user ) {
            $profile_img_url = get_user_meta( $user->ID, 'mup_profile_img', true );
        }
    } else {
        $profile_img_url = get_user_meta( $id_or_email, 'mup_profile_img', true );
    }

    if ( $profile_img_url ) {
        $profile_img = "<img alt='$alt' src='$profile_img_url' class='avatar avatar-$size photo' style='object-fit: cover' height='$size' width='$size'/>";
    } else {
        $profile_img = $avatar;
    }

    return $profile_img;
}

add_filter( 'get_avatar', 'mup_display_profile_pic', 10, 5 );

function mup_notice_count() {
    $user_id = get_current_user_id();
    $last_read = get_user_meta( $user_id, 'mup_notice_read', true );
    $count = 0;

    $posts = get_posts([
        'post_type' => 'mup_notifications',
        'publish' => true
    ]);

    foreach ($posts as $post) {
        if ( get_post_timestamp( $post->ID ) > $last_read ) $count++;
    }

    return $count;
}

function mup_set_last_notice_time() {
    $posts = get_posts( [ 'post_type' => 'mup_notifications' ] );
    $count = 0;

    if ( count( $posts ) > 0 ) {
        foreach ( $posts as $post ) {
            $count++;

            if ( $count == 1 ) {
                update_user_meta( get_current_user_id(), 'mup_notice_read', get_post_timestamp( $post->ID ) );
            }
        }
    }
}

function mup_mail_from_name( $original_email_from ) {
    return get_bloginfo( 'name' );
}

add_filter( 'wp_mail_from_name', 'mup_mail_from_name' );

function mup_email_template( $content ) {
    ob_start();
    $dir = is_rtl() ? 'direction: rtl;' : '';
    ?>

    <div style="
        background-color: #fff;
        max-width: 600px;
        margin: auto;
        padding: 20px;
        <?php esc_attr_e( $dir ); ?>
        border: 1px solid #e6e6e6;
        border-right: 4px solid #43aed4;
        border-radius: 5px;
    ">
        <?php echo wpautop( $content ); ?>
    </div>

    <?php return ob_get_clean();
}

function mup_show_message( $text, $type ) {
    ob_start(); ?>

    <?php if ( ! is_array( $text ) ): ?>
        <div class="mup-msg mup-<?php esc_attr_e( $type ); ?>-msg">
            <span><?php esc_html_e( $text ); ?></span>
        </div>
    <?php else: ?>
        <div class="mup-msg mup-<?php esc_attr_e( $type ); ?>-msg">
            <h3><?php _e( 'Fix the following errors:', 'mas-user-panel' ); ?></h3>

            <ul>
                <?php foreach ( $text as $message ) echo '<li>' . esc_html( $message ) . '</li>'; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php echo ob_get_clean();
}

function mup_access_prepare( $access ) {
    $roles = get_editable_roles();
    $allowed = [];
    $role_arr = [];

    foreach ( $roles as $role => $details ) $allowed[] = $role;

    for ( $i = 0; $i < count( $access ); $i++ ) {
        if ( in_array( $access[$i], $allowed ) ) {
            $role_arr[] = sanitize_text_field( $access[$i] );
        }
    }

    return $role_arr;
}