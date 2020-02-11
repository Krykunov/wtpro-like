<?php

function wtrpo_top_posts() {

    $posts = get_posts( array(
        'numberposts' => -1,
        'post_type'   => 'post',
    ) );

    foreach( $posts as $post ){
        $postLikeCount = new WP_Query(array(
            'post_type' => 'like',
            'meta_query' => array(
                array(
                    'key' => 'liked_post_id',
                    'compare' => '=',
                    'value' => $post->ID,
                )
            )
        ));

        update_post_meta($post->ID, 'total_likes', $postLikeCount);
    }

    $top_query = new WP_Query(
        array (
            'post_type' => 'post',
            'orderby' => 'meta_value',
            'meta_key' => 'total_likes',
            'order' => 'DESC'
        )
    );

    while ( $top_query->have_posts() ) {
        $top_query->the_post();

        the_title();
    }

}

add_shortcode('top_posts', 'wtrpo_top_posts');
