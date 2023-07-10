(function ($) {
	"use strict";

	$(document).ready(function () {

					var ajaxUrl = frontend_js_obj.ajax_url;
					var wpNonce = frontend_js_obj.ajax_nonce;

					// console.log(ajaxUrl, wpNonce);

					$('body').addClass($('.majc-main-wrapper').data('overlayenable'));

					$(document.body).trigger('wc_fragment_refresh');

					$.ajax({
									url: ajaxUrl,
									type: 'POST',
									data: {
													action: 'get_refresh_fragments',
													wp_nonce: wpNonce
									},
									success: function (response) {

													if (response.fragments) {

																	//Set fragments
																	$.each(response.fragments, function (key, value) {
																					$(key).replaceWith(value);
																	});

																	if (('sessionStorage' in window && window.sessionStorage !== null)) {

																					sessionStorage.setItem(wc_cart_fragments_params.fragment_name, JSON.stringify(response.fragments));
																					sessionStorage.setItem(wc_cart_fragments_params.cart_hash_key, response.cart_hash);
																					localStorage.setItem(wc_cart_fragments_params.cart_hash_key, response.cart_hash);

																					if (response.cart_hash) {
																									sessionStorage.setItem('wc_cart_created', (new Date()).getTime());
																					}
																	}
																	$(document.body).trigger('wc_fragments_refreshed');
													}
									}
					});


					$('body').find(".majc-toggle-button").on('click', function () {
									// Add Toggle class on buton toggle
									$(this).closest('.majc-main-wrapper').toggleClass('majc-cartbasket-open');
									$(this).toggleClass('majc-toggle-btn-open');
									var $popup = $(this).next('.majc-cart-popup');

									if ($popup.hasClass('majc-cartpop-animation-enabled')) {
													var showAnimation = $popup.data('showanimation');
													var hideAnimation = $popup.data('hideanimation');

													if ($popup.hasClass('majc-popup-in-view') && hideAnimation) {
																	$popup.addClass('animate--animated ' + hideAnimation);
																	$popup.one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function (e) {
																					$popup.removeClass('animate--animated majc-popup-in-view ' + hideAnimation);
																	});
													} else if (!$popup.hasClass('majc-popup-in-view') && showAnimation) {
																	$popup.addClass('animate--animated majc-popup-in-view ' + showAnimation);
																	$popup.one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function (e) {
																					$popup.removeClass('animate--animated ' + showAnimation);
																	});
													} else if ($popup.hasClass('majc-popup-in-view')) {
																	$popup.removeClass('majc-popup-in-view');
													} else {
																	$popup.addClass('majc-popup-in-view');
													}
									} else {
													$(this).next('.majc-cart-popup').toggleClass('active');
									}
					});

					$('body').find(".majc-cart-close").on('click', function () {
									var $popup = $(this).closest('.majc-main-inner-wrapper');
									$popup.find(".majc-cartbasket-toggle-btn").trigger('click');
					});

					$(document).on('click', '.add_to_cart_button', function () {
									var cart = $('body').find('.majc-toggle-open-btn');

									var imgtodrag = $(this).closest('.product').find("img").eq(0);

									if (imgtodrag.length && cart.length) {
													var imgclone = imgtodrag.clone()
																					.offset({
																									top: imgtodrag.offset().top,
																									left: imgtodrag.offset().left
																					})
																					.css({
																									'opacity': '0.8',
																									'position': 'absolute',
																									'height': '150px',
																									'width': '150px',
																									'z-index': '100'
																					})
																					.appendTo($('body'))
																					.animate({
																									'top': cart.offset().top + 10,
																									'left': cart.offset().left + 10,
																									'width': 75,
																									'height': 75
																					}, 1000);

													setTimeout(function () {
																	cart.effect("shake", {
																					times: 2,
																					distance: 150
																	}, 200);
													}, 1500);

													imgclone.animate({
																	'width': 0,
																	'height': 0
													}, function () {
																	$(this).detach()
													});
									}
					});
					// remove item from cart
					$(document).on('click', '.remove', function (e) {
									e.preventDefault();

									// $(this).closest('.majc-body').addClass('majc-loader');

									var cart_item_id = $(this).attr("data-cart_item_id"),
													cart_item_key = $(this).attr("data-cart_item_key");

									console.log(cart_item_id, cart_item_key);

									$.ajax({
													type: 'POST',
													dataType: 'json',
													url: ajaxUrl,
													data: {
																	action: "remove_item",
																	cart_item_id: cart_item_id,
																	cart_item_key: cart_item_key,
																	wp_nonce: wpNonce
													},
													success: function (response) {

																	if (!response || response.error) {
																					return;
																	}

																	var fragments = response.fragments;

																	// Replace fragments
																	if (fragments) {
																					// console.log(fragments);
																					$.each(fragments, function (key, value) {
																									$(key).replaceWith(value);
																					});
																	}

																	$('.majc-body').removeClass('majc-loader');
													},
													error: ( response ) => {
														console.log( response );
														this.isRequestProcessing = false;
													},
									});
					});

					// Apply Discount Coupons
					$('body').find('.majc-coupon-submit').on('click', function (e) {
									e.preventDefault();
									var $button = $(this);
									var couponCode = $button.prev(".majc-coupon-code").val();
									$button.addClass('majc-button-loading');
									$.ajax({
													url: ajaxUrl,
													type: 'POST',
													data: {
																	action: "add_coupon_code",
																	couponCode: couponCode,
																	wp_nonce: wpNonce
													},
													success: function (response) {
																	var $responseField = $button.closest('.majc-coupon').find('.majc-cpn-resp');
																	$responseField.html(response.msg);
																	if (response.result == 'not valid' || response.result == 'already applied') {
																					$responseField.css({'background-color': '#e2401c', 'color': '#fff'});
																	} else {
																					$responseField.css({'background-color': '#0f834d', 'color': '#fff'});
																	}
																	$responseField.fadeIn().delay(2000).fadeOut();
																	$(document.body).trigger('wc_fragment_refresh');
																	$button.removeClass('majc-button-loading');
													}
									});
					});

					// Remove Applied Discount Coupons
					$('body').on('click', '.majc-remove-cpn', function () {

									var couponCode = $(this).parent('li').attr('data-code'),
																	$removeBtn = $(this);

									$.ajax({
													url: ajaxUrl,
													type: 'POST',
													data: {
																	action: "remove_coupon_code",
																	couponCode: couponCode,
																	wp_nonce: wpNonce
													},
													success: function (response) {
																	var $responseField = $removeBtn.closest('.majc-coupon').find('.majc-cpn-resp');
																	$responseField.html(response);
																	$responseField.css({'background-color': '#0f834d', 'color': '#fff'});
																	$responseField.fadeIn().delay(2000).fadeOut();
																	$(document.body).trigger('wc_fragment_refresh');
													}
									});

					});

					/* Increment Cart Item Quantity */
					$("body").on("click", ".majc-qty-plus", function (e) {

									var input = $(this).closest('.majc-cart-items').find("input.majc-qty:not(:disabled)");

									if (input) {
													var pre = parseInt(input.val());
													input.val(pre + 1);
													input.trigger("change");
									}

					});

					/* Decrement Cart Item Quantity */
					$("body").on("click", ".majc-qty-minus", function (e) {

									var input = $(this).closest('.majc-cart-items').find("input.majc-qty:not(:disabled)");

									if (input) {
													var pre = parseInt(input.val()) - 1;

													// Do Nothing if Only 1 Item Left in Cart
													if (pre > 0) {
																	input.val(pre);
																	input.trigger("change");
													}
									}
					});

					console.log($("input.qty-input"));

					// Quantity change 
					$('body').on('change', 'input[name="qty-input"]', function () {
					console.log("hello");

									$(this).closest('.majc-body').addClass('majc-loader');

									var qty = $(this).val();
									var ckey = $(this).closest('.majc-cart-items').data('ckey');
									console.log(qty, ckey);

									$.ajax({
													url: ajaxUrl,
													type: 'POST',
													data: 'action=change_item_qty&ckey=' + ckey + '&qty=' + qty + '&wp_nonce=' + wpNonce,
													success: function (response) {
																	$(document.body).trigger('wc_fragment_refresh');
																	setTimeout(function () {
																					$('.majc-body').removeClass('majc-loader');
																	}, 1000);
													}
									});
					});
	});

})(jQuery);