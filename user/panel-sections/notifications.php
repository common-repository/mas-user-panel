<?php
$paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
$panel = mup_panel_options();

$query = new WP_Query([
    'post_type' => 'mup_notifications',
    'publish' => true,
    'posts_per_page' => $panel['notifications_per_page'],
    'paged' => $paged,
]);

$user_id = get_current_user_id();
$last_read = get_user_meta( $user_id, 'mup_notice_read', true );
?>

<div id="mup-notifications">
    <?php if ( $query->have_posts() ): ?>
        <?php while ( $query->have_posts() ): $query->the_post(); ?>
            <article class="mup-card">
                <header>
                    <h3><?php the_title(); ?></h3>

                    <?php if ( ! $last_read or get_post_timestamp() > $last_read ): ?>
                        <span class="mup-unread" style="<?php echo is_rtl() ? 'left: 10px' : 'right: 10px' ?>"></span>
                    <?php endif; ?>
                </header>

                <div class="mup-card-content">
                    <?php the_content(); ?>
                </div>

                <footer>
                    <span>
                        <?php echo __( 'By ', 'mas-user-panel' ) . get_the_author(); ?>
                    </span>

                    <span>
                        <?php echo __( 'Date: ', 'mas-user-panel' ) . get_the_date(); ?>
                    </span>
                </footer>
            </article>
        <?php endwhile; ?>

        <?php
        include_once MUP_USER_PATH . '/parts/pagination.php';
        wp_reset_postdata();
        ?>
    <?php else: ?>
        <?php mup_show_message( __( 'There is no notice.', 'mas-user-panel' ), 'info' ); ?>
    <?php endif; ?>
</div>

<?php mup_set_last_notice_time(); ?>