<?php


if ( ! defined( 'PIZZANIA_DIR_PATH' ) ) {
	define( 'PIZZANIA_DIR_PATH', untrailingslashit( get_template_directory() ) );
}

if ( ! defined( 'PIZZANIA_DIR_URI' ) ) {
	define( 'PIZZANIA_DIR_URI', untrailingslashit( get_template_directory_uri() ) );
}

if ( ! defined( 'PIZZANIA_ASSETS_JS_URI' ) ) {
	define( 'PIZZANIA_ASSETS_JS_URI', untrailingslashit( get_template_directory_uri() ) . '/assets/js' );
}

if ( ! defined( 'PIZZANIA_ASSETS_IMG_URI' ) ) {
	define( 'PIZZANIA_BUILD_IMG_URI', untrailingslashit( get_template_directory_uri() ) . '/assets/img' );
}

if ( ! defined( 'PIZZANIA_ASSETS_CSS_URI' ) ) {
	define( 'PIZZANIA_ASSETS_CSS_URI', untrailingslashit( get_template_directory_uri() ) . '/assets/css' );
}

if ( ! defined( 'PIZZANIA_ARCHIVE_POST_PER_PAGE' ) ) {
	define( 'PIZZANIA_ARCHIVE_POST_PER_PAGE', 9 );
}

if ( ! defined( 'PIZZANIA_SEARCH_RESULTS_POST_PER_PAGE' ) ) {
	define( 'PIZZANIA_SEARCH_RESULTS_POST_PER_PAGE', 9 );
}



require get_theme_file_path('/inc/class/product-category-route.php');
require PIZZANIA_DIR_PATH . '/inc/class/assets.php';
require PIZZANIA_DIR_PATH . '/inc/class/theme.php';
require PIZZANIA_DIR_PATH . '/inc/class/side-cart.php';



function ajax_add_to_cart_script()
{
	$vars = array('ajax_url' => admin_url('admin-ajax.php'));
	wp_enqueue_script('wc-variation-add-to-cart', get_template_directory_uri() . '/js/jquery.add-to-cart.js', array('jquery'), null, true);
	wp_localize_script('wc-variation-add-to-cart', 'WC_VARIATION_ADD_TO_CART', $vars);
}

add_action('wp_enqueue_scripts', 'ajax_add_to_cart_script');
add_action('wp_ajax_nopriv_woocommerce_add_variation_to_cart', 'so_27270880_add_variation_to_cart');

function so_27270880_add_variation_to_cart()
{
	ob_start();

	$product_id        = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
	$quantity          = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
	$variation_id      = isset($_POST['variation_id']) ? absint($_POST['variation_id']) : '';
	$variations        = !empty($_POST['variation']) ? (array) $_POST['variation'] : '';
	$passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);

	if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id, $variations)) {

		do_action('woocommerce_ajax_added_to_cart', $product_id);

		if (get_option('woocommerce_cart_redirect_after_add') == 'yes') {
			wc_add_to_cart_message($product_id);
		}

		// Return fragments
		WC_AJAX::get_refreshed_fragments();
	} else {

		// If there was an error adding to the cart, redirect to the product page to show any errors
		$data = array(
			'error' => true,
			'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id)
		);

		wp_send_json($data);
	}

	die();
}



add_action('wp_ajax_nopriv_woocommerce_add_variation_to_cart', 'so_27270880_add_variation_to_cart');
add_action('wp_ajax_woocommerce_add_variation_to_cart', 'so_27270880_add_variation_to_cart');

