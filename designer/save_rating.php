<?php


session_start();
if(!$_SESSION['designer_id']){header('Location: ../index.php');  die();}
if(!$_GET['design_id']){header('Location: ../index.php');  die();}
$design_id=$_GET['design_id'];
$designer_id=$_SESSION['designer_id'];

include_once('db_utility.php');
$conn = connect_to_db();
//************Check Identity
$checkidentity="Select * From Design INNER JOIN Design_Designer ON Design.DesignID=Design_Designer.f_DesignID WHERE Design.DesignID =".$design_id." AND Design_Designer.f_DesignerID=".$_SESSION['designer_id'] ;
$result= mysqli_query($conn,$checkidentity);
if (mysqli_num_rows($result) > 0) {}else {header('Location: ../index.php');die();}

foreach ($_POST as $key => $value)
{

	
	
    if (strpos($key,'a') !== false) {// action
   		$feedbackID = substr($key,1);
   		$action = htmlspecialchars($value);
   		$sql="SELECT * FROM Feedback_Rating WHERE FeedbackID=? AND RaterID=?";
							  if($stmt=mysqli_prepare($conn,$sql))
							  {
							    mysqli_stmt_bind_param($stmt,"ii",$feedbackID,$designer_id);
							    mysqli_stmt_execute($stmt);
							    $result = $stmt->get_result();
							  }
		if($result){
			if(mysqli_num_rows($result)>0){
				$cat = 1;
			}
			else {$cat=2;}
		}
		else {$cat=2;}
		if($cat==1){
			$sql="UPDATE Feedback_Rating SET action=? WHERE FeedbackID=?";
			if($stmt=mysqli_prepare($conn,$sql)){
				mysqli_stmt_bind_param($stmt,"ii",$action,$feedbackID);
				mysqli_stmt_execute($stmt);
			}
			else {
			    echo "Error updating record: " . mysqli_error($conn);
			}
		}else if($cat==2){
			$sql="INSERT INTO Feedback_Rating (FeedbackID, RaterID, action) VALUES (?,?,?)";
			if($stmt=mysqli_prepare($conn,$sql)){
				mysqli_stmt_bind_param($stmt,"iii",$feedbackID, $designer_id, $action);
				mysqli_stmt_execute($stmt);
			}
			else {
			    echo "Error updating record: " . mysqli_error($conn);
			}
		}
		
	}
    else if (strpos($key,'b') !== false) {// response
   		$feedbackID = substr($key,1);
   		$text = htmlspecialchars($value);
   		$sql="SELECT * FROM Feedback_Rating WHERE FeedbackID=? AND RaterID=?";
							  if($stmt=mysqli_prepare($conn,$sql))
							  {
							    mysqli_stmt_bind_param($stmt,"ii",$feedbackID,$designer_id);
							    mysqli_stmt_execute($stmt);
							    $result = $stmt->get_result();
							  }
		if($result){
			if(mysqli_num_rows($result)>0){
				$cat = 1;
			}
			else {$cat=2;}
		}
		else {$cat=2;}
		if($cat==1){
			$sql="UPDATE Feedback_Rating SET response=? WHERE FeedbackID=?";
			if($stmt=mysqli_prepare($conn,$sql)){
				mysqli_stmt_bind_param($stmt,"si",$response,$feedbackID);
				mysqli_stmt_execute($stmt);
			}
			else {
			    echo "Error updating record: " . mysqli_error($conn);
			}
		}else if($cat==2){
			$sql="INSERT INTO Feedback_Rating (FeedbackID, RaterID, response) VALUES (?,?,?)";
			if($stmt=mysqli_prepare($conn,$sql)){
				mysqli_stmt_bind_param($stmt,"iis",$feedbackID, $designer_id, $text);
				mysqli_stmt_execute($stmt);
			}
			else {
			    echo "Error updating record: " . mysqli_error($conn);
			}
		}
		
	}
	else // perceived quality
	{
   		$feedbackID = substr($key,1);
   		$quality = htmlspecialchars($value);
   		$sql="SELECT * FROM Feedback_Rating WHERE FeedbackID=? AND RaterID=?";
							  if($stmt=mysqli_prepare($conn,$sql))
							  {
							    mysqli_stmt_bind_param($stmt,"ii",$feedbackID,$designer_id);
							    mysqli_stmt_execute($stmt);
							    $result = $stmt->get_result();
							  }
		if($result){
			if(mysqli_num_rows($result)>0){
				$cat = 1;
			}
			else {$cat=2;}
		}
		else {$cat=2;}
		if($cat==1){
			$sql="UPDATE Feedback_Rating SET rating=? WHERE FeedbackID=?";
			if($stmt=mysqli_prepare($conn,$sql)){
				mysqli_stmt_bind_param($stmt,"i",$quality,$feedbackID);
				mysqli_stmt_execute($stmt);
			}
			else {
			    echo "Error updating record: " . mysqli_error($conn);
			}
		}else if($cat==2){
			$sql="INSERT INTO Feedback_Rating (FeedbackID, RaterID, rating) VALUES (?,?,?)";
			if($stmt=mysqli_prepare($conn,$sql)){
				mysqli_stmt_bind_param($stmt,"iii",$feedbackID, $designer_id, $quality);
				mysqli_stmt_execute($stmt);
			}
			else {
			    echo "Error updating record: " . mysqli_error($conn);
			}
		}
	}
	
} 

mysqli_close($conn); 
header('Location: ../index.php');
?>
