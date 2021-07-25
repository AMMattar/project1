<?php
require 'connectionDB.php';
require 'loginCheck.php';

$sql2 = 'select * from coursestypes';
$op2 = mysqli_query($con,$sql2);


$id = $_GET['id'];
$id = filter_var($id,FILTER_SANITIZE_NUMBER_INT);

$message = '';
if(!filter_var($id, FILTER_VALIDATE_INT)){
    $_SESSION['message'] = "Invalid Id";
    header("Location: index_admin.php");
}

// cleaning input data
function cleaning($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$errorMessages = array();

if($_SERVER['REQUEST_METHOD'] == "POST"){

    // if empty and validation 

    $name = cleaning($_POST['name']);
    if(empty($name)){
        $errorMessages['name']='please enter your name';
    }
    $sector = cleaning($_POST['sector']);
    if(empty($sector)){
        $errorMessages['sector']='content can\'t be empty';
    }
    if(count($errorMessages) == 0){
    //echo 'Valid Data';
    $sql = "update courses set name='$name', id_sector='$sector' where id = '$id'";
    $op = mysqli_query($con, $sql);
    if($op){
        $_SESSION['message'] = 'Record Updated';
        header("Location: index_admin.php");
    }else {
        $errorMessages['sqlOperation'] = 'error in executing SQL try Again';
    }
}else{
    foreach($errorMessages as $key=> $value){
        echo '* '.$key.' : '.$value.'<br>';
    }
}

}


    $sql = "SELECT courses.id, courses.name, courses.id_sector, coursestypes.id AS course_id, coursestypes.sector FROM `courses` JOIN coursestypes ON courses.id_sector = coursestypes.id where courses.id = $id";
    $op = mysqli_query($con, $sql);
    $data = mysqli_fetch_assoc($op);



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Edit Courses</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Edit Data</h2>
  <form  method="post"  action="adminEdit.php?id=<?php echo $data['id'];?>"  enctype ="multipart/form-data">
 
  <div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input type="text"  name="name" value= "<?php echo $data['name'];?>" class="form-control" id="exampleInputName" aria-describedby="" placeholder="Enter Name">
  </div>


  <div class="form-group">
    <label for="exampleInputEmail1">Sector</label>
    <select name="sector" class="form-control">
        <?php
            while($sector_data = mysqli_fetch_assoc($op2)){
        ?>
        <option value="<?php echo $sector_data['id'];?>"><?php echo $sector_data['sector'];?></option>
        <?php } ?>
    </select>
  </div> 
  <button type="submit" class="btn btn-primary">Update</button>
</form>
</div>

</body>
</html>

