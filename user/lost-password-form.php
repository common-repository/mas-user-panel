<form id="mup-lost-password-form" action="<?php echo wp_lostpassword_url(); ?>" method="post">
    <?php if ( isset( $_GET['errors'] ) ) {
        if ( $_GET['errors'] === 'empty_username' ) {
            mup_show_message( __( 'Email must not be empty.', 'mas-user-panel' ), 'error' );
        }

        if ( $_GET['errors'] === 'invalid_email' ) {
            mup_show_message( __( 'Invalid Email', 'mas-user-panel' ), 'error' );
        }

        if ( $_GET['errors'] === 'invalidcombo' ) {
            mup_show_message( __( 'User has not registered with this email.', 'mas-user-panel' ), 'error' );
        }
    }

    if ( isset( $_GET['checkemail'] ) and  $_GET['checkemail'] === 'confirm' ):
        mup_show_message( __( 'A password recovery link has been sent to your email. Please check your email.', 'mas-user-panel' ), 'info' );
    else: ?>
        <p>
            <input type="text" name="user_login" placeholder="<?php _e( 'Email', 'mas-user-panel' );?>">
        </p>

        <p>
            <input type="submit" name="submit" value="<?php _e( 'Recovery Password', 'mas-user-panel' ); ?>"/>
        </p>
    <?php endif; ?>
</form>