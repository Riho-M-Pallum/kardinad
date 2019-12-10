<?php
	require_once('connect.php');//get connection
    session_start();	//start session

	$json_array = array();

    $sqlSuntimes = "SELECT Sunrise, Sunset FROM users WHERE Arduino_ID = ?";
    
	
	if($stmt = $conn->prepare($sql)){

		$stmt->bind_param("s",$param_Arduino_ID);

		$param_Arduino_ID //somehow get arduino's mac address
		if ($Suntimes ->num_rows > 0){
	    	$row = $Suntimes->fetch_assoc();
	    	$json_array[] = $row;
	    	
	    }   	
	}
    
    echo json_encode($json_array);	//convert into json string so it can be echoed and is readable
    $conn->close();
?>