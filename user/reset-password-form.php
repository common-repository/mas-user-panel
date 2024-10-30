<form id="mup-reset-password-form" action="<?php echo site_url( 'wp-login.php?action=resetpass' ); ?>" method="post">
    <?php
    if ( isset( $_GET['error'] ) and $_GET['error'] === 'password_reset_empty' ) {
        mup_show_message( __( 'Password must not be empty.', 'mas-user-panel' ), 'error' );
    }
    
    if ( isset( $_GET['error'] ) and $_GET['error'] === 'password_reset_mismatch' ) {
        mup_show_message( __( 'Two passwords do not match.', 'mas-user-panel' ), 'error' );
    }
    
    if ( isset( $_GET['error'] ) and $_GET['error'] === 'password_reset_min' ) {
        $pass = mup_user_pass_settings();
        mup_show_message( sprintf( __( 'Minimum password letters must be %d', 'mas-user-panel' ), esc_html( $pass['min'] ) ), 'error' );
    }

    if ( isset( $_GET['login'] ) and $_GET['login'] === 'expiredkey' ) {
        mup_show_message( __( 'Password recovery link has expired.', 'mas-user-panel' ), 'error' );
    }
    ?>

    <input type="hidden" name="rp_login" value="<?php esc_attr_e( $_REQUEST['login'] ); ?>" autocomplete="off" />
    <input type="hidden" name="rp_key" value="<?php esc_attr_e( $_REQUEST['key'] ); ?>" />

    <p>
        <input type="password" name="pass1" autocomplete="off" />
        <span class="mup-input-info"><?php echo wp_get_password_hint(); ?></span>
    </p>

    <p>
        <input type="password" name="pass2" autocomplete="off" />
    </p>

    <p class="resetpass-submit">
        <input type="submit" name="submit" value="<?php _e( 'Reset Password', 'personalize-login' ); ?>"/>
    </p>
</form>