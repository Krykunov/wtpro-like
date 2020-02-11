<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              tochno.pro
 * @since             1.0.0
 * @package           Wtpro_Like
 *
 * @wordpress-plugin
 * Plugin Name:       Wtpro Like
 * Plugin URI:        tochno.pro
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            igkr
 * Author URI:        tochno.pro
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wtpro-like
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Load Content part with like block
require_once(plugin_dir_path(__FILE__).'/includes/wtpro-like-content.php');

// Load Scripts
require_once(plugin_dir_path(__FILE__).'/includes/wtpro-scripts.php');

// Load custom REST API routes
require_once(plugin_dir_path(__FILE__).'/includes/like-route.php');

// Load Shortcode for posts with likes
require_once(plugin_dir_path(__FILE__).'/includes/wtpro-like-shortcode.php');

// Register custom post type for Likes
register_activation_hook( __FILE__, 'wtpro_like_activate' );

function wtpro_like_activate() {

    register_post_type('like', array(
        'supports' => array('title', 'custom-fields'),
        'public' => false,
        'show_ui' => true,
        'labels' => array(
            'name' => 'Likes',
            'add_new_item' => 'Add New Like',
            'edit_item' => 'Edit Like',
            'all_items' => 'All Likes',
            'singular_name' => 'Like'
        ),
        'menu_icon' => 'dashicons-heart'
    ));

    flush_rewrite_rules();

}

add_action('init', 'wtpro_like_activate');

