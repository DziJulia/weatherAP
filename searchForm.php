 
 <?php
 $page = basename($_SERVER['SCRIPT_FILENAME']);

 ?>
 <!---FORM -->
     <!---BOOTSTRAP FOR FORM-->   
     <div class="container h-100 ">
        <div class="row align-items-center h-100 " style="margin-top: 90px">
            <div class="col-11 mx-auto">
                <div class="jumbotron">
                <form action="<?php $page ?>" method="POST" class="rounded" novalidate>
                <h3 class="text-center">Search data by index</h3>
                <div class="row">
                            <!--- OPTIONS FOR LOCATION--> 
                            <h6><label for="date">Please select index:
                            <br>
                        <!--- ERROR MESSAGE IF THE OPTION IS NOT SELECTED -->
                        <span class="error" id="errIndex"> <?php echo $indexErr;?></span>
                        </label></h6>
                        <input type="text" id="weatherID" name="weatherID"  class="form-control" onchange="displayDivDemo('errLocation', this)" value="<?php if(isset($_POST['weatherID'])) echo $index;?>"  required >
  
                      </div>
                      <!-- button sumbision-->
                      <br>
                        <div class="row d-flex align-items-end flex-column ">
                                <button id = "button" class="btn btn-lg" type="submit" ><span class="fas fa-search"></span> Search</button> 
                            </div>
                            <!---END OF FORM -->
                </form>

                                     <!---END OF DIVS -->
                 </div>
            </div>
        </div>
    </div>
