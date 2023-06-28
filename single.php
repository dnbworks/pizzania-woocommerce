<?php


get_header();
?>

<div class="wrapper" id="single-wrapper">
	<div class="container" id="content" tabindex="-1">

		<div class="row">

			<main class="site-main" id="main">

				<?php
				while (have_posts()) {
					the_post();
					get_template_part('loop-templates/content', 'single');
				}
				?>

			</main>

			<?php
			// Do the right sidebar check and close div#primary.
			get_template_part('global-templates/right-sidebar-check');
			?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #single-wrapper -->

<?php
get_footer();
