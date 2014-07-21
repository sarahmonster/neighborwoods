<?php
/**
* The template for a venue.  By default it displays venue information and lists 
* events that occur at the specified venue.
*
* You can customize this view by putting a replacement file of the same name (single-venue.php) in the events/ directory of your theme.
*/

// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

?>
<?php $venue_id = get_the_id(); ?>

<div class="grid_6">
		<?php echo tribe_get_embedded_map(get_the_ID(), '460px', '400px') ?>
		<span class="back"><a href="/events/map"><?php _e('&laquo; Back to Events', 'tribe-events-calendar-pro'); ?></a></span>	
		<?php if( get_post_meta( get_the_ID(), '_EventShowMapLink', true ) == 'true' ) : ?>
				<a class="gmap" itemprop="maps" href="<?php echo tribe_get_map_link() ?>" title="<?php _e('Click to view a Google Map', 'tribe-events-calendar-pro'); ?>" target="_blank"><?php _e('Google Map', 'tribe-events-calendar-pro' ); ?></a>
			<?php endif; ?>							

</div>

<div class="grid_6">

	<h1><?php the_title() ?></h1>
	
	<div id="tribe-events-event-meta">
		<?php if(tribe_get_phone()) : ?>
		<dt class="venue-label venue-label-phone"><?php _e('Phone', 'tribe-events-calendar-pro') ?></dt> 
			<dd itemprop="telephone" class="venue-meta venue-meta-phone"><?php echo tribe_get_phone(); ?></dd>
		<?php endif; ?>
		
		<?php if( tribe_address_exists( get_the_ID() ) ) : ?>
		<dt class="venue-label venue-label-address">
			<?php _e('Address', 'tribe-events-calendar-pro') ?><br />
			
		</dt>
			<dd class="venue-meta venue-meta-address">
			<?php echo tribe_get_full_address( get_the_ID() ); ?>
			</dd>
		<?php endif; ?>
		<?php if ( get_the_content() != ''): ?>
		<dt class="venue-label venue-label-description"><?php _e('Description', 'tribe-events-calendar-pro') ?></dt>
		<dd class="venue-meta venue-meta-description"><?php the_content() ?></dd>
		<?php endif ?>
	</dl>
	</div>

<div id="tribe-events-loop" class="tribe-events-events post-list clearfix upcoming venue-events">
	<?php 
	$venueEvents = tribe_get_events(array('venue'=>get_the_ID(), 'eventDisplay' => 'upcoming', 'posts_per_page' => -1)); 
	global $post; 
	$first = true;
	?>					
	<?php if( sizeof($venueEvents) > 0 ): ?>
		<h2>Upcoming Events At This Site</h2>					
		<?php foreach( $venueEvents as $post ): 
			setup_postdata($post);	?>
			<div id="post-<?php the_ID() ?>" <?php post_class($first ? 'tribe-events-event clearfix first': 'tribe-events-event clearfix' ); $first = false; ?> itemscope itemtype="http://schema.org/Event">
				<?php the_title('<h3 itemprop="name"><a href="' . tribe_get_event_link() . '" title="' . the_title_attribute('echo=0') . '" rel="bookmark" itemprop="url">', '</a></h3>'); ?>
				
						<h4>
						<?php if (tribe_is_multiday()): ?>
							<?php _e('Starts', 'tribe-events-calendar-pro') ?>
							<meta itemprop="startDate" content="<?php echo tribe_get_start_date( null, false, 'Y-m-d' ); ?>" /><?php echo tribe_get_start_date(); ?>
						
						<?php _e('Ends', 'tribe-events-calendar-pro') ?>
						<meta itemprop="endDate" content="<?php echo tribe_get_end_date( null, false, 'Y-m-d' ); ?>" /><?php echo tribe_get_end_date(); ?>
						<?php else: ?>
							<meta itemprop="startDate" content="<?php echo tribe_get_start_date( null, false, 'Y-m-d' ); ?>" /><?php echo tribe_get_start_date(); ?>
						<?php endif; ?>
						</h4>
						
						
					<?php has_excerpt() ? the_excerpt() : the_content() ?>

						
			</div> <!-- End post -->				
		<?php endforeach; ?>						
	<?php endif; ?>
	<?php // Reset the post and id to the venue post before comments template shows up.
	$post = get_post($venue_id); 
	global $id;
	$id = $venue_id;?>
</div>

</div>
