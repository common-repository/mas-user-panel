<?php include_once MUP_USER_PATH . '/register-form-handler.php'; ?>

<form id="mup-register-form" method="post">
    <?php if ( count( $errors ) > 0 ) {
        mup_show_message( $errors, 'error' );
    }

    if ( isset( $success ) ) {
        mup_show_message( $success, 'success' );
    }

    wp_nonce_field( 'register_nonce', 'mup_register_nonce' );

    $posts = get_posts([
        'post_type' => 'mup_reg_field',
        'order' => 'ASC',
        'orderby' => 'menu_order',
        'numberposts' => -1,
    ]);

    foreach ($posts as $post) {
        if ( $post->post_title === 'first_name' ) {
            mup_first_name( $post->post_content );
        }

        if ( $post->post_title === 'last_name' ) {
            mup_last_name( $post->post_content );
        }

        if ( $post->post_title === 'display_name' ) {
            mup_display_name( $post->post_content );
        }

        if ( $post->post_title === 'user_login' ) {
            mup_user_login( $post->post_content );
        }

        if ( $post->post_title === 'user_email' ) {
            mup_user_email( $post->post_content );
        }

        if ( $post->post_title === 'user_pass' ) {
            mup_user_pass( $post->post_content );
        }

        if ( $post->post_title === 'user_url' ) {
            mup_user_url( $post->post_content );
        }
    }
    ?>

    <input id="mup-register-btn" type="submit" name="register" value="<?php _e( 'register', 'mas-user-panel' ); ?>"/>

    <?php $login = mup_login_options(); ?>

    <?php if ( $login['login_slug'] ): ?>
        <?php $login_page = get_post( $login['login_slug'] ); ?>

        <div id="mup-form-links">
            <a href="<?php echo esc_url( home_url( $login_page->post_name ) ); ?>">
                <?php _e( 'Go to login form', 'mas-user-panel' ); ?>
            </a>
        </div>
    <?php endif; ?>
</form>
