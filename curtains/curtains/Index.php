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


	$sqlLongitude = "SELECT Longitude, Latitude FROM users";
	$Location = $conn -> query($sqlLongitude);




	if($Location->num_rows > 0){
		$row = $Location -> fetch_assoc();
		$Longitude = $row ["Longitude"]; 
		$Latitude = $row ["Latitude"];
		echo "Longitude: ".$Longitude, "Latitude".$Latitude;
	} 
	else {
		echo "empty";
	}

	
	$jsondata = file_get_contents('https://api.sunrise-sunset.org/json?lat='.$Latitude.'&lng='.$Longitude.'%date = today&formatted = 0');
	$obj = json_decode($jsondata);
	$data = $obj ->results;
	echo "\n";
	echo $data -> sunrise;
	
	$conn -> close();
?>