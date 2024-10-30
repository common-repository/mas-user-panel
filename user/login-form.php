<form id="mup-login-form" method="post">
    <?php
    if ( isset( $_REQUEST['error'] ) ) {
        if ($_REQUEST['error'] === 'invalid_request') {
            mup_show_message(__('Invalid Request.', 'mas-user-panel'), 'error');
        } elseif ($_REQUEST['error'] === 'empty_username') {
            mup_show_message(__('Username must not be empty.', 'mas-user-panel'), 'error');
        } elseif ($_REQUEST['error'] === 'empty_pass') {
            mup_show_message(__('Password must not be empty.', 'mas-user-panel'), 'error');
        } elseif (isset($_REQUEST['error']) and $_REQUEST['error'] === 'activation') {
            mup_show_message(__('Your account is not active.', 'mas-user-panel'), 'error');
        } else {
            mup_show_message(__('Sorry, there is a problem logging in.', 'mas-user-panel'), 'error');
        }
    }

    $register = mup_register_options();

    if ( $register['register_activation'] and isset( $_GET['email'] ) and $_GET['key'] ) {
        $user = get_user_by( 'email', $_GET['email'] );
        $status = get_user_meta( $user->ID, 'mup_user_status', true );

        if ( $user and ! $status and $user->user_activation_key === $_GET['key'] ) {
            update_user_meta( $user->ID, 'mup_user_status', 1 );
            mup_show_message( __( 'Your account has been activated. You caد log in now.', 'mas-user-panel' ), 'success' );
        } else {
            mup_show_message( __( 'Invalid Request.', 'mas-user-panel' ), 'error' );
        }
    }

    if ( isset( $_GET['login'] ) and $_GET['login'] === 'invalidkey' ) {
         mup_show_message( __( 'Invalid Request.', 'mas-user-panel' ), 'error' );
    }

    if ( isset( $_GET['checkemail'] ) and $_GET['checkemail'] === 'confirm' ) {
        mup_show_message( __( 'Password recovery link has been sent to your email. Please check your email and click on the link.', 'mas-user-panel' ), 'success' );
    }

    if ( isset( $_GET['login'] ) and $_GET['login'] === 'expiredkey' ) {
        mup_show_message( __( 'Password recovery link has expired.', 'mas-user-panel' ), 'error' );
    }

    if ( isset( $_GET['password'] ) and $_GET['password'] === 'changed' ) {
        mup_show_message( __( 'Password changed successfully. You can log in now.', 'mas-user-panel' ), 'success' );
    }

    wp_nonce_field( 'login_nonce', 'mup_login_nonce' );

    $qo = get_queried_object();
    ?>

    <input type="hidden" name="mup_login_slug" value="<?php esc_attr_e( $qo->post_name ) ?>">

    <p>
        <input type="text" name="user_login" placeholder="<?php esc_attr_e( 'Username or email', 'mas-user-panel' ); ?>"/>
    </p>

    <p>
        <input type="password" name="user_pass" placeholder="<?php esc_attr_e( 'Password', 'mas-user-panel' ); ?>"/>
    </p>

    <p>
        <input id="mup-remember" name="remember" type="checkbox"/>

        <label for="mup-remember">
            <?php _e( 'Remember', 'mas-user-panel' ); ?>
        </label>
    </p>

    <input type="submit" name="mup_submit_login" value="<?php esc_attr_e( 'Login', 'mas-user-panel' ); ?>"/>

    <?php
    $register = mup_register_options();
    $general = mup_general_options();
    ?>

    <?php if ( $register['register_slug'] or $general['lost_pass_slug'] ): ?>
        <div id="mup-form-links">
            <?php
            $register_page = get_post( $register['register_slug'] );
            $lost_pass_page = get_post( $general['lost_pass_slug'] );
            ?>

            <?php if ( $register['register_slug'] ): ?>
                <?php $register_page = get_post( $register['register_slug'] ); ?>

                <a href="<?php esc_attr_e( $register_page->post_name ); ?>">
                    <?php _e( 'Register', 'mas-user-panel' ); ?>
                </a>
            <?php endif; ?>

            <?php
            if ( $register['register_slug'] and $general['lost_pass_slug'] ) {
                echo '<span> | </span>';
            }
            ?>

            <?php if ( $general['lost_pass_slug'] ): ?>
                <?php $lost_pass_page = get_post( $general['lost_pass_slug'] ); ?>

                <a href="<?php esc_attr_e( $lost_pass_page->post_name ); ?>">
                    <?php _e( 'I forgot password', 'mas-user-panel' ); ?>
                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</form>
