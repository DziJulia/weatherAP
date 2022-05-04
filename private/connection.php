<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <?php
    //THIS VARIABLES WOULD BE CHANGE ACCORDING WHO IS WORKING ON THE PROJECT

              $servername = "localhost:3306";
              $username = "root";
              $password = "Girl94552";
              $dbname = "weather";

          // CREATING CONNECTION
          $conn = new mysqli($servername, $username, $password);
          // CHECKING CONNECTION
          if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          } 
          // CREATING DATABASE
          $sql  = "CREATE DATABASE IF NOT EXISTS  $dbname";

         if ($conn->query($sql) === TRUE) {
              //  echo "Database created successfully";
         } else {
                echo "Error creating database: " . $conn->error;
          }
          //CONNECTING TO DATABASE
        if(mysqli_select_db($conn,$dbname)){
       //      echo "connected";
        }
        else {
          echo "Error connecting to database: " . $conn->error;
        }
        //CREATING A TABLE
        $queryUser = 'CREATE TABLE IF NOT EXISTS userInput(
          id INT NOT NULL AUTO_INCREMENT,
          name VARCHAR(150),
          date VARCHAR(150),
          latitude FLOAT,
          longitude FLOAT,
          PRIMARY KEY (id));';

          // CREATE TABLE API WEATHER INPUTS
        $queryAPI = 'CREATE TABLE IF NOT EXISTS response(
          id int NOT NULL AUTO_INCREMENT,
          datetime DATE,
          conditions VARCHAR(800),
          description VARCHAR(150),
          icon VARCHAR(50),
          sunrise TIME,
          sunset TIME,
          tempmax REAL,
          tempmin REAL,
          dew REAL,
          humidity REAL,
          pressure REAL,
          windspeed REAL,
          visibility REAL,
          userID INT NOT NULL,
          PRIMARY KEY (id),
          FOREIGN KEY  (userID) REFERENCES userInput(id)
          ON DELETE CASCADE ON UPDATE CASCADE);';

          //CHECKING IF THEY GET CREATED
          if ($conn->query($queryUser) === TRUE) {
          //  echo "Table userInput created successfully";
          } else {
            echo "Error creating table: " . $conn->error;
          }
          if ($conn->query($queryAPI) === TRUE) {
          //  echo "Table response created successfully";
          } else {
          echo "Error creating table: " . $conn->error;
          }


          //INSERTING IT TABLE USER INPUT
        if (!function_exists('insertUser(($name,$date,$latitude,$longitude)')){
          function insertUser($name,$date,$latitude,$longitude){
             //create query for adding to data base
            return   "INSERT INTO userInput(name,date,latitude,longitude)  VALUES ('$name','$date','$latitude','$longitude')";
          }
          }
          //INSERTING IT TABLE WEATHER INPUT
        if (!function_exists('insertWeather(($datetime,$conditions,$description,$icon,$sunrise, $sunset,$tempmax,$tempmin,$dew,$humidity, $pressure, $windspeed,$visibility,$userID)')){
          function insertWeather($datetime,$conditions,$description,$icon,$sunrise, $sunset,$tempmax,$tempmin,$dew,$humidity, $pressure, $windspeed,$visibility,$userID){
             //create query for adding to data base
            return   "INSERT INTO response( datetime,conditions,description,icon,sunrise, sunset,tempmax,tempmin,dew,humidity, pressure, windspeed,visibility,userID) VALUES (CONVERT('$datetime', date),'$conditions','$description','$icon',CONVERT('$sunrise',time), CONVERT('$sunset',time),'$tempmax','$tempmin','$dew','$humidity', '$pressure', '$windspeed','$visibility','$userID')";
          }
          }
                    //GET DATA
        if (!function_exists('getWeather())')){
          function getWeather(){
             //create query for adding to data base
            return   "SELECT response.*, name, userInput.latitude, userInput.longitude FROM response
            JOIN userInput ON response.userID = userInput.id ORDER BY response.id DESC" ;
              }
          }

                            //GET DATA STORED row
        if (!function_exists('getRow($index)')){
          function getRow($index){
             //create query for adding to data base
            return   "SELECT response.*, name, userInput.latitude, userInput.longitude FROM response
            JOIN userInput ON response.userID = userInput.id WHERE response.id ='$index';";
              }
          }
          //Delete row
          if (!function_exists('delete($weatherRow)')) {
            function delete($weatherRow){
              return  "DELETE FROM response WHERE id = '$weatherRow' ";
            }
            }
    ?>
</body>
</html>