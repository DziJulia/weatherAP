<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    <?php include 'css/stored.css'; ?>
    </style>
</head>
<body>
             <!---INCLUDING HEADER -->
<?php
    include ('header.php');
    require('private/connection.php');
    $indexErr=$index = "";
    $display = True;
    if($_SERVER["REQUEST_METHOD"] == "POST"){
 
                //method to clean data
                function clean_data($data){
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = strip_tags($data);
                    $data = htmlentities($data);
                    $data = htmlspecialchars($data);
                }

                $index= clean_data($_POST['weatherID']);

                if(isset($_POST['weatherID'])){

                    $index= $_POST["weatherID"];

                 if(!preg_match("/^[0-9]+$/",$index)) {
              //       echo "HERE";
                    $indexErr="* Numbers only!";
                }
            }
                if(empty($_POST['weatherID'])){
                    $indexErr="* Enter index!";
                }
        //if empty good to go with searching index also need to check if its in database
                if(empty($indexErr)){
                    $select = mysqli_query($conn, getRow($index));
                    if(!$select){
                        die(mysqli_error($conn));
                    }
                    $count = mysqli_num_rows($select);
                    if($count > 0)  {
                    $display = False;
                    ?>
                    <h1 class = "down text-center">Previous weather list</h1>
                     <!---INCLUDING FOOTER -->
                     <table class="table table-striped table-responsive table-bordered">
                        <tr><th>ID</th><th>Location</th><th>Weather ID</th><th>Date</th><th>Conditions</th><th>Description</th><th>Icon</th><th>Sunrise</th><th>Sunset</th><th>Temp max</th><th>Temp min</th><th>Dew</th><th>Humidity</th><th>Pressure</th><th>Windspeed</th><th>Visibility</th></tr>
                        <?php 
    
                            while($row = mysqli_fetch_assoc($select)) {
                                ?>
                                <tr class="smaller">
                                        <td><?php echo $row['userID']; ?></td>
                                      <?php  if(empty($row['name'])){
                                          ?>
                                        <td><?php echo $row['latitude']." - ".$row['longitude']; ?></td>
                                        <?php
                                      }else{
                                          ?>
                                        <td><?php echo $row['name']; ?></td>
                                        <?php } ?>
                                        <td><?php echo $row['id']; ?></td>
                                        <td><?php echo $row['datetime']; ?></td>
                                        <td><?php echo $row['conditions']; ?></td>
                                        <td><?php echo $row['description']; ?></td>
                                        <td><img src="img/icon/iconColor/<?php echo $row['icon'];?>.png" alt="icon"></td>
                                        <td><?php echo $row['sunrise']; ?></td>
                                        <td><?php echo $row['sunset'] ?></td>
                                        <td><?php echo $row['tempmax']; ?></td>
                                        <td><?php echo $row['tempmin']; ?></td>
                                        <td><?php echo $row['dew'];?></td>
                                        <td><?php echo $row['humidity']; ?></td>
                                        <td><?php echo $row['pressure'];?></td>
                                        <td><?php echo $row['windspeed']; ?></td>
                                        <td><?php echo $row['visibility'];?></td>
                        
                                    </tr>
                                <?php

                       }
                       ?>
                       	</table>
                       <?php
                    }
                    else{
                        $indexErr="* Index not found!"  ;
                    }
                }

}
                        if($display){

                        include ('searchForm.php');  

                        }
 include ('footer.php');  
            ?>

<script>
        //function for errors to dissaper after the element is enterd OR REAPER WHEN WE UNSELECT
   function displayDivDemo(id, elementValue) {
      document.getElementById(id).style.display = elementValue.value == "" ? 'block' : 'none';
   }

    </script>
</body>
</html>