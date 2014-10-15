<?php
require_once("connection.php");


// Define ajax request vars - $_GET
$lng = -103.343803;
$lat = 20.67359;

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

$query2 = "SELECT cities.id, concat(cities.name, ', ' , states.name) AS city FROM cities INNER JOIN states ON cities.state = states.id ORDER BY cities.state;";
$result2 = mysql_query($query2);
$category_array = array(); 
while ($cat = mysql_fetch_assoc($result2)) {  
    array_push($category_array, array(
        "id" => $cat['id'],
        "city" => $cat['city']
	));
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Store Locator</title>
	<meta name="description" content="McDonalds Store Locator using PHP, MySQL and Google Maps" />
	<meta name="keywords" content="javascript, web, ajax, jquery, store locator, google maps" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
	<script type="text/javascript" src="gmaps.js"></script>
	<link href="style.css" rel="stylesheet" type="text/css" />
	<link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>
</head>
<body>
<div id="main">
	<div id="banner">
		<h1>Localizador de Tiendas</h1>
		<p>Buscar por Geolocalizaci&oacute;n, Ciudad o Direcci&oacute;n completa</p>
	</div>
	<div id="content">
		<div id="loading">
			<p>Buscando...</p>
		</div>
		<div id="form" class="form">
			<div class="form_content">
				<button id="geolocation" class="boton target">Geolocalizaci&oacute;n</button>
				<input type="text" placeholder="Ej. Av. &Aacute;vila Camacho, Guadalajara, Jalisco" id="address" class="text" />
				<select id="category" class="select">
					<?php foreach ($category_array as $category) {
							$selected = ($category['city'] == 'Guadalajara, Jalisco') ? "selected" : " ";
					?>
						<option value="<?= $category['id']; ?>" <?= $selected; ?>><?= utf8_decode($category['city']); ?></option>
					<?php } ?>
				</select>
				<button id="boton" class="boton">Buscar Tiendas</button>
			</div>
		</div>
		<div id="sidebar">
			<?php foreach($result_array as $marker){ ?>
				<div class="store" 
					data-lat="<?= $marker['lat'];?>" 
					data-lng="<?= $marker['lng'];?>" 
					data-name="<?= utf8_decode($marker['name']); ?>" 
					data-address="<?= utf8_decode($marker['address']); ?>"
					data-city="<?= utf8_decode($marker['city']); ?>"
					data-telephone="<?= $marker['telephone']; ?>"
					data-email="<?= utf8_decode($marker['email']); ?>"
					data-schedule="<?= utf8_decode($marker['schedule']); ?>"
					data-notes="<?= utf8_decode($marker['notes']); ?>"
				>
					<span class='letra2'><?= utf8_decode($marker['name']); ?></span>
					<span class='letra'><?= utf8_decode($marker['address']); ?></span>
					<span class='letra'><?= utf8_decode($marker['city']); ?>.</span>
					<span class='letra'><b>Tel:&nbsp;</b><?= $marker['telephone']; ?></span>
					<span class='letra'><b>Email:&nbsp;</b><?= utf8_decode($marker['email']); ?></span>
					<span class='letra'><b>Horario:&nbsp;</b><?= utf8_decode($marker['schedule']); ?></span>
					<span class='letra'><?= utf8_decode($marker['notes']); ?></span>
					<span class='letra'><b>Disctancia:</b> <?=  round($marker['distance'], 2); ?>Km</span>
				</div>
			<?php } ?>
		</div>
		<div id="map_canvas" style="height: 400px;width: 499px;display: inline-block;">
			
		</div>
	</div>
	<div id="contact">
		<div id="form" class="form" method="post">
			<div id="form_content" class="form_content" style="height: 92px;">
				<form id="contact_form" name="contact_form">
					<div id="text_contact" class="text_contact">
						<h5 class="letra2">Sucursal Ju&aacute;rez</h5>
						<div class="letra">
							<p>Av. Ju&aacute;rez # 305. Guadalajara, Jalisco.</p>
							<p>Tel: (33) 3614-2856, 3614-9785</p>
						</div>
						<input type="hidden" name="email" value="" />
						<input type="hidden" name="store" value="" />
					</div>
					<div id="contact_div">
						<textarea placeholder="Mensaje" id="message" name="message" class="text txt-contact" rows="3" ></textarea>
						<button id="btn-contact" class="boton btn-contact">Contactar</button>
					</div>
				</form>
				
			</div>
		</div>
	</div>
	<div id="footer">
		<h1>Footer</h1>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		init_map();
		init_store();
		var lat, lng;
		var rel_ubicacion = [];
 		
		$('#geolocation').click(function(){
			
			$('#loading').show();
			GMaps.geolocate({
			  success: function(position) {
			  	
			  	//borrar marker
			  	map.removeMarkers();
			  	
			  	lat = position.coords.latitude;
				lng = position.coords.longitude;
			  	
			  	loadSidebar(lat, lng);
			    map.setCenter(position.coords.latitude, position.coords.longitude);
				
				rel_ubicacion = [lat, lng];
				
			    map.addMarker({
					lat: position.coords.latitude,
					lng: position.coords.longitude,
					title: 'Lima',
					icon: 'marker.png',
					infoWindow: {
					  content: '<p>Est&aacute;s Aqu&iacute;</p>'
					}
				});
				
				
				$.ajax({
				        type: "POST",
				        url: "finder.php",
				        data: "lat="+lat+"&lng="+lng+"&geo=1",
				        success: function(response){
				        	
				        	obj = JSON.parse(response);
				        	
				        	for(i = 0; i < obj.length; ++i) {
			                    
			                    geo_marker = map.addMarker({
									lat: obj[i]['lat'],
									lng: obj[i]['lng'],
									title: "'" + obj[i]['name'] + "'",
									icon: 'blue1.png',
									infoWindow: {
									  content: "<p><div style='overflow: auto;'><b class='letra2'>" + obj[i]['name'] + " </b><span class='letra'>" + obj[i]['address'] + " </span><span class='letra'>" + obj[i]['city'] + " .</span><span class='letra'><b>Tel:&nbsp;</b>" + obj[i]['telephone'] + " </span><span class='letra'><b>Email:&nbsp;</b>" + obj[i]['email'] + " </span><span class='letra'><b>Horario:&nbsp;</b>" + obj[i]['schedule'] + " </span><span class='letra'>" + obj[i]['notes'] + " </span></div></p>"
									}
								});
			                }
			                //console.log(geo_marker);
			                init_store();
				       		$('#loading').hide();
				      	}
				});
				

			  },
			  error: function(error) {
			    alert('Geolocation failed: '+error.message);
			  },
			  not_supported: function() {
			    alert("Your browser does not support geolocation");
			  },
			  always: function() {
			    //console.log("Geolocation Done!");
			  }
			});

		});
		
		function init_store(){
			$('.store').click(function(){
				var lat 	  = $(this).attr('data-lat');
				var lng 	  = $(this).attr('data-lng');
				var name 	  = $(this).attr('data-name');
				var address   = $(this).attr('data-address');
				var city 	  = $(this).attr('data-city');
				var telephone = $(this).attr('data-telephone');
				var email     = $(this).attr('data-email');
				var schedule  = $(this).attr('data-schedule');
				var notes 	  = $(this).attr('data-notes');
				
				var content   = '<h5 class="letra2">'+name+'</h5><div class="letra"><p>'+address+'</p><p>'+telephone+'</p></div><input type="hidden" name="email" value="'+email+'" /><input type="hidden" name="store" value="'+name+'" />';
				
				map.setCenter(lat,lng);
				
				if(rel_ubicacion.length == 2){
					map.removeMarkers();
					map.cleanRoute();
					console.log(rel_ubicacion[0] + " / " + rel_ubicacion[1]);
					
					map.addMarker({
						lat: rel_ubicacion[0],
						lng: rel_ubicacion[1],
						title: 'Estás aquí',
						icon: 'marker.png',
						infoWindow: {
						  content: '<p>Est&aacute;s Aqu&iacute;</p>'
						}
					});
					
					map.addMarker({
						lat: lat,
						lng: lng,
						title: "'" + name + "'",
						icon: 'marker_store.png',
						infoWindow: {
						  content: "<p><div style='overflow: auto;'><b class='letra2'>" + name + " </b><span class='letra'>" + address + "</span><span class='letra'>" + city + ".</span><span class='letra'><b>Tel:&nbsp;</b>" + telephone + "</span><span class='letra'><b>Email:&nbsp;</b>" + email + "</span><span class='letra'><b>Horario:&nbsp;</b>schedule</span><span class='letra'>" + notes + "</span></div></p>"
						}
					});
					
					map.drawRoute({
					  origin: [rel_ubicacion[0], rel_ubicacion[1]],
					  destination: [lat, lng],
					  travelMode: 'driving',
					  strokeColor: '#131540',
					  strokeOpacity: 0.6,
					  strokeWeight: 6
					});
				}else{
					//Nothing to draw
				}
				
				$('#contact_div').css({'display':'block'});
				$('#contact #text_contact').html(content);
				$('#contact').slideDown('slow');
				
				
				
			});
		}
		
		
		function loadSidebar(lat, lng){
			
			$.ajax({
			        type: "POST",
			        url: "sidebar.php",
			        data: "lat="+lat+"&lng="+lng,
			        success: function(response){
			        	
			        	$('#sidebar').html(response);
			       	
			      }
			});
			
		}
		
		function loadSidebar_city(lat, lng){
			var city = $('#category').val();
			
			$.ajax({
			        type: "POST",
			        url: "sidebar_city.php",
			        data: "lat="+lat+"&lng="+lng+"&city="+city,
			        success: function(response){
			        	
			        	$('#sidebar').html(response);
			       	
			      }
			});
			
		}
		
		$('#btn-contact').click(function(e){
			e.preventDefault();
			var datos = $('#contact_form').serialize();
			$.ajax({
			        type: "POST",
			        url: "envia-mail.php",
			        data: datos,
			        success: function(response){
			        	$('#contact_form').each (function() { this.reset(); });
			        	if(response == 0){
			        		$('#contact_div').css({'display':'none'});
			        		$('#contact #text_contact').html("<h1 class='mail_h1'>Ha ocurrido un error.</h1>");
			        	}else if(response == 1){
			        		$('#contact_div').css({'display':'none'});
			        		$('#contact #text_contact').html("<h1 class='mail_h1'>Mensaje Enviado.</h1>");
			        	}else{
			        		alert('Por favor ingrese un mensaje.');
			        	}
			        	
			       	
			      }
			});
		});
		
		$('#boton').click(function(){
			
			$('#loading').show();
			var geolocation_value = [lat, lng];
			var code_address = $('#address').val() + ", " + $('#category option:selected').text();
			//console.log(code_address);
			//borrar marke
			map.removeMarkers();
			
			GMaps.geocode({
			  address: code_address,
			  callback: function(results, status) {
			    if (status == 'OK') {
			      var latlng = results[0].geometry.location;
			      map.setCenter(latlng.lat(), latlng.lng());
			      map.addMarker({
			        lat: latlng.lat(),
			        lng: latlng.lng(),
			        icon: 'marker.png'
			      });
			      
			      loadSidebar_city(latlng.lat(), latlng.lng());
			      var lat = latlng.lat();
			      var lng = latlng.lng();
			      var city = $('#category').val();
			      
			      rel_ubicacion = [lat, lng];
			      
			      /* Agregar el resto de los markers */
				  $.ajax({
				        type: "POST",
				        url: "finder.php",
				        data: "lat="+lat+"&lng="+lng+"&city="+city+"&geo=2",
				        success: function(response){
				        	
				        	obj = JSON.parse(response);
				        	
				        	for(i = 0; i < obj.length; ++i) {
			                    
			                    geo_marker = map.addMarker({
									lat: obj[i]['lat'],
									lng: obj[i]['lng'],
									title: "'" + obj[i]['name'] + "'",
									icon: 'marker_store.png',
									infoWindow: {
									  content: "<p><div style='overflow: auto;'><b class='letra2'>" + obj[i]['name'] + " </b><span class='letra'>" + obj[i]['address'] + " </span><span class='letra'>" + obj[i]['city'] + " .</span><span class='letra'><b>Tel:&nbsp;</b>" + obj[i]['telephone'] + " </span><span class='letra'><b>Email:&nbsp;</b>" + obj[i]['email'] + " </span><span class='letra'><b>Horario:&nbsp;</b>" + obj[i]['schedule'] + " </span><span class='letra'>" + obj[i]['notes'] + " </span></div></p>"
									}
								});
			                }
			                //console.log(geo_marker);
			                init_store();
				       		$('#loading').hide();
				      	}
				  });
			      
			    }
			  }
			});
		});

		function setAllMap(map) {
		  for (var i = 0; i < markers.length; i++) {
		    markers[i].setMap(map);
		  }
		}
		
		function init_map(address){
			if(typeof(address) == 'undefined'){
				//console.log('OK ' + address); //Do something
			}
			
			map = new GMaps({
				div: '#map_canvas',
				lat: 20.67364750332206,
				lng: -103.34639947812502,
				zoom: 13
			});

			<?php foreach($result_array as $marker){ ?>
				
				map.addMarker({
					lat: <?= $marker['lat']; ?>,
					lng: <?= $marker['lng']; ?>,
					title: '<?= $marker['name']; ?>',
					icon: 'marker_store.png',
					infoWindow: {
					  content: "<p><div style='overflow: auto;'><b class='letra2'><?= utf8_decode($marker['name']); ?> </b><span class='letra'><?= utf8_decode($marker['address']); ?></span><span class='letra'><?= utf8_decode($marker['city']); ?>.</span><span class='letra'><b>Tel:&nbsp;</b><?= $marker['telephone']; ?></span><span class='letra'><b>Email:&nbsp;</b><?= $marker['email']; ?></span><span class='letra'><b>Horario:&nbsp;</b><?= utf8_decode($marker['schedule']); ?></span><span class='letra'><?= utf8_decode($marker['notes']); ?></span></div></p>"
					}
				});

			<?php } ?>
			  
			
		}
		//End init_map function
		
	  
	});
</script>
</body>
</html>