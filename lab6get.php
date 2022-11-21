<?php


    $servername= "localhost";
    $username="root";
    $password="";
    $dbname = "iotlab6";
    $con = mysqli_connect($servername,$username,$password,$dbname);


    if (!isset($_GET['ID'])) 
        die(" ID not specified");
    if ($_GET['ID']=='')
        die(" ID is blank");
    if (!is_numeric($_GET['ID'] ) )
        die(" ID is not numeric");
    if ($_GET['ID']>'2'||$_GET['ID']<'1')
        die(" ID does not exist");
    
    $data=array();        

    $q=mysqli_query($con,"select SensorReadings from Readings where ID={$_GET['ID']} AND Sensor={$GET['Sensor']} order by level DESC LIMIT 5");  

    $row=mysqli_fetch_object($q); 


    echo "
      <table align='center' width='70%'>;
            <tr bgcolor='#C27BA0'>
                <th><font color='#FFFFFF'>Sensor Readings</th>
            </tr>
    ";
    while ($row)
    {         
        echo "
        <tr bgcolor='#C27BA0'><font color='#FFFFFF'>
                    <td><font color='#FFFFFF'>{$row->SensorReadings}</td>
        </tr>

        ";
        $row=mysqli_fetch_object($q);
    } 
    echo "</table>";     
    


?>