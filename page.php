<?php

get_header();

?>

<div class="container">
	<div class="header-bottom">
		<section class="navigation">
			<div class="nav-container">

	
			</div>
		</section>
	</div>
</div>

<main>
	<div class="wrapper" id="page-wrapper">

		<div class="<?php ?>" id="content" tabindex="-1">

			<div class="row">

				<?php
				// Do the left sidebar check and open div#primary.
				get_template_part('global-templates/left-sidebar-check');
				?>

				<main class="site-main" id="main">

					<?php
					while (have_posts()) {
						the_post();
						get_template_part('template-parts/content', 'page');
					}
					?>

				</main>

				<?php
				// Do the right sidebar check and close div#primary.
				get_template_part('global-templates/right-sidebar-check');
				?>

			</div><!-- .row -->

		</div><!-- #content -->

	</div><!-- #page-wrapper -->
</main>

<?php
get_footer();
