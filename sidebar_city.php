<?php
function pre_dump($arg,$die=null){
	echo "<pre>";
	var_dump($arg);
	echo "</pre>";
	if($die) die;
}

$hostname = 'localhost';
$username = 'user';
$password = 'pass';
$dbname   = 'store_locator';
 
mysql_connect($hostname, $username, $password)
    or die_with_error(mysql_error());
mysql_select_db($dbname) or die_with_error(mysql_error());
mysql_set_charset('utf8');

$lng  = $_POST['lng'];
$lat  = $_POST['lat'];
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

foreach($result_array as $marker){
	?>
	<div class="store" 
		data-lat="<?= $marker['lat'];?>" 
		data-lng="<?= $marker['lng'];?>" 
		data-name="<?= $marker['name']; ?>" 
		data-address="<?= $marker['address']; ?>"
		data-city="<?= $marker['city']; ?>"
		data-telephone="<?= $marker['telephone']; ?>"
		data-email="<?= $marker['email']; ?>"
		data-schedule="<?= $marker['schedule']; ?>"
		data-notes="<?= $marker['notes']; ?>"
	>
		<span class='letra2'><?= $marker['name']; ?></span>
		<span class='letra'><?= $marker['address']; ?></span>
		<span class='letra'><?= $marker['city']; ?>.</span>
		<span class='letra'><b>Tel:&nbsp;</b><?= $marker['telephone']; ?></span>
		<span class='letra'><b>Email:&nbsp;</b><?= $marker['email']; ?></span>
		<span class='letra'><b>Horario:&nbsp;</b><?= $marker['schedule']; ?></span>
		<span class='letra'><?= $marker['notes']; ?></span>
		<span class='letra'><b>Disctancia:</b> <?=  round($marker['distance'], 2); ?>Km</span>
	</div>
	<?php
}

