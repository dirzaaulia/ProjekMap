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
			    <a href="saranwisata.php" id="MenuAdministrator">Saran Wisata</a>
			    <a href="tambahwisata.php" id="MenuAdministrator" style="background: #0D47A1; padding: 1% 1% 1% 1%">Daftar Administrator</a>
			</div>
		</div>

		<div id="contentTabelAdministrator">
			<table id="tabelAdministrator">
				<?php  

					include("koneksi.php");

					 $BatasAwal = 10;

	                if (!empty($_GET['halaman'])) {

	                    $hal = $_GET['halaman'] - 1;
	                    $MulaiAwal = $BatasAwal * $hal;

	                } else if (!empty($_GET['halaman']) and $_GET['halaman'] == 1) {
	                
	                    $MulaiAwal = 0;

	                } else if (empty($_GET['halaman'])) {
	                
	                    $MulaiAwal = 0;
	                }

					$query = mysqli_query($con, "SELECT * FROM `admin` LIMIT $MulaiAwal, $BatasAwal");

					if(mysqli_num_rows($query)>0){
	        
	                    echo "<tr>
	                            <th>Nomor</th>
	                            <th>Nama Administrator</th>
	                        </tr>";

	                    while($de=mysqli_fetch_array($query)){

	                        $id=$de['id'];
	                        $username=$de['username'];

	                        echo "
	                                <tr>
	                                	<td>".$id."</td>
	                                	<td>".$username."</td>
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
	            $cekQuery = mysqli_query($con, "SELECT * FROM `admin`");
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

	<div id="opsiAdministrator">
		<div id="tambahAdmin">
			<form action="" method="post" enctype="multipart/form-data">
				<span id="teksTambahAdmin">Tambah Administrator</span>

				<br><br>
			  	<label for="username">Username</label>
			  	<input type="text" id="username" name="username" placeholder="Ketikkan username administrator">

			  	<label for="password">Password</label>
			  	<input type="password" id="password" name="password" placeholder="Ketikkan password administrator ">
			    <br><br>
			    <input type="submit" value="Tambahkan Administrator" name="buttonTambahAdmin" id="buttonTambahAdmin" style="margin-top: 21.5%">

			    <?php

					if (isset($_POST['buttonTambahAdmin'])) {
			
						include("koneksi.php");

				    	$username = $_POST['username'];
						$password = $_POST['password'];

				        $q = "INSERT INTO `admin` (`id`, `username`, `password`) VALUES (NULL, '$username', '$password')";
               		
               			if ($username == NULL) {
               				
               				echo "<script type='text/javascript'>alert('Terjadi kesalahan saat menambahkan data administrator. Username tidak boleh kosong')</script>";

               			} else if ($password == NULL) {

               				echo "<script type='text/javascript'>alert('Terjadi kesalahan saat menambahkan data administrator. Password tidak boleh kosong')</script>";

               			} else if (mysqli_query($con, $q)) {
			        	
			        		echo "<script type='text/javascript'>alert('Data administrator telah berhasil di tambahkan ke database')</script>";
			        		echo '<META HTTP-EQUIV="Refresh" Content="0; URL="daftar_administrator.php">';

			      		} else {

			      			echo "<script type='text/javascript'>alert('Terjadi kesalahan saat menambahkan data administrator')</script>";
			      		}
			      	}
			
			?>
			</form>
		</div>

		<div id="ubahAdmin">
			<form action="" method="post" enctype="multipart/form-data">
				<span id="teksUbahAdmin">Ubah Administrator</span>

				<br><br>
			  	 <label for="nomoradmin">Nomor Administrator</label>
					<select name="nomoradmin" id="nomoradmin" class="styled-select slate">
						<option value="-">Pilih Nomor Administrator</option>
						<?php 

							include "koneksi.php";

							$sql = mysqli_query($con, "SELECT * FROM `admin`");
							while ($row = mysqli_fetch_array($sql)){
								echo "<option value=\"". $row['id']."\">" . $row['id'] ." - ". $row['username']."</option>";
							}
						?>
					</select>
			  	 <label for="username">Username</label>
			  	<input type="text" id="username" name="username" placeholder="Ketikkan username administrator">

			  	<label for="password">Password</label>
			  	<input type="password" id="password" name="password" placeholder="Ketikkan password administrator ">
			    <br><br>
			    <input type="submit" value="Ubah Administrator" name="buttonUbahAdmin" id="buttonUbahAdmin">

			    <?php

					if (isset($_POST['buttonUbahAdmin'])) {
			
						include("koneksi.php");
		
						$id = $_POST['nomoradmin'];
						$username = $_POST['username'];
						$password = $_POST['password']; 

				        $q = "UPDATE `admin` SET `username`='$username', `password`='$password' WHERE `id`=$id";
               		
               			if ($id == NULL){

               				echo "<script type='text/javascript'>alert('Terjadi kesalahan saat mengubah data administrator. Pilih terlebih dahulu nomor administrator yang ingin diubah')</script>";

               			} else if ($username == NULL) {

               				echo "<script type='text/javascript'>alert('Terjadi kesalahan saat mengubah data administrator. Username tidak boleh kosong')</script>";

               			} else if ($password == NULL){

               				echo "<script type='text/javascript'>alert('Terjadi kesalahan saat mengubah data administrator. Password tidak boleh kosong')</script>";

               			} else if (mysqli_query($con, $q)) {
			        	
			        		echo "<script type='text/javascript'>alert('Data administrator telah berhasil di ubah pada database')</script>";
			        		echo '<META HTTP-EQUIV="Refresh" Content="0; URL="daftar_administrator.php">';

			      		} else {

			      			echo "<script type='text/javascript'>alert('Terjadi kesalahan saat mengubah data administrator')</script>";
			      		}	
					}
			?>
			</form>
		</div>

		<div id="hapusAdmin">
			<form action="" method="post" enctype="multipart/form-data">
				<span id="teksHapusAdmin">Hapus Administrator</span>

				<br><br>
			  	 <label for="nomoradmin">Nomor Administrator</label>
					<select name="nomoradmin" id="nomoradmin" class="styled-select slate">
						<option value="-">Pilih Nomor Administrator</option>
						<?php 

							include "koneksi.php";

							$sql = mysqli_query($con, "SELECT * FROM `admin`");
							while ($row = mysqli_fetch_array($sql)){
								echo "<option value=\"". $row['id']."\">" . $row['id'] ." - ". $row['username']."</option>";
							}
						?>
					</select>
			    <input type="submit" value="Hapus Administrator" name="buttonHapusAdmin" id="buttonHapusAdmin" style="margin-top: 45.8%">
			    <?php

					if (isset($_POST['buttonHapusAdmin'])) {
			
						$id = $_POST['nomoradmin'];

				        $q = "DELETE FROM `admin` WHERE `id`=$id";
               		
               			if ($id == NULL){

               				echo "<script type='text/javascript'>alert('Terjadi kesalahan saat menambahkan data wisata. Pilih terlebih dahulu nomor administrator yang ingin di hapus')</script>";

               			} else if (mysqli_query($con, $q)) {
			        	
			        		echo "<script type='text/javascript'>alert('Data wisata telah berhasil di hapus dari database')</script>";
			        		echo '<META HTTP-EQUIV="Refresh" Content="0; URL="daftar_administrator.php">';

			        		$w = "ALTER TABLE `admin` AUTO_INCREMENT=$id";

			        		mysqli_query($con, $w);

			      		} else {

			      			echo "<script type='text/javascript'>alert('Terjadi kesalahan saat menghapus data administrator')</script>";
				      	
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