<?php

add_action('rest_api_init', 'wtproLikeRoutes');

function wtproLikeRoutes() {
  register_rest_route('wtpro/v1', 'manageLikes', array(
    'methods' => 'POST',
    'callback' => 'makeLike'
  ));

  register_rest_route('wtpro/v1', 'manageLikes', array(
    'methods' => 'DELETE',
    'callback' => 'removeLike'
  ));
}

function makeLike($data) {

    if (is_user_logged_in()) {

        $post = sanitize_text_field( $data['thispostID']);

        $existQuery = new WP_Query(array(
            'author' => get_current_user_id(),
            'post_type' => 'like',
            'meta_query' => array(
                array(
                    'key' => 'liked_post_id',
                    'compare' => '=',
                    'value' => $post
                )
            )
        ));

        if ($existQuery->found_posts == 0 AND get_post_type($post) == 'post') {
            return wp_insert_post(array(
                'post_type' => 'like',
                'post_status' => 'publish',
                'post_title' => 'PHP Create Post TEST',
                'meta_input' => array(
                    'liked_post_id' => $post
                )
            ));
        } else {
            die("Invalid");
        }


    } else {
        die("only!!!");
    }
}



function removeLike($data) {
    $likeId = sanitize_text_field($data['like']);
    if (get_current_user_id() == get_post_field('post_author', $likeId) AND get_post_type($likeId) == 'like') {
        wp_delete_post($likeId, true);
        return 'Cong!';
    } else {
        die("No permission!");
    }
}