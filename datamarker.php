<?php
	require("koneksiXML.php");

	// Start XML file, create parent node

	$dom = new DOMDocument("1.0");
	$node = $dom->createElement("markers");
	$parnode = $dom->appendChild($node);

	// Opens a connection to a MySQL server

	$connection=mysqli_connect('localhost', $username, $password);
	if (!$connection) {  die('Not connected : ' . mysqli_error());}

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

	// Iterate through the rows, adding XML nodes for each

	while ($row = @mysqli_fetch_assoc($result)){
	  // Add to XML document node
	  $node = $dom->createElement("marker");
	  $newnode = $parnode->appendChild($node);
	  $newnode->setAttribute("id",$row['id']);
	  $newnode->setAttribute("nama",$row['nama']);
	  $newnode->setAttribute("gambar", $row['gambar']);
	  $newnode->setAttribute("deskripsi", $row['deskripsi']);
	  $newnode->setAttribute("lat", $row['lat']);
	  $newnode->setAttribute("lng", $row['lang']);
	}

	echo $dom->saveXML();

?>