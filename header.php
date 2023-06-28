<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<title><?php bloginfo('name'); ?><?php wp_title('|'); ?></title>
	<meta name="description" content="<?php bloginfo('description'); ?>">
	<link rel="shortcut icon" href="http://localhost/iplc/wp-content/themes/iplc/assets/img/logo-favicon.png" type="image/png">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php do_action('wp_body_open'); ?>

	<div class="site" id="page">
		<nav>
			<div class="container logo-menu-container">
				<a href="/" class="logo">
					<img src="<?php echo get_template_directory_uri() . '/assets/img/logo.png'; ?>" alt="" srcset="">
				</a>

				<div class="row align-items-center justify-content-end">
					<div class="col-3 d-flex justify-content-end align-items-center ">
						<div class="menu-container">
							<div class="menu">
								<span></span>
								<span></span>
								<span></span>
							</div>
						</div>
					</div>
					<div class="col-9 nav-container">
						<div class="top-section">
							<div class="search-container">
								<form action="" method="post">
									<input type="text" name="search" placeholder="what are you looking for...">
								</form>
								<span><i class="fas fa-search"></i></span>
								<span>search</span>
							</div>
							<ul class="social-media">
								<li><span><i class="fab fa-facebook-f"></i></span></li>
								<li><span><i class="fab fa-twitter"></i></span></li>
								<li><span><i class=" fab fa-instagram"></i></span></li>
							</ul>
							<a href="/login" class="account" style="display: inline-block;">
								<img src="<?php echo get_template_directory_uri() . '/assets/img/account.png'; ?>" alt="" srcset="" width="24px">
							</a>
							<div class="cartBtn-div">
								<img src="<?php echo get_template_directory_uri() . '/assets/img/cart.png'; ?>" alt="" srcset="" class="cartBtn">
								<span class="cart-items-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
							</div>
						</div>
						<div class="links-contianer">
							<ul class="links">
								<li><a href="/" class="active-link">Home</a></li>
								<li><a href="/order">Order Online</a></li>
								<li><a href="about.html">About us</a></li>
							</ul>
						</div>
						<div class="cart">
							<div class="d-flex justify-content-between py-2">
								<span class="clearbtn">CLEAR CART</span>
								<img src="<?php echo get_template_directory_uri() . '/assets/img/cancel.png'; ?>" alt="" srcset="" width="20px" height="20px" id="close-cart">
							</div>
							<!-- <p class="py-2">Your cart is empty</p> -->
							<div class="cart-content">
								<div class="cart-item">
									<div class="row no-gutters">
										<div class="col-3">
											<div class="img-holder">
												<img src="http://pizza.local/wp-content/uploads/2023/06/BELLY_BUSTER_67-100x100.png" alt="" width="80px">
											</div>
										</div>
										<div class="col-7">
											<div class="cart-item-details">
												<div class="title">Regular hand tossed 5 cheese pizza</div>
												<span class="options"><i class="fas fa-caret-down"></i> Show options:</span>
												<div class="options-content">
													<span class="option">Mozzarella cheese, Fet cheese, Grated Parmesan, Cheddar cheese</span>
												</div>
											</div>
										</div>
										<div class="col-2">
											<p class="item-price">₱450.00</p>
										</div>
									</div>
									<div class="cart-btns d-flex align-items-center">
										<div class="quantity">
											<label for="quantity">Quantity: </label>
											<input type="number" name="quantity" id="quantity" value="1">
										</div>
										<span>Edit</span>
										<span>Remove</span>
									</div>
								</div>
							</div>
							<div class="total-calculation">
								<div class="d-flex justify-content-between py-2">
									<span>Delivery Charge</span>
									<span>₱49.00</span>
								</div>
								<div class="d-flex justify-content-between py-2">
									<span>Order Total</span>
									<span>₱456.00</span>
								</div>
							</div>
							<a href="#">CHECKOUT</a>
						</div>


					</div>
				</div>
			</div>
		</nav>