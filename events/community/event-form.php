<?php

// Don't load directly
if ( !defined( 'ABSPATH' ) ) {
	die('-1');
}


/**
 * The Submit and Edit event form
 * You can customize this view by putting a replacement file of the same name (event-form.php) in the events/community/ directory of your theme.
 *
 * @package TribeCommunityEvents
 * @since  1.0
 * @author Modern Tribe Inc.
 */
?>
<script type="text/javascript">
jQuery(document).ready(function() {
	jQuery('#show_hidden_categories').click(function() {
		//jQuery('#event-categories').css('overflow-y', 'scroll');
		jQuery('.hidden_category').show('medium');
		jQuery('#show_hidden_categories').hide();
		return false;

	}); 
});

</script>


<p>Be a part of National NeighborWoods&reg; Month 2013! Just fill out the quick form below with information about your October event, and it’ll automatically be added to the national campaign! <strong>NOTE:</strong> Please fill in all fields below. Incomplete submissions with blank fields will not be accepted.</p>

<form method="post" action="" enctype="multipart/form-data">
	<?php $this->outputMessage(); ?>
	<?php wp_nonce_field( 'ecp_event_submission' ); ?>
	<div class="events-community-post-title">
		<label for='post_title' <?php if ( $_POST && empty( $event->post_title ) ) echo 'class="error"'; ?>><?php _e( 'Title', 'tribe-events-community' ); ?></label> 
		<?php $this->formTitle( $event ) ?>
	</div>
	
	<div class="events-community-post-content">
		<label for='post_content' <?php if ( $_POST && empty( $event->post_content)  ) echo 'class="error"'; ?>><?php _e( 'Description', 'tribe-events-community' ); ?></label> 
		<?php $this->formContentEditor( $event ); ?>
	</div>





	<?php
	$this->formEventDetails( $event );
	$this->formSpamControl();
	?>

	<div class="events-community-footer wp-admin events-cal">
	<input type='submit' id="post" class="button submit events-community-submit" value="<?php
	if ( isset( $tribe_event_id ) && $tribe_event_id ) {
		_e( 'Update Event', 'tribe-events-community' );
	} else {
	 _e( 'Submit Event', 'tribe-events-community' );
	}
	?>" name='community-event' />
	</div>

</form>