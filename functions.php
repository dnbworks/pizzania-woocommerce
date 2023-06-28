<?php


require get_theme_file_path('/inc/product-category-route.php');

function iplc_script_enqueue()
{

	wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap-grid.min.css', array(), '3.3.4', 'all');
	wp_enqueue_style('style', get_template_directory_uri() . '/assets/css/style.css', array(), '1.0.0', 'all');

	// js
	wp_enqueue_script('fontawesome', get_template_directory_uri() . '/assets/js/fontawesome.js', array(), '1.0.0', true);
	wp_enqueue_script('script', get_template_directory_uri() . '/assets/js/script.js', array(), '1.0.0', true);

}
add_action('wp_enqueue_scripts', 'iplc_script_enqueue');

/*
	==========================================
	 Head function
	==========================================
*/
function iplc_remove_version()
{
	return '';
}
add_filter('the_generator', 'iplc_remove_version');

// Customize excerpt word count length
function custom_excerpt_length()
{
	return 22;
}
add_filter('excerpt_length', 'custom_excerpt_length');


function iplc_theme_setup()
{

	add_theme_support('menus');

	register_nav_menu('primary', 'Primary Header Navigation');
	register_nav_menu('secondary', 'Footer Navigation');
}

add_action('init', 'iplc_theme_setup');

/*
	==========================================
	 Theme support function
	==========================================
*/
add_theme_support('custom-background');
add_theme_support('custom-header');
add_theme_support('post-thumbnails');
add_theme_support('post-formats', array('aside', 'image', 'video'));
add_theme_support('html5', array('search-form'));
add_theme_support('custom-logo');
add_image_size('newsImageLandscape', 280, 200, true);


function themename_custom_logo_setup()
{
	$defaults = array(
		'width'                => 150,
		'flex-height'          => true,
		'flex-width'           => true,
		'unlink-homepage-logo' => true,
	);
	add_theme_support('custom-logo', $defaults);
}
add_action('after_setup_theme', 'themename_custom_logo_setup');

/*
	==========================================
	 Custom Post Type
	==========================================
*/


function iplc_features()
{
	add_theme_support('title-tag');
}

add_action('after_setup_theme', 'iplc_features');





add_action( 'wp_ajax_nopriv_load_more', 'ajax_script_post_load_more' );
add_action( 'wp_ajax_load_more', 'ajax_script_post_load_more'  );

