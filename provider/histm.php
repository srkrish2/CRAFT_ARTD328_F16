<?php
  session_start();
  $_SESSION['mid']=$_GET['mid'];
  $_SESSION['writerid']=$_GET['writerid'];
  $mid = $_SESSION['mid'];
  $writerid = $_SESSION['writerid'];
  if(!$mid||!$writerid){header('Location: feedback_error.php');}
  include_once('../webpage-utility/db_utility.php');
  $conn = connect_to_db();

  //Get design
  $sql="SELECT * FROM Designs WHERE mid=?";
  if($stmt=mysqli_prepare($conn,$sql))
  {
    mysqli_stmt_bind_param($stmt,"s",$mid);
    mysqli_stmt_execute($stmt);
    $result = $stmt->get_result();
    $designs=$result->fetch_assoc() ;      
    mysqli_stmt_close($stmt); 
  }
  if(count($designs)>0){
    $design_id=$designs['DesignID'];
    $title=$designs['title'];
    $title=htmlspecialchars($designs['title']);
    $title=preg_replace('#&lt;(/?(?:br /))&gt;#', '<\1>', $title);

    $stage=$designs['stage'];
    $description=htmlspecialchars($designs['description']);
    $description=preg_replace('#&lt;(/?(?:br /))&gt;#', '<\1>', $description);
    
    $filename=$designs['file'];
    $team=$designs['teamID'];
  }

  //Get previous iteration design
  $sql="SELECT * FROM Designs WHERE teamID=? AND stage=?";
  if($stmt=mysqli_prepare($conn,$sql))
  {
    $p_stage = $stage - 1;
    mysqli_stmt_bind_param($stmt,"ii",$team,$p_stage);
    mysqli_stmt_execute($stmt);
    $result = $stmt->get_result();
    $designs=$result->fetch_assoc() ;      
    mysqli_stmt_close($stmt); 
  }
  if(count($designs)>0){
    $p_design_id=$designs['DesignID'];
    $p_filename=$designs['file'];
  }

  //Is writer a mentor?
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

  //Get feedback for previous iteration
  $sql="SELECT * FROM Feedback WHERE (DesignID=? AND mentor=?) LIMIT 1";
  if($stmt=mysqli_prepare($conn,$sql))
  {
    mysqli_stmt_bind_param($stmt,"ii",$p_design_id,$mentor);
    mysqli_stmt_execute($stmt);
    $result = $stmt->get_result();
    $feedback=$result->fetch_assoc() ;  
    $fbkid = $feedback['FeedbackID'];
    $fbktext = $feedback['content'];
    mysqli_stmt_close($stmt); 
  }

  //Get Feedback Response for previous iteration
  $sql="SELECT * FROM Feedback_rating WHERE FeedbackID=?";
  if($stmt=mysqli_prepare($conn,$sql))
  {
    mysqli_stmt_bind_param($stmt,"i",$fbkid);
    mysqli_stmt_execute($stmt);
    $result = $stmt->get_result();
    $rating=$result->fetch_assoc() ;    
    $response = $rating['response'];
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
    <link rel="stylesheet" type="text/css" href="../dist/css/bootstrap.min.css">
    <link href="../css/provider.css" rel="stylesheet">

  </head>

  <body>

      <div class="main-section" style="padding-top:50px">
        <div class="container">

          <!-- Instructions -->
          <div class="well" id="instructions" style="width:100%; font-size:16px; margin:0px auto;text-align:justify;padding-left:50px;padding-right:50px;background:#F2F2F2">       
            <h3 style="color:black;">
              <strong>
                Task Instructions
              </strong>
            </h3>
            <p >
              You have been assigned as the only peer mentor for the following project for the entire semester. You have the unique opportunity to see the designs from start to finish and provide quality feedback. This task is worth 20 points, and will be graded on completeness (including both strengths and weaknesses of the design), relevance (the appropriateness and helpfulness), and quality (providing insights beyond the superficial). We encourage you to review the previous design, the feedback for the previous iteration, and the designer's response to the feedback when providing your own feedback.</p>

          <div id="email-div" name="email-div"><strong> Enter your university email:</strong> <input type="text" id="email" name="email"><em style="color:red;"> (required)*</em>
          </div>

          </div>

          <!--Previous Design -->  
          <div id = "prev" name="prev" style="display:inline;">   
          <h3>Previous Iteration</h3>    
          <div class="row" id='prevrow'> 
              <div class="col">      
               <div class="img-div" onmouseover="" style="cursor: pointer;" >
               <img width="auto" height="400px" src=<?php echo $p_filename; ?> onClick="view(this);" >
               <p><em style="color:grey">* Click on the image to enlarge </em></p>
                </div>
              </div>
            <div class="col" style="margin-right:30px;">
              <h3>Peer Feedback</h3>
              <p class="project-description" style='text-align: justify;'><?php echo $fbktext;?> </p>
              <h3>Designer Response to Feedback</h3>
              <p class="project-description" style='text-align: justify;'><?php echo $response;?> </p>
            </div>
          </div><!--end Previous Design row--><!--end Design row-->

          <div id="nextbtn" style="display:inline">
            <p style="text-align:center;">Press Next to see the current version of the design</p>
            <button style="text-align:center;margin-top:20px" type="submit" class="btn-submit" id="submit-bn" onclick="nnext();">Next</button> 
            </div>
          </div>


          <!--Design -->
          <div id = "current" name="current" style="display:none;">   
            <h3>Current Iteration</h3>      
            <div class="row">       
               <div class="img-div" onmouseover="" style="cursor: pointer;" >
               <img width="auto" height="400px" src=<?php echo $filename; ?> onClick="view(this);" >
               <p><em style="color:grey">* Click on the image to enlarge </em></p>
              </div>
              <div style="margin-right:30px;">
                <h3><?php echo htmlspecialchars($title)?></h3>
                <p class="project-description" style='text-align: justify;'><?php echo $description;?> </p>
              </div>
            </div>
          <!--end Design row--><!--end Design row-->
          <div style="text-align:center;margin-top:20px;">
            <p style="text-align:center;">Press Back to see the previous version of the design</p>
            <button type="submit" class="btn-submit" id="submit-bn" onclick="back();">Back</button> 
            </div>
          <!--Empty field alert --> 
            <div class="alert alert-danger" role="alert" id="error_alert" style="display:none;">
              <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
              Please fill out the empty fields.
            </div>
            

              
              <form class="hidden" action="post_survey_history.php?mid=<?php echo $mid;?>&writerid=<?php echo $writerid;?>" method="post" id="feedback_form" name="feedback_form">
                <input name="_fbk-text"/>
                <input name="_email"/>
                <input type="hidden" id='timespent' name="timespent" value="" />
                <input type="hidden" id='nexttime' name="nexttime" value="" />
                <input type="hidden" id='behavior' name="behavior" value="" />

              </form>

              <div style="margin-top:25px;"></div>

            </div>

            <!--Feedback -->
            <div class="sub_frame required" id="fbk-div" style="display:none">       
              <h4 class="question-text"><strong>Please provide feedback (in English) for how to improve the design &nbsp</strong><em style="color:red;"> (required)</em></h4>
                  
              <textarea id="fbk-text" name="fbk-text" rows="7" style="width:100%;"></textarea>  
            </div>

              <div id = "buttons" style="text-align:center;margin-top:20px;display:none">
              <button type="submit" class="btn-submit" id="submit-bn" onclick="save();">Submit</button> 
              </div>

          </div>
      </div><!--end container-->

    </div><!--end main-section-->


    <script>

    var behavior;

    $("#email").bind("keydown", function() {
        $('#email-div').removeClass("has-error-text");
    }
    );

    document.getElementById("fbk-text").onkeypress = function() {myFunction()};

    function myFunction() {
      var d = new Date();
      t = d.getTime();
      time = t-start;
        behavior.push("k:"+t);
    }

    $(document).ready(function() {
      var d = new Date();
       start = d.getTime();
       behavior = new Array();
    });

    function nnext(){
      var current = document.getElementById("current");
      current.style.display = "inline" ;
      var current = document.getElementById("fbk-div");
      current.style.display = "inline" ;
      var current = document.getElementById("buttons");
      current.style.display = "inline" ;
      var current = document.getElementById("nextbtn");
      current.style.display = "none" ;
      var prev = document.getElementById("prev");
      prev.style.display = "none" ;
      var d = new Date();
      next = d.getTime();
      nexttime = next-start;
      behavior.push("n:"+nexttime);
    }

    function back(){
      var current = document.getElementById("current");
      current.style.display = "none" ;
      var current = document.getElementById("buttons");
      current.style.display = "none" ;
      var current = document.getElementById("nextbtn");
      current.style.display = "inline" ;
      var prev = document.getElementById("prev");
      prev.style.display = "inline" ;
      var d = new Date();
      backt = d.getTime();
      backtime = backt-start;
      behavior.push("b:"+backtime);
    }

    function save(){
      
        var errorMsg='';
          $("#error_alert").hide();
        $(".has-error").removeClass("has-error");
         var isOkay = true;

         if ($('#email').val() == "") {
           $("#error_alert").show();
           errorMsg=errorMsg+'\n'+"Provide your univerisity ID";
           $('#email-div').addClass("has-error-text");
           isOkay = false;
          }

        var multiline= $('#fbk-text').val().replace(/\r?\n/g, '<br />');
        $('#fbk-text').val( $.trim( multiline ));

        if ($('#fbk-text').val() == "") {
           $("#error_alert").show();
           $('#fbk-div').addClass("has-error");
           errorMsg += 'Please provide feedback on the design. ';
           isOkay = false;
        }

        if(isOkay==true){
          $("#feedback_form [name=_email]").val( $("#email").val() );
          $("#feedback_form [name=_fbk-text]").val( $("#fbk-text").val() );
          var d = new Date();
          var end = d.getTime();
          var timespent = end - nexttime;
          document.getElementById('timespent').value = timespent;
          document.getElementById('nexttime').value = nexttime;
          document.getElementById('behavior').value = behavior.toString();
          $("#feedback_form").submit();
            
        }else
        {
          alert(errorMsg);
        }
    }
    
      function view(imgsrc) {
        addlabel("click-image");  
            viewwin = window.open(imgsrc.src,'viewwin', 'width=800,height=400px'); 
          }

    </script>

  </body>
</html>