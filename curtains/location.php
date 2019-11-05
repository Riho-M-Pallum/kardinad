<?php 
    require_once('connect.php');
    session_start();
    $lat = "";
    $lng = "";  
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $lat = trim($_POST["lat"]);    
        $lng = trim($_POST["lng"]);        
        if (!empty($lng) && !empty($lat)){

            $sql = "UPDATE users SET Longitude = ?, Latitude = ? WHERE User_ID = $_SESSION[id]";
            if($stmt = $conn ->prepare($sql)){
                $stmt ->bind_param("dd", $param_lng, $param_lat);
                $param_lat = $lat;
                $param_lng = $lng;
                if ($stmt -> execute()){
                    header("location: suntimes.php");
                }else{
                    echo "Something went wrong. Try again.";
                }
            }
            $stmt->close();
        }
        $conn->close();
    }
 ?>
<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
            #map{ width:700px; height: 500px; }
            .wrapper{ width: 700px; padding: 20px; width: 500px; margin: auto;}
        </style>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
        <title>Save Marker Example</title>
    </head>
    <body>
        <div class = "wrapper">
            <h1>Select a location!</h1>
            <p>Click on a location on the map to select it. Drag the marker to change location.</p>
            
            <!--map div-->
            <div id="map"></div>
                
            <!--our form-->
            <h2>Chosen Location</h2>
            <form action ="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">  
                <div class = "form-group <?php echo (!empty($lat_err)) ? 'has-error' : '' ; ?>">
                    <label> Latitude: </label>
                    <input type="text" name="lat" id ="lat" readonly="yes" class ="form-control" value="<?php echo $lat; ?>"><br>
                </div>
                <div class = "form-group <?php echo (!empty($lng_err)) ? 'has-error' : '' ; ?>">
                    <label> Longitude: </label>
                    <input type="text" name="lng" id="lng" readonly="yes" class ="form-control" value="<?php echo $lng; ?>">
                </div>
                <div>
                    <input type ="submit" class ="btn btn-primary" value ="Submit">
                </div>
            </form>
            <script type="text/javascript" src="map.js"></script>
            <p>
                <a href="welcome.php" class="btn btn-seconday">Go back</a>
            </p>
        </div>
    </body>
</html>