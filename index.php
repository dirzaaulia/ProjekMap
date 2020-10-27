<!DOCTYPE html>
<html>
<head>
	<title>Jelajah Sumatera Barat</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div id="header">
    <div id="backgroundTeksIndex">
        <br>
        <span id="teksJudulIndex">Jelajah Sumatera Barat</span>
        <p id="deskripsiIndex">Selamat Datang Wisatawan! Mulailah perjalanan anda untuk menjelajahi keindahan wisata alam serta wisata lainnya di Sumatera Barat dengan melihat semua informasi wisata di Sumatera Barat disini. Sumatera Barat merupakan salah satu surga wisata di Pulau Sumatera dan juga di Indonesia. Bersiap untuk melihat pesona keindahan Sumatera Barat yang memukau dan membuat anda akan sulit untuk melupakannya.</p>
        <br>
        <button id="buttonIndex" onclick="smoothScroll(document.getElementById('peta'))">Mulai Menjelajah!</button>
    </div> 

    <script type="text/javascript">
      window.smoothScroll = function(target) {
          var scrollContainer = target;
          do { //find scroll container
              scrollContainer = scrollContainer.parentNode;
              if (!scrollContainer) return;
              scrollContainer.scrollTop += 1;
          } while (scrollContainer.scrollTop == 0);

          var targetY = 0;
          do { //find the top of target relatively to the container
              if (target == scrollContainer) break;
              targetY += target.offsetTop;
          } while (target = target.offsetParent);

          scroll = function(c, a, b, i) {
              i++; if (i > 30) return;
              c.scrollTop = a + (b - a) / 30 * i;
              setTimeout(function(){ scroll(c, a, b, i); }, 20);
          }
          // start scrolling
          scroll(scrollContainer, scrollContainer.scrollTop, targetY, 0);
      }
    </script>
  </div>

  <div id="mySidenav" class="sidenav">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="#">Beranda</a>
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

	<div id="peta">
    <div id="navigation">
      <br>
      <span title="Menu" id="buttonNavigation" onclick="openNav()">&#9776;</span>
    </div>
    <div id="map"></div>
  </div>

	<script>
      //Membuat label sesuai dengan tipe tempat
      /*var customLabel = {
        restaurant: {
          label: 'R'
        },
        bar: {
          label: 'B'
        }
      };*/

      //Fungsi initMap atau fungsi map
      function initMap() {

        //Membuat map baru pada lat dan lang tertentu dengan zoom tertentu
        var map = new google.maps.Map(document.getElementById('map'), {
          center: new google.maps.LatLng(-0.727136, 100.560591),
          zoom: 8,
          scrollwheel: false,
          draggable: false

        });

        //Mendeklarasikan variabel infoWindow
        var infoWindow = new google.maps.InfoWindow;

          // Change this depending on the name of your PHP or XML file
          // Menentukan halaman yang berisi XML dimana database terhubung
          downloadUrl('datamarker.php', function(data) {

            //Mendeklarasikan fungsi untuk membaca data XML
            var xml = data.responseXML;
            //Mendeklarasikan variabel marker untuk menampung data dengan tag 'marker' pada XML
            var markers = xml.documentElement.getElementsByTagName('marker');

            //Untuk setiap Array pada variabel 'markers'
            Array.prototype.forEach.call(markers, function(markerElem) {

              /*
              //Mendeklarasikan variabel 'nama' dimana isinya diambil dari tag 'name' pada XML
              var name = markerElem.getAttribute('name');
              //Mendeklarasikan variabel 'address' dimana isinya diambil dari tag 'address' pada XML
              var address = markerElem.getAttribute('address');
              //Mendeklarasikan variabel 'type' dimana isinya diambil dari tag 'type' pada XML
              var type = markerElem.getAttribute('type');
              //Mendeklarasikan variabel 'point' dimana isinya diambil dari tag 'lat' dan 'lng' pada XML yang berfungsi sebagai penyimpan nilai posisi*/

              var id = markerElem.getAttribute('id');
              var name = markerElem.getAttribute('nama');
              var gambar = markerElem.getAttribute('gambar');
              var deskripsi = markerElem.getAttribute('deskripsi');
              var point = new google.maps.LatLng(
                  parseFloat(markerElem.getAttribute('lat')),
                  parseFloat(markerElem.getAttribute('lng')));

              //InfoWindow
              var infowincontent = document.createElement('div'); //Membuat konten InfoWindow dengan membuat elemen div
              infowincontent.setAttribute("align", "center")

              var strong = document.createElement('strong'); // Membuat elemen strong yaitu teks bold
              strong.textContent = name //Masukkan isi teksnya yaitu 'name'
              strong.style.font = "17pt arial black";
              infowincontent.appendChild(strong); //Masukkan teks strong ke konten InfoWindow
              infowincontent.appendChild(document.createElement('br')); //Masukkan br atau baris baru ke konten InfoWindow
              infowincontent.appendChild(document.createElement('br')); //Masukkan br atau baris baru ke konten InfoWindow

              var image = document.createElement("IMG");
              image.setAttribute("src", "gambar/"+gambar);
              image.setAttribute("height", "500");
              infowincontent.appendChild(image);
              infowincontent.appendChild(document.createElement('br'));
              infowincontent.appendChild(document.createElement('br')); //Masukkan br atau baris baru ke konten InfoWindow

              var divText = document.createElement('div');
              divText.setAttribute("align", "justify")
              infowincontent.appendChild(divText);

              var text = document.createElement('p'); //Membuat elemen teks
              text.textContent = deskripsi //Masukkan isi teks tersebut adalah 'address'
              text.style.font = "10pt verdana"
              divText.appendChild(text); //Masukkan teks tersebut ke dalam konten InfoWindow
              //Batas InfoWindow

              //var icon = customLabel[type] || {};
              var marker = new google.maps.Marker({
                map: map,
                position: point,
                title: name,
                label: id
              });
              marker.addListener('click', function() {
                infoWindow.setContent(infowincontent);
                infoWindow.open(map, marker);
                marker.setAnimation(google.maps.Animation.BOUNCE);
                marker.setLabel(null);
              });
              infoWindow.addListener('closeclick', function(){
                marker.setAnimation(null);
                marker.setLabel(id);
                map.panTo(marker.position);
              })
            });
          });
        }

      function downloadUrl(url, callback) {
        var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

        request.onreadystatechange = function() {
          if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
          }
        };

        request.open('GET', url, true);
        request.send(null);
      }

      function doNothing() {}
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyANKd9qmaATJbd6xKOvJHRuj70C5d6Eufs&language=ID&callback=initMap"
    async defer></script>

</body>
</html>