<?php
$user_id = get_current_user_id();
$user = get_user_by( 'ID', $user_id );
?>

<div id="mup-dashboard">
    <div id="mup-user-details" class="mup-card">
        <header>
            <?php echo get_avatar( $user_id ); ?>

            <span>
                <?php
                if ( ! empty( $user->first_name ) and ! empty( $user->last_name ) ) {
                    esc_html_e( $user->first_name . ' ' . $user->last_name );
                } else {
                    esc_html_e( $user->display_name );
                }
                ?>
            </span>
        </header>

        <div class="mup-card-content">
            <?php if ( ! empty( $user->first_name ) ): ?>
                <p>
                    <strong><?php _e( 'First Name: ', 'mas-user-panel' ); ?></strong>
                    <span><?php esc_html_e( $user->first_name ); ?></span>
                </p>
            <?php endif; ?>

            <?php if ( ! empty( $user->last_name ) ): ?>
                <p>
                    <strong><?php _e( 'Last Name: ', 'mas-user-panel' ); ?></strong>
                    <span><?php esc_html_e( $user->last_name ); ?></span>
                </p>
            <?php endif; ?>

            <p>
                <strong><?php _e( 'User Name: ', 'mas-user-panel' ); ?></strong>
                <span><?php esc_html_e( $user->user_login ); ?></span>
            </p>

            <p>
                <strong><?php _e( 'Display Name: ', 'mas-user-panel' ); ?></strong>
                <span><?php esc_html_e( $user->display_name ); ?></span>
            </p>

            <p>
                <strong><?php _e( 'Email: ', 'mas-user-panel' ); ?></strong>
                <span><?php esc_html_e( $user->user_email ); ?></span>
            </p>

            <p>
                <strong><?php _e( 'Registered Date: ', 'mas-user-panel' ); ?></strong>
                <span><?php echo date_i18n('F j, Y',  esc_html( $user->user_registered ) ); ?></span>
            </p>
        </div>
    </div>

    <?php
    if ( mup_notice_count() ) {
        mup_show_message( sprintf( __( 'There is %d notice(s) from admin.', 'mas-user-panel' ), mup_notice_count() ), 'info' );
    }

    if ( mup_ticket_notice_count() ) {
        mup_show_message( sprintf( __('There is %d reply (or replies) from admin.', 'mas-user-panel'), mup_ticket_notice_count() ), 'info' );
    }
    ?>
</div>