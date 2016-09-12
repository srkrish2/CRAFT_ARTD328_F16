<?php
    
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

if ($stmt = mysqli_prepare($conn, "SELECT * From u_Designer WHERE email = ?")) {
  
  mysqli_stmt_bind_param($stmt, "s", $email);
  $email=test_input($EMAIL);
  mysqli_stmt_execute($stmt);
  $result = $stmt->get_result();
  $designer = $result->fetch_assoc();  
  
 

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
    if($designer['password'] != test_input($PWD) ){
      $isOkay=0;
      mysqli_close($conn);
      //header('Location:error.php?error=pwd_incorrect');
      echo "pwd_incorrect";
      die();
    }
    else
    {
        //Check Group
        if($designer['DesignerID']<190)
        {
         
                $isOkay=0;
                mysqli_close($conn);
                //header('Location:error.php?error=pwd_incorrect');
                echo "remove";
                 die();
        }

        if($designer['process'] == 6 ){
        $isOkay=0;
        mysqli_close($conn);
        //header('Location:error.php?error=pwd_incorrect');
        echo "finished";
        die();
        
        }
       
       /* else{

            if($designer['process'] <3 ){
            $isOkay=0;
            mysqli_close($conn);
            //header('Location:error.php?error=pwd_incorrect');
            echo "remove";
            die();
            }
      }*/


    } 



  }

}


if($isOkay==1){
  $_SESSION['email']=$designer['email'];
  $_SESSION['password']=$designer['password'];
  $_SESSION['designer_id']=$designer['DesignerID'];
  echo "success";

}



  

   mysqli_close($conn);
   //header('Location:'.$HOME_PAGE);

   ?>