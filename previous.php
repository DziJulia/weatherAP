<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    <?php include 'css/previous.css'; ?>

    </style>
</head>
<body>
         <!---INCLUDING HEADER -->
<?php
    include ('header.php');
    require('private/connection.php');
    ?>
         <?php
     $sql = mysqli_query($conn,getWeather());
     if(!$sql){
        die(mysqli_error($conn));
    }
        ?>
	<h1 class = "down text-center">Previous weather list</h1>
     <!---INCLUDING FOOTER -->
     <table class="table table-striped table-responsive table-bordered">
		<tr><th>Weather ID</th><th>Location</th><th>Date</th><th>Conditions</th><th>Description</th><th>Icon</th><th>Sunrise</th><th>Sunset</th><th>Temp max</th><th>Temp min</th><th>Dew</th><th>Humidity</th><th>Pressure</th><th>Windspeed</th><th>Visibility</th></tr>
	   
    <?php 
    
           while ($row = mysqli_fetch_assoc($sql)) { 
            
        ?>
        <tr class="smaller">
               <td><?php echo $row['id']; ?></td>
              <?php  if(empty($row['name'])){
                  ?>
                <td><?php echo $row['latitude']." - ".$row['longitude']; ?></td>
                <?php
              }else{
                  ?>
                <td><?php echo $row['name']; ?></td>
                <?php } ?>
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
  //echo $date;
			
  
		?>
        	</table>

        <?php
 include ('footer.php');  
            ?>

</body>
</html>