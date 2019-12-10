<?php
	require_once('connect.php');	//import the connection file
	session_start();				//start the session

	$sunrise = $sunset ="";			//initialsie sunset and sunrise variables
	$longitude = $latitude ="";		//initialise the longitude and latitude variables

	$sqllocation = "SELECT Longitude, Latitude FROM users WHERE User_ID = $_SESSION[id]";	//prepare a select statement to get longitude and latitude from the database users where User_ID is the current session id
	$Location = $conn -> query($sqllocation);	//get kication

	if($Location->num_rows > 0){				
		$row = $Location -> fetch_assoc();
		$Longitude = $row ["Longitude"]; 
		$Latitude = $row ["Latitude"];
	} 
	else {
		$Longitude = $row ["Longitude"]; 
		$Latitude = $row ["Latitude"];
	}
	$jsondata = file_get_contents('https://api.sunrise-sunset.org/json?lat='.$Latitude.'&lng='.$Longitude.'%date = today&formatted = 0'); //send a query to suntimes database using the location of current user
	$obj = json_decode($jsondata); //convert from json into object
	$data = $obj ->results;		  	
	
	$sunrise = $data -> sunrise;  	//get parametre sunrise of object 
	$sunset = $data -> sunset;		//get parametre sunset of object
	
	$sqlinsert = "UPDATE users SET Sunrise = ?, Sunset = ? WHERE User_ID = $_SESSION[id]";	//prepare an insert statement

	if($stmt = $conn-> prepare($sqlinsert)){	//if the connection works
		$stmt ->bind_param("ss", $param_sunrise, $param_sunset);	//prepare statement
		$param_sunrise = $sunrise;	//set parametres equal to the values from the query
		$param_sunset = $sunset;	// re
		if($stmt ->execute()){	//if it executes then go to the welcome screen
			header("location: welcome.php");
		}
		else{	//if it doesn't then let the user set their location
			header("location: location.php");
		}
	}
	else{	//if the connection doesn't work go to the location screen
		$conn->close();
		header("location: location.php");
	}
	$stmt->close();	//close statement
	$conn->close(); //close connection

?>
