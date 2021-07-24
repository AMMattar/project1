<?php 

   require 'connectionDB.php';
   require 'loginCheck.php';

   # Clean input ...
   function CleanInputs($input){

    $input = trim($input);
    $input = stripcslashes($input);
    $input = htmlspecialchars($input);

    return $input;
  }

    $errorMessages = array();
    if($_SERVER['REQUEST_METHOD'] == "POST" ){

       $name  = CleanInputs($_POST['name']);
       $sector = CleanInputs($_POST['sector']);

        // Name Validation ...
        if(!empty($name)){
          // code ... 
           if(strlen($name) < 3){
              $errorMessages['name'] = "Name Length must be > 2 "; 
             }
        }else{
          $errorMessages['name'] = "Required";
        }


        // Email Validation ... 
        if(empty($sector)){
           // code ... 
            $errorMessages['sector'] = "Required";
        }
     if(count($errorMessages) == 0){

          $sql = "insert into courses (name,id_sector) values ('$name','$sector')";

          $op =  mysqli_query($con,$sql);

          //mysqli_error($con);

       if($op){
         echo 'Data Inserted';
       }else{
         echo 'Error Try Again';
       }



     }else{

     // print error messages 
     foreach($errorMessages as $key => $value){

        echo '* '.$key.' : '.$value.'<br>';
     }





     }


    }





?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Add Courses</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Add Course</h2>
  <form  method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"  enctype ="multipart/form-data">
 
  <div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input type="text"  name="name" class="form-control" id="exampleInputName" aria-describedby="" placeholder="Enter Name">
  </div>


  <div class="form-group">
    <label for="exampleInputEmail1">Sector</label>
    <input type="text" name="sector" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
  </div>  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<button><a href="index_admin.php">Go back</a></button>
</div>

</body>
</html>





