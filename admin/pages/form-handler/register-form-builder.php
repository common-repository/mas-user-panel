<?php


if ( isset( $_POST['register_fields'] ) ) {
    $errors = [];

    if ( ! isset( $_POST['register_field_nonce'] ) or ! wp_verify_nonce( $_POST['register_field_nonce'], 'register_field' ) ) {
        $errors[] = __( 'Invalid Request.', 'mas-user-panel' );
    } else {
        $fields = MUPRegField::fields();

        if ( isset( $_POST['first_name'] ) ) {
            $settings = [
                'placeholder' => sanitize_text_field( $_POST['first_name_placeholder'] ),
                'required' => isset( $_POST['first_name_required'] ),
                'min' => intval( $_POST['first_name_min'] ),
                'info' => sanitize_text_field( $_POST['first_name_info'] ),
            ];

            $field_data = [
                'post_title' => 'first_name',
                'post_type' => 'mup_reg_field',
                'post_content' => maybe_serialize( $settings ),
                'menu_order' => intval( $_POST['first_name'] ),
                'post_status' => 'publish',
            ];

            if ( in_array( 'first_name', $fields ) ) {
                $field_data['ID'] = intval( $_POST['first_name_id'] );
                $save = wp_update_post( $field_data );

                if ( is_wp_error( $save ) ) {
                    $errors[] = __( 'error in editing firstname.', 'mas-user-panel' );
                }
            } else {
                $save = wp_insert_post( $field_data );

                if ( is_wp_error( $save ) ) {
                    $errors[] =  __( 'error in creating firstname.', 'mas-user-panel' );
                }
            }
        } elseif ( in_array( 'first_name', $fields ) ) {
            $del = wp_delete_post( MUPRegField::field_id_by_name( 'first_name' ), true );

            if ( ! $del ) {
                $errors[] = __( 'error in deleting firstname.', 'mas-user-panel' );
            }
        }

        if ( isset( $_POST['last_name'] ) ) {
            $settings = [
                'placeholder' => sanitize_text_field( $_POST['last_name_placeholder'] ),
                'required' => isset( $_POST['last_name_required'] ),
                'min' => intval( $_POST['last_name_min'] ),
                'info' => sanitize_text_field( $_POST['last_name_info'] ),
            ];

            $field_data = [
                'post_title' => 'last_name',
                'post_type' => 'mup_reg_field',
                'post_content' => maybe_serialize( $settings ),
                'menu_order' => intval( $_POST['last_name'] ),
                'post_status' => 'publish',
            ];

            if ( in_array( 'last_name', $fields ) ) {
                $field_data['ID'] = intval( $_POST['last_name_id'] );
                $save = wp_update_post( $field_data );

                if ( is_wp_error( $save ) ) {
                    $errors[] = __( 'error in editing lastname.', 'mas-user-panel' );
                }
            } else {
                $save = wp_insert_post($field_data);

                if ( is_wp_error( $save ) ) {
                    $errors[] =  __( 'error in creating lastname.', 'mas-user-panel' );
                }
            }
        } elseif ( in_array( 'last_name', $fields ) ) {
            $del = wp_delete_post( MUPRegField::field_id_by_name( 'last_name' ), true );

            if ( ! $del ) {
                $errors[] = __( 'error in deleting lastname.', 'mas-user-panel' );
            }
        }

        if ( isset( $_POST['display_name'] ) ) {
            $settings = [
                'placeholder' => sanitize_text_field( $_POST['display_name_placeholder'] ),
                'required' => isset( $_POST['display_name_required'] ),
                'min' => intval( $_POST['display_name_min'] ),
                'info' => sanitize_text_field( $_POST['display_name_info'] ),
            ];

            $field_data = [
                'post_title' => 'display_name',
                'post_type' => 'mup_reg_field',
                'post_content' => maybe_serialize( $settings ),
                'menu_order' => intval( $_POST['display_name'] ),
                'post_status' => 'publish',
            ];

            if ( in_array( 'display_name', $fields ) ) {
                $field_data['ID'] = intval( $_POST['display_name_id'] );
                $save = wp_update_post( $field_data );

                if ( is_wp_error( $save ) ) {
                    $errors[] = __( 'error in editing display name.', 'mas-user-panel' );
                }
            } else {
                $save = wp_insert_post($field_data);

                if ( is_wp_error( $save ) ) {
                    $errors[] =  __( 'error in creating display name.', 'mas-user-panel' );
                }
            }
        } elseif ( in_array( 'display_name', $fields ) ) {
            $del = wp_delete_post( MUPRegField::field_id_by_name( 'display_name' ), true );

            if ( ! $del ) {
                $errors[] = __( 'error in deleting display name.', 'mas-user-panel' );
            }
        }

        if ( isset( $_POST['user_login'] ) ) {
            $settings = [
                'placeholder' => sanitize_text_field( $_POST['user_login_placeholder'] ),
                'min' => intval( $_POST['user_login_min'] ),
                'info' => sanitize_text_field( $_POST['user_login_info'] ),
            ];

            $field_data = [
                'post_title' => 'user_login',
                'post_type' => 'mup_reg_field',
                'post_content' => maybe_serialize( $settings ),
                'menu_order' => intval( $_POST['user_login'] ),
                'post_status' => 'publish',
            ];

            if ( in_array( 'user_login', $fields ) ) {
                $field_data['ID'] = intval( $_POST['user_login_id'] );
                $save = wp_update_post( $field_data );

                if ( is_wp_error( $save ) ) {
                    $errors[] = __( 'error in editing username.', 'mas-user-panel' );
                }
            } else {
                $save = wp_insert_post( $field_data );

                if ( is_wp_error( $save ) ) {
                    $errors[] =  __( 'error in creating username.', 'mas-user-panel' );
                }
            }
        } elseif ( in_array( 'user_login', $fields ) ) {
            $del = wp_delete_post( MUPRegField::field_id_by_name( 'user_login' ), true );

            if ( ! $del ) {
                $errors[] = __( 'error in deleting username.', 'mas-user-panel' );
            }
        }

        if ( isset( $_POST['user_email'] ) ) {
            $settings = [
                'placeholder' => sanitize_text_field( $_POST['user_email_placeholder'] ),
                'info' => sanitize_text_field( $_POST['user_email_info'] ),
            ];

            $field_data = [
                'post_title' => 'user_email',
                'post_type' => 'mup_reg_field',
                'post_content' => maybe_serialize( $settings ),
                'menu_order' => intval( $_POST['user_email'] ),
                'post_status' => 'publish',
            ];

            if ( in_array( 'user_email', $fields ) ) {
                $field_data['ID'] = intval( $_POST['user_email_id'] );
                $save = wp_update_post( $field_data );

                if ( is_wp_error( $save ) ) {
                    $errors[] = __( 'error in editing user email.', 'mas-user-panel' );
                }
            } else {
                $save = wp_insert_post( $field_data );

                if ( is_wp_error( $save ) ) {
                    $errors[] =  __( 'error in creating user email.', 'mas-user-panel' );
                }
            }
        } elseif ( in_array( 'user_email', $fields ) ) {
            $del = wp_delete_post( MUPRegField::field_id_by_name( 'user_email' ), true );

            if ( ! $del ) {
                $errors[] = __( 'error in deleting user email.', 'mas-user-panel' );
            }
        }

        if ( isset( $_POST['user_pass'] ) ) {
            $settings = [
                'placeholder' => sanitize_text_field( $_POST['user_pass_placeholder'] ),
                'conf_placeholder' => sanitize_text_field( $_POST['conf_user_pass_placeholder'] ),
                'info' => sanitize_text_field( $_POST['user_pass_info'] ),
                'min' => intval( $_POST['user_pass_min'] )
            ];

            $field_data = [
                'post_title' => 'user_pass',
                'post_type' => 'mup_reg_field',
                'post_content' => maybe_serialize( $settings ),
                'menu_order' => intval( $_POST['user_pass'] ),
                'post_status' => 'publish',
            ];

            if ( in_array( 'user_pass', $fields ) ) {
                $field_data['ID'] = intval( $_POST['user_pass_id'] );
                $save = wp_update_post( $field_data );

                if ( is_wp_error( $save ) ) {
                    $errors[] = __( 'error in editing password.', 'mas-user-panel' );
                }
            } else {
                $save = wp_insert_post( $field_data );

                if ( is_wp_error( $save ) ) {
                    $errors[] =  __( 'error in creating password.', 'mas-user-panel' );
                }
            }
        } elseif ( in_array( 'user_pass', $fields ) ) {
            $del = wp_delete_post( MUPRegField::field_id_by_name( 'user_pass' ), true );

            if ( ! $del ) {
                $errors[] = __( 'error in deleting password.', 'mas-user-panel' );
            }
        }

        if ( isset( $_POST['user_url'] ) ) {
            $settings = [
                'placeholder' => sanitize_text_field( $_POST['user_url_placeholder'] ),
                'required' => isset( $_POST['user_url_required'] ),
                'info' => sanitize_text_field( $_POST['user_url_info'] ),
            ];

            $field_data = [
                'post_title' => 'user_url',
                'post_type' => 'mup_reg_field',
                'post_content' => maybe_serialize( $settings ),
                'menu_order' => intval( $_POST['user_url'] ),
                'post_status' => 'publish',
            ];

            if ( in_array( 'user_url', $fields ) ) {
                $field_data['ID'] = intval( $_POST['user_url_id'] );
                $save = wp_update_post( $field_data );

                if ( is_wp_error( $save ) ) {
                    $errors[] = __( 'error in editing website.', 'mas-user-panel' );
                }
            } else {
                $save = wp_insert_post( $field_data );

                if ( is_wp_error( $save ) ) {
                    $errors[] =  __( 'error in creating website.', 'mas-user-panel' );
                }
            }
        } elseif ( in_array( 'user_url', $fields ) ) {
            $del = wp_delete_post( MUPRegField::field_id_by_name( 'user_url' ), true );

            if ( ! $del ) {
                $errors[] = __( 'error in deleting website.', 'mas-user-panel' );
            }
        }
    }
}