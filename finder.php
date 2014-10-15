<?php
require_once("connection.php");


//Por Geolocalización
if($_POST['geo']==1){
	$lng = $_POST['lng'];
	$lat = $_POST['lat'];
	
	$query = sprintf("SELECT locations.id AS id, locations.lat AS lat, locations.lng AS lng, stores.name AS name, stores.address AS address,
		(SELECT concat(cities.name, ', ' , states.name) FROM cities INNER JOIN states ON cities.state = states.id WHERE cities.id = stores.city) AS city,
		stores.telephone AS telephone, stores.email AS email, stores.schedule AS schedule, stores.notes AS notes,
		(acos(sin(radians(%s)) * sin(radians(lng)) + cos(radians(%s)) * cos(radians(lng)) * 
		cos(radians(%s) - radians(lat))) * 6378) AS distance FROM locations INNER JOIN stores WHERE locations.store = stores.id ORDER BY distance ASC;",
	    mysql_real_escape_string($lat), 
	    mysql_real_escape_string($lat),  
	    mysql_real_escape_string($lng));
	
	$result = mysql_query($query);
	$result_array = array(); 
	while ($row = mysql_fetch_assoc($result)) {  
	    array_push($result_array, array(
	        "id" => $row['id'],
	        "lng" => $row['lat'],
	        "lat" => $row['lng'],
	        "name" => $row['name'],
	        "address" => $row['address'],
	        "city" => $row['city'],
	        "telephone" => $row['telephone'],
	        "email" => $row['email'],
	        "schedule" => $row['schedule'],
	        "notes" => $row['notes'],
	        "distance" => $row['distance']
		));
	}
	
	echo json_encode($result_array);
}else{ //Por Geocodificación

	$lng = $_POST['lng'];
	$lat = $_POST['lat'];
	$city = $_POST['city'];
	
	$query = sprintf("SELECT locations.id AS id, locations.lat AS lat, locations.lng AS lng, stores.name AS name, stores.address AS address,
		(SELECT concat(cities.name, ', ' , states.name) FROM cities INNER JOIN states ON cities.state = states.id WHERE cities.id = stores.city) AS city,
		stores.telephone AS telephone, stores.email AS email, stores.schedule AS schedule, stores.notes AS notes,
		(acos(sin(radians(%s)) * sin(radians(lng)) + cos(radians(%s)) * cos(radians(lng)) * 
		cos(radians(%s) - radians(lat))) * 6378) AS distance FROM locations INNER JOIN stores WHERE locations.store = stores.id AND stores.city = %s ORDER BY distance ASC;",
	    mysql_real_escape_string($lat), 
	    mysql_real_escape_string($lat),  
	    mysql_real_escape_string($lng),
	    mysql_real_escape_string($city));
	
	$result = mysql_query($query);
	$result_array = array(); 
	while ($row = mysql_fetch_assoc($result)) {  
	    array_push($result_array, array(
	        "id" => $row['id'],
	        "lng" => $row['lat'],
	        "lat" => $row['lng'],
	        "name" => $row['name'],
	        "address" => $row['address'],
	        "city" => $row['city'],
	        "telephone" => $row['telephone'],
	        "email" => $row['email'],
	        "schedule" => $row['schedule'],
	        "notes" => $row['notes'],
	        "distance" => $row['distance']
		));
	}
	
	echo json_encode($result_array);
}

