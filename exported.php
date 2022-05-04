<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<?php
    include ('header.php');
    require('private/connection.php');

    if (!isset($_POST['delete'])) {
        ?>
        <script type="text/javascript">
               window.location="export.php";
        
        </script>
    <?php
     }
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        ?>
        <div class="container h-100 ">
<div class="row align-items-center h-100">
<div class="col-11 mx-auto">
<div class="jumbotron">
<form class=" rounded" >
    <?php
      if(!empty($_POST['weatherRow'])){
          $delete= mysqli_query($conn,delete($_POST['weatherRow'] ));
          echo "<div  class = 'text-center'>";
          echo "<h5><div> Row was succesfully DELETED</div></h5>";
          echo "<h5><div> Please return to "."<br>"."<a href='index.php'>homepage.com</a>!</div></h5>";
          echo "</div>";
          $displayForm = FALSE;
          mysqli_close($conn);
      }
      else{

        echo "<div  class = 'text-center'>";
        echo "<h5><div> Issue with deleting the row.</h5>";
        echo "<h5><div style='text-align = center'> Please return to "."<br>"."<a href='index.php'>homepage.com</a>!</div></h5>";
        echo "</div>";
      }

echo "WEAHER " .$_POST['weatherRow'] ;
    }
    include ('footer.php');  
    ?>

</body>
</html>