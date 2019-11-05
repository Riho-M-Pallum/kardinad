<?php
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "kardinad";

	// creating a connection using the mysqli library
	$conn = new mysqli($servername, $username, $password, $dbname);
	//check connection 
	if($conn -> connect_error){
		die ("connection failed: " .$conn ->connect_error);
	}
?>