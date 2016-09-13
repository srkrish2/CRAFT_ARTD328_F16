<?php

  session_start();  
  //check session
  $DESIGNER= $_SESSION['designer_id'];
  $experimentID= $_SESSION['experimentID'];
  //if($experimentID!=3){ header("Location: ../index.php"); die(); }
  
  if(!$DESIGNER) { header("Location: ../index.php"); die(); }
    
  include_once('../webpage-utility/db_utility.php');
    $conn = connect_to_db();
    

  $sql="SELECT * FROM u_Designer WHERE DesignerID=?";
  if($stmt=mysqli_prepare($conn,$sql))
  {
    mysqli_stmt_bind_param($stmt,"i",$DESIGNER);
    mysqli_stmt_execute($stmt);
    $result = $stmt->get_result();
    $designer=$result->fetch_assoc() ;      
      mysqli_stmt_close($stmt); 
  }

  $sql="SELECT * FROM Team WHERE DesignerID=?";
  if($stmt=mysqli_prepare($conn,$sql))
  {
    mysqli_stmt_bind_param($stmt,"i",$DESIGNER);
    mysqli_stmt_execute($stmt);
    $result = $stmt->get_result();
    $team = $result->fetch_assoc() ;  
    $teamid = $team['teamID'];
    $_SESSION['team_id']=$teamid;    
    mysqli_stmt_close($stmt); 
  }


  $sql="SELECT * FROM Designs WHERE teamID=? ORDER BY DesignID ASC";
  if($stmt=mysqli_prepare($conn,$sql))
  {
    mysqli_stmt_bind_param($stmt,"i",$teamid);
    mysqli_stmt_execute($stmt);
    $result = $stmt->get_result();
    while ($myrow = $result->fetch_assoc()) {
        $designs[]=$myrow;
     }
     $design_number=count($designs); 
    mysqli_stmt_close($stmt); 

  }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
   <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <?php include('../webpage-utility/ele_header.php');?>
   <title>Signin Page </title>
    <!-- Custom styles for this template -->
    <link href="../css/designer.css" rel="stylesheet">
    <link href="../css/index.css" rel="stylesheet">
  </head>

  <body>

    <!--Where designs are shown-->
    <div class="main-section">
      <div class="container">
    <!-- Nav Bar-->
    <!--<?php //include('../webpage-utility/ele_nav.php');?>-->
    <!-- End Nav Bar-->

    <nav class="navbar navbar-fixed-top navbar-inverse" style="background:#002058">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" style="color:#E87722" href="../index.php">CRAFT</a>
            </div>
            <button type="button" class="btn btn-default navbar-btn navbar-right" id="logout">Logout</button>
            
        </div>
      
    </nav>
    <script>
      $(document).ready(function(){
        $('#logout').click(function(){
            $.post('../webpage-utility/logout.php', function (response) {
                window.location.href='../index.php';
            });
        });

    });
    </script>



      <!-- Button trigger modal -->
        <div>
          <a type="button" class="btn-add" href="design_form.php?design_id=0"> &nbsp&nbsp Add Design &nbsp&nbsp </a> 
        </div>
    
      <?php
        if(count($designs)>0){
          $count_design=1;
          foreach($designs as  $value){
            if( ($count_design % 4)==1 ){
              echo "<div class='row' style='padding-top:30px;''>";
            }
            switch ($value['stage']) {
              case 1: $stage = "Concepts"; break;
              case 2: $stage = "Initial Design"; break;
              case 3: $stage = "Revised Design"; break;
              case 4: $stage = "Final Design"; break;
            }
            echo "<script type='text/javascript'>alert(".$stage.");</script>";
            //*************** Get Feedback number for each design**********//
            // $fbknum="SELECT * From `Feedback` WHERE `f_DesignID` =".$value['DesignID'];              
            // $result2= mysqli_query($conn,$fbknum);
            // $getnum=mysqli_num_rows($result2); 

            $sql="SELECT * FROM Feedback WHERE DesignID=?";
            if($stmt=mysqli_prepare($conn,$sql))
            {
              mysqli_stmt_bind_param($stmt,"i",$value['DesignID']);
              mysqli_stmt_execute($stmt);
              $result = $stmt->get_result();
              $feedbacks = array();
              if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                  $feedbacks[] = $row;
                }
              }
              $getnum=count($feedbacks); 
            }

            echo " <div class='col-sm-4 col-md-3'> ";
            echo "<div class='thumbnail' style='padding-top:10px;padding-right:10px;padding-left:10px;'>";

            echo "<a href='rate_comment.php?design_id=".$value['DesignID']."'><img id='img-preview' border=0 src='../design/".$value['file']."' onmouseover='' style='cursor: pointer;'></a>";

            echo " <div style='padding-top:10px;padding-left:10px;'><h5><strong>".htmlspecialchars($value['title'])."</strong></h5></div> <div style='padding-left:10px;'><h5>".htmlspecialchars($stage)."</h5></div>";
            echo "<hr>";

            echo "<div style='text-align:right;padding-bottom:10px;'>";           

            echo " <a href='rate_comment.php?design_id=".$value['DesignID']."' > <span class='glyphicon glyphicon-comment'></span>&nbsp".$getnum."</a> ";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            if($count_design%4==0){
              echo "</div>";
            }
            $count_design++;
          }
        }
        else
        {
          echo "<div style='margin-top:20px;'>Click 'Add Design' to upload your design.</div>";
        }
        mysqli_close($conn);
      ?>

      </div>

    </div>

    <script>
    </script>
    
  </body>
</html>