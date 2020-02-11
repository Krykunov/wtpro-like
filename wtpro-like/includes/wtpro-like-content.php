<?php

function wtrpo_add_likebox($content) {

    $likeCount = new WP_Query(array(
        'post_type' => 'like',
        'meta_query' => array(
            array(
                'key' => 'liked_post_id',
                'compare' => '=',
                'value' => get_the_ID()
            )
        )
    ));

    $existStatus = 'no';
    $likeButtonText = 'Like';

    if (is_user_logged_in()) {
        $existQuery = new WP_Query(array(
            'author' => get_current_user_id(),
            'post_type' => 'like',
            'meta_query' => array(
                array(
                    'key' => 'liked_post_id',
                    'compare' => '=',
                    'value' => get_the_ID()
                )
            )
        ));

        if ($existQuery->found_posts) {
            $existStatus = 'yes';
            $likeButtonText = 'Liked';
        }

        $like_button = '<span class="button-like" data-like="' . $existQuery->posts[0]->ID . '" data-exists="' . $existStatus . '" data-postid="' . get_the_ID() . '">' . $likeButtonText . '  </span>';
    }

    $like_block = '<div class="likes-block">' . $like_button . ' Total likes: <span class="likes-count">' . $likeCount->found_posts . '</span></div><br>';

    if ( is_single() ) {
        return $content . $like_block;
    }

}

add_filter('the_content', 'wtrpo_add_likebox');


