<?php

session_start();
if(!$_SESSION['designer_id']){ header('Location: index.php');  die();}
$designer_id=$_SESSION['designer_id'];

//$designer_id = 53;

include_once($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/db_utility.php');
$conn = connect_to_db();
$isOkay= false;

$aspects = "";
if(!empty($_POST['aspects'])) {
    foreach($_POST['aspects'] as $check) {
    	$aspects = $aspects . "," .$check;
    }
}


$name = $_POST['name'];
$change = $_POST['change'];
$improve = $_POST['improve'];
$confidence = $_POST['confidence'];
$iter = $_POST['iter'];
$fbk_use = $_POST['fbk-use'];
$fbk_amt = $_POST['fbk-amt'];
$ref = $_POST['ref'];
$influence  = $_POST['influence'];
$future = $_POST['future'];


//************ Save Survey
$sql="SELECT * FROM Final_Survey WHERE f_Designer=?";
if($stmt1=mysqli_prepare($conn,$sql))
{
	mysqli_stmt_bind_param($stmt1,"i",$designer_id);
	mysqli_stmt_execute($stmt1);
	$result = $stmt1->get_result();
	while ($myrow = $result->fetch_assoc()) {
	    $record[]=$myrow;
	 }
	mysqli_stmt_close($stmt1);

	if(count($record) > 0) {//Update Record
		$sql2 = "UPDATE Final_Survey SET name=?, `change`=?, aspects=?, improve=?, confidence=?, another_iter=?, fbk_use=?, reflect=?,fbk_amt=?, influence=?, future=? WHERE f_Designer = ?";
		if($stmt2 = mysqli_prepare($conn,$sql2)){
			mysqli_stmt_bind_param($stmt2, "sissisiiiss", $name,$change,$aspects,$improve,$confidence, $iter, $fbk_use, $ref, $fbk_amt, $influence, $future);		
			mysqli_stmt_execute($stmt2);
		}
		else
		{ 
			$msg = "Sorry, something went wrong. Please contact the system administrator at yyeng4@illinois.edu";
		}
	
	}
	else///New Record
	{
		mysqli_report(MYSQLI_REPORT_ALL);
		$sql3 = "INSERT INTO Final_Survey(f_Designer, name, `change`, aspects, improve, confidence, another_iter, fbk_use, reflect, fbk_amt, influence, future) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
		$stmt = mysqli_prepare($conn,$sql3);
		if($stmt){
			error_log("after prepare");
			mysqli_stmt_bind_param($stmt, "isissisiiiss", $designer_id,$name,$change,$aspects,$improve,$confidence, $iter, $fbk_use, $ref, $fbk_amt, $influence, $future);
			mysqli_stmt_execute($stmt);

			$msg = "Thank you for participating in this study.";
		}
		else
		{ 
			$msg = "Sorry, something went wrong. Please contact the system administrator at yyeng4@illinois.edu";
		}
		
		
	}
}
else{
	$msg = "Sorry, something went wrong. Please contact the system administrator at yyeng4@illinois.edu";
}


//************ Update Designer Status --- TODO: Add 
// if($designer['group']=='reflection' ||$designer['group']=='feedback-reflection' )
// {	
// 	//Finished Task
// 	$sql = "UPDATE `u_Designer` SET `process` =? WHERE `DesignerID`=?";
// 	if($stmt = mysqli_prepare($conn,$sql)){
// 		mysqli_stmt_bind_param($stmt, "ii", $process, $designer_id);
// 		$process=5;
// 		mysqli_stmt_execute($stmt);
// 	}	
// 	mysqli_stmt_close($stmt);
// 	mysqli_close($conn); 
// 	header('Location: second_stage.php');

// }
// else if ($designer['group']=='reflection-feedback')
// {
// 	mysqli_close($conn); 
// 	header('Location: feedback.php');

// }

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
    include('webpage-utility/ele_header.php'); 
    ?>
  <script src="js/jquery-1.11.3.min.js"></script>


</head>
<body>
    
    <?php 
        include('webpage-utility/ele_nav.php'); 
    ?>

    <div class="main-section">
        <div class="container-fluid">
            <h4><?php echo $msg ?></h4>
    </div>



    </div><!--end main-section-->


</body>
</html>
