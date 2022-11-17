<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "WTL";

$con = mysqli_connect($servername, $username, $password, $dbname);

if (!$con) {
    echo "Error: " . mysqli_connect_error();
    exit();
};

$TankID = " ";
$Reading = " ";

if (isset($_GET['ReadingID'])) {
    $TankID = $_GET['TankID'];
}

if (isset($_GET['SensorReading'])) {
    $Reading = $_GET['SensorReading'];
}

$sql = "INSERT INTO `Readings` (`ReadingID`,`SensorReading`) VALUE ('{$SensorID}','{$SensorReading}')";


 if (mysqli_query($con, $sql)){
     echo "Database updated successfully";
 }
 else
 echo "Error! Could not update";


?>
