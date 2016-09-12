<?php

 session_start();
 $designer_id=$_SESSION['designer_id'];
 $team_id=$_SESSION['team_id'];

if(!$designer_id) { header("Location: ../index.php"); die(); }
if(is_null($_GET['design_id']))
	{ header("Location: homepage.php"); die();}

$design_id=$SESSION['design_id']=$_GET['design_id'];

function generateRandomString($length = 10) {
    
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
	
    return $randomString;
}

include_once('../webpage-utility/db_utility.php');
$conn = connect_to_db();
	
$isOkay=true;

	
	$_title = mysqli_real_escape_string($conn, $_POST['title']);
	$_description= mysqli_real_escape_string($conn, nl2br( $_POST['description'] ));
	$generated_mid= $_SESSION['design_id'].generateRandomString();
	$_stage = $_POST['stage'];

	$sql="INSERT INTO Designs (`teamID`, `description`, `stage`, `title`, `mid`) VALUES (?, ?, ?, ?, ?)";
	if($stmt=mysqli_prepare($conn,$sql))
	{
		mysqli_stmt_bind_param($stmt,"isiss",$team_id,$_description,$_stage,$_title,$generated_mid);
		if(!mysqli_stmt_execute($stmt)){
			echo "Sorry, there was an error in the database";
		}
		else{
			$design_id = mysqli_insert_id();
		}
		mysqli_stmt_close($stmt); 
	}

	//Upload File
	if($_POST['update_file']=="true"){
		if(!$_FILES['fileToUpload']['size'] == 0 && $_FILES['fileToUpload']['error'] == 0)
		{ 
			$target_dir = "../designs/";
			$_upload_file = basename($_FILES["fileToUpload"]["name"]);
			$upload_file = (strlen($_upload_file) > 12) ? substr($_upload_file,0,4) : $_upload_file;
			$imageFileType = pathinfo($_upload_file,PATHINFO_EXTENSION);
			$target_file="t".$team_id."_s".$_stage."_d".$design_id.".".$imageFileType;
			$newFilePath= $target_dir.$target_file;

			if(file_exists($newFilePath)) {
			   // echo "delete first";
			    chmod($newFilePath,0755); //Change the file permissions if allowed
			    unlink($newFilePath); //remove the file
			}

		    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $newFilePath)) {
		    	//echo "save image";
		    	$sql="UPDATE Designs SET file=? WHERE DesignID = ? ";
				if($stmt=mysqli_prepare($conn,$sql))
				{
					mysqli_stmt_bind_param($stmt,"si",$target_file,$design_id);
					if(mysqli_stmt_execute($stmt)){
					}
					else{
				    	echo "Error updating picture: " . mysqli_error($conn);
					}
		    	} else {
			        echo "Sorry, there was an error uploading your file.";
		    	}
			}
		}
	}

//echo "HERE!!!!!!";
mysqli_close($conn);//""
//echo "<html><img width='auto' height='300px' src='../design/".$newFilePath."'></html>"; 
if($_POST['action']=="sent-to-view"){
	//echo "preview";
	header( "Location: preview.php?design_id=".$design_id );
	die();
}
else
{
	//echo "save";
	header( "Location: designer_home.php");
	die();
}				 ;

?>
