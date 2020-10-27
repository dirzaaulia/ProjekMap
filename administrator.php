 <!DOCTYPE html>
<html>
<head>
	<title>Jelajah Sumatera Barat</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div id="contentAdministrator">
		<div id="headerAdministrator">
			<br>
			<span style="margin-left: 1%; font-size: 20pt" title="Menu" id="buttonNavigation" onclick="openNav()">&#9776;</span>
			<span style="margin-left: 15%;" id="teksHeaderAdministrator">Administrator</span>

			<div id="MenuAdministrator" class="MenuAdministrator">
				<br>
			    <a href="administrator.php" id="MenuAdministrator" style="background: #0D47A1; padding: 1% 1% 1% 1%" >Daftar Wisata</a>
			    <a href="saranwisata.php" id="MenuAdministrator" >Saran Wisata</a>
			    <a href="daftar_administrator.php" id="MenuAdministrator" >Daftar Administrator</a>
			</div>
		</div>

		<div id="contentTabelDaftarWisata">
			<table id="tabelDaftarWisata">
				<?php  

					include("koneksi.php");

					 $BatasAwal = 2;

	                if (!empty($_GET['halaman'])) {

	                    $hal = $_GET['halaman'] - 1;
	                    $MulaiAwal = $BatasAwal * $hal;

	                } else if (!empty($_GET['halaman']) and $_GET['halaman'] == 1) {
	                
	                    $MulaiAwal = 0;

	                } else if (empty($_GET['halaman'])) {
	                
	                    $MulaiAwal = 0;
	                }

					$query = mysqli_query($con, "SELECT * FROM `map` LIMIT $MulaiAwal, $BatasAwal");

					if(mysqli_num_rows($query)>0){
	        
	                    echo "<tr>
	                            <th>Nomor</th>
	                            <th>Nama Tempat Wisata</th>
	                            <th>Deskripsi Tempat Wisata</th>
	                            <th>Gambar Tempat Wisata</th>
	                        </tr>";

	                    while($de=mysqli_fetch_array($query)){

	                        $id=$de['id'];
	                        $nama=$de['nama'];
	                        $gambar=$de['gambar'];
	                        $deskripsi=$de['deskripsi'];

	                        echo "
	                                <tr>
	                                	<td>".$id."</td>
	                                	<td style='font-weight: bold'>".$nama."</td>
	                                    <td style='width: 700px; text-align: justify'>".$deskripsi."</td>
	                                    <td><img id=\"gambarTabel\" src=\"gambar/".$gambar."\"></td>
	                                </tr>
	                        ";
	                      }

	               	} else {
	                    	
	                    echo"
	           	            <tr>
	                            <td>Data tidak ada.</td>
	                        </tr>
	                    ";
	                }
				?>
			</table>
			<br>
			<?php

            //navigasi
            $cekQuery = mysqli_query($con, "SELECT * FROM `map`");
            $jumlahData = mysqli_num_rows($cekQuery);

               if ($jumlahData > $BatasAwal) {

                echo '<center><div style="font-size:15px; text-decoration-color:blue">Halaman : ';
                $a = explode(".", $jumlahData / $BatasAwal);
                $b = $a[0];
                $c = $b + 1;

                for ($i = 1; $i <= $c; $i++) {

                    echo '<a class="halamanTabel" style="font-family: verdana; font-size: 11pt; text-decoration-color:blue; text-decoration:none; font-weight:bold;';
                    
                    if ($_GET['halaman'] == $i) {
                
                    echo 'color:black';
                    
                    }
                
                    echo '" href="?halaman=' . $i . '">' . $i . '</a> - ';
                }
                    
                echo '</div></center>';

            }
        ?>

        <br><br>

        	<div id="opsiDaftarWisata">

				<div id="tambahDaftarWisata">
					<form action="" method="post" enctype="multipart/form-data">
						<span id="teksTambahWisata">Tambah Wisata</span>

						<br><br>
					  	<label for="namatempatwisata">Nama Tempat Wisata</label>
					  	<input type="text" id="namatempatwisata" name="namatempatwisata" placeholder="Ketikkan nama tempat wisata yang ingin ditambahkan">

					  	<label for="deskripsitempatwisata">Deskripsi Tempat Wisata</label>
					  	<textarea style="height: 200px" id="deskripsitempatwisata" name="deskripsitempatwisata" placeholder="Ketikkan mengenai tempat wisata tersebut misalnya wisata alam untuk melihat pemandangan gunung, daerahnya dingin dan sebagainya"></textarea>

					  	<br><br>
					  	<div id="map" style="width: 100%; height: 400px; "></div>
					  	Klik pada peta di atas untuk memberi Marker dimana lokasi tempat wisata berada.
					  	<br><br>

					  	<label for="posisilat">Posisi Lintang</label>
					  	<input type="text" id="posisilat" name="posisilat" placeholder="Klik pada peta untuk mendapatkan posisi lintang ">

					  	<label for="posisilang">Posisi Bujur</label>
					  	<input type="text" id="posisilang" name="posisilang" placeholder="Klik pada peta untuk mendapatkan posisi bujur">

					   	<label for="fileToUpload">Pilih file gambar untuk tempat wisata</label>
					    <input type="file" name="fileToUpload" id="fileToUpload"><br><br>
					    
					    <input type="submit" value="Tambahkan Data Tempat Wisata" name="buttonTambahDaftarWisata" id="buttonTambahDaftarWisata" style="margin-top: 14%">

					    <?php

   						if (isset($_POST['buttonTambahDaftarWisata'])) {
					
						include("koneksi.php");

						$target_dir = "gambar/";
						$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
						$uploadOk = 1;
						$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
						// Check if image file is a actual image or fake image
					    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
					    if($check !== false) {

					        $uploadOk = 1;	

					    } else {

					        $uploadOk = 0;
					    }

						// Allow certain file formats
						if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
						    echo "<script type='text/javascript'>alert('Terjadi kesalahan saat mengubah gambar Logo. Ekstensi gambar yang diperbolehkan hanya JPG, JPEG dan PNG')</script>";
						    $uploadOk = 0;
						}
						// Check if $uploadOk is set to 0 by an error
						if ($uploadOk == 0) {
						    echo "<script type='text/javascript'>alert('Terjadi kesalahan saat mengubah gambar Logo.')</script>";
						// if everything is ok, try to upload file
						} else {

						    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

						    		$namatempatwisata = $_POST['namatempatwisata'];
   									$deskripsitempatwisata = $_POST['deskripsitempatwisata'];
   									$posisilat = $_POST['posisilat'];
   									$posisilang = $_POST['posisilang'];
						    		$gambar = basename($_FILES["fileToUpload"]["name"]);

						        $q = "INSERT INTO `map` (`id`, `nama`, `gambar`, `deskripsi`, `lat`, `lang`) VALUES (NULL, '$namatempatwisata', '$gambar', '$deskripsitempatwisata', '$posisilat', '$posisilang')";
	                   		
					        	if ($namatempatwisata == NULL){

									echo "<script type='text/javascript'>alert('Terjadi kesalahan saat mengubah data wisata. Nama tempat wisata tidak boleh kosong')</script>";

								} else if ($deskripsitempatwisata == NULL){

									echo "<script type='text/javascript'>alert('Terjadi kesalahan saat mengubah data wisata. Deskripsi tempat wisata tidak boleh kosong')</script>";

								} else if ($posisilat == NULL){

									echo "<script type='text/javascript'>alert('Terjadi kesalahan saat mengubah data wisata. Tentukan posisi lokasi tempat wisata dengan mengklik pada map.')</script>";

								} else if ($gambar == NULL){

									echo "<script type='text/javascript'>alert('Terjadi kesalahan saat mengubah data wisata. Gambar harus di pilih terlebih dahulu')</script>";

								} else if (mysql_query($q)) {
					        	
					        		echo "<script type='text/javascript'>alert('Data wisata telah berhasil di tambahkan ke database')</script>";
					        		echo '<META HTTP-EQUIV="Refresh" Content="0; URL="administrator.php">';

					      		} else {

					      			echo "<script type='text/javascript'>alert('Terjadi kesalahan saat menambahkan data wisata')</script>";
					      		
					      		}
							}
						}
					}
					?>
					</form>

					
				</div>

				<div id="ubahDaftarWisata">
					<form action="" method="post" enctype="multipart/form-data">
						<span id="teksUbahWisata">Ubah Wisata</span>

						<br><br>
						<label for="nomorwisata">Nomor Wisata</label>
							<select name="nomorwisata" id="nomorwisata" class="styled-select slate">
								<option value="-">Pilih Nomor Wisata</option>
								<?php 

									include "koneksi.php";

									$sql = mysqli_query($con, "SELECT * FROM `map`");
									while ($row = mysqli_fetch_array($sql)){
										echo "<option value=\"". $row['id']."\">" . $row['id'] ." - ". $row['nama']."</option>";
									}
								?>
							</select>

						
					  	<label for="namatempatwisata">Nama Tempat Wisata</label>
					  	<input type="text" id="namatempatwisata" name="namatempatwisata" placeholder="Ketikkan nama tempat wisata yang baru">

					  	<label for="deskripsitempatwisata">Deskripsi Tempat Wisata</label>
					  	<textarea style="height: 200px" id="deskripsitempatwisata" name="deskripsitempatwisata" placeholder="Ketikkan mengenai tempat wisata tersebut misalnya wisata alam untuk melihat pemandangan gunung, daerahnya dingin dan sebagainya"></textarea>

					  	<br><br>
					  	<div id="map2" style="width: 100%; height: 400px; "></div>
					  	Klik pada peta di atas untuk memberi Marker dimana lokasi tempat wisata berada.
					  	<br><br>

					  	<label for="posisilat">Posisi Lintang</label>
					  	<input type="text" id="posisilat2" name="posisilat2" placeholder="Klik pada peta untuk mendapatkan posisi lintang ">

					  	<label for="posisilang">Posisi Bujur</label>
					  	<input type="text" id="posisilang2" name="posisilang2" placeholder="Klik pada peta untuk mendapatkan posisi bujur">

					   	<label for="fileToUpload">Pilih file gambar untuk tempat wisata</label>
					    <input type="file" name="fileToUpload" id="fileToUpload"><br><br>
					    
					    <input type="submit" value="Ubah Data Tempat Wisata" name="buttonUbahDaftarWisata" id="buttonUbahDaftarWisata">
					</form>

					<?php

   						if (isset($_POST['buttonUbahDaftarWisata'])) {
					
						include("koneksi.php");

						$target_dir = "gambar/";
						$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
						$uploadOk = 1;
						$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
						// Check if image file is a actual image or fake image
					    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
					    if($check !== false) {

					        $uploadOk = 1;	

					    } else {

					        $uploadOk = 0;
					    }

						// Allow certain file formats
						if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
						    echo "<script type='text/javascript'>alert('Terjadi kesalahan saat mengubah gambar Logo. Ekstensi gambar yang diperbolehkan hanya JPG, JPEG dan PNG')</script>";
						    $uploadOk = 0;
						}
						// Check if $uploadOk is set to 0 by an error
						if ($uploadOk == 0) {
						    echo "<script type='text/javascript'>alert('Terjadi kesalahan saat mengubah gambar Logo.')</script>";
						// if everything is ok, try to upload file
						} else {

						    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

						    	$nomorwisata = $_POST["nomorwisata"];
		   						$namatempatwisata = $_POST['namatempatwisata'];
		   						$deskripsitempatwisata = $_POST['deskripsitempatwisata'];
		   						$posisilat = $_POST['posisilat2'];
		   						$posisilang = $_POST['posisilang2'];
						    	$gambar = basename($_FILES["fileToUpload"]["name"]);

						    
						        $q = "UPDATE `map` SET `nama`='$namatempatwisata', `gambar`='$gambar', `deskripsi`='$deskripsitempatwisata', `lat`='$posisilat', lang='$posisilang' WHERE `id`=$nomorwisata";
	                   		
								if ($nomorwisata == NULL){

									echo "<script type='text/javascript'>alert('Terjadi kesalahan saat mengubah data wisata'. Pilih terlebih dahulu nomor wisata yang ingin di ubah)</script>";

								} else if ($namatempatwisata == NULL){

									echo "<script type='text/javascript'>alert('Terjadi kesalahan saat mengubah data wisata. Nama tempat wisata tidak boleh kosong')</script>";

								} else if ($deskripsitempatwisata == NULL){

									echo "<script type='text/javascript'>alert('Terjadi kesalahan saat mengubah data wisata. Deskripsi tempat wisata tidak boleh kosong')</script>";

								} else if ($posisilat == NULL){

									echo "<script type='text/javascript'>alert('Terjadi kesalahan saat mengubah data wisata. Tentukan posisi lokasi tempat wisata dengan mengklik pada map.')</script>";

								} else if ($gambar == NULL){

									echo "<script type='text/javascript'>alert('Terjadi kesalahan saat mengubah data wisata. Gambar harus di pilih terlebih dahulu')</script>";

								} else if (mysqli_query($con, $q)) {
					        	
					        		echo "<script type='text/javascript'>alert('Data wisata telah berhasil di ubah pada database')</script>";
					        		echo '<META HTTP-EQUIV="Refresh" Content="0; URL="administrator.php">';

					      		} else {

					      			echo "<script type='text/javascript'>alert('Terjadi kesalahan saat mengubah data wisata')</script>";
					      		
					      		}
							}
						}
					}
					?>

				</div>
				
			</div>
			<br><br>
			<div id="hapusDaftarWisata">
				<form action="" method="post" enctype="multipart/form-data">
					<br>
					<span id="teksHapusWisata">Hapus Wisata</span>
					<br><br>
					<label for="nomorwisata">Nomor Wisata</label>
						<select name="nomorwisata" id="nomorwisata" class="styled-select slate">
							<option value="-">Pilih Nomor Wisata</option>
							<?php 

								include "koneksi.php";

								$sql = mysqli_query($con, "SELECT * FROM `map`");
								while ($row = mysqli_fetch_array($sql)){
									echo "<option value=\"". $row['id']."\">" . $row['id'] ." - ". $row['nama']."</option>";
								}
							?>
						</select>
					<br>
					<input type="submit" value="Hapus Data Tempat Wisata" name="buttonHapusDaftarWisata" id="buttonHapusDaftarWisata">
			   		<?php

   						if (isset($_POST['buttonHapusDaftarWisata'])) {
					
							include("koneksi.php");

							$nomorwisata = $_POST['nomorwisata'];


					        $q = "DELETE FROM `map` WHERE `id`=$nomorwisata";
                   		
                   				if ($nomorwisata == NULL){

                   					echo "<script type='text/javascript'>alert('Terjadi kesalahan saat menghapus data wisata. Pilih terlebih dahulu nomor wisata yang ingin di hapus')</script>";

                   				} else if (mysqli_query($con, $q)) {
					        	
					        		echo "<script type='text/javascript'>alert('Data wisata telah berhasil di hapus dari database')</script>";
					        		echo '<META HTTP-EQUIV="Refresh" Content="0; URL="administrator.php">';

					        		$w = "ALTER TABLE `map` AUTO_INCREMENT=$id";

			        				mysqli_query($con, $w);

					      		} else {

					      			echo "<script type='text/javascript'>alert('Terjadi kesalahan saat menghapus data wisata')</script>";

					      		}
						}
					?>
				</form>
			</div>
		</div>
	</div>

	<script type="text/javascript">

		var map;
		var map2;
		var marker;
		var marker2;

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

    		//Membuat map baru pada lat dan lang tertentu dengan zoom tertentu
	        map2 = new google.maps.Map(document.getElementById('map2'), {
	          center: new google.maps.LatLng(-0.727136, 100.560591),
	          zoom: 7,
	          scrollwheel: false,
	        });

        	map2.addListener('click', function(event) {
     			// get lat/lon of click
                var clickLat = event.latLng.lat();
                var clickLon = event.latLng.lng();

                // show in input box
                document.getElementById("posisilat2").value = clickLat.toFixed(5);
                document.getElementById("posisilang2").value = clickLon.toFixed(5);


                placeMarker2(event.latLng);
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

		function placeMarker2(location) {
				
				if (!marker) {

				marker2 = new google.maps.Marker({
					position: location,
					map: map2,
					animation: google.maps.Animation.BOUNCE
				});
		
			} else {

				marker2.setPosition(location);
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
</body>
</html>