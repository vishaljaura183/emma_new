<style>
html,body {
	height: 100%;
	margin: 0;
	padding: 0;
}
div#map_outer
{
	position: absolute;
	border: 2px solid #3a3a3a;
	height: 800px;
	width: 100%;
//	left:14.5299%;
	left:0;
	
}
div#map {
	width: 100%;
	height: 100%;
}

#sidebar-left {
	display: none;
}
</style>


<?php
include ('inc/common_func.php');
include ('header.php');
echo '<div id="map_outer"><div id="map"></div></div>';

$get_poll_venues 	= get_values_poll_venues($db);
$get_technicians 	= get_values_technicians($db);

//Poll venues
$lats_arr 			= array();
$longs_arr 			= array();

//Technicians
$lat_longs_arr 			= array();
$lat_longs_arr2 			= array();

foreach ($get_poll_venues as $key => $poll_venue) {
	$lat_longs_arr[$key]['lat'] 		= $poll_venue['latitude'];
	$lat_longs_arr[$key]['long'] 		= $poll_venue['longitude'];
	$lat_longs_arr[$key]['address'] 		= $poll_venue['address'];
}
foreach ($get_technicians as $key => $techs) {
	$lat_longs_arr2[$key]['lat'] 		= $techs['lat'];
	$lat_longs_arr2[$key]['long'] 		= $techs['long'];
	$lat_longs_arr2[$key]['tech_detail'] 		= $techs['first_name'].' '.$techs['last_name'].'[ '.$techs['email'].' ]';
}

$lat_longs_json 	= json_encode( $lat_longs_arr );
$lat_longs_json2 	= json_encode( $lat_longs_arr2 );
?>


<script>
var poll_venues;
var techs;
function initMap() {
	poll_venues =  <?php echo $lat_longs_json ?>;
	techs =  <?php echo $lat_longs_json2 ?>;
	
	  var map = new google.maps.Map(document.getElementById('map'), {
	    zoom: 11,
	    center: {lat: parseFloat(poll_venues[0].lat), lng: parseFloat(poll_venues[0].long)}

	  });

	
		// Adds markers to the map.

		// Marker sizes are expressed as a Size of X,Y where the origin of the image
		// (0,0) is located in the top left of the image.

		// Origins, anchor positions and coordinates of the marker increase in the X
		// direction to the right and in the Y direction down.
		var image = {
		    url: 'img/poll_venue.png',
		    // This marker is 20 pixels wide by 32 pixels high.
		    size: new google.maps.Size(32, 32),
		    // The origin for this image is (0, 0).
		    origin: new google.maps.Point(0, 0),
		    // The anchor for this image is the base of the flagpole at (0, 32).
		    anchor: new google.maps.Point(0, 32)
	  	};
		var image2 = {
		    url: 'img/tech_icon_new.png',
		    // This marker is 20 pixels wide by 32 pixels high.
		    size: new google.maps.Size(32, 37),
		    // The origin for this image is (0, 0).
		    origin: new google.maps.Point(0, 0),
		    // The anchor for this image is the base of the flagpole at (0, 32).
		    anchor: new google.maps.Point(0, 32)
	  	};

		// Shapes define the clickable region of the icon. The type defines an HTML
		  // <area> element 'poly' which traces out a polygon as a series of X,Y points.
		  // The final coordinate closes the poly by connecting to the first coordinate.
		  var shape = {
		    coords: [1, 1, 1, 20, 18, 20, 18, 1],
		    type: 'poly'
		  };
			
	  
			
		for( i in  poll_venues)
		{
			var marker = new google.maps.Marker({
			    position: {lat: parseFloat(poll_venues[i].lat), lng: parseFloat(poll_venues[i].long)},
			    map: map,
			    title: poll_venues[i].address,
		    	icon: image,
		        shape: shape			  				    
			  });
			
  
		}
		
		for( i in  techs)
		{
			  var marker = new google.maps.Marker({
			    position: {lat: parseFloat(techs[i].lat), lng: parseFloat(techs[i].long)},
			    map: map,
			    title: techs[i].tech_detail,
		    	icon: image2,
				//animation: google.maps.Animation.BOUNCE,
		        shape: shape			  				    
			  });
		}
	}

</script>
<script defer
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMSyfPFG4MtrtBHoN2UJsX9pAo3D2Z8pM&signed_in=true&callback=initMap"></script>
</body>
</html>