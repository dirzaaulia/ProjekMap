<?php
		require("koneksiXML.php");

		function parseToXML($htmlStr)
		{
			
			$xmlStr=str_replace('<','&lt;',$htmlStr);
			$xmlStr=str_replace('>','&gt;',$xmlStr);
			$xmlStr=str_replace('"','&quot;',$xmlStr);
			$xmlStr=str_replace("'",'&#39;',$xmlStr);
			$xmlStr=str_replace("&",'&amp;',$xmlStr);
			return $xmlStr;
		}

		// Opens a connection to a MySQL server
		$connection=mysqli_connect ('localhost', $username, $password);
		if (!$connection) {
		  die('Not connected : ' . mysqli_error());
		}

		// Set the active MySQL database
		$db_selected = mysqli_select_db($connection, $database);
		if (!$db_selected) {
		  die ('Can\'t use db : ' . mysqli_error());
		}

		// Select all the rows in the markers table
		$query = "SELECT * FROM map";
		$result = mysqli_query($connection, $query);
		if (!$result) {
		  die('Invalid query: ' . mysqli_error());
		}

		header("Content-type: text/xml");

		// Start XML file, echo parent node
		echo '<markers>';

		// Iterate through the rows, printing XML nodes for each
		while ($row = @mysqli_fetch_assoc($result)){
		  // Add to XML document node
		  echo '<marker ';
		  echo 'id="' . $row['id'] . '" ';
		  echo 'nama="' . $row['nama'] . '" ';
		  echo 'gambar="' . $row['gambar'] . '" ';
		  echo 'deskripsi="' . parseToXML($row['deskripsi']) . '" ';
		  echo 'lat="' . $row['lat'] . '" ';
		  echo 'lng="' . $row['lang'] . '" ';
		  echo '/>';
		}

		// End XML file
		echo '</markers>';
	?>