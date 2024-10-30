<?php
// close ticket
if ( isset( $_GET['close-ticket'] ) and wp_verify_nonce( $_GET['close-ticket'], 'close_ticket' ) ) {
    if ( isset( $_GET['ticket'] ) and ! empty( $_GET['ticket'] ) ) {
        $ticket_id = intval( $_GET['ticket'] );
        $update_status = update_post_meta( $ticket_id, 'mup_ticket_status', 'closed' );

        if ($update_status) {
            $success = __('Ticket Closed.', 'mas-user-panel');
        }
    }
}

// open ticket (remove mup_ticket_status post meta)
if ( isset( $_GET['open-ticket'] ) and wp_verify_nonce( $_GET['open-ticket'], 'open_ticket' ) ) {
    if ( isset( $_GET['ticket'] ) and ! empty( $_GET['ticket'] ) ) {
        $ticket_id = intval( $_GET['ticket'] );
        $delete_status = delete_post_meta( $ticket_id, 'mup_ticket_status' );

        if ( $delete_status ) {
            $success = __( 'Ticket Reopened', 'mas-user-panel' );
        }
    }
}

// delete ticket
if ( isset( $_GET['del-ticket'] ) and wp_verify_nonce( $_GET['del-ticket'], 'del_ticket' ) ) {
    if ( isset( $_GET['ticket'] ) and ! empty( $_GET['ticket'] ) ) {
        $ticket_id = intval( $_GET['ticket'] );
        mup_delete_ticket( $ticket_id );
    }
}
?>

<div id="mup-wrap" class="wrap">
    <h1 class="wp-heading-inline">
        <?php _e('Tickets', 'mas-user-panel'); ?>
    </h1>

    <table id="mup-ticket-list-table">
        <thead>
            <tr>
                <th>
                    <?php _e('Title', 'mas-user-panel'); ?>
                </th>

                <th>
                    <?php _e('Creator', 'mas-user-panel'); ?>
                </th>

                <th>
                    <?php _e('Email', 'mas-user-panel'); ?>
                </th>

                <th>
                    <?php _e('Priority', 'mas-user-panel'); ?>
                </th>

                <th>
                    <?php _e('Status', 'mas-user-panel'); ?>
                </th>

                <th>
                    <?php _e('Date', 'mas-user-panel'); ?>
                </th>

                <th colspan="2">
                    <?php _e('Actions', 'mas-user-panel'); ?>
                </th>
            </tr>
        </thead>

        <tbody>
            <?php
            $query = new WP_Query([
                'post_type' => 'mup_ticket',
                'post_parent' => 0,
                'posts_per_page' => 20
            ]);
            ?>

            <?php if ( $query->have_posts() ): ?>
                <?php while ( $query->have_posts() ): $query->the_post(); ?>
                    <tr>
                        <td>
                            <a href="<?php echo esc_url( add_query_arg( [ 'single-ticket' => get_the_ID() ], remove_query_arg( [ 'close-ticket', 'open-ticket', 'del-ticket', 'ticket' ] ) ) ); ?>">
                                <strong><?php the_title(); ?></strong>

                                <?php
                                    $ticket_unread = get_post_meta( get_the_ID(), 'mup_admin_ticket_read', true );
                                    $conut = $ticket_unread ? mup_admin_ticket_notice_count( get_the_ID() ) + 1 : mup_admin_ticket_notice_count( get_the_ID() );

                                    if ( $conut ) {
                                        echo '<span class="mup-unread-count">' . esc_html( $conut ) . '</span>';
                                    }
                                ?>
                            </a>
                        </td>

                        <td><?php the_author(); ?></td>

                        <td><?php esc_html_e( get_the_author_meta('email') ); ?></td>

                        <td>
                            <span id="mup-ticket-priority">
                                <?php
                                $priority = get_post_meta( get_the_ID(), 'mup_ticket_priority', true );
                                
                                if ( $priority === 'low' ) {
                                    _e( 'Low', 'mas-user-panel' );
                                } elseif ( $priority === 'normal' ) {
                                    _e( 'Normal', 'mas-user-panel' );
                                } else {
                                    _e( 'High', 'mas-user-panel' );
                                }
                                ?>
                            </span>
                        </td>

                        <td>
                            <?php
                            $status = get_post_meta( get_the_ID(), 'mup_ticket_status', true );

                            if ( $status and $status === 'closed' ) {
                                echo '<span id="mup-ticket-close">' . __( 'Closed', 'mas-user-panel' ) . '</span>';
                            } else {
                                echo '<span id="mup-ticket-open">' . __( 'Open', 'mas-user-panel' ) . '</span>';
                            }
                            ?>
                        </td>

                        <td><?php echo sprintf( __( 'Date: %s at %s', 'mas-user-panel' ), get_the_date('Y/m/d' ), get_the_time( 'H:m:i' ) ); ?></td>

                        <td>
                            <?php $status = get_post_meta( get_the_ID(), 'mup_ticket_status', true ); ?>

                            <?php if ( ! $status ): ?>
                                <?php $args = [ 'close-ticket' => wp_create_nonce( 'close_ticket' ), 'ticket' => get_the_ID() ]; ?>

                                <a href="<?php echo esc_url( add_query_arg( $args, remove_query_arg( [ 'open-ticket', 'del-ticket' ] ) ) ); ?>"
                                   onclick="return confirm('Are you sure you want to close this ticket?')">
                                    <?php _e( 'Close', 'mas-user-panel' ); ?>
                                </a>
                            <?php else: ?>
                                <?php $args = [ 'open-ticket' => wp_create_nonce( 'open_ticket' ), 'ticket' => get_the_ID() ]; ?>

                                <a href="<?php echo esc_url( add_query_arg( $args, remove_query_arg(  [ 'close-ticket', 'del-ticket' ] ) ) ); ?>">
                                    <?php _e( 'Reopen', 'mas-user-panel' ); ?>
                                </a>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?php $args = [ 'del-ticket' => wp_create_nonce( 'del_ticket' ), 'ticket' => get_the_ID() ]; ?>

                            <a href="<?php echo esc_url( add_query_arg( $args, remove_query_arg( [ 'close-ticket', 'open-ticket' ] ) ) ); ?>"
                               onclick="return confirm('Are you sure you want to delete this ticket?')">
                                <?php _e( 'Delete', 'mas-user-panel' ); ?>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6"><?php _e( 'There is no ticket.', 'mas-user-panel' )?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>