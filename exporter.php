<?php
/*
Template Name: CSV Exporter
*/

global $post;
$all_events = tribe_get_events(array(
'eventDisplay'=>'all',
'posts_per_page'=>-1
));


echo '<p>All done! <a href="/locations/export.csv">Here&rsquo;s your exported CSV!</a>';
echo '</ul>';

// set up array
$events = array();
$events[0] = array('Event title','Date posted','Organization','Contact Name','Venue Name','Address','City','State','Zip','Country','Phone','Email','Website','Event Date','Time Start','Time End','Shipping Contact Name', 'Shipping Address', 'Shipping City', 'Shipping State', 'Shipping Zip', '# of Volunteers','# of Trees to be Planted','# of Trees to be Cared For','# of Square Feet of Invasives to be Removed','Project Description','Event link');

$count = 1;

foreach($all_events as $post) {
	setup_postdata($post);
	
	echo "<li>"; 
	echo get_the_title();
	//echo "</h2>";
	$events[$count][] = get_the_title();
	
	

	//echo "<em>Posted: ";
	//echo get_the_time('l, F jS, Y') .'</em>';
	$events[$count][] = get_the_time('F j, Y');

	//echo "<br>Organization: ";
	//echo tribe_get_organizer();
	$events[$count][] = tribe_get_organizer();

	//echo "<br>Event Submitter: ";
	//echo tribe_get_custom_field("Event Submitter");
	$events[$count][] = tribe_get_custom_field("Event Submitter");


	//echo "<br>Venue Name: ";
	//echo tribe_get_venue();
	$events[$count][] = tribe_get_venue();

	
	//echo "<br>Address: ";
	//echo tribe_get_address();	
	$events[$count][] = tribe_get_address();
	//tribe_get_full_address()

	
	//echo "<br>City: ";
	//echo tribe_get_city();
	$events[$count][] = tribe_get_city();

	//echo "<br>State: ";
	//echo tribe_get_region();
	$events[$count][] = tribe_get_region();
	
	//echo "<br>Zip: ";
	//echo tribe_get_zip();
	$events[$count][] = tribe_get_zip();
	
	//echo "<br>Country: ";
	//echo tribe_get_country();
	$events[$count][] = tribe_get_country();
	
	//echo "<br>Phone: ";
	//echo tribe_get_organizer_phone();
	$events[$count][] = tribe_get_organizer_phone();
	
	//echo "<br>Email: ";
	//echo tribe_get_organizer_email();
	$events[$count][] = tribe_get_organizer_email();

	//echo "<br>Website: ";
	//echo tribe_get_organizer_link($post->ID, false, false);
	$events[$count][] = tribe_get_organizer_link($post->ID, false, false);

//	$events[$count][] = tribe_get_organizer_link($post->ID, false);
	
	echo " (Event Date: ";
	echo tribe_get_start_date( $post->ID, true, 'D. M j' ) . ')';
	$events[$count][] = tribe_get_start_date( $post->ID, true, 'D. M j' );
		
	//echo "<br>Time Start: ";
	//echo tribe_get_start_date( $post->ID, true, '' );
	$events[$count][] = tribe_get_start_date( $post->ID, true, '' );
	
	//echo "<br>Time End: ";
	//echo tribe_get_end_date( $post->ID, true, '' );
	$events[$count][] = tribe_get_end_date( $post->ID, true, '' );
	
	//echo "<br><strong>Shipping Address: ";
	//print_r (tribe_the_custom_fields());
	$shipping_address = tribe_get_custom_field('Shipping Contact Name') . "\r\n";
	$shipping_address .= tribe_get_custom_field('Shipping Address (cannot be P.O. Box)') . "\r\n";
	$shipping_address .=  tribe_get_custom_field('Shipping City'). ", ";
	$shipping_address .=  tribe_get_custom_field('Shipping State') ." ";
	$shipping_address .=  tribe_get_custom_field('Shipping Zip');
	//echo $shipping_address;
	//echo "</strong>";
	$events[$count][] = tribe_get_custom_field('Shipping Contact Name') . "\r\n";
	$events[$count][] = tribe_get_custom_field('Shipping Address (cannot be P.O. Box)') . "\r\n";
	$events[$count][] =  tribe_get_custom_field('Shipping City'). ", ";
	$events[$count][] =  tribe_get_custom_field('Shipping State') ." ";
	$events[$count][] =  tribe_get_custom_field('Shipping Zip');
	//$events[$count][] = $shipping_address;
	
	//echo "<br>Number of Volunteers: ";
	//echo tribe_get_custom_field('Number of Volunteers');
	$events[$count][] = tribe_get_custom_field('Number of Volunteers');
	
	//echo "<br>Number of Trees to be Planted: ";
	//echo tribe_get_custom_field('Number of Trees to be Planted');
	$events[$count][] = tribe_get_custom_field('Number of Trees to be Planted');
	
	//echo "<br>Number of Trees to be Cared For: ";
	//echo tribe_get_custom_field('Number of Trees to be Cared For');
	$events[$count][] = tribe_get_custom_field('Number of Trees to be Cared For');

	//echo "<br>Number of Square Feet of Invasives to be Removed: ";
	//echo tribe_get_custom_field('Number of Square Feet of Invasives to be Removed');
	$events[$count][] = tribe_get_custom_field('Number of Square Feet of Invasives to be Removed');	

	
	//echo "<br>Project Description: ";
	//echo get_the_content();
	$events[$count][] = get_the_content();
	
	//echo "<br>Event link: ";
	//echo get_permalink();
	$events[$count][] = get_permalink();


	// oh, and we may as well remove all the stupid html entities now...	
	 $events[$count]= array_map('html_entity_decode',$events[$count]);  
	 $events[$count]= array_map('striphtml',$events[$count]);  


$count++;
} //endforeach 

//print_r($events);

function striphtml($string)
{
   $string = str_replace(array("&lt;", "&gt;", '&amp;', '&#039;', '&quot;','&lt;', '&gt;'), array("<", ">",'&','\'','"','<','>'), htmlspecialchars_decode($string, ENT_QUOTES));

       return $string;
  
} 


// write a csv file with data
$filename = 'locations/'.date("D-M-j-G:i-Y").'.csv';
$filename = "/export.csv";
//$fp = fopen('/exported.csv', 'w');
$fp = fopen($_SERVER['DOCUMENT_ROOT'].'/locations/export.csv','w');

foreach ($events as $fields) {
    fputcsv($fp, $fields);
}

fclose($fp);

wp_reset_query(); ?>
