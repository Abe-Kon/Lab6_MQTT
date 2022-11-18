<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "iotlab6";

$con = mysqli_connect($servername, $username, $password, $dbname);

if (!$con) {
    echo "Error: " . mysqli_connect_error();
    exit();
};

$Sensor = " ";
$ID = " ";
$SensorReading = " ";

if (isset($_GET['Sensor'])) {
    $Sensor = $_GET['Sensor'];
}
if (isset($_GET['ID'])) {
    $ID = $_GET['ID'];
}

if (isset($_GET['SensorReading'])) {
    $SensorReading = $_GET['SensorReading'];
}

$sql = "INSERT INTO `Readings` (`Sensor`,`ID`,`SensorReading`) VALUE ('{$Sensor}','{$ID}','{$SensorReading}')";


 if (mysqli_query($con, $sql)){
     echo "Database updated successfully";
 }
 else
 echo "Error! Could not update";


?>
