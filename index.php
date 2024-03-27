<?php
	function extractParam($pathSegments, $pathIndex, $query_params, $query_param) {
	  if (count($pathSegments)>$pathIndex) return trim(urldecode($pathSegments[$pathIndex]));
	  if ($query_params[$query_param]!=null) return trim(urldecode($query_params[$query_param]));
	  return null;
	}

	$segments = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));
	$query_str = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
	parse_str($query_str, $query_params);
	$location=extractParam($segments,1, $query_params, "location");
	$unitGroup=extractParam($segments,2, $query_params, "unitGroup");
	//$startDateTime=extractParam($segments,3, $query_params, "fromdate");
	
//	$endDateTime=extractParam($segments,4, $query_params, "todate");
	$aggregateHours=24;
	$apiKey="";


  function isValidLongitude($longitude){
    if(preg_match("/^-?([1]?[1-7][1-9]|[1]?[1-8][0]|[1-9]?[0-9])\.{1}\d{1,6}$/",
      $longitude)) {
       return true;
    } else {
       return false;
    }
  }
  function isValidLatitude($latitude){
    if (preg_match("/^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}$/", $latitude)) {
        return true;
    } else {
        return false;
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    <?php include 'css/index.css'; ?>
    </style>
</head>
<body>
    <?php
    include ('header.php');
    // REQUIRE connection.php
       require('private/connection.php');
       $displayForm=True;
       $locationErr=$longtitudeErr=$dateErr=$latitudenErr="";
       $errors = array();
       $unitGroup="metric";
       $latitude="";
       $longtitude="";
       $location=$date=$date1="";

 if($_SERVER["REQUEST_METHOD"] == "POST"){
         //method to clean data
         function clean_data($data){
          $data = trim($data);
          $data = stripslashes($data);
          $data = strip_tags($data);
          $data = htmlentities($data);
          $data = htmlspecialchars($data);
      }
      $latitude= clean_data($_POST['latitude']);
      $longtitude= clean_data($_POST['longtitude']);
      $location= clean_data($_POST['location']);
      $date= clean_data($_POST['day1']);
      $date1=clean_data($_POST['day2']);

                //getting intputs of the parrent need variables checked
                // 1 LOCATION

                if(isset($_POST["location"])){
                  $location= $_POST["location"];
                  //checking  if its only letters
              if (!preg_match("/^[a-zA-Z-' ]*$/", $location)) {
              $locationErr = "* Only letters and white space allowed";
              $errors[] = $locationErr;
              }
               }
               if(empty($_POST["location"])){
            
            
                   // 2 LATITUDE AND LONGTITUDE
                   if(isset($_POST["latitude"])){
                    $latitude= $_POST["latitude"];
                    if(!strpos( $latitude,'.')){
                      $latitude .= ".0";
                    }
                    //checking  if its only letters
                   //checking  if its only numbers and dot
                    if(!isValidLatitude($latitude)) {
                $latitudenErr = "* Not valid latitude!";
                $errors[] = $latitudenErr;
                }
                 }
                 if(empty($_POST["latitude"])){
                  $latitudenErr= "* Please write latitude";
                    $errors[] = $latitudenErr;
                 }
                 if(isset($_POST["longtitude"])){
                  $longtitude= $_POST["longtitude"];
                  if(!strpos( $longtitude,'.')){
                    $longtitude .= ".0";
                  }
                         //checking  if its only numbers and dot
                  if(!isValidLongitude($longtitude)){
                    $longtitudeErr = "* Not valid longtitude";
                    $errors[] = $longtitudeErr;
                    }
                 }
            
                 if(empty($_POST["longtitude"])){
                  $longtitudeErr= "* Please write longtitude";
                    $errors[] = $longtitudeErr;
                 }
                 if(empty($_POST["longtitude"] && $_POST['latitude'])){
                 $locationErr= "* Please write adress or partial address";
                 $errors[] = $locationErr;
                }
               }
                 if(isset($_POST["day1"])){
                  $day1= $_POST["day1"];
                 }
 /*              DAte is optional it doesn't have to be selected
                if(empty($_POST["day1"])){
                  $dateErr= "* Please select date";
                    $errors[] = $dateErr;
                 }*/
                 if(isset($_POST["day2"])){
                  $day2= $_POST["day2"];
                 }
                 if(empty($_POST["day2"])){
                  $day2= $_POST["day1"];
                 }
     if(count($errors)==0)
                 {
  $displayForm = false;
//getting API and inserting it to database
// 48.167%2C7.117
if(!empty($_POST["location"])){
  if(empty($_POST["day1"])){
    //if not date selected selected date is today
    $url="https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/{$location}/today?&unitGroup={$unitGroup}&include=current&key={$apiKey}&contentType=json";
  }
  else{
  $url="https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/{$location}/{$day1}/{$day2}?&unitGroup={$unitGroup}&include=days&key={$apiKey}&contentType=json";
  }
}
else if(!empty($_POST["latitude"] && $_POST["longtitude"])){
  if(empty($_POST["day1"])){
    $url="https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/{$latitude}%2C{$longtitude}/today?&unitGroup={$unitGroup}&include=current&key={$apiKey}&contentType=json";
  }
  else{
    $url="https://weather.visualcrossing.com/VisualCrossingWebServices/rest/services/timeline/{$latitude}%2C{$longtitude}/{$day1}/{$day2}?&unitGroup={$unitGroup}&include=days&key={$apiKey}&contentType=json";
   }
}
              $json = file_get_contents($url);
              $response_data = json_decode($json,true);

              $days=array();
      
              $locationInstance=$response_data['address'];
              $days = $response_data['days'];
        //    echo  $days;
   //           $values=$locationInstance->values;

       //     echo json_encode($json);
   //    echo "HERE";
   //         var_dump($response_data['days']);
       

       //     creating mini arrays with all values   
               $datetime = array_column($days, 'datetime');
               $conditions = array_column($days, 'conditions');
               $description = array_column($days, 'description');
               $icon = array_column($days, 'icon');
               $sunrise = array_column($days, 'sunrise');
               $sunset = array_column($days, 'sunset');
               $tempmax = array_column($days, 'tempmax');
               $tempmin = array_column($days, 'tempmin');
               $dew = array_column($days, 'dew');
               $humidity = array_column($days, 'humidity');
               $pressure= array_column($days, 'pressure');
               $windspeed = array_column($days, 'windspeed');
               $visibility = array_column($days, 'visibility');
    //        PUTTING VALUES TO MY DATABASE
  // echo $day2;
            if(empty($day1)){
              $day1 = $day2= date("Y-m-d");
            }
            $date = $day1. " - " . $day2;
    
            $queryUser = insertUser($location,$date,floatval($latitude),floatval($longtitude));
            if(mysqli_query($conn, $queryUser)){
              $user_id = $conn->insert_id;
              for ($x = 0; $x < count($days); $x++) {
              $queryUser = insertWeather($datetime[$x],$conditions[$x],$description[$x],$icon[$x],$sunrise[$x], $sunset[$x],(real)$tempmax[$x],(real)$tempmin[$x],(real)$dew[$x],(real)$humidity[$x], (real)$pressure[$x], (real)$windspeed[$x],(real)$visibility[$x], $user_id );
              
              if(mysqli_query($conn,$queryUser)){
              //    echo "SUCCES";
              }
              else {
                echo "Error: " . $query . "<br>" . mysqli_error($conn);
              }
            }
          }else {
                   echo "Error: " . $query . "<br>" . mysqli_error($conn);
              }
           

           
	?>
	<!-- Create the HTML for the weather forecast data -->
	<h1 class = "down text-center">Weather Forecast for <?php echo $locationInstance; ?></h1>
	<table class="table table-striped table-responsive table-bordered">
		<tr><th>Date</th><th>Conditions</th><th>Description</th><th>Icon</th><th>Sunrise</th><th>Sunset</th><th>Temp max</th><th>Temp min</th><th>Dew</th><th>Humidity</th><th>Pressure</th><th>Windspeed</th><th>Visibility</th></tr>
		<?php 
			  for ($x = 0; $x < count($days); $x++) {
		?>
			<tr class="smaller">
				<td><?php echo $datetime[$x]; ?></td>
				<td><?php echo $conditions[$x]; ?></td>
				<td><?php echo $description[$x] ; ?></td>
				<td><img src="img/icon/iconColor/<?php echo $icon[$x];?>.png" alt="icon"></td>
				<td><?php echo $sunrise[$x]; ?></td>
				<td><?php echo $sunset[$x]; ?></td>
				<td><?php echo $tempmax[$x]; ?></td>
        <td><?php echo $tempmin[$x]; ?></td>
        <td><?php echo $dew[$x]; ?></td>
        <td><?php echo $humidity[$x]; ?></td>
        <td><?php echo $pressure[$x]; ?></td>
        <td><?php echo $windspeed[$x]; ?></td>
        <td><?php echo $visibility[$x]; ?></td>

			</tr>
		<?php
  //echo $date;
			}

		?>
	</table>

  <?php
 }
}
 if ( $displayForm){
  ?>
  <!---FORM -->
     <!---BOOTSTRAP FOR FORM-->   
  <div class="container h-100 ">
        <div class="row align-items-center h-100 " style="margin-top: 90px">
            <div class="col-11 mx-auto">
                <div class="jumbotron">
                <form action="index.php" method="POST" class="rounded" novalidate>
                    <!---User wants to be able to input Name, Latitude, Longitude, Specific Date -->
                    <h3 class="text-center">Search weather</h3>
                      <!---USING BOOTSRAP GRID -->
                    <div class="row">
                      <div class="col-sm-7 col-md-6">
                            <!--- OPTIONS FOR LOCATION--> 
                            <h6><label for="date">Please select location:
                            <br>
                        <!--- ERROR MESSAGE IF THE OPTION IS NOT SELECTED -->
                        <span class="error" id="errLocation"> <?php echo $locationErr;?></span>
                        </label></h6>
                        <input type="text" id="location" name="location"  class="form-control" onchange="displayDivDemo('errLocation', this)" value="<?php if(isset($_POST['location'])) echo $location;?>"  required >
  
                      </div>
                      <br>
                      <div class="col-sm-7 col-md-6">
                        <!--- OPTIONS TO SELECT  YEAR OF BIRTH-->
                        <h6 ><label for="date">Date :
                              <br>
                            <!--- ERROR MESSAGE IF THE OPTION IS NOT SELECTED -->
                            <span class="error" id="errDate"> <?php echo $dateErr;?></span>
                            </label></h6>
                            <!--- MINIMU DATE IS CURRENT DATE AND AVAILABLE ONLY FOR A WEEK-->
                            <input type="date" name="day1" min="<?=date('Y-m-d');?>" max="<?=date('Y-m-d',strtotime('now +1 week'));?>"  class="form-control" onchange="displayDivDemo('errDate', this)">
    
                            <div class="text-center">
                              
                            <button type="button"  data-toggle="collapse" data-target="#date" class="btn border" aria-expanded="false" aria-controls="date"><i class="fa fa-plus"></i></button>
                            </div>
                            <div id="date" class="collapse panel-collapse">
                            <h6 ><label for="date">Date to:
                            <!--- ERROR MESSAGE IF THE OPTION IS NOT SELECTED -->
                            <span class="error" id="errDate2"> <?php echo $dateErr;?></span>
                            </label></h6>
                            <!--- MINIMU DATE IS CURRENT DATE AND AVAILABLE ONLY FOR A WEEK-->
                            <input type="date" name="day2" min="<?=date('Y-m-d');?>" max="<?=date('Y-m-d',strtotime('now +1 week'));?>"  class="form-control" onchange="displayDivDemo('errDate', this)">
                            </div>
                          </div>
                            </div>
                            <br>
                          <div class="row">
                          <div class="col-sm-7 col-md-6">
                            <!--- OPTIONS FOR LOCATION-->
                            <h6><label for="date">Please select Latitude:
                            <br>
                        <!--- ERROR MESSAGE IF THE OPTION IS NOT SELECTED -->
                        <span class="error" id="errLatitude"> <?php echo $latitudenErr;?></span>
                        </label></h6>
                        <!--- if adress is not selected i have to select latitude and latitude-->
                        <input type="text" id="latitude" name="latitude"  class="form-control" onchange="displayDivDemo('errLatitude', this)" value="<?php if(isset($_POST['latitude'])) echo $latitude;?>"  required >
                      </div>
                      <div class="col-sm-7 col-md-6">
                            <!--- OPTIONS FOR LOCATION-->
                            <h6><label for="date">Please select Longtitude:
                            <br>
                        <!--- ERROR MESSAGE IF THE OPTION IS NOT SELECTED -->
                        <span class="error" id="errLongtitude"> <?php echo $longtitudeErr;?></span>
                        </label></h6>
                        <!--- if adress is not selected i have to select latitude and longtitude-->
                        <input type="text" id="longtitude" name="longtitude"  class="form-control" onchange="displayDivDemo('errLongtitude', this)" value="<?php if(isset($_POST['longtitude'])) echo $longtitude;?>"  required >
  
                      </div>

                    </div>
                      <!-- button sumbision-->
                      <br>
                        <div class="row d-flex align-items-end flex-column ">
                                <button id = "button" class="btn btn-lg" type="submit" ><span class="fas fa-search-plus"></span> Search&add</button> 
                            </div>
                            <!---END OF FORM -->
                </form>
                  <!---END OF DIVS -->
                 </div>
            </div>
        </div>
    </div>
  <!---INCLUDING FOOTER -->
        <?php
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
