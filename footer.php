<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Boilerplate
 * @since Boilerplate 1.0
 */
?>
		</section><!-- #main -->
		<footer role="contentinfo">
		<div id="footer" class="grid_12">
<?php
	/* A sidebar in the footer? Yep. You can can customize
	 * your footer with four columns of widgets.
	 */
	get_sidebar( 'footer' );
?>
		</div>
		<div class="clearfix"></div>
		
		<div class="grid_12 copyright">&copy; <?php echo date(Y); ?> Alliance for Community Trees. Website by <a href="http://triggersandsparks.com">Triggers &amp; Sparks</a>.</div>
		</footer><!-- footer -->
<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */
	wp_footer();
?>
	</div> <!-- end #wrapper -->
	<script>
		jQuery(function() {
			if (jQuery('#tribe-community-events').length) {

				jQuery('#event_taxonomy').hide();
				jQuery('#event_image_uploader').hide();
				
				jQuery('#EventShowMapLink').attr('checked', 'checked');
				jQuery('#EventShowMap').attr('checked', 'checked');
				jQuery('#google_map_link_toggle,#google_map_toggle').hide();
				
				jQuery('#event_datepickers h4').text('Time & Date');				
				jQuery('#event_venue h4').text('Event Location');
				jQuery('#event_organizer h4').text('Organizer');
				jQuery('#event_custom h4').text('Shipping Address');
				jQuery('#event-meta tr').eq(6).before('<tr><td class="tribe_sectionheader" colspan="2" style="padding-top: 50px !important;"><h4>Additional information</h4></td></tr>');
			}
		});
	</script>
	</body>

</html>