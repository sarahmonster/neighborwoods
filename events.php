<?php

/**
 * The template for displaying single event pages. 
 *
Template Name: Custom events template
 */


get_header(); ?>


<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	

<?php if ($_SERVER['REQUEST_URI'] === '/events-list/community/add' OR $_SERVER['REQUEST_URI'] === '/events-list/community/add/'):  ?>
					<?php get_sidebar(); ?>
					
					<div class="grid_7">				

					
<?php else: ?>
	<div class="grid_12">

<?php endif; ?>




					<h1 class="entry-title"><?php the_title(); ?></h1>

					<div class="entry-content">

						<?php the_content(); ?>

					</div>
</div>	



						

										




<?php endwhile; ?>

<?php get_footer(); ?>
