<?php

error_log("here",0);
    
session_start();

$EMAIL = $_POST['inputEmail'];
$PWD = $_POST['inputPassword'];
$TYPE=$_SESSION['role'];

include_once('./webpage-utility/db_utility.php');
$conn = connect_to_db();

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$isOkay=1;
error_log("here",0);

if ($stmt = mysqli_prepare($conn, "SELECT * From u_Designer WHERE email = ?")) {
  error_log("prepared",0);
  mysqli_stmt_bind_param($stmt, "s", $EMAIL);
  mysqli_stmt_execute($stmt);
  $result = $stmt->get_result();
  $designer = $result->fetch_assoc();  
  }
  else{
    error_log("not connected",0);
  }

  error_log($designer, 0);
 

  if(!$designer)
  {
    $isOkay=0;
    mysqli_close($conn);
      //header('Location:error.php?error=email_not_exit');
    echo "email_not_exit";
    die();
 
  }
  else
  { 
    if($designer['pass'] != test_input($PWD) ){
      $isOkay=0;
      mysqli_close($conn);
      //header('Location:error.php?error=pwd_incorrect');
      echo "pwd_incorrect";
      die();
    }

  }


if($isOkay==1){
  $_SESSION['email']=$designer['email'];
  $_SESSION['password']=$designer['password'];
  $_SESSION['designer_id']=$designer['DesignerID'];
  echo "success";
  die();
}

   mysqli_close($conn);
   //header('Location:'.$HOME_PAGE);

   ?>