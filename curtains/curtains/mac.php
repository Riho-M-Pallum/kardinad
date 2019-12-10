<?php
	require_once('connect.php');//get connection
    session_start();	//start session
    $address =$address_err="";//create address and it's error variables
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
    	if(empty(trim($_POST["address"]))){    //if is empty
        	$address_err = "Please enter your arduino ID.";
       	}else{
       		$address = trim($_POST["address"]);
       	}


       	if(empty($address_err)){
       		//prepare insert statement
       		$sql = "UPDATE users SET Arduino_IP = ? WHERE User_ID = $_SESSION[id]";

       		if($stmt = $conn->prepare($sql)){
       			//bind variables into prepared statement
       			$stmt->bind_param("s",$param_address);
       			//Set variables
       			$param_address = $address;
       			if($stmt->execute()){
       				header("location: welcome.php");
       			}
       			else {
       				echo"Something went wrong please try again";
       			}
       		}
       		$stmt->close();
       	}
       	$conn->close();
    }


    
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-32">
    <title>Connect Arduino</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center;}
        .wrapper{ width: 350px; padding: 20px 100px; width: 500px; margin: auto;}
    </style>
</head>
<body>
	<div class="wrapper">
		<h1>Connect your Arduino</h1>
		<p>Enter the code that came with your arduino in this form</p>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<div class = "form-group <?php echo (!empty($address_err)) ? 'has-error' : '' ; ?>">
				<label>Address:</label>
				<input type="text" name="address" class="form-control" value="<?php echo $address; ?>">
			</div>
			<div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <a href="welcome.php">Go back</a>
		</form>
	</div>
</body>
</html>