<?php


class MUPPostType {
    static public function init() {
        add_action( 'init', [ __CLASS__, 'mup_notifications_post_type' ] );
        add_action( 'init', [ __CLASS__, 'mup_ticket_post_type' ] );
        add_action( 'init', [ __CLASS__, 'mup_register_field' ] );
    }

    static public function mup_notifications_post_type() {
        $labels = [
            'name' => __( 'Notifications', 'mas-user-panel' ),
            'singular_name' => __( 'Notice', 'mas-user-panel' ),
            'menu_name' => __( 'Notifications', 'mas-user-panel' ),
            'name_admin_bar' => __( 'Notice', 'mas-user-panel' ),
            'add_new' => __( 'Add New', 'mas-user-panel' ),
            'add_new_item' => __( 'Add Notice New', 'mas-user-panel' ),
            'new_item' => __( 'New Notice', 'mas-user-panel' ),
            'edit_item' => __( 'Edit Notice', 'mas-user-panel' ),
            'view_item' => __( 'Display Notice', 'mas-user-panel' ),
            'all_items' => __( 'Notifications', 'mas-user-panel' ),
            'search_items' => __( 'Search Notifications', 'mas-user-panel' ),
            'parent_item_colon' => __( 'Parent Notifications:', 'mas-user-panel' ),
            'not_found' => __( 'Not found notice.', 'mas-user-panel' ),
            'not_found_in_trash' => __( 'Not found notice in trash.', 'mas-user-panel' ),
            'featured_image' => __( 'Notice image', 'mas-user-panel' ),
            'set_featured_image' => __( 'Adjust notice image', 'mas-user-panel' ),
            'remove_featured_image' => __( 'Delete notice image', 'mas-user-panel' ),
            'use_featured_image' => __( 'Use as notice image', 'mas-user-panel' ),
            'archives' => __( 'Notifications archives', 'recipe' ),
            'insert_into_item' => __( 'Insert into Notice', 'mas-user-panel' ),
            'uploaded_to_this_item' => __( 'Upload into notice', 'mas-user-panel' ),
            'filter_items_list' => __( 'Filter Notifications list', 'mas-user-panel' ),
            'items_list_navigation' => __( 'Notifications list navigation', 'mas-user-panel' ),
            'items_list' => __( 'Notifications List', 'mas-user-panel' ),
        ];

        $args = [
            'labels' => $labels,
            'description' => 'notifications post type.',
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => false,
            'query_var' => true,
            'rewrite' => [ 'slug' => 'mup-notifications' ],
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
            'supports' => [ 'title', 'editor' ],
            'show_in_rest' => true
        ];

        register_post_type( 'mup_notifications', $args );
    }

    static public function mup_ticket_post_type() {
        $labels = [
            'name' => 'Tickets',
            'singular_name' =>'Ticket',
            'menu_name' => 'Tickets',
            'name_admin_bar' => 'Ticket',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Ticket',
            'new_item' => 'New Ticket',
            'edit_item' => 'Edit Ticket',
            'view_item' => 'Display Ticket',
            'all_items' => 'Tickets',
            'search_items' => 'Search Tickets',
            'parent_item_colon' => 'Parent Tickets:',
            'not_found' => 'Not found ticket.',
            'not_found_in_trash' => 'Not found ticket in trash.',
            'featured_image' => 'Ticket Image',
            'set_featured_image' => 'Adjust ticket image',
            'remove_featured_image' => 'Delete ticket image',
            'use_featured_image' => 'Use as a ticket image',
            'archives' => 'Tickets Archive',
            'insert_into_item' => 'insert into ticket',
            'uploaded_to_this_item' => 'Upload in this ticket',
            'filter_items_list' =>'Filter Tickets List',
            'items_list_navigation' => 'Tickets List Navigation',
            'items_list' => 'Tickets list',
        ];

        $args = [
            'labels' => $labels,
            'description' => 'ticket post type.',
            'public' => false,
            'show_ui' => false,
            'show_in_menu' => false,
            'query_var' => true,
            'rewrite' => [ 'slug' => 'mup-notifications' ],
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => true,
            'supports' => [],
            'show_in_rest' => true
        ];

        register_post_type( 'mup_ticket', $args );
    }

    static public function mup_register_field() {
        $labels = [
            'name' => 'register field',
            'singular_name' =>'register field',
            'menu_name' => 'register fields',
            'name_admin_bar' => 'register field',
            'add_new' => 'add new',
            'add_new_item' => 'add new register field',
            'new_item' => 'new register field',
            'edit_item' => 'edit register field',
            'view_item' => 'display register field',
            'all_items' => 'register fields',
            'search_items' => 'search register fields',
            'parent_item_colon' => 'register field parent:',
            'not_found' => 'not found register field.',
            'not_found_in_trash' => 'not found register field in trash.',
            'featured_image' => 'register field image',
            'set_featured_image' => 'add register field image',
            'remove_featured_image' => 'remove register field image',
            'use_featured_image' => 'use as register field image',
            'archives' => 'register field archive',
            'insert_into_item' => 'insert into register field',
            'uploaded_to_this_item' => 'upload in register field',
            'filter_items_list' => 'filter register field list',
            'items_list_navigation' => 'register field navigation list',
            'items_list' => 'register field list',
        ];

        $args = [
            'labels' => $labels,
            'description' => 'register field post type.',
            'public' => false,
            'show_ui' => false,
            'show_in_menu' => false,
            'query_var' => true,
            'rewrite' => [ 'slug' => 'mup-reg-field' ],
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => true,
            'supports' => [],
            'show_in_rest' => true
        ];

        register_post_type( 'mup_register_field', $args );
    }
}

MUPPostType::init();