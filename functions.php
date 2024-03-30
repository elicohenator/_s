<?php

/**
 * _s functions and definitions
 */

if (!defined('_S_VERSION')) {
	define('_S_VERSION', '1.0.0');
}

if (!function_exists('_s_setup')) :

	function _s_setup()
	{

		load_theme_textdomain('_s', get_template_directory() . '/languages');
		add_theme_support('automatic-feed-links');
		add_theme_support('title-tag');
		add_theme_support('post-thumbnails');
		add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'primary' => esc_html__('Primary', '_s'),
			)
		);
	}
endif;
add_action('after_setup_theme', '_s_setup');


/** 
 * Remove extra image sizes
 */
function remove_extra_image_sizes()
{
	foreach (get_intermediate_image_sizes() as $size) {
		if (!in_array($size, array('thumbnail', 'medium', 'large', '2048x2048'))) {
			remove_image_size($size);
		}
	}
}
add_action('init', 'remove_extra_image_sizes');


/**
 * Enqueue scripts and styles.
 */
function _s_scripts()
{
	wp_enqueue_style('_s-screen', get_template_directory_uri() . '/styles/screen.css', array(), filemtime(get_template_directory() . '/styles/screen.css'));
	wp_enqueue_style('_s-style', get_stylesheet_uri(), array(), _S_VERSION);

	wp_enqueue_script('_s-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), filemtime(get_template_directory() . '/js/scripts.js'), true);
	wp_enqueue_script('_s-custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), filemtime(get_template_directory() . '/js/custom.js'), true);
	wp_enqueue_script('_s-navigation', get_template_directory_uri() . '/js/navigation.js', array(), filemtime(get_template_directory() . '/js/navigation.js'), true);

	$phpVars = array(
		'template_directory' => get_template_directory_uri(),
		'ajax_url' => admin_url("admin-ajax.php"),
		'ajax_nonce' => wp_create_nonce("ajax_nonce"),
		'version' => _S_VERSION
	);
	wp_localize_script('_s-custom', 'php_vars', $phpVars);
}
add_action('wp_enqueue_scripts', '_s_scripts');


// Functions which enhance the theme by hooking into WordPress.
require get_template_directory() . '/inc/enhancements.php';

// Custom template tags for this theme.
require get_template_directory() . '/inc/template-tags.php';

// Functions which enhance the theme by hooking into WordPress.
require get_template_directory() . '/inc/template-functions.php';

// Customizer additions.
require get_template_directory() . '/inc/customizer.php';

// Customizer additions.
require get_template_directory() . '/inc/admin.php';

// Customizer additions.
require get_template_directory() . '/inc/acf.php';

// Load WooCommerce compatibility file.
if (class_exists('WooCommerce')) {
	require get_template_directory() . '/inc/woocommerce.php';
}
