<?php

session_start();
//echo $_GET['designID'];
//if(!$_GET['designID'] && !$_SESSION['designID']){
//  header('Location: ../feedback_error.php');
//}
$design_id =$_GET['designID'];

include_once($_SERVER['DOCUMENT_ROOT'].'/mentoring/webpage-utility/db_utility.php');
$conn = connect_to_db();


$fbktext= mysqli_real_escape_string($conn, nl2br( $_POST['_fbk-text'] ));
$email=mysqli_real_escape_string($conn, nl2br($_POST['_email']));



/******* Save feedback provided by the provider **********/ 
$sql2 = "INSERT INTO Feedback(FeedbackID, f_ProviderID, f_DesignID, content,feedback_time, email) VALUES ('','" .
    $_SESSION['c_provider']."','".$GLOBALS['design_id']."','".$fbktext."','".$submittime."','".$email."')";
// echo $sql2;
if (mysqli_query($conn, $sql2)) {
    $feedback_id= mysqli_insert_id($conn);
    //$behavior_file = fopen("../behavior/".$GLOBALS['design_id']."_".$feedback_id.".txt", "w");
    //fwrite($behavior_file, $behavior);
    //fclose($behavior_file);
}

else {
        echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
    }

mysqli_close($conn);

if ($_SESSION['condition']=="mturk") {
     echo "The code is <strong>".$_SESSION['mturk_code']."</strong>. <br>Please copy the code and paste it to the HIT page. ";
}
else
{
     echo "Thank you! Your feedback has been recorded. Please close this window. \n";
}



?>

