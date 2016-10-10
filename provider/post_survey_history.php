<?php 
  session_start();
  $_SESSION['mid']=$_GET['mid'];
  $_SESSION['writerid']=$_GET['writerid'];
  $mid = $_SESSION['mid'];
  $writerid = $_SESSION['writerid'];
  if(!$mid||!$writerid){header('Location: feedback_error.php');}
 include_once('../webpage-utility/db_utility.php');
 $conn = connect_to_db();

 $fbktext=$_POST['_fbk-text'];
 $email=$_POST['_email'];
 $timespent=$_POST['timespent'];
 $nexttime=$_POST['nexttime'];
  $behavior=$_POST['behavior'];
  echo $behavior;
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
//************ Is feedback already there from this designer?
$insertsql = "SELECT * FROM `Feedback` WHERE `WriterID` = ? AND `DesignID` = ? AND version=?";
 if($stmt=mysqli_prepare($conn,$insertsql))
  {
    echo "here";
    mysqli_stmt_bind_param($stmt,"iii",$writerid, $designid, $version);
    mysqli_stmt_execute($stmt);   
    $result = $stmt->get_result();
    $result=$result->fetch_assoc() ; 
    mysqli_stmt_close($stmt); 
  }
  else{echo "error";}

//************ if feedback not present Save Feedback
if(!count($result)){
$insertsql = "INSERT INTO `Feedback`(`WriterID`, `DesignID`, `version`, `content`, `start_time`, `end_time`, `mentor`, `next_time`, `behavior`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
 if($stmt=mysqli_prepare($conn,$insertsql))
  {
    echo "here1";
    mysqli_stmt_bind_param($stmt,"iiisiiiis",$writerid, $designid, $version, $fbktext, $start_time, $timespent, $mentor, $nexttime, $behavior);
    mysqli_stmt_execute($stmt);   
    mysqli_stmt_close($stmt); 
  }
  else{echo "error1";}
}//************ if feedback present update Feedback
else{
$insertsql = "UPDATE `Feedback` SET content=? WHERE (WriterID=? AND DesignID=? AND version=?)";
 if($stmt=mysqli_prepare($conn,$insertsql))
  {
    echo "here2";
    mysqli_stmt_bind_param($stmt,"siii",$fbktext, $writerid, $designid, $version);
    mysqli_stmt_execute($stmt);   
    mysqli_stmt_close($stmt); 
  }
}
  
 ?>

<!DOCTYPE html>
<html>
<head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="Yu-Chun (Grace) Yen, UIUC">
    <link rel="icon" href="logo.png">
 <script src="js/jquery-1.11.3.min.js"></script>
    <!-- Bootstrap core CSS and js -->
    <link rel="stylesheet" type="text/css" href="../dist/css/bootstrap.min.css">
    <script type="text/javascript" src="../dist/js/bootstrap.min.js"></script>

    <!-- JQuery and Google font -->
    <link href='https://fonts.googleapis.com/css?family=Exo:100,400' rel='stylesheet' type='text/css'>

    <title> Final Survey</title>
    <?php include('../webpage-utility/ele_header.php'); ?>
   

    <style>

        .centered-form{
            margin-top: 60px;
        }

        .centered-form .panel{
            background: rgba(255, 255, 255, 0.8);
            box-shadow: rgba(0, 0, 0, 0.3) 20px 20px 20px;
        }
    </style>

</head>
<body>

  <div class="container">
    <div class="row centered-form">
      <div class="col-md-10 col-md-offset-1"> 
        <div class="panel panel-info">
          <div class="panel-heading">
            <h3>Post-Feedback Survey</h3>
            <p>Please complete the following survey honestly. Your answers will not affect your grade. However, failure to complete the survey means that your participation for this activity will not be counted.</p>
          </div>
          <div class="panel-body">
            <div class="alert alert-danger" role="alert" id="error_alert" style="display:none;">
              <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
              Please fill out or verify the indicated fields.
            </div>

            <form class="form" action='save_survey_history.php?mid=<?php echo $mid;?>&writerid=<?php echo $writerid;?>' name="survey" id="survey" method="post" enctype="multipart/form-data">

              <h4>How much effort did you put into:</h4>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th></th>
                    <th style="text-align:center;">Minimal</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="text-align:center;">Maximum</th>
                  </tr>
                </thead>
                <div>
                  <tr class="form-group required" id="form-group-e1">
                    <th scope='row' style='width:40%' class="radio-label" ><label class="control-label" for='e1'>Evaluating the design</label></td>
                    <td style='width:12%' align="center" class="radio-cell" ><input type="radio" class="radio-inline" name="e1" id="e1" value="1"></td>
                    <td style='width:12%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="e1" id="e1" value="2"></td>
                    <td style='width:12%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="e1" id="e1" value="3"></td>
                    <td style='width:12%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="e1" id="e1" value="4"></td>
                    <td style='width:12%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="e1" id="e1" value="5"></td>
                  </tr>
                </div>
                <div >
                  <tr class="form-group required" id="form-group-e2">
                    <th scope='row' style='width:25%' class="radio-label" ><label class="control-label" for='e2'>Evaluating the history</label></td>
                    <td style='width:12%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="e2" id="e2" value="1"></td>
                    <td style='width:12%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="e2" id="e2" value="2"></td>
                    <td style='width:12%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="e2" id="e2" value="3"></td>
                    <td style='width:12%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="e2" id="e2" value="4"></td>
                    <td style='width:12%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="e2" id="e2" value="5"></td>
                  </tr>
                </div>
                <div>
                  <tr class="form-group required" id="form-group-e3">
                    <th scope='row' style='width:25%' class="radio-label" ><label class="control-label" for='e3'>Writing the feedback</label></td>
                    <td style='width:12%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="e3" id="e3" value="1"></td>
                    <td style='width:12%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="e3" id="e3" value="2"></td>
                    <td style='width:12%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="e3" id="e3" value="3"></td>
                    <td style='width:12%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="e3" id="e3" value="4"></td>
                    <td style='width:12%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="e3" id="e3" value="5"></td>
                  </tr>
                </div>
              </table>

              <hr>

              <br>

              <h4>Estimate how much time you spent on the following in minutes:</h4>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th></th>
                    <th></th>
                  </tr>
                </thead>
                <div>
                  <tr class="form-group required" id="form-group-t_design">
                    <th scope='row' style='width:40%' class="radio-label" ><label class="control-label" for='t_design'>Evaluating the design</label></td>
                    <td><input style='width:60%' type="text" class="text-inline" name="t_design" id="t_design" placeholder="ex. 10" value=""></td>
                  </tr>
                </div>
                <div>
                  <tr class="form-group required" id="form-group-t_history">
                    <th scope='row' style='width:40%' class="radio-label" ><label class="control-label" for='t_history'>Evaluating the history</label></td>
                    <td><input style='width:60%' type="text" class="text-inline" name="t_history" placeholder="ex. 10" id="t_history" value=""></td>
                  </tr>
                </div>
                <div>
                  <tr class="form-group required" id="form-group-t_write">
                    <th scope='row' style='width:40%' class="radio-label" ><label class="control-label" for='t_write'>Writing the feedback</label></td>
                    <td><input style='width:60%' type="text" class="text-inline" name="t_write" placeholder="ex. 10" id="t_write" value=""></td>
                  </tr>
                </div>
              </table>

              <hr>

              <br>

              <h4>Please rate how strongly you disagree or agree with the following statements about the design you reviewed:</h4>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th></th>
                    <th style="text-align:center;">Strongly Disagree</th>
                    <th></th>
                    <th></th>
                    <th style="text-align:center;">Neutral</th>
                    <th></th>
                    <th></th>
                    <th style="text-align:center;">Strongly Agree</th>
                  </tr>
                </thead>
                <div >
                  <tr class="form-group required" id="form-group-d1">
                    <th scope='row' style='width:40%' class="radio-label" ><label class="control-label" for='d1'>I was given all of the information needed to effectively review the design</label></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d1" id="d1" value="1"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d1" id="d1" value="2"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d1" id="d1" value="3"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d1" id="d1" value="4"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d1" id="d1" value="5"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d1" id="d1" value="6"></td>
                    <td style='width:12%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d1" id="d1" value="7"></td>
                  </tr>
                </div>
                <div>
                  <tr  class="form-group required" id="form-group-d2">
                    <th scope='row' style='width:40%' class="radio-label" ><label class="control-label" for='d2'>I valued the design I reviewed</label></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d2" id="d2" value="1"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d2" id="d2" value="2"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d2" id="d2" value="3"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d2" id="d2" value="4"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d2" id="d2" value="5"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d2" id="d2" value="6"></td>
                    <td style='width:12%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d2" id="d2" value="7"></td>
                  </tr>
                </div>
                <div>
                  <tr class="form-group required" id="form-group-d3">
                    <th scope='row' style='width:40%' class="radio-label" ><label class="control-label" for='d3'>I would like to review the next iteration of the design I reviewed</label></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d3" id="d3" value="1"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d3" id="d3" value="2"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d3" id="d3" value="3"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d3" id="d3" value="4"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d3" id="d3" value="5"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d3" id="d3" value="6"></td>
                    <td style='width:12%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d3" id="d3" value="7"></td>
                  </tr>
                </div>
                <div>
                  <tr class="form-group required" id="form-group-d4">
                    <th scope='row' style='width:40%' class="radio-label" ><label class="control-label" for='d4'>I have the expertise needed help the design become better</label></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d4" id="d4" value="1"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d4" id="d4" value="2"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d4" id="d4" value="3"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d4" id="d4" value="4"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d4" id="d4" value="5"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d4" id="d4" value="6"></td>
                    <td style='width:12%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="d4" id="d4" value="7"></td>
                  </tr>
                </div>
              </table>

              <hr>

              <br>

              <h4>Please rate how strongly you disagree or agree with the following statements about the designers who work you reviewed:</h4>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th></th>
                    <th style="text-align:center;">Strongly Disagree</th>
                    <th></th>
                    <th></th>
                    <th style="text-align:center;">Neutral</th>
                    <th></th>
                    <th></th>
                    <th style="text-align:center;">Strongly Agree</th>
                  </tr>
                </thead>
                <div>
                  <tr class="form-group required" id="form-group-m1">
                    <th scope='row' style='width:40%' class="radio-label" ><label class="control-label" for='m1'>I can be open and honest in my feedback</label></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="m1" id="m1" value="1"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="m1" id="m1" value="2"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="m1" id="m1" value="3"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="m1" id="m1" value="4"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="m1" id="m1" value="5"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="m1" id="m1" value="6"></td>
                    <td style='width:12%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="m1" id="m1" value="7"></td>
                  </tr>
                </div>
                <div>
                  <tr class="form-group required" id="form-group-m2">
                    <th scope='row' style='width:40%' class="radio-label" ><label class="control-label" for='m2'>My feedback will be valued by the designers</label></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="m2" id="m2" value="1"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="m2" id="m2" value="2"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="m2" id="m2" value="3"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="m2" id="m2" value="4"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="m2" id="m2" value="5"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="m2" id="m2" value="6"></td>
                    <td style='width:12%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="m2" id="m2" value="7"></td>
                  </tr>
                </div>
                <div>
                  <tr class="form-group required" id="form-group-m3">
                    <th scope='row' style='width:40%' class="radio-label" > <label class="control-label" for='m3'>I value the effort of the designers</label></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="m3" id="m3" value="1"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="m3" id="m3" value="2"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="m3" id="m3" value="3"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="m3" id="m3" value="4"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="m3" id="m3" value="5"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="m3" id="m3" value="6"></td>
                    <td style='width:12%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="m3" id="m3" value="7"></td>
                  </tr>
                </div>
              </table>

              <hr>

              <br>

              <h4>Please rate how strongly you disagree or agree with the following statements about the feedback activity: </h4>
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th></th>
                    <th style="text-align:center;">Strongly Disagree</th>
                    <th></th>
                    <th></th>
                    <th style="text-align:center;">Neutral</th>
                    <th></th>
                    <th></th>
                    <th style="text-align:center;">Strongly Agree</th>
                  </tr>
                </thead>
                <div>
                  <tr class="form-group required" id="form-group-a1">
                    <th scope='row' style='width:40%' class="radio-label" ><label class="control-label" for='a1'>Learning to become a better designer is important to me<label></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a1" id="a1" value="1"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a1" id="a1" value="2"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a1" id="a1" value="3"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a1" id="a1" value="4"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a1" id="a1" value="5"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a1" id="a1" value="6"></td>
                    <td style='width:12%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a1" id="a1" value="7"></td>
                  </tr>
                </div>
                <div>
                  <tr class="form-group required" id="form-group-a2">
                    <th scope='row' style='width:40%' class="radio-label" ><label class="control-label" for='a2'>Giving good feedback is important to me</label></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a2" id="a2" value="1"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a2" id="a2" value="2"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a2" id="a2" value="3"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a2" id="a2" value="4"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a2" id="a2" value="5"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a2" id="a2" value="6"></td>
                    <td style='width:12%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a2" id="a2" value="7"></td>
                  </tr>
                </div>
                <div>
                  <tr class="form-group required" id="form-group-a3">
                    <th scope='row' style='width:40%' class="radio-label" ><label class="control-label" for='a3'>This activity helped me learn how to write better feedback</label></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a3" id="a3" value="1"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a3" id="a3" value="2"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a3" id="a3" value="3"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a3" id="a3" value="4"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a3" id="a3" value="5"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a3" id="a3" value="6"></td>
                    <td style='width:12%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a3" id="a3" value="7"></td>
                  </tr>
                </div>
                <div>
                  <tr class="form-group required" id="form-group-a4">
                    <th scope='row' style='width:40%' class="radio-label" ><label class="control-label" for='a4'>I believe the feedback I wrote will help the designers improve their designs.</label></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a4" id="a4" value="1"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a4" id="a4" value="2"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a4" id="a4" value="3"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a4" id="a4" value="4"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a4" id="a4" value="5"></td>
                    <td style='width:8%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a4" id="a4" value="6"></td>
                    <td style='width:12%' align="center" class="radio-cell"><input type="radio" class="radio-inline" name="a4" id="a4" value="7"></td>
                  </tr>
                </div>
              </table>

              <input type='hidden' name='fbktext' value='<?php echo "$fbktext";?>'/> 
              <input type='hidden' name='email' value='<?php echo "$email";?>'/> 
              <input type='hidden' name='timespent' value='<?php echo "$timespent";?>'/> 
            </form>
            <hr>

             <div class="form-group">
              <div class="row"><div class="col-md-4"></div>
                <div class="col-md-8">
                  <p ><button type="submit" class="btn btn-success btn-lg" style="width:200px" onClick="javascript:save()"> Submit </button> </p>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

<script>
function save() {
  var isOkay = true;
          $("#error_alert").hide();
          $(".has-error").removeClass("has-error");

        $('input#t_design').val($.trim($('input#t_design').val() )  );
        if ($("input[name='t_design']").val() == "" ) {
              $("#form-group-t_design").addClass("has-error");
              isOkay = false;
        }
        $('input#t_history').val($.trim($('input#t_history').val() )  );
        if ($("input[name='t_history']").val() == "" ) {
              $("#form-group-t_history").addClass("has-error");
              isOkay = false;
        }
        $('input#t_write').val($.trim($('input#t_write').val() )  );
        if ($("input[name='t_write']").val() == "" ) {
              $("#form-group-t_write").addClass("has-error");
              isOkay = false;
        }

        if ($("input[name='e1']:checked").size() == 0 ) {
              $("#form-group-e1").addClass("has-error");
              isOkay = false;
        }
        if ($("input[name='e2']:checked").size() == 0 ) {
              $("#form-group-e2").addClass("has-error");
              isOkay = false;
        }
        if ($("input[name='e3']:checked").size() == 0 ) {
              $("#form-group-e3").addClass("has-error");
              isOkay = false;
        }

        if ($("input[name='d1']:checked").size() == 0 ) {
              $("#form-group-d1").addClass("has-error");
              isOkay = false;
        }
        if ($("input[name='d2']:checked").size() == 0 ) {
              $("#form-group-d2").addClass("has-error");
              isOkay = false;
        }
        if ($("input[name='d3']:checked").size() == 0 ) {
              $("#form-group-d3").addClass("has-error");
              isOkay = false;
        }
        if ($("input[name='d4']:checked").size() == 0 ) {
              $("#form-group-d4").addClass("has-error");
              isOkay = false;
        }

        if ($("input[name='m1']:checked").size() == 0 ) {
              $("#form-group-m1").addClass("has-error");
              isOkay = false;
        }
        if ($("input[name='m2']:checked").size() == 0 ) {
              $("#form-group-m2").addClass("has-error");
              isOkay = false;
        }
        if ($("input[name='m3']:checked").size() == 0 ) {
              $("#form-group-m3").addClass("has-error");
              isOkay = false;
        }

        if ($("input[name='a1']:checked").size() == 0 ) {
              $("#form-group-a1").addClass("has-error");
              isOkay = false;
        }
        if ($("input[name='a2']:checked").size() == 0 ) {
              $("#form-group-a2").addClass("has-error");
              isOkay = false;
        }
        if ($("input[name='a3']:checked").size() == 0 ) {
              $("#form-group-a3").addClass("has-error");
              isOkay = false;
        }
        if ($("input[name='a4']:checked").size() == 0 ) {
              $("#form-group-a4").addClass("has-error");
              isOkay = false;
        }

        if (isOkay === true){

          $('#survey').submit();
        }
        else{
              //If something is not okay, then we come here
          $("#error_alert").show();
        }
    
    }

    function trimfield(str) 
    { 
        return str.replace(/^\s+|\s+$/g,''); 
    }
</script>
</body>
</html>


