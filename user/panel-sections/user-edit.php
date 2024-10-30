<?php
$user_id = get_current_user_id();
$user = get_user_by('id', $user_id);
$first_name_set = mup_first_name_settings();
$last_name_set = mup_last_name_settings();
$display_name_set = mup_display_name_settings();
$pass_set = mup_user_pass_settings();
$url_set = mup_user_url_settings();
$errors = [];

// delete uploaded profile image
if ( isset( $_GET['del-avatar'] ) ) {
    if ( wp_verify_nonce( $_GET['del-avatar'], 'delete_avatar') ) {
        $get_previous_url = get_user_meta( $user_id, 'mup_profile_img', true );
        $file_path = wp_get_upload_dir()['basedir'] . wp_get_upload_dir()['subdir'] . '/' . basename( $get_previous_url );

        wp_delete_file( $file_path );
        delete_user_meta($user_id, 'mup_profile_img');
    }
}

// update user details
if ( isset( $_POST['edit_user'] ) ) {
    $nonce = ( isset( $_POST['user_edit_nonce'] ) and wp_verify_nonce( $_POST['user_edit_nonce'], 'user_edit' ) );

    if ( ! $nonce ) {
        $errors[] = __( 'Invalid Request.', 'mas-user-panel' );
    }

    if ( isset( $_FILES['profile_pic'] ) and ! empty( $_FILES['profile_pic']['name'] ) ) {
         $upload_pro_pic_error = mup_upload_pro_pic( $_FILES['profile_pic'] );

         if ( $upload_pro_pic_error ) {
             $errors[] = $upload_pro_pic_error;
         }
    }

    if ( $first_name_set['required'] and empty( $_POST['first_name'] ) ) {
        $errors[] = __( 'Firstname must not be empty.', 'mas-user-panel' );
    }

    if ( $first_name_set['required'] and strlen( $_POST['first_name'] ) < $first_name_set['min'] ) {
        $errors[] = sprintf( __( 'Minimum firstname letters must be %d', 'mas-user-panel' ), $first_name_set['min'] );
    }

    if ( $last_name_set['required'] and empty( $_POST['last_name'] ) ) {
        $errors[] = __( 'Lastname must not be empty.', 'mas-user-panel' );
    }

    if ( $last_name_set['required'] and strlen( $_POST['last_name'] ) < $last_name_set['min'] ) {
        $errors[] = sprintf( __( 'Minimum lastname letters must be %d', 'mas-user-panel' ), $last_name_set['min'] );
    }

    if ( $display_name_set['required'] and empty( $_POST['display_name'] ) ) {
        $errors[] = __( 'Display name must not be empty.', 'mas-user-panel' );
    }

    if ( $display_name_set['required'] and strlen( $_POST['display_name'] ) < $display_name_set['min'] ) {
        $errors[] = sprintf( __( 'Minimum display name letters must be %d', 'mas-user-panel' ), $display_name_set['min'] );
    }

    if ( ! empty( $_POST['user_pass'] ) ) {
        if ( $_POST['user_pass'] !== $_POST['confirm_user_pass'] ) {
            $errors[] = __( 'Two passwords do not match.', 'mas-user-panel' );
        }

        if ( strlen( $_POST['user_pass'] ) < $pass_set['min'] ) {
            $errors[] = sprintf( __( 'Minimum password letters must be %d', 'mas-user-panel' ), $pass_set['min'] );
        }

        $user_pass = sanitize_text_field( $_POST['user_pass'] );
    } else {
        $user_pass = $user->user_pass;
    }

    if ( $url_set['required'] and empty( $_POST['user_url'] ) ) {
        $errors[] = __( 'Website must not be empty.', 'mas-user-panel' );
    }

    $user_data = [
        'ID' => $user_id,
        'first_name' => sanitize_text_field( $_POST['first_name'] ),
        'last_name' => sanitize_text_field( $_POST['last_name'] ),
        'display_name' => sanitize_text_field( $_POST['display_name'] ),
        'user_login' => $user->user_login,
        'user_pass' => $user_pass,
        'user_url' => sanitize_text_field( $_POST['user_url'] ),
    ];

    if ( ! count( $errors ) > 0 ) {
        $user_update = wp_update_user( $user_data );

        if ( is_wp_error( $user_update ) ) {
            $errors[] = __( 'There is a problem editing the profile.', 'mas-user-panel' );
        } else {
            $success = __( 'Changes applied successfully.', 'mas-user-panel' );
        }
    }
}

$panel = mup_panel_options();
$user = get_user_by('id', $user_id);
?>

<div id="mup-user-edit">
    <?php if ( count( $errors ) > 0 ): ?>
        <div class="mup-msg mup-error-msg">
            <h3><?php _e( 'Fix the following errors:', 'mas-user-panel' ); ?></h3>

            <ul>
                <?php foreach ( $errors as $error ): ?>
                    <li><?php esc_html_e( $error ); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ( isset( $success ) ): ?>
        <div class="mup-msg mup-success-msg">
            <p><?php esc_html_e( $success ); ?></p>
        </div>
    <?php endif; ?>

    <form action="" method="post" enctype="multipart/form-data">
        <?php wp_nonce_field('user_edit', 'user_edit_nonce'); ?>

        <?php if ( $panel['upload_avatar'] ): ?>
            <div id="mup-pro-pic">
                <div>
                    <?php echo get_avatar( $user_id, '80' ); ?>

                    <label for="mup-upload-pro-pic">
                        <?php _e( 'Upload Avatar', 'mas-user-panel' ); ?>
                    </label>

                    <?php $profile_img_url = get_user_meta( $user_id, 'mup_profile_img', true ); ?>

                    <?php if ( $profile_img_url ): ?>
                        <a href="<?php echo esc_url( add_query_arg( 'del-avatar', wp_create_nonce( 'delete_avatar' ) ) ); ?>"
                           onclick="return confirm('<?php _e( 'Are you sure you want to delete the avatar? If removed, gravatar is used.', 'mas-user-panel' ); ?>')">
                            <?php _e( 'Delete Avatar', 'mas-user-panel' ) ?>
                        </a>
                    <?php endif; ?>

                    <input id="mup-upload-pro-pic" type="file" name="profile_pic" hidden/>
                </div>

                <span class="mup-input-info">
                    <?php echo sprintf( __( 'If the avatar is not uploaded, the gravatar is used. Maximum size is %d KB. Allowed extensions: jpj, jpeg and png', 'mas-user-panel' ), esc_html( $panel['avatar_size'] ) ); ?>
                </span>
            </div>
        <?php endif; ?>

        <p>
            <input type="text" name="first_name" placeholder="<?php esc_attr_e( 'Firstname', 'mas-user-panel' ); ?>" value="<?php esc_attr_e( $user->first_name ); ?>"/>

            <?php if ( $first_name_set['required'] ): ?>
                <span class="mup-input-info">
                    <?php
                    _e( 'Required', 'mas-user-panel' );

                    if ( $first_name_set['min'] > 0 ) {
                        sprintf( __( 'and minimum letters %d', 'mas-user-panel' ), esc_html( $first_name_set['min'] ) );
                    }
                    ?>
                </span>
            <?php endif; ?>
        </p>

        <p>
            <input type="text" name="last_name" placeholder="<?php esc_attr_e( 'Lastname', 'mas-user-panel' ); ?>"  value="<?php esc_attr_e( $user->last_name ); ?>"/>

            <?php if ( $last_name_set['required'] ): ?>
                <span class="mup-input-info">
                    <?php
                    _e( 'Required', 'mas-user-panel' );

                    if ( $last_name_set['min'] > 0 ) {
                        sprintf( __( 'and minimum letters %d', 'mas-user-panel' ), esc_html( $last_name_set['min'] ) );
                    }
                    ?>
                </span>
            <?php endif; ?>
        </p>

        <p>
            <input type="text" name="display_name" placeholder="<?php esc_attr_e( 'Display Name', 'mas-user-panel' ); ?>"  value="<?php esc_attr_e( $user->display_name ); ?>"/>

            <?php if ( $display_name_set['required'] ): ?>
                <span class="mup-input-info">
                    <?php
                    _e( 'Required', 'mas-user-panel' );

                    if ( $display_name_set['min'] > 0 ) {
                        sprintf( __( 'and minimum letters %d', 'mas-user-panel' ), esc_html( $display_name_set['min'] ) );
                    }
                    ?>
                </span>
            <?php endif; ?>
        </p>

        <p>
            <input type="email" name="email" placeholder="<?php esc_attr_e( 'Email', 'mas-user-panel' ); ?>" value="<?php esc_attr_e( $user->user_email ); ?>" disabled/>

            <span class="mup-input-info">
                <?php _e( 'Email cannot be changed.', 'mas-user-panel' ); ?>
            </span>
        </p>

        <p>
            <input type="text" name="user_login" placeholder="<?php esc_attr_e( 'Username', 'mas-user-panel' ); ?>"  value="<?php esc_attr_e( $user->user_login ); ?>" disabled/>

            <span class="mup-input-info">
                <?php _e( 'Username cannot be changed.', 'mas-user-panel' ); ?>
            </span>
        </p>

        <p>
            <input type="password" name="user_pass" placeholder="<?php esc_attr_e( 'New Password', 'mas-user-panel' ); ?>"/>

            <span class="mup-input-info">
                <?php echo sprintf( __( 'At least %d letters. For more security, use a combination of letters and numbers. If you do not intend to change, keep it empty.', 'mas-user-panel' ), esc_html( $pass_set['min'] ) ); ?>
            </span>
        </p>

        <p>
            <input type="password" name="confirm_user_pass" placeholder="<?php esc_attr_e( 'Confirm Password', 'mas-user-panel' ); ?>"/>
        </p>

        <p>
            <input type="text" name="user_url" placeholder="<?php esc_attr_e( 'Website', 'mas-user-panel' ); ?>"  value="<?php esc_attr_e( $user->user_url ); ?>"/>

            <?php if ( $url_set['required'] ): ?>
                <span class="mup-input-info">
                    <?php _e( 'Required', 'mas-user-panel' ); ?>
                </span>
            <?php endif; ?>
        </p>

        <input type="submit" name="edit_user" value="<?php _e( 'Edit Profile', 'mas-user-panel' ); ?>"/>
    </form>
</div>