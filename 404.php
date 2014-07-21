<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */

get_header(); ?>


<?php get_sidebar(); ?>

			<article id="post-0" class="grid_7">

				<h1 class="entry-title"><?php _e( 'Not Found', 'boilerplate' ); ?></h1>
				
				<div class="entry-content">
				<p><?php _e( 'The page you&rsquo;re looking for isn&rsquo;t here. Our site has recently been relaunched, so things may have moved. Try using the links above instead.', 'boilerplate' ); ?></p>
				<?php //get_search_form(); ?>
				<script>
					// focus on search field after it has loaded
					document.getElementById('s') && document.getElementById('s').focus();
				</script>
				</div>
			</article>
<?php get_footer(); ?>
