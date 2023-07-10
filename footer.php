<footer>
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-4 col-lg-4 column">
				<h3>Company</h3>
				<ul>
					<li><a href="">About Us</a></li>
					<li><a href="">Contact Us</a></li>
					<li><a href="">Branches</a></li>
					<li><a href="">Blog</a></li>
					<li><a href="">Online Ordering Help</a></li>
					<li><a href="">Join our club Email</a></li>
				</ul>
			</div>
			<div class="col-12 col-md-4 col-lg-4 column">
				<h3>Useful Links</h3>
				<ul>
					<li><a href="">Feedbacks</a></li>
					<li><a href="">Privacy Policy</a></li>
					<li><a href="">Terms and Condition</a></li>
					<li><a href="">FQA</a></li>
				</ul>
			</div>
			<div class="col-12 col-md-4 col-lg-4 column">
				<h3>Useful Links</h3>
				<ul>
					<li><a href="">About Us</a></li>
					<li><a href="">Contact Us</a></li>
					<li><a href="">Branches</a></li>
					<li><a href="">Employment</a></li>
					<li><a href="">Blog</a></li>
					<li><a href="">Online Ordering Help</a></li>
					<li><a href="">Join our club Email</a></li>
				</ul>
			</div>
		</div>
		<p class="copyright">Copyright © 2021 Pizzania <sup>&reg;</sup> | Disclamer: This website is for educational purposes only. Contents are owned by respective creditors.</p>
	</div>
</footer>


<div id="main-wrapper">
	<div class="check-cart <?php echo esc_attr(WC()->cart->is_empty() ? 'majc-hide-cart-items' : ''); ?>"></div>
	<div class="main-inner-wrapper">

		<div class="cart-popup">
			<div class="cart-popup-inner">

				<div class="header">
					<h2>
						Your Cart
					</h2>
					<div class="sub-header">
						<span class="cart-qty-count"><?php esc_html_e('Quantity: ', 'mini-ajax-cart'); ?><?php echo WC()->cart->get_cart_contents_count(); ?></span>
						<span class="cart-item-count"><?php esc_html_e('Items: ', 'mini-ajax-cart'); ?><?php echo sizeof(WC()->cart->get_cart()); ?></span>
					</div>
					<span class="cart-close">
					<img src="<?php echo get_template_directory_uri() . '/assets/img/cancel.png'; ?>" alt="" srcset="" width="20px" height="20px" id="close-cart">
					</span>
				</div>


				<div class="body">
					<div class="majc-cart-item-wrap">
						<?php if (!WC()->cart->is_empty()) { ?>
							<div class="majc-mini-cart">
								<?php
								$items = WC()->cart->get_cart();
								foreach ($items as $itemKey => $itemVal) {
								?>
									<div class="cart-item" data-itemId="<?php echo esc_attr($itemVal['product_id']); ?>" data-cKey="<?php echo esc_attr($itemVal['key']); ?>">
										<div class="row no-gutters">
											<?php
											$product = wc_get_product($itemVal['data']->get_id());
											$product_id = apply_filters('woocommerce_cart_item_product_id', $itemVal['product_id'], $itemVal, $itemKey);
											$getProductDetail = wc_get_product($itemVal['product_id']);
											?>
											<div class="col-5">
												<?php echo $getProductDetail->get_image('thumbnail'); ?>
											</div>

											<div class="col-7">
												<div class="cart-item-details">
													<div class="title">
														<?php echo esc_html($product->get_name()); ?>
													</div>
													<span class="options"><i class="fas fa-caret-down"></i> Show options:</span>
													<div class="options-content">
														<span class="option">Mozzarella cheese, Fet cheese, Grated Parmesan, Cheddar cheese</span>
													</div>

													<div class="majc-item-qty">
														<span class="majc-qty-minus majc-qty-chng icon_minus-06"></span>

														<input type="number" class="majc-qty" step="1" min="0" max="14" value="<?php echo intval($itemVal['quantity']); ?>" placeholder="" inputmode="numeric">

														<span class="majc-qty-plus majc-qty-chng icon_plus"></span>
													</div>

													<div class="majc-item-price">
														<?php
														$wc_product = $itemVal['data'];
														echo WC()->cart->get_product_subtotal($wc_product, $itemVal['quantity']);
														?>
														<?php
														echo wc_get_formatted_cart_item_data($itemVal); // PHPCS: XSS ok.

														?>
													</div>
													<div class="cart-btns d-flex align-items-center">

														<a href="#">Edit</a>
														<div class="majc-item-remove">
														<?php
														echo apply_filters('woocommerce_cart_item_remove_link', sprintf(
															'<a href="%s" class="remove"  aria-label="%s" data-cart_item_id="%s" data-cart_item_sku="%s" data-cart_item_key="%s">remove</a>',
															esc_url(wc_get_cart_remove_url($itemKey)),
															esc_html__('Remove this item', 'mini-ajax-cart'),
															esc_attr($product_id),
															esc_attr($product->get_sku()),
															esc_attr($itemKey)
														), $itemKey);
														?>
													</div>
													</div>
												</div>

											</div>
										</div>
									</div>
								<?php
								} // product foreach loop ends
								?>
							</div> <!-- majc-mini-cart -->
						<?php } else { ?>
							<div class="majc-empty-cart">
								<?php esc_html_e('The Cart is Empty', 'mini-ajax-cart'); ?>
							</div>
						<?php } ?>
					</div>


					<!-- Summary -->
					<div class="majc-buy-summary">

						<div class="majc-cart-total-wrap">
							<label><?php echo esc_html__('Cart Total', 'mini-ajax-cart'); ?></label>
							<div class="majc-cart-total-amount"><?php echo wc_price(WC()->cart->get_subtotal() + WC()->cart->get_subtotal_tax()); ?></div>
						</div>

						<div class='majc-cart-subtotal-wrap'>
							<?php
							$get_totals = WC()->cart->get_totals();
							$cart_total = $get_totals['subtotal'];
							$cart_discount = $get_totals['discount_total'];
							$final_subtotal = $cart_total - $cart_discount;
							?>
							<label class='majc-total-label'><?php echo esc_html__('Subtotal', 'mini-ajax-cart'); ?></label>

							<div class='majc-subtotal-amount'>
								<?php echo get_woocommerce_currency_symbol() . number_format($final_subtotal, 2); ?>
							</div>
						</div>

					</div>




					<div class="majc-cart-action-btn-wrap">


						<div class="majc-cart-checkout-btn">



						</div>
					</div> <!-- majc-footer -->
				</div> <!-- majc-body -->

			</div> <!-- majc-cart-popup-inner -->
		</div> <!-- majc-cart-popup -->
	</div> <!-- majc-main-inner-wrap -->

	<div class="majc-main-wrapper-bg"></div>
</div> <!-- majc-main-wrapper -->

</div>



<?php wp_footer(); ?>


</body>

</html>