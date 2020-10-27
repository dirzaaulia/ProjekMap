<!DOCTYPE html>
<html>
<head>
	<title>Jelajah Sumatera Barat</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div id="contentTambahWisata">
		<div id="judulTambahWisata">
			<br>
			<span style="margin-left: 1%; font-size: 20pt" title="Menu" id="buttonNavigation" onclick="openNav()">&#9776;</span>
			<span style="margin-left: 7.5%;" id="teksJudulTambahWisata">Tambahkan Tempat Wisata</span>
		</div>

		<div id="contentFormTambahWisata">
			<form action="" method="post" enctype="multipart/form-data">
				<br>
				<p style="text-align: justify;">Ada tempat wisata yang belum tercantum pada daftar wisata di website ini? 

Silahkan isi form berikut ini untuk menambahkan tempat wisata yang anda ketahui agar kami dapat menambahkannya ke dalam website ini.</p>
				<br><br>
			  	<label for="namalengkap">Nama Lengkap</label>
			  	<input type="text" id="namalengkap" name="namalengkap" placeholder="Ketikkan nama lengkap">

				<label for="alamat">Alamat</label>
			  	<textarea id="alamat" name="alamat" placeholder="Ketikkan alamat lengkap"></textarea>

			  	<label for="namatempatwisata">Nama Tempat Wisata</label>
			  	<input type="text" id="namatempatwisata" name="namatempatwisata" placeholder="Ketikkan nama tempat wisata yang ingin ditambahkan">

			  	<label for="lokasitempatwisata">Lokasi Tempat Wisata</label>
			  	<input type="text" id="lokasitempatwisata" name="lokasitempatwisata" placeholder="Ketikkan nama lokasi tempat wisata yang ingin ditambahkan, Contoh : Pasar Atas, Bukittinggi">

			  	<label for="deskripsitempatwisata">Deskripsi Tempat Wisata</label>
			  	<textarea style="height: 200px" id="deskripsitempatwisata" name="deskripsitempatwisata" placeholder="Ketikkan mengenai tempat wisata tersebut misalnya wisata alam untuk melihat pemandangan gunung, daerahnya dingin dan sebagainya"></textarea>

			  	<br><br>
			  	<div id="map" style="width: 100%; height: 400px; float: none;"></div>
			  	<br>
			  	Klik pada peta di atas untuk memberi Marker dimana lokasi tempat wisata berada.
			  	<br><br>

			  	<label for="posisilat">Posisi Lintang</label>
			  	<input type="text" id="posisilat" name="posisilat" placeholder="Klik pada peta untuk mendapatkan posisi lintang ">

			  	<label for="posisilang">Posisi Bujur</label>
			  	<input type="text" id="posisilang" name="posisilang" placeholder="Klik pada peta untuk mendapatkan posisi bujur">

			   	<label for="fileToUpload">Pilih file gambar untuk tempat wisata</label>
			    <input type="file" name="fileToUpload" id="fileToUpload"><br><br>
			    
			    <input type="submit" value="Tambahkan Data Tempat Wisata" name="buttonSubmit" id="buttonSubmit">
			</form>
		</div>
	
		<script type="text/javascript">

			var map; 
			var marker;

		  	function initMap() {
		        //Membuat map baru pada lat dan lang tertentu dengan zoom tertentu
		        map = new google.maps.Map(document.getElementById('map'), {
		          center: new google.maps.LatLng(-0.727136, 100.560591),
		          zoom: 7,
		          scrollwheel: false,
		        });

            	map.addListener('click', function(event) {
         			// get lat/lon of click
	                var clickLat = event.latLng.lat();
	                var clickLon = event.latLng.lng();

	                // show in input box
	                document.getElementById("posisilat").value = clickLat.toFixed(5);
	                document.getElementById("posisilang").value = clickLon.toFixed(5);


	                placeMarker(event.latLng);
        		});

		    }

		    function placeMarker(location) {
  				
  				if (!marker) {

					marker = new google.maps.Marker({
						position: location,
						map: map,
						animation: google.maps.Animation.BOUNCE
					});
			
				} else {

					marker.setPosition(location);
				}
			}

        </script>
       	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyANKd9qmaATJbd6xKOvJHRuj70C5d6Eufs&language=ID&callback=initMap" async defer></script>

		<div id="mySidenav" class="sidenav">
			<a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
		    <a href="index.php">Beranda</a>
		    <a href="daftarwisata.php">Daftar Tempat Wisata</a>
		    <a href="tambahwisata.php">Tambahkan Tempat Wisata</a>
		    <a href="administrator_login.php">Administrator</a>
		</div>

		<script>
			function openNav() {
		      document.getElementById("mySidenav").style.width = "250px";
		      document.getElementById("main").style.marginLeft = "250px";
		  	}

		  	function closeNav() {
		      document.getElementById("mySidenav").style.width = "0";
		      document.getElementById("main").style.marginLeft= "0";
		  	}
		 </script>
	</div>

	<?php

			if (isset($_POST['buttonSubmit'])) {

				$lat = $_POST['posisilat'];
				$lang = $_POST['posisilang']; 

				$url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=$lat,$lang&destinations=-6.885745,107.623124&key=AIzaSyANKd9qmaATJbd6xKOvJHRuj70C5d6Eufs";
				$json = file_get_contents($url);
				$json_data = json_decode($json);

				echo $json_data->rows[0]->elements[0]->distance->text;

			}
	?>
</body>
</html>