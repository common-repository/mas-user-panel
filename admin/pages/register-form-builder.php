<?php include_once MUP_ADMIN_PATH . 'pages/form-handler/register-form-builder.php'; ?>

<div id="mup-wrap" class="wrap">
    <h1><?php _e( 'Register Fields', 'mas-user-panel' ); ?></h1>

    <?php if ( isset( $errors ) and count( $errors ) > 0 ): ?>
        <div class="notice notice-error is-dismissible">
            <?php
            foreach ( $errors as $error ) {
                echo '<p><strong>' . esc_html_e( $error ) . '</strong></p>';
            }
            ?>
        </div>
    <?php endif; ?>

    <?php if ( isset( $errors ) and ! count( $errors ) > 0 ): ?>
        <div class="notice notice-success is-dismissible">
            <p>
                <strong>
                    <?php _e( 'Settings Changed.', 'mas-user-panel' ); ?>
                </strong>
            </p>
        </div>
    <?php endif; ?>

    <?php if ( ! MUPRegField::field_exist('user_login') or ! MUPRegField::field_exist('user_email') or ! MUPRegField::field_exist('user_pass') ): ?>
        <div class="notice notice-error">
            <p>
                <strong>
                    <?php _e( 'The three fields of username, email and password are required.', 'mas-user-panel' ); ?>
                </strong>
            </p>
        </div>
    <?php endif; ?>

    <div id="mup-register-fields">
        <div id="mup-buttons-wrap">
            <div>
                <button class="mup-buttons button-secondary" data-type="first_name">
                    <?php _e( 'Firstname', 'mas-user-panel' ); ?>
                </button>
            </div>

            <div>
                <button class="mup-buttons button-secondary" data-type="last_name">
                    <?php _e( 'Lastname', 'mas-user-panel' ); ?>
                </button>
            </div>

            <div>
                <button class="mup-buttons button-secondary" data-type="display_name">
                    <?php _e( 'Display Name', 'mas-user-panel' ); ?>
                </button>
            </div>

            <?php if ( ! MUPRegField::field_exist( 'user_login' ) ): ?>
                <div>
                    <button class="mup-buttons button-secondary" data-type="user_login">
                        <?php _e( 'Username', 'mas-user-panel' ); ?>
                    </button>
                </div>
            <?php endif; ?>

            <?php if ( ! MUPRegField::field_exist( 'user_email' ) ): ?>
                <div>
                    <button class="mup-buttons button-secondary" data-type="user_email">
                        <?php _e( 'Email', 'mas-user-panel' ); ?>
                    </button>
                </div>
            <?php endif; ?>

            <?php if ( ! MUPRegField::field_exist( 'user_pass' ) ): ?>
                <div>
                    <button class="mup-buttons button-secondary" data-type="user_pass">
                        <?php _e( 'Password', 'mas-user-panel' ); ?>
                    </button>
                </div>
            <?php endif; ?>

            <div>
                <button class="mup-buttons button-secondary" data-type="user_url">
                    <?php _e( 'Website', 'mas-user-panel' ); ?>
                </button>
            </div>
        </div>

        <form id="mup-reg-fields-form" method="post" enctype="multipart/form-data">
            <?php wp_nonce_field( 'register_field', 'register_field_nonce' ); ?>

            <div id="mup-reg-fields-wrap">
                <?php
                $posts = get_posts([
                    'post_type' => 'mup_reg_field',
                    'order' => 'ASC',
                    'orderby' => 'menu_order',
                    'numberposts' => -1,
                ]);

                foreach ( $posts as $post ) {
                    if ( $post->post_title === 'first_name' ) {
                        echo mup_first_name_setting_fields( $post->ID );
                    }

                    if ( $post->post_title === 'last_name' ) {
                        echo mup_last_name_setting_fields( $post->ID );
                    }

                    if ( $post->post_title === 'display_name' ) {
                        echo mup_display_name_setting_fields( $post->ID );
                    }

                    if ( $post->post_title === 'user_login' ) {
                        echo mup_user_login_setting_fields( $post->ID );
                    }

                    if ( $post->post_title === 'user_email' ) {
                        echo mup_user_email_setting_fields( $post->ID );
                    }

                    if ( $post->post_title === 'user_pass' ) {
                        echo mup_user_pass_setting_fields( $post->ID );
                    }

                    if ( $post->post_title === 'user_url' ) {
                        echo mup_user_url_setting_fields( $post->ID );
                    }
                }
                ?>
            </div>

            <p>
                <input class="button-primary" type="submit" name="register_fields" value="<?php esc_attr_e( 'Save Settings', 'mas-user-panel' ); ?>"/>
            </p>
        </form>
    </div>
</div>