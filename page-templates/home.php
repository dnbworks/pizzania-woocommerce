<?php

/**
 * Template Name: Home
 *
 *
 */

// Exit if accessed directly.
defined('ABSPATH') || exit;

get_header();



?>

<div class="order-here" style="position: relative;">

	<div class="shadow"></div>
	<div class="order" style="height: 60px;">


	</div>
	<div class="container">
		<div class="row justify-content-between align-items-start">
			<div class="col-12 col-md-4 col-lg-3 catergory">
				<?php

				$orderby = 'name';
				$order = 'desc';
				$hide_empty = false;
				$cat_args = array(
					'orderby'    => $orderby,
					'order'      => $order,
					'hide_empty' => $hide_empty,
				);

				$product_categories = get_terms('product_cat', $cat_args);

				if (!empty($product_categories)) {
					$counter = 0;
					$class = '';
					echo '<ul>';
					foreach ($product_categories as $key => $category) {
						$counter++;
						if ($counter == 1) {
							$class = 'active';
						} else {
							$class = '';
						}
				?>
						<li class="<?php echo $class; ?> li type" id="<?php echo $category->slug; ?>">
							<a href="#" class="d-flex justify-content-between type">
								<span class="type"><?php echo $category->name; ?></span>
								<span><i class="fas fa-chevron-right"></i></span>
							</a>
						</li>

				<?php }
					echo '</ul>';
				} else {
					echo 'no content';
				}
				?>


			</div>

			<div class="col-12 col-md-8 col-lg-9">
				<div class="flex-item menu-content">
					<?php
					$arg = array(
						'post_type' => 'product',
						'posts_per_page' => 6,
						'tax_query' => array(
							array(
								'taxonomy' => 'product_cat',
								'field' => 'slug',
								'terms' => array('special-offer'),
								'operator' => 'IN'
							)
						)
					);

					$products_by_cat = new WP_Query($arg);
					if ($products_by_cat->have_posts()) {
						while ($products_by_cat->have_posts()) {
							$products_by_cat->the_post();

							$product = wc_get_product(get_the_id()); // Get the WC_Product Object

							if ($product->is_type('variable')) {
								$product = new WC_Product_Variable(get_the_id());
								$variation_variations = $product->get_variation_attributes(); // get all attributes by variations
							} else {
								$variation_variations = false;
							}

							$image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'medium');

							$product_array = array(
								'product_name' => get_the_title(),
								'product_image' => $image[0],
								"product_slug" => $product->get_slug(),
								'product_price' => $product->get_regular_price(),
								'product_categories' => $product->get_category_ids(),
								'is_variable' => $product->is_type('variable')
							);

					?>

							<div class="item" data-product='<?php echo json_encode($product_array);  ?>' id="<?php echo get_the_ID(); ?>" data-attributes='<?php echo json_encode($variation_variations);  ?>' data-name="<?php echo $product->get_slug() ?>">
								<div class="views-field views-field-field-product-image">
									<div class="field-content">
										<a href="#">
											<div class="media media--blazy  media--image">
												<img height="220" width="220" class="b-lazy media__image media__element b-loaded" alt="" src="<?php echo $image[0]; ?>" typeof="foaf:Image">
											</div>
										</a>
									</div>
								</div>
								<div class="views-field product-list-title">
									<a href="#" hreflang="en"><?php echo get_the_title(); ?></a>
								</div>

								<div class="views-field views-field-price__number">
									<span class="field-content">starts at
										<?php
										wc_get_template('loop/price.php');
										?>
									</span>
								</div>

								<div style="text-align: center;">
									<a href="<?php echo esc_url(sprintf('%1$s/?add-to-cart=%2$s', site_url(), get_the_ID())); ?>" class="add_to_cart_button ajax_add_to_cart" data-product_id='<?php echo get_the_ID(); ?>'>
										Order Now
									</a>
								</div>

							</div>
					<?php
						}
					}
					wp_reset_postdata();
					?>
				</div>
			</div>




			<div class="pagination d-flex justify-content-center">

			</div>
		</div>
	</div>
</div>
</div>

<div class="select-item-modal">
	<div class="title-header d-flex justify-content-between">
		<div class="title">Tossed 5 cheese pizza Builder</div>
		<div class="close-modal-btn"><img src="<?php echo get_template_directory_uri() . '/assets/img/cancel.png'; ?>" alt="" srcset="" width="18px"></div>
	</div>
	<div class="row">
		<div class="col-lg-7">
			<div class="options-header">
				<div class="title">Do you want to customize your specialty pizza?</div>
				<div class="btns">
					<a href="#" id="customize-btn">Yes, customize</a>
					<a href="#">No, add to cart</a>
				</div>
				<div class="info">
					<p>The pizza builder will always select regular cut, regular size, 1 ketchup sachet and no toppings as default.</p>
				</div>
			</div>
			<div class="customize">
				<div class="title">
					Select your options
				</div>
				<form action="" method="post" id="form">
					<label for="size">Choose your pizza size</label>
					<div style="margin-bottom: 10px; position: relative;">
						<i class="fas fa-caret-down"></i>
						<input type="text" name="size" class="input-text input" placeholder="Choose your size" data-listen="input" autocomplete="off" readonly="" data-required-validate="true" id="size">
						<ul class="list" style="display: none;">
							<li class="" data-combination-value="2205-6846" data-select-value="Regular" data-price-value="210" data-product="14233">
								<div class="o-form-dropdown_input--item [ u-df-mb u-df-mb-fd-c u-df-mb-jc-c ]">
									<h5 class="h5">Regular</h5>
									<div class="o-form-dropdown_input--item__subdetail [ u-df-mb ]">
										<span>₱210.00</span>
									</div>
								</div>
							</li>
							<li class="" data-combination-value="2205-6847" data-select-value="Large" data-price-value="380" data-product="14233">
								<div class="o-form-dropdown_input--item [ u-df-mb u-df-mb-fd-c u-df-mb-jc-c ]">
									<h5 class="h5">Large</h5>
									<div class="o-form-dropdown_input--item__subdetail [ u-df-mb ]">
										<span>₱380.00</span>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<label for="condiments">Choose your condiments</label>
					<div style="margin-bottom: 10px; position: relative;">
						<i class="fas fa-caret-down"></i>
						<input type="text" name="condiments" class="input-text input" placeholder="Choose your condiments" data-listen="input" autocomplete="off" readonly="" data-required-validate="true" id="condiments">
						<ul class="list" style="display: none;">
							<li class="" data-combination-value="2205-6846" data-select-value="Hot Chix" data-price-value="210" data-product="14233">
								<div class="o-form-dropdown_input--item [ u-df-mb u-df-mb-fd-c u-df-mb-jc-c ]">
									<h5 class="h5"><i class="fas fa-ban"></i> No Add-ons</h5>
								</div>
							</li>
							<li class="" data-combination-value="2205-6846" data-select-value="Hot Chix" data-price-value="210" data-product="14233">
								<div class="o-form-dropdown_input--item [ u-df-mb u-df-mb-fd-c u-df-mb-jc-c ]">
									<h5 class="h5">Hot Chix</h5>
									<div class="o-form-dropdown_input--item__subdetail [ u-df-mb ]">
										<span>₱15.10</span>
									</div>
								</div>
							</li>
							<li class="" data-combination-value="2205-6847" data-select-value="Sweet Soy" data-price-value="380" data-product="14233">
								<div class="o-form-dropdown_input--item [ u-df-mb u-df-mb-fd-c u-df-mb-jc-c ]">
									<h5 class="h5">Lime</h5>
									<div class="o-form-dropdown_input--item__subdetail [ u-df-mb ]">
										<span>₱20.00</span>
									</div>
								</div>
							</li>
							<li class="" data-combination-value="2205-6847" data-select-value="Sweet Soy" data-price-value="380" data-product="14233">
								<div class="o-form-dropdown_input--item [ u-df-mb u-df-mb-fd-c u-df-mb-jc-c ]">
									<h5 class="h5">Ketchup - 1 Sachet</h5>
									<div class="o-form-dropdown_input--item__subdetail [ u-df-mb ]">
										<span>₱5.00</span>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<label for="pizza_cut">Choose your pizza cut</label>
					<div style="margin-bottom: 10px; position: relative;">
						<i class="fas fa-caret-down"></i>
						<input type="text" name="pizza_cut" class="input-text input" placeholder="Choose your pizza cut" data-listen="input" autocomplete="off" readonly="" data-required-validate="true" id="pizza_cut">
						<ul class="list" style="display: none;">
							<li class="" data-combination-value="2205-6846" data-select-value="Hot Chix" data-price-value="210" data-product="14233">
								<div class="o-form-dropdown_input--item [ u-df-mb u-df-mb-fd-c u-df-mb-jc-c ]">
									<h5 class="h5">Regular Cut</h5>
								</div>
							</li>
							<li class="" data-combination-value="2205-6847" data-select-value="Sweet Soy" data-price-value="380" data-product="14233">
								<div class="o-form-dropdown_input--item [ u-df-mb u-df-mb-fd-c u-df-mb-jc-c ]">
									<h5 class="h5">Square Cut</h5>
								</div>
							</li>
						</ul>
					</div>
					<label for="Instruction">Special Instruction (optional)</label>
					<textarea name="Instruction" id="Instruction" class="input" placeholder="Add Special Instruction here"></textarea>
					<button type="submit" id="add"><img src="asset/img/loader.svg" alt="" srcset="">Add to Tray</button>
				</form>
			</div>
		</div>
		<div class="col-lg-5">
			<div class="dialog-item-details">
				<div class="dialog">
					<div class="title">MY PIZZA</div>
					<div class="pizza-name">Regular Hand Tossed 5 cheese</div>
					<div class="quantity">
						<label for="quantity">Quantity: </label>
						<input type="number" name="quantity" id="quantity" value="1">
					</div>
				</div>
				<img src="http://pizza.local/wp-content/uploads/2023/06/PEPPERONI_48.png" alt="" style="display:block; margin: 10px auto;" width="200px">
			</div>
		</div>
	</div>
</div>
<?php
// woocommerce_mini_cart();

?>
</div>

<div id="json-info" data-categories='<?php echo json_encode($product_categories); ?>'></div>



<?php
get_footer();
