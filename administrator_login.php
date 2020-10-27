<!DOCTYPE html>
<html>
<head>
	<title>Jelajah Sumatera Barat</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

	<div id="wrapperLoginAdmin">
		<div id="navigation">
			<br>
			<span title="Menu" id="buttonNavigation" onclick="openNav()">&#9776;</span>
		</div>
		<div id="contentLoginAdmin">
			Jelajah Sumatera Barat
			<p style="font-size: 20pt">Administrator Login</p>

			<form style="font-size: 12pt; font-family: verdana; text-align: left;" action="" method="POST">
				<br><br>
			  	<label for="username">Username</label>
			  	<input type="text" id="username" name="username" placeholder="Ketikkan username">

				<label for="password">Password</label>
			  	<input type="password" id="password" name="password" placeholder="Ketikkan password">
    			<br><br>
			    <input type="submit" value="Login" name="buttonSubmit" id="buttonSubmit">
			</form> 

			<?php

				$username='';
				$password='';

				if (isset($_POST['buttonSubmit'])) {

					include "koneksi.php";

					// Variabel username dan password
					//$username= mysqli_real_escape_string($koneksi, $_POST['username']);
					//$password= mysqli_real_escape_string($koneksi, $_POST['password']);
					$username= mysqli_real_escape_string($con, $_POST['username']);
					$password= mysqli_real_escape_string($con, $_POST['password']);

					if (!($username)){

						echo "<script type='text/javascript'>alert('Usename tidak boleh kosong dan harus di isi')</script>";
					
					} elseif (!($password)) {

						echo "<script type='text/javascript'>alert('Password tidak boleh kosong dan harus di isi')</script>";
					
					} else {

						$sel_user = ("SELECT * FROM `admin` WHERE `username`='$username' AND `password`='$password'");

						//$run_user = mysqli_query($koneksi, $sel_user);
						$run_user = mysqli_query($con, $sel_user);

						$exe = mysqli_num_rows($run_user);

						if($exe == 1){

							
							header("Location: administrator.php");

						} else {

							echo "<script type='text/javascript'>alert('Username dan Password salah, mohon periksa dan coba login kembali')</script>";
						}
					}
				}
			?>
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