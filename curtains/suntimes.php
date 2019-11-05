<?php
	require_once('connect.php');
	session_start();

	$sunrise = $sunset ="";
	$longitude = $latitude ="";

	$sqllocation = "SELECT Longitude, Latitude FROM users WHERE User_ID = $_SESSION[id]";
	$Location = $conn -> query($sqllocation);

	if($Location->num_rows > 0){
		$row = $Location -> fetch_assoc();
		$Longitude = $row ["Longitude"]; 
		$Latitude = $row ["Latitude"];
	} 
	else {
		$Longitude = $row ["Longitude"]; 
		$Latitude = $row ["Latitude"];
	}
	$jsondata = file_get_contents('https://api.sunrise-sunset.org/json?lat='.$Latitude.'&lng='.$Longitude.'%date = today&formatted = 0');
	$obj = json_decode($jsondata);
	$data = $obj ->results;
	
	$sunrise = $data -> sunrise;
	$sunset = $data -> sunset;

	$sqlinsert = "UPDATE users SET Sunrise = ?, Sunset = ? WHERE User_ID = $_SESSION[id]";

	if($stmt = $conn-> prepare($sqlinsert)){
		$stmt ->bind_param("ss", $param_sunrise, $param_sunset);
		$param_sunrise = $sunrise;
		$param_sunset = $sunset;
		if($stmt ->execute()){
			header("location: welcome.php");
		}
		else{
			header("location: location.php");
		}
	}
	else{
		$conn->close();
		header("location: location.php");
	}
	$stmt->close();
	$conn->close();

?>
