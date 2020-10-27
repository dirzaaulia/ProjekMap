<!DOCTYPE html>
<html>
<head>
	<title>Jelajah Sumatera Barat</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div id="contentDaftarWisata">
		<div id="judulDaftarWisata">
			<br>
			<span style="margin-left: 1%; font-size: 20pt" title="Menu" id="buttonNavigation" onclick="openNav()">&#9776;</span>
			<span style="margin-left: 10%;" id="teksJudulDaftarWisata">Daftar Tempat Wisata</span>
		</div>

		<br>
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
			</table>
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
		</div>
</body>
</html>