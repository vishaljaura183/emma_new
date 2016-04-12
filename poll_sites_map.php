<?php
include ('header.php');
include ('inc/common_func.php');
echo '<div id="map_outer"><div id="map"></div></div>';

$get_poll_venues 	= get_values_poll_venues($db);
$get_technicians 	= get_values_technicians($db);

//Poll venues
$lats_arr 			= array();
$longs_arr 			= array();

//Technicians
$lat_longs_arr 			= array();
$lat_longs_arr2 		= array();

foreach ($get_poll_venues as $key => $poll_venue) {
	$lat_longs_arr[$key]['lat'] 					= $poll_venue['latitude'];
	$lat_longs_arr[$key]['long'] 					= $poll_venue['longitude'];
	$lat_longs_arr[$key]['address'] 				= $poll_venue['address'];
	$lat_longs_arr[$key]['location_nm'] 			= $poll_venue['location_poll'];
	$lat_longs_arr[$key]['voting_district'] 		= $poll_venue['voting_district'];
}
foreach ($get_technicians as $key => $techs) {
	$lat_longs_arr2[$key]['lat'] 		= $techs['lat'];
	$lat_longs_arr2[$key]['long'] 		= $techs['long'];
	$lat_longs_arr2[$key]['tech_detail'] 		= $techs['first_name'].' '.$techs['last_name'].'[ OPEN TICKETS: '.$techs['num_open_tkt'].']';
}

$lat_longs_json 	= json_encode( $lat_longs_arr );
$lat_longs_json2 	= json_encode( $lat_longs_arr2 );
?>


<script type = 'text/javascript'>
var map;
var poll_venues;
var techs;
var markers = [];

    window.onload = function() {
    	poll_venues =  <?php echo $lat_longs_json ?>;
    	techs =  <?php echo $lat_longs_json2 ?>;
    	map = new google.maps.Map(document.getElementById('map'), {
    	    zoom: 11,
    	    center: {lat: parseFloat(poll_venues[0].lat), lng: parseFloat(poll_venues[0].long)},
			zoomControlOptions : true
			


    	  });

    	$.getJSON("<?php echo LIVE_SITE; ?>/ajax_call_functions.php?action=get_poll_venues_n_techs").done(function(data) {
	  	     json = data;
	    	   loadMarkers(json);
	  	  });
    	  
    }

	//This is the function to set all defferent types of markers on map. it will not load map.
    function loadMarkers( poll_venues_n_techs_json )
    {
		if( markers.length > 0 )
		{	
	    	while (markers.length > 0) {
	            markers.pop().setMap(null);
	        }
	        markers.length = 0;
		}
		
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
		    anchor: new google.maps.Point(32, 32)
	  	};

	  	//TECH YELLOW
		var image3 = {
		    url: 'img/tech_icon_yellow.png',
		    // This marker is 20 pixels wide by 32 pixels high.
		    size: new google.maps.Size(32, 37),
		    // The origin for this image is (0, 0).
		    origin: new google.maps.Point(0, 0),
		    // The anchor for this image is the base of the flagpole at (0, 32).
		    anchor: new google.maps.Point(32, 37)
	  	};
	  	
	  	//ROVER  Orange // ROVER IMAGE
		var image5 = {
		    url: 'img/tech_icon_yellow.png',
		  //  url: 'img/tech_icon_green24.png',
		    // This marker is 20 pixels wide by 32 pixels high.
		    size: new google.maps.Size(32, 40),
		    // The origin for this image is (0, 0).
		    origin: new google.maps.Point(0, 0)
		    // The anchor for this image is the base of the flagpole at (0, 32).
		   // anchor: new google.maps.Point(32, 37)
	  	};

		var image4 = {
		    url: 'img/new_green2.png',
		  //  url: 'img/tech_icon_green24.png',
		    // This marker is 20 pixels wide by 32 pixels high.
		    size: new google.maps.Size(32, 40),
		    // The origin for this image is (0, 0).
		    origin: new google.maps.Point(0, 0)
		    // The anchor for this image is the base of the flagpole at (0, 32).
		   // anchor: new google.maps.Point(32, 37)
	  	};
		
	  	//TECH RED // Red would indicate that the technician is on assignment 
		var image2 = {
		   // url: 'img/tech_icon.png',
		    url: 'img/red_new.png',
		  //  url: 'img/tech_icon_red.png',
		    // This marker is 20 pixels wide by 32 pixels high.
		    size: new google.maps.Size(32, 40),
		    // The origin for this image is (0, 0).
		    origin: new google.maps.Point(0,0),
		    // The anchor for this image is the base of the flagpole at (0, 32).
		    anchor: new google.maps.Point(32, 40)
	  	};

		// Shapes define the clickable region of the icon. The type defines an HTML
		  // <area> element 'poly' which traces out a polygon as a series of X,Y points.
		  // The final coordinate closes the poly by connecting to the first coordinate.
		  var shape = {
		    coords: [1, 1, 1, 20, 18, 20, 18, 1],
		    type: 'poly'
		  };

		
    	for( i in  poll_venues_n_techs_json.poll_venues)
    	{
    		var title_map = poll_venues_n_techs_json.poll_venues[i].voting_district+' ['+poll_venues_n_techs_json.poll_venues[i].location_nm+' '+poll_venues_n_techs_json.poll_venues[i].address+']';
    			var marker = new google.maps.Marker({
    			    position: {lat: parseFloat(poll_venues_n_techs_json.poll_venues[i].lat), lng: parseFloat(poll_venues_n_techs_json.poll_venues[i].long)},
    			    map: map,
    			    title: title_map,
    		    	icon: image,
    		        shape: shape			  				    
    			  });
   			 markers.push(marker);
  			  
    		}
    		
    		for( i in  poll_venues_n_techs_json.techs)
    		{
        		switch ( poll_venues_n_techs_json.techs[i].is_available )
        		{
        			case 0:
					if(poll_venues_n_techs_json.techs[i].role == 'rover'){
					 var marker = new google.maps.Marker({
 	    			    position: {lat: parseFloat(poll_venues_n_techs_json.techs[i].lat), lng: parseFloat(poll_venues_n_techs_json.techs[i].long)},
 	    			    map: map,
 	    			    title: poll_venues_n_techs_json.techs[i].rover_detail,
 	    		    	icon: image5,
 	    				//animation: google.maps.Animation.BOUNCE,
 	    		        shape: shape			  				    
 	    			  });
					}
					else{
       				 var marker = new google.maps.Marker({
 	    			    position: {lat: parseFloat(poll_venues_n_techs_json.techs[i].lat), lng: parseFloat(poll_venues_n_techs_json.techs[i].long)},
 	    			    map: map,
 	    			    title: poll_venues_n_techs_json.techs[i].tech_detail,
 	    		    	icon: image4,
 	    				//animation: google.maps.Animation.BOUNCE,
 	    		        shape: shape			  				    
 	    			  });
					}
            			break;
            			
        			case 1:
       				 var marker = new google.maps.Marker({
 	    			    position: {lat: parseFloat(poll_venues_n_techs_json.techs[i].lat), lng: parseFloat(poll_venues_n_techs_json.techs[i].long)},
 	    			    map: map,
 	    			    title: poll_venues_n_techs_json.techs[i].tech_detail,
 	    		    	icon: image2,
 	    				//animation: google.maps.Animation.BOUNCE,
 	    		        shape: shape			  				    
 	    			  });
            			break;
            			
        			case 2:
       				 var marker = new google.maps.Marker({
 	    			    position: {lat: parseFloat(poll_venues_n_techs_json.techs[i].lat), lng: parseFloat(poll_venues_n_techs_json.techs[i].long)},
 	    			    map: map,
 	    			    title: poll_venues_n_techs_json.techs[i].tech_detail,
 	    		    	icon: image4,
 	    				//animation: google.maps.Animation.BOUNCE,
 	    		        shape: shape			  				    
 	    			  });
            			break;
            			
            		default:
                		break;
        		}
    			 
    			  markers.push(marker);
    			  
    		}

    		for (var i = 0; i < markers.length; i++) {
    		    markers[i].setMap(map);
    		  }
    }

    
    setInterval(function() {
  	  $.getJSON("<?php echo LIVE_SITE; ?>/ajax_call_functions.php?action=get_poll_venues_n_techs").done(function(data) {
  	     json = data;
    	   loadMarkers(json);
  	  });
  	}, 10000);
    
</script>
<script defer
	src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAMSyfPFG4MtrtBHoN2UJsX9pAo3D2Z8pM&signed_in=true"></script>
</body>
</html>

<style>
html,body {
	height: 100%;
	margin: 0;
	padding: 0;
}
div#map_outer
{
/*	position: absolute;*/
	border: 2px solid #3a3a3a;
	height: 800px;
	width: 100%;
//	left:14.5299%;
	left:0;
	
}
div#map {
	width: 100%;
	height: 78%;
}

#sidebar-left {
	display: none;
}
</style>