<?php

$servername= "localhost";
$username= "root";
$password= "";
$dbname="iotlab6";

$con = mysqli_connect($servername,$username,$password,$dbname);

if(!$con){
	echo "Error: " . mysqli_connect_error();
	exit();
}
else echo "Connection Success!";

$Owner=" ";
$Location=" ";
$ID=" ";

if(isset($_GET['ID'])){
$ID=$_GET['ID'];
}

if(isset($_GET['Owner'])){
$Owner=$_GET['Owner'];
}

if(isset($_GET['Location'])){
$Location=$_GET['Location'];
}

$sql_check = "SELECT `ID` FROM `Owners` WHERE `ID` = {$ID}";
$sql_insert  = "INSERT INTO `Owners` (`ID`,`Owner`,`Location`) VALUES ('{$ID}','{$Owner}','{$Location}')";


$id_present_check = mysqli_query($con, $sql_check);

if ($id_present_check) {
	if (mysqli_num_rows($id_present_check) == 1) {
		echo "Data already present\n";
	} else {
		if (mysqli_query($con, $sql_insert )){
			echo "Data inserted successfully\n";
		}
		else {		
			echo "Error! Could not update\n";
		}
	}

} else {
	echo "Could not query database\n";
	exit(1);
}

?>
