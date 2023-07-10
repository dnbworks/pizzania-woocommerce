<?php

defined('ABSPATH') or die('No script please!!');

if (!class_exists('Assets')) {
	class Assets
	{

		function __construct()
		{
			// load class.
			$this->setup_hooks();
		}

		protected function setup_hooks()
		{

			add_action('wp_enqueue_scripts', [$this, 'register_styles']);
			add_action('wp_enqueue_scripts', [$this, 'register_scripts']);
		}

		public function register_styles()
		{
			// Register styles.

			wp_register_style('bootstrap-css', PIZZANIA_ASSETS_CSS_URI . '/bootstrap-grid.min.css', [], '3.3.4', 'all');
			wp_register_style('main-css', PIZZANIA_ASSETS_CSS_URI . '/style.css', ['bootstrap-css'], '1.0.0', 'all');

			// Enqueue Styles.
			wp_enqueue_style('bootstrap-css');
			wp_enqueue_style('main-css');
		}

		public function register_scripts()
		{
			// Register scripts.

			wp_register_script('fontawesome', PIZZANIA_ASSETS_JS_URI . '/fontawesome.js', [], '1.0.0', true);
			wp_register_script('main-js', PIZZANIA_ASSETS_JS_URI . '/script.js', [], '1.0.0', true);
			wp_register_script('frontend-script', PIZZANIA_ASSETS_JS_URI . '/frontend.js', ['jquery'], '1.0.0', true);


			// Enqueue Scripts.
			wp_enqueue_script('fontawesome');
			wp_enqueue_script('main-js');
			wp_enqueue_script('frontend-script');

			$frontend_js_obj = array(
				'root_url' => get_site_url(),
				'ajax_url' => admin_url('admin-ajax.php'),
				'ajax_nonce' => wp_create_nonce('majc-frontend-ajax-nonce')
			);
			wp_localize_script('frontend-script', 'frontend_js_obj', $frontend_js_obj);
		}
	}
	new Assets();
}
