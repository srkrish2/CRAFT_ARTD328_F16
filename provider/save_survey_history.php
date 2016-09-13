<?php
  session_start();
  $_SESSION['mid']=$_GET['mid'];
  $_SESSION['writerid']=$_GET['writerid'];
  $mid = $_SESSION['mid'];
  $writerid = $_SESSION['writerid'];

//$designer_id = 53;

include_once($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/db_utility.php');
$conn = connect_to_db();
$isOkay= true;

$e1 = $_POST['e1'];
$e2 = $_POST['e2'];
$e3 = $_POST['e3'];

$t_design = $_POST['t_design'];
$t_history = $_POST['t_history'];
$t_write = $_POST['t_write'];

$d1 = $_POST['d1'];
$d2 = $_POST['d2'];
$d3 = $_POST['d3'];
$d4 = $_POST['d4'];

$m1 = $_POST['m1'];
$m2 = $_POST['m2'];
$m3 = $_POST['m3'];

$a1 = $_POST['a1'];
$a2 = $_POST['a2'];
$a3 = $_POST['a3'];
$a4 = $_POST['a4'];

$fbktext= mysqli_real_escape_string($conn, nl2br( $_POST['fbktext'] ));
$email=mysqli_real_escape_string($conn, nl2br($_POST['email']));
$timespent=$_POST['timespent'];
$start_time=0;

//************ Find Design ID
$designidsql = "SELECT * From Designs Where mid=?";
 if($stmt=mysqli_prepare($conn,$designidsql))
  {
    mysqli_stmt_bind_param($stmt,"s",$mid);
    mysqli_stmt_execute($stmt);
    $result = $stmt->get_result();
    $design=$result->fetch_assoc() ; 
    $designid = $design['DesignID'];
    $version = $design['stage'];     
    mysqli_stmt_close($stmt); 
  }
  else{
  	$isOkay = false;
  }

//************ Find out if writer is random or peer mentor
$insertsql = "SELECT * FROM `u_Designer` WHERE DesignerID=?";
 if($stmt=mysqli_prepare($conn,$insertsql))
  {
    mysqli_stmt_bind_param($stmt,"i",$writerid);
    mysqli_stmt_execute($stmt);  
    $result = $stmt->get_result();
    $design=$result->fetch_assoc() ; 
    $mentor = $design['mentor'] ;
    mysqli_stmt_close($stmt); 
  }
  else{
    $isOkay = false;
  }

//************ Save Survey
$insertsql = "INSERT INTO `Survey1`(`WriterID`,`t_design`, `t_history`, `t_write`, `e1`, `e2`, `e3`, `d1`, `d2`, `d3`, `d4`, `m1`, `m2`, `m3`, `a1`, `a2`, `a3`, `a4`, `num`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
 if($stmt=mysqli_prepare($conn,$insertsql))
  {
    mysqli_stmt_bind_param($stmt,"isssiiiiiiiiiiiiiii",$writerid, $t_design, $t_history, $t_write, $e1, $e2, $e3, $d1, $d2, $d3, $d4, $m1, $m2, $m3, $a1, $a2, $a3, $a4, $version);
    mysqli_stmt_execute($stmt);   
    mysqli_stmt_close($stmt); 
  }
  else{
  	$isOkay = false;
  }

if($isOkay){
	$msg = "Thank you for your feedback!";
}
else{
	$msg = "Sorry, something went wrong!";
}

?>

<html>
<head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="logo.png">

 <!-- Bootstrap core CSS and js -->
     <link rel="stylesheet" type="text/css" href="dist/css/bootstrap.min.css">
    <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>

<!-- JQuery and Google font-->
    <link href='https://fonts.googleapis.com/css?family=Exo:100,400' rel='stylesheet' type='text/css'>

  <title> Final Survey </title>
  <?php 
    include('/mentoring/webpage-utility/ele_header.php'); 
    ?>
  <script src="js/jquery-1.11.3.min.js"></script>


</head>
<body>

    <div class="main-section">
        <div class="container-fluid">
            <h4><?php echo $msg ?></h4>
    </div>



    </div><!--end main-section-->


</body>
</html>
