<?php
$post_id = intval( $_GET['single-ticket'] );
$post = get_post( $post_id );

if ( is_null( $post ) or $post->post_type !== 'mup_ticket' ) { ?>
    <script>window.location.href = '<?php echo admin_url(); ?>admin.php?page=mup-tickets';</script>
    <?php exit;
}

// close ticket
if ( isset( $_GET['close-ticket'] ) and wp_verify_nonce( $_GET['close-ticket'], 'close_ticket' ) ) {
    $update_status = update_post_meta( $post_id, 'mup_ticket_status', 'closed' );

    if ( $update_status ) {
        $success = __( 'Ticket Closed.', 'mas-user-panel' );
    }
}

// open ticket (remove mup_ticket_status post meta)
if ( isset( $_GET['open-ticket'] ) and wp_verify_nonce( $_GET['open-ticket'], 'open_ticket' ) ) {
    $delete_status = delete_post_meta( $post_id, 'mup_ticket_status' );

    if ( $delete_status ) {
        $success = __( 'Ticket Reopened.', 'mas-user-panel' );
    }
}

// delete ticket
if ( isset( $_GET['del-ticket'] ) and wp_verify_nonce( $_GET['del-ticket'], 'del_ticket' ) ) {
    mup_delete_ticket( $post->ID ); ?>
    <script>window.location.href = '<?php echo admin_url(); ?>admin.php?page=mup-tickets';</script>
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
                'post_content' =>  wpautop( wp_kses( $_POST['ticket_content'], 'post' ) ),
                'post_parent' => $post_id,
                'post_status' => 'publish',
                'meta_input' => [ 'mup_ticket_read' => 'user_unread' ]
            ]);

            if ( ! is_wp_error( $insert ) ) {
                $success = __( 'Reply sent.', 'mas-user-panel' );
                $user_email = get_the_author_meta( 'email', $post->post_author );
                $panel = mup_panel_options();
                $email_subject = sanitize_text_field( $panel['ticket_email_subject'] );
                $headers = [ 'Content-Type: text/html; charset=UTF-8' ];
                $search = [ '[site_name]', '[site_url]', '[ticket_title]' ];
                $replace = [ get_bloginfo('name'), site_url(), $post->post_title ];
                $change = str_replace( $search, $replace, $panel['ticket_email_content'] );

                wp_mail( $user_email, $email_subject, mup_email_template( $change ), $headers );
            }
        }
    } else {
        $error = __( 'Invalid Request.', 'mas-user-panel' );
    }
}
?>

<div id="mup-wrap" class="wrap">
    <h1>
        <?php echo __( 'Creator: ', 'mas-user-panel' ) . get_the_author_meta( 'login', $post->post_author ); ?>
    </h1>

    <?php if ( isset( $error ) ): ?>
        <div class="notice notice-error is-dismissible">
            <p><strong><?php esc_html_e( $error ); ?></strong></p>
        </div>
    <?php endif; ?>

    <?php if ( isset( $success ) ): ?>
        <div class="notice notice-success is-dismissible">
            <p><strong><?php esc_html_e( $success ); ?></strong></p>
        </div>
    <?php endif; ?>

    <div id="mup-ticket-actions">
        <?php $status = get_post_meta( $post_id, 'mup_ticket_status', true ); ?>

        <?php if ( ! $status ): ?>
            <?php $args = [ 'close-ticket' => wp_create_nonce( 'close_ticket' ) ]; ?>

            <a class="button button-cancel"
               href="<?php echo esc_url( add_query_arg( $args, remove_query_arg( 'open-ticket' ) ) ); ?>"
               onclick="return confirm('Are you sure you want to close this ticket?')">
                <?php _e( 'Close Ticket', 'mas-user-panel' ); ?>
            </a>
        <?php else: ?>
            <?php $args = [ 'open-ticket' => wp_create_nonce( 'open_ticket' ) ]; ?>

            <a class="button button-cancel" href="<?php echo esc_url( add_query_arg( $args, remove_query_arg(  'close-ticket' ) ) ); ?>">
                <?php _e( 'Reopen Ticket', 'mas-user-panel' ); ?>
            </a>
        <?php endif; ?>

        <?php $args = [ 'del-ticket' => wp_create_nonce( 'del_ticket' ) ]; ?>

        <a class="button button-cancel"
           href="<?php echo esc_url( add_query_arg( $args, remove_query_arg( 'close-ticket' ) ) ); ?>"
           onclick="return confirm('Are you sure you want to delete this ticket?')">
            <?php _e( 'Delete Ticket', 'mas-user-panel' ); ?>
        </a>
    </div>

    <article id="mup-ticket">
        <header>
            <span>
                <?php echo sprintf( __( 'Date: %s at %s', 'mas-user-panel' ), get_the_date( '', $post->ID ), get_the_time( '', $post->ID ) ); ?>
            </span>

            <span> |
                <?php
                $priority = get_post_meta( get_the_ID(), 'mup_ticket_priority', true );

                _e('Priority: ', 'mas-user-panel' );

                if ( $priority === 'low' ) {
                    echo '<span class="mup-badge-info">' . __( 'Low', 'mas-user-panel' ) . '</span>';
                } elseif ( $priority === 'normal' ) {
                    echo '<span class="mup-badge-info">' . __( 'Normal', 'mas-user-panel' ) . '</span>';
                } else {
                    echo '<span class="mup-badge-info">' . __( 'High', 'mas-user-panel' ) . '</span>';
                }
                ?>
            </span>

            <span> |
                <?php
                _e( 'Status: ', 'mas-user-panel' );

                if ( $status and $status === 'closed' ) {
                    echo '<span class="mup-badge-error">' . __( 'Closed', 'mas-user-panel' ) . '</span>';
                } else {
                    echo '<span class="mup-badge-success">' . __( 'Open', 'mas-user-panel' ) . '</span>';
                }
                ?>
            </span>

            <?php
            $ticket_read = get_post_meta( $post->ID, 'mup_admin_ticket_read', true );

            if ( $ticket_read ) {
                echo '<span class="mup-unread" style="' . ( is_rtl() ? 'left: 10px' : 'right: 10px' ) . '"></span>';
                delete_post_meta( $post->ID, 'mup_admin_ticket_read' );
            }
            ?>

            <div>
                <?php echo get_avatar( $post->post_author, 70 ); ?>
                <h3><?php echo get_the_author_meta( 'login', $post->post_author ); ?></h3>
            </div>

            <h2><?php echo __( 'Subject: ', 'mas-user-panel' ) . $post->post_title; ?></h2>
        </header>

        <p><?php echo wp_kses( $post->post_content, 'post' ); ?></p>
    </article>

    <div id="mup-ticket-replies">
        <?php
        $panel = mup_panel_options();

        $query = new WP_Query([
            'post_type' => 'mup_ticket',
            'post_parent' => $post_id,
            'posts_per_page' => 20,
        ]);
        ?>

        <?php if ( $query->have_posts() ): ?>
            <?php while ( $query->have_posts() ): $query->the_post(); ?>
                <?php
                $author = get_the_author_meta( 'ID' );
                $class = ( $post->post_author != $author ) ? 'mup-ticket-user-reply' : '';
                ?>

                <article class="mup-ticket <?php esc_attr_e( $class ); ?>">
                    <header>
                        <span>
                            <?php echo sprintf( __( 'Date: %s at %s', 'mas-user-panel' ), get_the_date(), get_the_time() ); ?>
                        </span>

                        <div>
                            <?php echo get_avatar( get_the_author_meta( 'ID' ), 50 ); ?>
                            <h3><?php esc_html_e( get_the_author_meta( 'login') ); ?></h3>
                        </div>

                        <?php
                        $ticket_read = get_post_meta( get_the_ID(), 'mup_admin_ticket_read', true );
                        
                        if ( $ticket_read ) {
                            echo '<span class="mup-unread" style="' . ( is_rtl() ? 'left: 10px' : 'right: 10px' ) . '"></span>';
                            delete_post_meta( get_the_ID(), 'mup_admin_ticket_read' );
                        }
                        ?>
                    </header>

                    <?php the_content(); ?>
                </article>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

    <form id="mup-reply-form" method="post">
        <?php wp_nonce_field( 'ticket_reply', 'ticket_reply_nonce' ); ?>

        <p>
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

        <input class="button-primary" type="submit" name="ticket_reply" value="<?php esc_attr_e('Send Reply', 'mas-user-panel'); ?>"/>
    </form>
</div>