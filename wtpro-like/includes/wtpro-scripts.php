<?php

// Add scripts

function wtpro_add_scripts(){
    wp_enqueue_style('wtpro-style', plugins_url() . '/wtpro-like/public/css/wtpro-like-public.css');
    wp_enqueue_script('wtpro-script', plugins_url() . '/wtpro-like/public/js/wtpro-like-public.js', array(), null ,'in_footer');
    wp_localize_script('wtpro-script', 'websiteData', array(
        'root_url' => get_site_url(),
        'nonce' => wp_create_nonce('wp_rest')
    ));
}

add_action('wp_enqueue_scripts', 'wtpro_add_scripts');