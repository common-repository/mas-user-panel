<?php
$ticket_id = intval( $_GET['ticket'] );
$post = get_post( $ticket_id );

if ( is_null( $post ) or $post->post_type !== 'mup_ticket' or $post->post_author != get_current_user_id() ) { ?>
    <script>window.location.href = '?section=ticket-list';</script>
    <?php exit;
}

// insert ticket reply
if ( isset( $_POST['ticket_reply'] ) and isset( $_POST['ticket_reply_nonce'] ) ) {
    if ( wp_verify_nonce( $_POST['ticket_reply_nonce'], 'ticket_reply') ) {
        if ( empty( $_POST['ticket_content'] ) ) {
            $error = __( 'Reply must not be empty.', 'mas-user-panel' );
        } else {
            $insert = wp_insert_post([
                'post_type' => 'mup_ticket',
                'post_content' => wpautop( wp_kses( $_POST['ticket_content'], 'post' ) ),
                'post_parent' => $ticket_id,
                'post_status' => 'publish',
                'meta_input' => [
                    'mup_admin_ticket_read' => 'admin_unread'
                ]
            ]);

            if ( ! is_wp_error( $insert ) ) {
                $success = __( 'Reply Sent.', 'mas-user-panel' );
            }
        }
    } else {
        $error = __( 'Invalid Request.', 'mas-user-panel' );
    }
}
?>

<div id="mup-single-ticket">
    <?php
    if ( isset( $error ) ) {
        mup_show_message( $error, 'error' );
    }

    if ( isset( $success ) ) {
        mup_show_message( $success, 'success' );
    }
    ?>

    <article id="mup-ticket" class="mup-card">
        <header>
            <div>
                <?php echo get_avatar( esc_html( $post->post_author ), '50' ); ?>

                <span>
                    <?php
                    _e( 'Status: ', 'mas-user-panel' );

                    $status = get_post_meta( $ticket_id, 'mup_ticket_status', true );

                    if ( $status === 'closed' ) {
                        echo '<strong class="mup-badge-error">' . __( 'Closed', 'mas-user-panel' ) . '</strong>';
                    } else {
                        echo '<strong class="mup-badge-success">' . __( 'Open', 'mas-user-panel' ) . '</strong>';
                    }
                    ?>
                </span>

                <span>
                    <?php
                    _e( 'Priority: ', 'mas-user-panel' );

                    $priority = get_post_meta( get_the_ID(), 'mup_ticket_priority', true );

                    if ( $priority === 'low' ) {
                        echo '<strong class="mup-badge-info">' . __( 'Low', 'mas-user-panel' ) . '</strong>';
                    } elseif ( $priority === 'normal' ) {
                        echo '<strong class="mup-badge-info">' . __( 'Normal', 'mas-user-panel' ) . '</strong>';
                    } else {
                        echo '<strong class="mup-badge-info">' . __( 'High', 'mas-user-panel' ) . '</strong>';
                    }
                    ?>
                </span>
            </div>
        </header>

        <div id="mup-single-ticket-content" class="mup-card-content">
            <h3><?php echo get_the_title( $post->ID ); ?></h3>
            <?php echo get_the_content( null, false, $post->ID ); ?>
        </div>

        <footer>
            <span>
                <?php echo sprintf( __( 'Date: %s at %s', 'mas-user-panel' ), get_the_date( '', $post->ID ), get_the_time( '', $post->ID ) ); ?>
            </span>
        </footer>
    </article>

    <div id="mup-ticket-replies">
        <?php
        $paged = ( get_query_var( 'paged' ) ) ? absint( get_query_var( 'paged' ) ) : 1;
        $panel = mup_panel_options();

        $query = new WP_Query([
            'post_type' => 'mup_ticket',
            'post_parent' => $ticket_id,
            'posts_per_page' => $panel['ticket_replies_per_page'],
            'paged' => $paged,
        ]);
        ?>

        <?php if ( $query->have_posts() ): ?>
            <h2><?php _e( 'Replies', 'mas-user-panel' ); ?></h2>

            <?php while ( $query->have_posts() ): $query->the_post(); ?>
                <?php
                $author = get_the_author_meta( 'ID' );
                $class = ( $author != get_current_user_id() ) ? 'mup-ticket-admin-reply' : '';
                $ticket_read = get_post_meta( get_the_ID(), 'mup_ticket_read', true );
                ?>

                <article class="mup-reply-ticket mup-card <?php esc_attr_e( $class ); ?>">
                    <?php if ( $ticket_read === 'user_unread' ): ?>
                        <span class="mup-unread" style="<?php echo is_rtl() ? 'left: 10px' : 'right: 10px' ?>"></span>
                    <?php endif; ?>

                    <header>
                        <div>
                            <?php echo get_avatar( $author, '50' ); ?>

                            <span>
                                <?php esc_html_e( get_the_author_meta( 'display_name' ) ); ?>
                            </span>
                        </div>
                    </header>

                    <div class="mup-card-content">
                        <?php echo get_the_content( null, false, get_the_ID() ) ?>
                    </div>

                    <footer>
                        <span>
                            <?php echo sprintf( __( 'Date: %s at %s', 'mas-user-panel' ), get_the_date(), get_the_time() ); ?>
                        </span>
                    </footer>
                </article>

                <?php
                if ( $ticket_read === 'user_unread' ) {
                    delete_post_meta( get_the_ID(), 'mup_ticket_read' );
                }
                ?>
            <?php endwhile; ?>

            <?php include_once MUP_USER_PATH . '/parts/pagination.php'; ?>
        <?php endif; ?>
    </div>

    <?php if ( $status !== 'closed' ): ?>
        <form id="mup-new-ticket-form" method="post">
            <?php wp_nonce_field( 'ticket_reply', 'ticket_reply_nonce' ); ?>

            <p>
<!--                <textarea id="mup-reply-ticket-content" name="ticket_content" placeholder="--><?php //esc_attr_e( 'پاسخ', 'mas-user-panel' ); ?><!--"></textarea>-->

                <?php
                $args = [
                    'media_buttons' => false,
                    'textarea_name' => 'ticket_content',
                    'textarea_rows' => 8,
                    'quicktags' => true,
                    'tinymce' => [
                        'toolbar1' => 'bold,italic,underline,separator,alignleft,aligncenter,alignright,separator,link,unlink,undo,redo',
                        'toolbar2' => '',
                        'toolbar3' => '',
                    ],
                ];

                wp_editor( __( 'Your Message', 'mas-user-panel' ), 'mup-ticket-content', $args );
                ?>
            </p>

            <input type="submit" name="ticket_reply" value="<?php esc_attr_e('Send Reply', 'mas-user-panel'); ?>"/>
        </form>
    <?php endif; ?>
</div>