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
			    <a href="administrator.php" id="MenuAdministrator">Daftar Wisata</a>
			    <a href="saranwisata.php" id="MenuAdministrator" style="background: #0D47A1; padding: 1% 1% 1% 1%">Saran Wisata</a>
			    <a href="daftar_administrator.php" id="MenuAdministrator" >Daftar Administrator</a>
			</div>
		</div>

		<div id="contentTabelWisataUser">
			<table id="tabelWisataUser">
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

					$query = mysqli_query($con, "SELECT * FROM `wisatauser` LIMIT $MulaiAwal, $BatasAwal");

					if(mysqli_num_rows($query)>0){
	        
	                    echo "<tr>
	                            <th>Nomor</th>
	                            <th>Nama User</th>
	                            <th>Alamat User</th>
	                            <th>Nama Tempat Wisata</th>
	                            <th>Lokasi Tempat Wisata</th>
	                            <th>Deskripsi Tempat Wisata</th>
	                            <th>Gambar</th>
	                        </tr>";

	                    while($de=mysqli_fetch_array($query)){

	                        $id=$de['id'];
	                        $nama=$de['nama'];
	                        $alamat=$de['alamat'];
	                        $namawisata=$de['namawisata'];
	                        $lokasiwisata=$de['lokasiwisata'];
	                        $deskripsi=$de['deskripsi'];
	                        $gambar=$de['gambar'];

	                        echo "
	                                <tr>
	                                	<td>".$id."</td>
	                                	<td>".$nama."</td>
	                                	<td>".$alamat."</td>
	                                	<td>".$namawisata."</td>
	                                	<td>".$lokasiwisata."</td>
	                                    <td>".$deskripsi."</td>
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
	            $cekQuery = mysqli_query($con, "SELECT * FROM `wisatauser`");
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
        </div>
	</div>

	 <div id="opsiWisataUser">
		<div id="tambahWisataUser">
					
					<br>
					<span id="teksTambahWisataUser">Tambahkan Saran Wisata Ke Daftar Wisata</span>
					<br><br>
					<label for="nomorwisata">Nomor Wisata</label>
						<select name="nomorwisata" id="nomorwisata" class="styled-select slate">
							<option value="-">Pilih Nomor Wisata</option>
							<?php 

								include "koneksi.php";

								$sql = mysqli_query($con, "SELECT * FROM `wisatauser`");
								while ($row = mysqli_fetch_array($sql)){
									echo "<option value=\"". $row['id']."\">" . $row['id'] ." - ". $row['namawisata']."</option>";
								}
							?>
						</select>
					<br>
					<input type="submit" value="Tambahkan Data Tempat Wisata" name="buttonTambahDaftarWisata" id="buttonTambahDaftarWisata">
			   		<?php

   						if (isset($_POST['buttonTambahDaftarWisata'])) {
					
							include("koneksi.php");

							$nomorwisata = $_POST['nomorwisata'];


					        $q = "INSERT INTO `map` (`nama`, `gambar`, `deskripsi`, `lat`, `lang`) SELECT `namawisata`, `gambar`, `deskripsi`, `lat`, `lang` FROM `wisatauser` WHERE `id`=$nomorwisata";
                   		
				        		if (mysqli_query($con, $q)) {
					        	
					        		echo "<script type='text/javascript'>alert('Data wisata telah berhasil di tambahkan pada database')</script>";
					        		echo '<META HTTP-EQUIV="Refresh" Content="0; URL="saranwisata.php">';

					      		} else {

					      		echo "<script type='text/javascript'>alert('Terjadi kesalahan saat menambahkan data wisata')</script>";
					      		}
						}
					?>
				</form>
		</div>
	</div>
	

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