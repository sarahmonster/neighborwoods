<?php

// Don't load directly
if ( !defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * My Events page
 * You can customize this view by putting a replacement file of the same name (delete.php) in the events/community/ directory of your theme.
 *
 * @package TribeCommunityEvents
 * @since  1.0
 * @author Modern Tribe Inc.
 */
?>
<script type="text/javascript">
/* This script is borrowed from http://filamentgroup.com/lab/responsive_design_approach_for_complex_multicolumn_data_tables/ and edited by Paul Hughes. */
jQuery(document).ready(function() {
	jQuery('.my-events').addClass("enhanced");
	var container = jQuery('.table-menu'); 
	jQuery( "thead th" ).each(function(i){
	
		var th = jQuery(this),
      	id = th.attr("id"), 
      	classes = th.attr("class");  // essential, optional (or other content identifiers)
         
   		// assign an ID to each header, if none is in the markup
   		if (!id) {
      		id = ( "col-" ) + i;
      		th.attr("id", id);
   		};      
         
   		// loop through each row to assign a "headers" attribute and any classes (essential, optional) to the matching cell
   		// the "headers" attribute value = the header's ID
   		jQuery( "tbody tr" ).each(function(){
      		var cell = jQuery(this).find("th, td").eq(i);                        
      		cell.attr("headers", id);
      		if (classes) { cell.addClass(classes); };
  	 	});
   
     	// create the menu hide/show toggles
   		if ( !th.is(".persist") ) {
   
      		// note that each input's value matches the header's ID; 
      		// later we'll use this value to control the visibility of that header and it's associated cells
      		var toggle = jQuery('<li><input type="checkbox" name="toggle-cols" id="toggle-col-'+i+'" value="'+id+'" /> <label for="toggle-col-'+i+'">'+th.text()+'</label></li>');
      
      		// append each toggle to the container
      		container.find("ul").append(toggle); 
	
			toggle.find("input").change(function(){
            	var input = jQuery(this), 
            	val = input.val(),  // this equals the header's ID, i.e. "company"
            	cols = jQuery("#" + val + ", [headers="+ val +"]"); // so we can easily find the matching header (id="company") and cells (headers="company")
         
            	if (input.is(":checked")) { cols.show(); }
            	else { cols.hide(); };		
         	})
         
         	// custom event that sets the checked state for each toggle based on column visibility, which is controlled by @media rules in the CSS
         	// called whenever the window is resized or reoriented (mobile)
         	.bind("updateCheck", function(){
            	if ( th.css("display") ==  "table-cell") {
               		jQuery(this).attr("checked", true);
            	}
            	else {
               		jQuery(this).attr("checked", false);
            	};
         	})
         
         	// call the custom event on load
         	.trigger("updateCheck");
   	 	};
	});
	// update the inputs' checked status
	jQuery(window).bind("orientationchange resize", function(){
   		container.find("input").trigger("updateCheck");
	});
	
	var menuWrapper = jQuery('<div class="table-menu-wrapper" />'),
   	menuBtn = jQuery('.table-menu-btn');
      
	menuBtn.click(function(){
   		container.toggleClass("table-menu-hidden");            
   		return false;
	});

	// assign click-away-to-close event
	jQuery(document).click(function(e){								
   		if ( !jQuery(e.target).is( container ) ) {
   			if ( !jQuery(e.target).is( container.find("*") ) ) {			
      			container.addClass("table-menu-hidden");
      		}
   		}				
	}); 	
});
</script>

<?php
	echo '<div id="add-new"><a href="' .$this->getUrl( 'add' ) . '" class="button">' .__( 'Add New','tribe-events-community' ) . '</a></div>';
	?>
	
	<?php
	
	echo '<div id="not-user">' .__( 'Not','tribe-events-community' ) . ' <i>' .$current_user->display_name. '</i> ? <a href="' .wp_logout_url( get_permalink() ) . '">' .__( 'Log Out','tribe-events-community' ) . '</a></div>';
	echo '<div style="clear:both"></div>';

	$this->outputMessage();

	$tbody = '';
	echo $this->pagination( $events, '', $this->paginationRange );
	$this->outputMessage( 'error' );
?>
		
		<div class="my-events-table-wrapper">

		<table>
		<thead><tr>
		<th>Status</th>
		<th>Event</th>
		<th>Date</th>
		<th>Admin</th>
		</tr></thead>
		
		<?php

		$rewriteSlugSingular = TribeEvents::getOption( 'singleEventSlug', 'event' );

		global $post;

		$old_post = $post;

		while ( $events->have_posts() ) {
			$e = $events->next_post();

			$post = $e;


				echo "<tr><td>";
				echo $this->getEventStatusIcon( $e->post_status );



			$canEdit = $this->userCanEdit( $e->ID, TribeEvents::POSTTYPE );

			if ( $canEdit ) {
				echo '</td><td><a href="' . $this->getUrl( 'edit',$e->ID ) . '">' . $e->post_title . '</a></td><td>';
			} else {
				echo $e->post_title;
			}
			
			$start_date = strtotime( $e->EventStartDate );
			echo tribe_event_format_date( $start_date, false, $this->eventListDateFormat );

			echo '<td> ( <a href="' . tribe_get_event_link( $e ) . '">' . __( 'View','tribe-events-community' ) . '</a> ';

			if ( $canEdit ) {
				echo $this->getEditButton( $e, 'Edit', '| ', ' ' );
				echo $this->getDeleteButton( $e );
			}
			
			echo " ) </td></tr>";








		}

		$post = $old_post;

		?>


	<?php echo $tbody;?>
		</table>
</div>
<?php
echo $this->pagination( $events, '', $this->paginationRange );