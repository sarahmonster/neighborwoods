<?php

/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the wordpress construct of pages
 * and that other 'pages' on your wordpress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */


get_header(); ?>

<?php get_sidebar(); ?>


<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<?php if ( is_front_page() ) { ?>

				

					<div class="grid_4">

						<?php dynamic_sidebar( 'homepage-one' ); ?>

					</div>

					

					<div class="grid_3">

						<?php dynamic_sidebar( 'homepage-two' ); ?>

					</div>

				

				

				<?php } else { ?>					

				


				<article id="post-<?php the_ID(); ?>" <?php post_class('grid_7'); ?>>				

					<h1 class="entry-title"><?php the_title(); ?></h1>

					<div class="entry-content">

						<?php the_content(); ?>

						<?php wp_link_pages( array( 'before' => '' . __( 'Pages:', 'boilerplate' ), 'after' => '' ) ); ?>

						<?php // edit_post_link( __( 'Edit', 'boilerplate' ), '', '' ); ?>

					</div><!-- .entry-content -->

				</article><!-- #post-## -->				

				

				<?php } ?>


				<?php //comments_template( '', true ); ?>

<?php endwhile; ?>

<?php get_footer(); ?>
