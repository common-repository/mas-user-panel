<?php
$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
$panel = mup_panel_options();

$query = new WP_Query([
    'post_type' => 'mup_ticket',
    'publish' => true,
    'post_parent' => 0,
    'author' => get_current_user_id(),
    'posts_per_page' => $panel['tickets_per_page'],
    'paged' => $paged,
]);
?>

<div id="mup-ticket-list">
    <?php if ( $query->have_posts() ): ?>
        <?php while ( $query->have_posts() ): $query->the_post(); ?>
            <article class="mup-card">
                <?php if ( mup_ticket_notice_count( get_the_ID() ) ): ?>
                    <span class="mup-unread" style="<?php echo is_rtl() ? 'left: 10px' : 'right: 10px' ?>"></span>
                <?php endif; ?>

                <header>
                    <span>
                        <?php
                        _e( 'Status: ', 'mas-user-panel' );

                        $status = get_post_meta( get_the_ID(), 'mup_ticket_status', true );

                        if ( $status === 'closed' ) {
                            echo '<strong class="mup-badge-error">' . __('Closed', 'mas-user-panel') . '</strong>';
                        } else {
                            echo '<strong class="mup-badge-success">' . __('Open', 'mas-user-panel') . '</strong>';
                        }
                        ?>
                    </span>

                    <span>
                        <?php
                        _e( 'Priority: ', 'mas-user-panel' );

                        $priority = get_post_meta( get_the_ID(), 'mup_ticket_priority', true );

                        if ( $priority === 'low' ) {
                            echo '<strong class="mup-badge-info">' . __('Low', 'mas-user-panel') . '</strong>';
                        } elseif ( $priority === 'normal' ) {
                            echo '<strong class="mup-badge-info">' . __('Normal', 'mas-user-panel') . '</strong>';
                        } else {
                            echo '<strong class="mup-badge-info">' . __('High', 'mas-user-panel') . '</strong>';
                        }
                        ?>
                    </span>
                </header>

                <div class="mup-card-content">
                    <?php $args = [ 'section' => 'single-ticket', 'ticket' => get_the_ID() ]; ?>

                    <a href="<?php echo esc_url( add_query_arg( $args , remove_query_arg( $remove_args ) ) ); ?>">
                        <h3><?php the_title(); ?></h3>
                    </a>
                </div>

                <footer>
                    <span><?php echo sprintf( __( 'Date: %s', 'mas-user-panel' ), get_the_date() ); ?></span>
                </footer>
            </article>
        <?php endwhile; ?>

        <?php include_once MUP_USER_PATH . '/parts/pagination.php'; ?>
    <?php else: ?>
        <?php mup_show_message( __( 'There is no ticket.', 'mas-user-panel' ), 'info' ); ?>
    <?php endif; ?>
</div>