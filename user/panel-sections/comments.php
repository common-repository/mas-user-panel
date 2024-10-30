<?php
$page = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$panel = mup_panel_options();

$limit = $panel['comments_per_page'];
$offset = ( $page * $limit ) - $panel['comments_per_page'];

$comments = get_comments([
    'user_id' => get_current_user_id(),
    'number' => $panel['comments_per_page'],
    'offset' => $offset,
]);
?>

<div id="mup-comments">
    <?php if ( count( $comments ) > 0 ): ?>
        <?php foreach ( $comments as $comment ): ?>
            <article class="mup-card">
                <header>
                    <?php
                    if ( $comment->comment_approved ) {
                        echo '<span class="mup-badge-success">' . __( 'Approved', 'mas-user-panel' ) . '</span>';
                    } else {
                        echo '<span class="mup-badge-warning">' . __( 'Unapproved', 'mas-user-panel' ) . '</span>';
                    }
                    ?>
                </header>

                <div class="mup-comment-content mup-card-content">
                    <p><?php esc_html_e( $comment->comment_content ); ?></p>

                    <span class="mup-comment-post">
                        <?php
                        $post = get_post( $comment->comment_post_ID );

                        echo __( 'For: ', 'mas-user-panel' );
                        echo '<a href="' . esc_url( get_the_permalink( $comment->comment_post_ID ) ) . '">' . esc_html( $post->post_title ) . '</a>';
                        ?>
                    </span>
                </div>

                <footer>
                    <span><?php echo sprintf( __( 'Date: %s at %s', 'mas-user-panel' ), get_comment_date( '', $comment->comment_ID ), get_comment_date( 'h:i', $comment->comment_ID ) ); ?></span>
                </footer>
            </article>
        <?php endforeach; ?>

        <?php
        $total_comments = get_comments( [ 'user_id' => get_current_user_id() ] );
        $big = 999999999;

        echo paginate_links([
            'total' => ceil( count( $total_comments ) / $limit ),
            'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
            'format' => '?paged=%#%',
            'current' => max( 1, get_query_var( 'paged' ) ),
        ]);
        ?>
    <?php else: ?>
        <?php mup_show_message( __( 'There is no comment.', 'mas-user-panel' ), 'info' ); ?>
    <?php endif; ?>
</div>