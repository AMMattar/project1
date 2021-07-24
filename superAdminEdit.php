<?php
require 'connectionDB.php';
require 'loginCheck.php';

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
    $email = cleaning($_POST['email']);
    if(!empty($email)){
           if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $errorMessages['email'] = "Invalid Email";
           }
        }else{
            $errorMessages['email'] = "Required";
        }
    $role = cleaning($_POST['role']);
    if(empty($role)){
        $errorMessages['role']='content can\'t be empty';
    }
    if(count($errorMessages) == 0){
    //echo 'Valid Data';
    $sql = "update users set name='$name', email='$email', role_id='$role' where id = '$id'";
    $op = mysqli_query($con, $sql);
    if($op){
        $_SESSION['message'] = 'Record Updated';
        header("Location: index_super_admin.php");
    }else {
        $errorMessages['sqlOperation'] = 'error in executing SQL try Again';
    }
}else{
    foreach($errorMessages as $key=> $value){
        echo '* '.$key.' : '.$value.'<br>';
    }
}

}


    $sql = "SELECT users.id, users.name, users.email, users.role_id, roles.id AS users_id, roles.role FROM `users` JOIN roles ON users.role_id = roles.id where users.id = $id";
    $op = mysqli_query($con, $sql);
    $data = mysqli_fetch_assoc($op);



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Edit Roles</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2>Edit Data</h2>
  <form  method="post"  action="superAdminEdit.php?id=<?php echo $data['id'];?>"  enctype ="multipart/form-data">
 
  <div class="form-group">
    <label for="exampleInputEmail1">Name</label>
    <input type="text"  name="name" value= "<?php echo $data['name'];?>" class="form-control" id="exampleInputName" aria-describedby="" placeholder="Enter Name">
  </div>

<div class="form-group">
    <label for="exampleInputEmail1">Email</label>
    <input type="email"  name="email" value= "<?php echo $data['email'];?>" class="form-control" id="exampleInputName" aria-describedby="" placeholder="Enter Email">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail1">Role</label>
    <input type="text"  name="role" value= "<?php echo $data['role_id'];?>" class="form-control" id="exampleInputName" aria-describedby="" placeholder="Enter Sector">
  </div> 
  <button type="submit" class="btn btn-primary">Update</button>
</form>
</div>

</body>
</html>

