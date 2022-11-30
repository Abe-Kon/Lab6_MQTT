<?php 
	define("SERVERNAME","localhost");
	define("USERNAME","root");
	define("PASSWORD","");
	define("DATABASE","aok");

      //create conncetion 

      $conn = mysqli_connect(SERVERNAME,USERNAME,PASSWORD,DATABASE);

      //check connection
      if(mysqli_connect_errno()){
          die("Connection failed" . mysqli_connect_error()); 
      }
      else{
          //echo "Connection successful.";
          //var_dump(mysqli_connect(SERVERNAME,USERNAME,PASSWORD,DATABASE));
      }
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TemHumLAb6</title>
    <style>
        body {
            font-family: Arial;
            text-align: center
        }

       
        /* .btn {
            display: block;
            width: 280px;
            margin: auto;
            padding: 30px
        } */

        /* .btn {
            font-size: 30px;
            color: black;
            text-decoration: none
        } */
        
        .on {
            background-color: SkyBlue
        }

        .off {
            background-color: LightSteelBlue
        }

        .zero {
            background-color: Thistle
        }
        .center 
        {
            margin-left: auto;
            margin-right: auto;
        }

        .alert {
            padding: 20px;
            font-size: 20px;
            background-color: blue; /* Red */
            color: white;
            margin-bottom: 15px;
        }
       
        body {
        background-color:#FFFFFF;
       }
        th,td {
            font-size: 20px;
            margin-top: 50px;
            margin-bottom: 5px;
            padding-top: 10px;
            padding-bottom: 20px;
            padding-left: 30px;
            padding-right: 40px;
            border-color: #FFFFFF;
        }    

        p {
            font-size: 30px;
            margin-top: 50px;
            margin-bottom: 5px
        }
    </style>
</head>
<body>
    <h1 style="background-color:DodgerBlue;">HUMIDITY AND TEMPERATURE DASHBOARD</h1>
   
    <form method="POST" action="">
        
        <input type="text" name="esp32ID" ID="32ID" placeholder="Enter ID (1 or 2)">
        <br><br>
        <input type="submit" name="displayTemp" id="displayTEMP" value="Temp">
        <input type="submit" name="selectHumidity" id="selectHUM" value="Humidity">
    </form>
   

</body>

    <?php 
        if(isset($_POST['displayTemp'])){
            //echo "yes";

            //get user input 
            $get_id=$_POST['esp32ID'];
            //echo "$get_id";

           //**define sql query */
            $selectsql = "SELECT Temperature FROM sensereads 
            WHERE ID='$get_id'
            ORDER BY Time DESC
            LIMIT 5
            ";
            //echo $selectsql;

            //** run sql query */
            $result = mysqli_query($conn, $selectsql);
            //var_dump($result);

            //**collect result from database */
            //$row = mysqli_fetch_assoc($result);

            //**to show the fetched data on your page */
            //echo($row['temp']);

             while($row = mysqli_fetch_assoc($result)){ 
                $temps[] = $row['Temperature'];
             }

            foreach($temps as $x){
                echo($x);
                echo "<br>";
            }
            
        }

        if(isset($_POST['selectHumidity'])){
            //echo "yes";
            $get_id=$_POST['esp32ID'];
            //echo "$get_id";
            $selectsql = "SELECT Humidity FROM sensereads
            WHERE ID='$get_id'
            ORDER BY Time DESC
            LIMIT 5
            ";
            //echo $selectsql;
            $result = mysqli_query($conn, $selectsql);
            //var_dump($result);
           
            while($row = mysqli_fetch_assoc($result)){ 
                $hums[] = $row['Humidity'];
            }

            foreach($hums as $y){
                echo($y);
                echo "<br>";
            }
          
        }
    ?>
</html>



