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
						<li class="<?php echo $class; ?> li type" id="<?php echo $category->name; ?>">
							<a href="#" class="d-flex justify-content-between type">
								<span class="type"><?php echo $category->name; ?></span>
								<span><i class="fas fa-chevron-right"></i></span>
							</a>
						</li>

				<?php }
					echo '</ul>';
				}
				?>


			</div>

			<div class="col-12 col-md-8 col-lg-9">
				<?php
				if (!empty($product_categories)) {
					$counter = 0;
					$class = '';
					foreach ($product_categories as $key => $product_cat) {
						$counter++;
						if ($counter == 1) {
							$class = 'show';
						} else {
							$class = 'none';
						}
				?>
						<div class="content-wrapper <?php echo $class; ?>" id="<?php echo $product_cat->name; ?>">
							<?php

							$arg = array(
								'post_type' => 'product',
								'posts_per_page' => 6,
								'tax_query' => array(
									array(
										'taxonomy' => 'product_cat',
										'field' => 'slug',
										'terms' => array($product_cat->slug),
										'operator' => 'IN'
									)
								)
							);



							$products_by_cat = new WP_Query($arg);
							if ($products_by_cat->have_posts()) {
								echo '<div class="flex-item menu-content">';
								while ($products_by_cat->have_posts()) {
									$products_by_cat->the_post();

									$product = new WC_Product(get_the_ID());

									if ($product->is_type('variable')) {
									}



									$image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'medium');
							?>
									<div class="item" id="<?php echo get_the_ID(); ?>">
										<div class="views-field views-field-field-product-image">
											<div class="field-content">
												<a href="#">
													<div class="media media--blazy  media--image">
														<img height="220" width="220" class="b-lazy media__image media__element b-loaded" alt="" src="<?php echo $image[0]; ?>" typeof="foaf:Image">
													</div>
												</a>
											</div>
										</div>
										<span class="views-field views-field-title">
											<span class="field-content product-list-title">
												<a href="#" hreflang="en"><?php echo get_the_title(); ?></a>
											</span>
										</span>
										<div class="views-field views-field-body">
											<div class="field-content">
												<p></p>
											</div>
										</div>

										<div class="views-field views-field-price__number">
											<span class="field-content">starts at
												<?php
												wc_get_template('loop/price.php');
												?>
											</span>
										</div>

										<div>
											<a href="<?php echo esc_url(sprintf('%1$s/?add-to-cart=%2$s', site_url(), get_the_ID())); ?>" class="px-3 py-1 rounded-sm mr-3 text-sm border-solid border border-current hover:bg-purple-600 hover:text-white hover:border-purple-600">
												Add to cart
											</a>
											<?php
											if ($product->is_type('variable')) {
												echo '<a href="">Customize</a>';
											}
											?>
										</div>

									</div>

								<?php }
								echo '</div>';
								?>
						</div>
				<?php
							}
							wp_reset_postdata();
						}
				?>

				<div class="pagination d-flex justify-content-center">
					<?php
					$paged = get_query_var('paged') ? get_query_var('paged') : 1;
					$total_pages = $products_by_cat->max_num_pages;
					get_template_part('template-parts/common/pagination', null, [
						'total_pages'  => $total_pages,
						'current_page' => $paged,
					]);

					?>
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
				<form action="" method="post" id="form_options">
					<label for="size">Choose your pizza size</label>
					<div style="margin-bottom: 10px; position: relative;">
						<svg class="svg-inline--fa fa-angle-down fa-w-10" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
							<path fill="currentColor" d="M143 352.3L7 216.3c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0l96.4 96.4 96.4-96.4c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9l-136 136c-9.2 9.4-24.4 9.4-33.8 0z"></path>
						</svg><!-- <i class="fas fa-angle-down"></i> -->
						<!-- <input type="text" name="size" class="input-text input" placeholder="Choose your size" data-listen="input" autocomplete="off" readonly="" data-required-validate="true" id="size"> -->
						<input type="text" name="size" class="input-text input" placeholder="Choose your size" data-listen="input" autocomplete="off" readonly="" data-required-validate="true" id="size">
						<ul class="[ u-df-mb u-df-mb-fd-c ]" style="visibility: visible; opacity: 0; display: none;">
							<li class="[ u-df-mb ] " data-combination-value="2205-6846" data-select-value="Regular" data-price-value="210" data-product="14233">
								<div class="o-form-dropdown_input--item [ u-df-mb u-df-mb-fd-c u-df-mb-jc-c ]">
									<h5 class="h5">Regular</h5>
									<div class="o-form-dropdown_input--item__subdetail [ u-df-mb ]">
										<span>Php 210.00</span>
									</div>
								</div>
							</li>
							<li class="[ u-df-mb ] " data-combination-value="2205-6847" data-select-value="Large" data-price-value="380" data-product="14233">
								<div class="o-form-dropdown_input--item [ u-df-mb u-df-mb-fd-c u-df-mb-jc-c ]">
									<h5 class="h5">Large</h5>
									<div class="o-form-dropdown_input--item__subdetail [ u-df-mb ]">
										<span>Php 380.00</span>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<label for="condiments">Choose your condiments</label>
					<div style="margin-bottom: 10px; position: relative;">
						<svg class="svg-inline--fa fa-angle-down fa-w-10" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
							<path fill="currentColor" d="M143 352.3L7 216.3c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0l96.4 96.4 96.4-96.4c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9l-136 136c-9.2 9.4-24.4 9.4-33.8 0z"></path>
						</svg><!-- <i class="fas fa-angle-down"></i> -->
						<!-- <input type="text" name="condiments" class="input-text input" placeholder="Choose your condiments" data-listen="input" autocomplete="off" readonly="" data-required-validate="true" id="condiments"> -->
						<input type="text" name="condiments" class="input-text input" placeholder="Choose your condiments" data-listen="input" autocomplete="off" readonly="" data-required-validate="true" id="condiments">
						<ul class="[ u-df-mb u-df-mb-fd-c ]" style="visibility: visible; opacity: 0; display: none;">
							<li class="[ u-df-mb ] " data-combination-value="2205-6846" data-select-value="Hot Chix" data-price-value="210" data-product="14233">
								<div class="o-form-dropdown_input--item [ u-df-mb u-df-mb-fd-c u-df-mb-jc-c ]">
									<h5 class="h5">Hot Chix</h5>
									<div class="o-form-dropdown_input--item__subdetail [ u-df-mb ]">
										<span>Php 15.10</span>
									</div>
								</div>
							</li>
							<li class="[ u-df-mb ] " data-combination-value="2205-6847" data-select-value="Sweet Soy" data-price-value="380" data-product="14233">
								<div class="o-form-dropdown_input--item [ u-df-mb u-df-mb-fd-c u-df-mb-jc-c ]">
									<h5 class="h5">Lime</h5>
									<div class="o-form-dropdown_input--item__subdetail [ u-df-mb ]">
										<span>Php 20.00</span>
									</div>
								</div>
							</li>
							<li class="[ u-df-mb ] " data-combination-value="2205-6847" data-select-value="Sweet Soy" data-price-value="380" data-product="14233">
								<div class="o-form-dropdown_input--item [ u-df-mb u-df-mb-fd-c u-df-mb-jc-c ]">
									<h5 class="h5">Ketchup - 1 Sachet</h5>
									<div class="o-form-dropdown_input--item__subdetail [ u-df-mb ]">
										<span>Php 5.00</span>
									</div>
								</div>
							</li>
						</ul>
					</div>
					<label for="pizza_cut">Choose your pizza cut</label>
					<div style="margin-bottom: 10px; position: relative;">
						<svg class="svg-inline--fa fa-angle-down fa-w-10" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-down" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" data-fa-i2svg="">
							<path fill="currentColor" d="M143 352.3L7 216.3c-9.4-9.4-9.4-24.6 0-33.9l22.6-22.6c9.4-9.4 24.6-9.4 33.9 0l96.4 96.4 96.4-96.4c9.4-9.4 24.6-9.4 33.9 0l22.6 22.6c9.4 9.4 9.4 24.6 0 33.9l-136 136c-9.2 9.4-24.4 9.4-33.8 0z"></path>
						</svg>
						<input type="text" name="pizza_cut" class="input-text input" placeholder="Choose your pizza cut" data-listen="input" autocomplete="off" readonly="" data-required-validate="true" id="pizza_cut">
						<ul class="[ u-df-mb u-df-mb-fd-c ]" style="visibility: visible; opacity: 0; display: none;">
							<li class="[ u-df-mb ] " data-combination-value="2205-6846" data-select-value="Hot Chix" data-price-value="210" data-product="14233">
								<div class="o-form-dropdown_input--item [ u-df-mb u-df-mb-fd-c u-df-mb-jc-c ]">
									<h5 class="h5">Regular Cut</h5>
								</div>
							</li>
							<li class="[ u-df-mb ] " data-combination-value="2205-6847" data-select-value="Sweet Soy" data-price-value="380" data-product="14233">
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
			<div class="dialog">
				<div class="title">MY PIZZA</div>
				<div class="pizza-name">Regular Hand Tossed 5 cheese</div>
				<div class="quantity">
					<label for="quantity">Quantity: </label>
					<input type="number" name="quantity" id="quantity" value="1">
				</div>
			</div>
			<img src="http://pizza.local/wp-content/uploads/2023/06/PEPPERONI_48.png" alt="" style="display:block; margin: 10px auto;">
		</div>
	</div>
</div>
</div>



<?php
				}
				get_footer();
