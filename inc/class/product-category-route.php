<?php

function pizza_register_search()
{
	register_rest_route('pizza/v1', 'product-category', array(
		'methods' => WP_REST_SERVER::READABLE,
		'callback' => 'search_results'
	));
}

function search_results($param)
{

	$paged = sanitize_text_field($param['page']) ? sanitize_text_field($param['page']) : 1;

	$arg = array(
		'post_type' 					=> 'product',
		'posts_per_page' => 6,
		'paged'          => $paged,
		'post_status'    => 'publish',
		'tax_query' 					=> array(
			array(
				'taxonomy' => 'product_cat',
				'field' 			=> 'slug',
				'terms' 			=> array(sanitize_text_field($param['term'])),
				'operator' => 'IN'
			)
		)
	);

	$results = array('data' => array());

	$products_by_cat = new WP_Query($arg);

	if ($products_by_cat->have_posts()) {
		$total_pages = 	$products_by_cat->max_num_pages;

		while ($products_by_cat->have_posts()) {
			$products_by_cat->the_post();

			$product_id            = get_the_ID();
			$product               = new WC_Product(get_the_ID());
			$product_thumbnail_url = get_the_post_thumbnail_url($product_id, 'medium');
			$product_title         = get_the_title();
			$product_link          = get_the_permalink();
			$product_price         = $product->get_price_html();

			if ($product->is_type('variable')) {
			}

			array_push($results['data'], [
				'product_id'            => $product_id,
				'product_thumbnail_url' => $product_thumbnail_url,
				'product_title' 								=> $product_title,
				'product_link' 									=> $product_link,
				'product_price' 								=> $product_price 
			]);
		}
	} else {
		return 'no results';
	}

	$results['pagination'] = paginate_links([
		'base' => get_pagenum_link(1) . '%_%',
		'format' => '&page=%#%',
		'current' => $paged,
		'total' => $total_pages,
		'prev_text' => __('« Prev', 'aquila'),
		'next_text' => __('Next »', 'aquila'),
	]);
	return json_encode($results);
	
}

add_action('rest_api_init', 'pizza_register_search');
