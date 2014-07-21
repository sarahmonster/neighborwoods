<?php
/*
Template Name: Find an event
*/

get_header(); ?>				

<div class="grid_12">
	<h1 class="entry-title"><?php the_title(); ?></h1>
</div>


<?
global $post;
$all_events = tribe_get_events(array(
'eventDisplay'=>'all',
'posts_per_page'=>-1
));

// set up array
$events = array();

$count = 1;

foreach($all_events as $post) {
	setup_postdata($post);
	$events[$count]['title'] = get_the_title();
	$events[$count]['organization'] = tribe_get_organizer();
	$events[$count]['venue'] = tribe_get_venue();
	$events[$count]['full_address'] = tribe_get_full_address();
	$events[$count]['address'] = tribe_get_address();
	$events[$count]['city'] = tribe_get_city();
	$events[$count]['state'] = tribe_get_region();
	$events[$count]['zip'] = tribe_get_zip();
	$events[$count]['country'] = tribe_get_country();

	// echo tribe_get_venue_id();
	$venue_id = tribe_get_venue_id();
	
	$results = mysql_query("SELECT * FROM `locations` WHERE `post_id` = $venue_id");
	while ($row = mysql_fetch_array($results, MYSQL_ASSOC)) {
		$events[$count]['lat'] = $row['lat'];
		$events[$count]['lng'] = $row['lng'];
	}
	$events[$count]['website'] = tribe_get_organizer_link($post->ID, false, false);
	$events[$count]['date'] = tribe_get_start_date( $post->ID, true, 'D. M j' );
	$events[$count]['description'] = get_the_content();
	$events[$count]['link'] = get_permalink();


	// oh, and we may as well remove all the stupid html entities now...	
	$events[$count]= array_map('html_entity_decode',$events[$count]);  
	$events[$count]= array_map('striphtml',$events[$count]);  

	$count++;
} //endforeach 

function striphtml($string)
{
   $string = str_replace(array("&lt;", "&gt;", '&amp;', '&#039;', '&quot;','&lt;', '&gt;'), array("<", ">",'&','\'','"','<','>'), htmlspecialchars_decode($string, ENT_QUOTES));

   return $string;
}					
?>		

<script charset="utf-8" src="//maps.googleapis.com/maps/api/js?sensor=false&amp;libraries=places"></script>
<script src="/locations/store.js"></script>
<script>
	var JSON_EVENTS = <?php echo json_encode($events) ?>;
	var events = [];

	google.maps.event.addDomListener(window, 'load', function() {
		var map = new google.maps.Map(document.getElementById('map-canvas'), {
			center: new google.maps.LatLng(39.436193,-95.009766),
			geolocation: false,
			zoom: 4,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});

		var panelDiv = document.getElementById('panel');

		for (var i in JSON_EVENTS) {
			if (JSON_EVENTS[i].lat && JSON_EVENTS[i].lng) {
				events.push(new storeLocator.Store('event_' + i, (new google.maps.LatLng(JSON_EVENTS[i].lat, JSON_EVENTS[i].lng)), null, {
					title: '<h4>' + JSON_EVENTS[i].title + '</h4> <div class="date">' + JSON_EVENTS[i].date + '</div>',
					address: '<span class="venue">' + JSON_EVENTS[i].venue + '<br></span> <span class="streetAddress">' + JSON_EVENTS[i].address + '<br></span> <span class="city">' + JSON_EVENTS[i].city + '</span>, <span class="state">' + JSON_EVENTS[i].state + '</span> <span class="zip">' + JSON_EVENTS[i].zip + '</span>',
					web: '<a href="' + JSON_EVENTS[i].link + '">View details</a>'
				}));
			}
		}

		var dataFeed = new storeLocator.StaticDataFeed();
		dataFeed.setStores(events);
		var view = new storeLocator.View(map, dataFeed);

		new storeLocator.Panel(panelDiv, {
			view: view
		});
	});
</script>

<div id="panel" class="grid_3"></div>
<div id="map-canvas" class="grid_9" style="height: 600px"></div>
			

<?php get_footer(); ?>