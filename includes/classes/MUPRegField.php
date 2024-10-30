<?php


class MUPRegField {
    static public function fields_settings( $name ) {
        $posts = get_posts([
            'post_type' => 'mup_reg_field',
            'numberposts' => -1,
        ]);

        $res = '';

        foreach ( $posts as $post ) {
            if ( $post->post_title === $name ) {
                $res = unserialize( $post->post_content );
                break;
            }
        }

        return $res;
    }

    static public function field_exist( $field ) {
        $fields = [];

        $posts = get_posts([
            'post_type' => 'mup_reg_field',
            'numberposts' => -1,
        ]);

        foreach ( $posts as $post ) $fields[] = $post->post_title;

        return in_array( $field, $fields );
    }

    static public function fields() {
        $fields = [];

        $posts = get_posts([
            'post_type' => 'mup_reg_field',
            'numberposts' => -1,
        ]);

        foreach ( $posts as $post ) $fields[] = $post->post_title;

        return $fields;
    }

    static public function field_id_by_name( $name ) {
        $field_id = false;

        $posts = get_posts([
            'post_type' => 'mup_reg_field',
            'numberposts' => -1,
        ]);

        foreach ( $posts as $post ) {
            if ( $post->post_title === $name ) $field_id = $post->ID;
        }

        return $field_id;
    }
}