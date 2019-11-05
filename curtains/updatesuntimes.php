<?php

	require_once('connect.php');
	session_start();

	$sunrise = $sunset ="";
	$longitude = $latitude ="";
	//get the largest user id
	$findmax = "SELECT max(User_ID) FROM users";
	$result = $conn->query($findmax);
	$resmax = $result ->fetch_assoc();
	$max = intval($resmax["max(User_ID)"]);
	echo var_dump($max);
	//get the smallest user id
	$findmin = "SELECT min(User_ID) FROM users";
	$result = $conn->query($findmin);
	$resmin =$result->fetch_assoc();
	$min = intval($resmin["min(User_ID)"]);
	//update all user id's between largest and smallest
	for ($i = $min; $i<=$max; $i++ ){
		$sqllocation = "SELECT Longitude, Latitude FROM users WHERE User_ID = $i";
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
		$sqlinsert = "UPDATE users SET Sunrise = ?, Sunset = ? WHERE User_ID = $i";

		if($stmt = $conn-> prepare($sqlinsert)){
			$stmt ->bind_param("ss", $param_sunrise, $param_sunset);
			$param_sunrise = $sunrise;
			$param_sunset = $sunset;
			if($stmt ->execute()){
				//(header("location: welcome.php");
				echo "worked";
			}
			else{
				//header("location: location.php");
				echo "didn't";
			}
		}
		else{
			$conn->close();
			header("location: location.php");
		}
		$stmt->close();
	}
	$conn->close();
	//run timed js functions in html
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<p id="demo"></p>
	<script type="text/javascript">
	var timer = setInterval(update,86400000);
	function update(){
		alert("<?php header("loaction: updatesuntimes.php") ;?>");
	}
	</script>
</body>
</html>