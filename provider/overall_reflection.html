<?php
 session_start();

 $mid=$_GET['mid'];
 $dfolder="design/";
 $type="overall";

 if(!$mid){header('Location: feedback_error.php');}

 include_once($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/db_utility.php');
 $conn = connect_to_db();
 	if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
 }

 //Get Design
 if ($stmt = mysqli_prepare($conn, "SELECT time_spent, file From Design WHERE mid = ?")) {
     /* bind parameters for markers */
     mysqli_stmt_bind_param($stmt, "s", $mid);
     /* execute query */
     mysqli_stmt_execute($stmt);
     /* bind result variables */
     $stmt->store_result();

 	if($stmt->num_rows > 0) {
 	    mysqli_stmt_bind_result($stmt, $time_spent,$file);
 	    /* fetch value */
 	    mysqli_stmt_fetch($stmt);
 	    /* close statement */
 	    mysqli_stmt_close($stmt);
 	} else {
 	    //No Designs found
 	    header('Location: feedback_error.php');
 	}
  
 }

 /************ Get Provider IP ****************/
 if(!$_SERVER['REMOTE_ADDR']){$ip="0";}
 else{	$ip=$_SERVER['REMOTE_ADDR'];}

 if(!$_SERVER['HTTP_X_FORWARDED_FOR']){	$proxy="0";}
 else{	$proxy=$_SERVER['HTTP_X_FORWARDED_FOR'];}

 $_ip = mysqli_real_escape_string($conn, $ip);
 $_proxy = mysqli_real_escape_string($conn, $proxy);

$existing_turker=0;

 /************ Check Provider Existence ****************/
if ($stmt = mysqli_prepare($conn, "SELECT ProviderID From u_Provider WHERE IP = ? AND PROXY = ? ")) 
 {
    /* bind parameters for markers */
    mysqli_stmt_bind_param($stmt, "ss",  $_ip,  $_proxy);
    /* execute query */
    mysqli_stmt_execute($stmt);
    $stmt->store_result();
    
    
    /* bind result variables */
    if($stmt->num_rows > 0) 
    {
    	$existing_turker=1;
        //existing provider
        mysqli_stmt_bind_result($stmt, $current_provider);
        /* fetch value */
        mysqli_stmt_fetch($stmt);
        $_SESSION['c_provider']=$current_provider; 
        /* close statement */
        mysqli_stmt_close($stmt);
    } 
   
 }

?>

<!DOCTYPE html>
<html>
<head>
	<script src="js/jquery-1.11.3.min.js"></script>
  <?php include('webpage-utility/ele_header.php'); ?>
  <title> Review My Design </title>
   

   <link rel="stylesheet" type="text/css" href="dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="overall.css">

</head>
<body >
<div class="main-section" style="padding-top:50px;padding-right:50px;padding-left:50px">


		<div class="container">

		<?php 
/*if($existing_turker==1){
 echo "<span style='color:red;font-size:20px;'>We notice that this device has been used to submit other HITs in this batch. To ensure the feedback quality, we will check all these submissions. If we find too much similarity, we will reject all the submissions. Otherwise, thanks for helping more designers with us. </span>" ;
}
*/
?>
			<!-- Instructions -->
			<div class="well" id="instructions" style="width:100%; font-size:16px; margin:0px auto;text-align:justify;padding-left:50px;padding-right:50px;background:#F2F2F2">				
				<h3 style="color:black;">
					<strong>
						Task Instructions
					</strong>
				</h3>
				<p >
					In this HIT, you will need to review a graphic design and its goals for at least one minute and provide feedback on the design. Your feedback should include both <strong>strengths </strong>(what you like) and <strong>weaknesses</strong> (what you don’t like) about the <span style='color:blue'>overall concept and the theme </span> of the design. We are not the designer, so you don't need to be overly positive. However, responses that demonstrate insufficient effort or are overly offensive will be rejected.</p>
				

			<div id="turker-div" name="turker-div"><strong> Enter your MTurk ID to start :</strong> <input type="text" id="turkerID" name="turkerID"><em style="color:red;"> (required)*</em>
			<p><em style="color:grey">This is for the purpose of payment. </em></p>
			</div>

			</div>


<div id="info" name="info" style="display:none"><span style='color:red'>You have already completed the maximum number of HITs allowed in this batch. Multiple submissions will be rejected and impact your approval rate.</span></div>
<div id='survey-part' style="display:none">

			<div class="row" style="width:100%;padding-top: 20px;  margin:auto;">
				
			<!--Design -->		
			<!--<div class="row" style="width:40%;padding-top: 20px;  margin:auto;">-->
					<div id="image" style="margin-top:20px">		
						 <div class="img-div" onmouseover="" style=" cursor: pointer; margin-right:20px; " >

						 <img style="border: 1px solid #A4A4A4; width:400px; " id="picture" name="picture" src="<?php echo $dfolder.$file ?>" onClick="view('<?php echo $mid;?> ');" >
						 <p><em style="color:grey">* Click on the image to enlarge </em></p>
						</div>
					</div>
			<!--</div>-->
			
			<h3>Design Goals</h3> <span style="font-size:16px">This is the first draft of a flyer created for a half marathon race called RUN@NYC. The event will be hosted by and held at Central Park in Manhattan, New York City at 7 am on October 1, 2016. Runners can register through the event website <spen style=" text-decoration: underline;">www.running-nyc.com </spen>(not live yet). The top three runners will receive a $300 prize each. The goal of the flyer is to encourage participation, be visually appealing, and convey the event details.
	<p><br>You can click on the image to enlarge.</p></span>
			</div>
	
			<hr>

			<div class="row">	
				<div class="sub_frame">	
					<div id="qual_div">
						<h4 class="question-text"><strong>1. How would you rate the degree to which the flyer satisfied all of the design goals?</strong> <em style="color:red;"> (required)</em></h4>				
						<table border="0" cellpadding="5" cellspacing="0" id="entry_1519429516" style="text-align: center;width:30%;">
							<tr aria-hidden="true">
								<td  class="radio-label" ></td>
								<td><label class="radio-cell">1</label></td> 
								<td><label class="radio-cell">2</label></td> 
								<td><label class="radio-cell">3</label></td> 
								<td><label class="radio-cell">4</label></td>
								<td><label class="radio-cell">5</label></td>  
								<td><label class="radio-cell">6</label></td>  
								<td><label class="radio-cell">7</label></td>  
								<td  class="radio-label" ></td>
							</tr>
							<tr>
								<td class="radio-label" >Low</td>
								<td class="radio-cell"><input type="radio" class="radio-inline" name="qualRadios" id="qualRadios1" value="1"></td>
							<td class="radio-cell"><input type="radio" class="radio-inline" name="qualRadios" id="qualRadios2" value="2"></td>
							<td class="radio-cell"><input type="radio" class="radio-inline" name="qualRadios" id="qualRadios3" value="3"></td>
							<td class="radio-cell"><input type="radio" class="radio-inline" name="qualRadios" id="qualRadios4" value="4"></td>
							<td class="radio-cell"><input type="radio" class="radio-inline" name="qualRadios" id="qualRadios5" value="5"></td>
							<td class="radio-cell"><input type="radio" class="radio-inline" name="qualRadios" id="qualRadios5" value="6"></td>
							<td class="radio-cell"><input type="radio" class="radio-inline" name="qualRadios" id="qualRadios5" value="7"></td>
							<td class="radio-label">High</td>		
							</tr>
						</table>
					</div>
				</div>
				
				<div class="sub_frame">	
					<div id="fbk_div">
					<h4 class="question-text required"><strong>2. Enter your feedback about the <span style="color:blue"><em>overall concept</em> </span>of the design, including both its strengths and weaknesses. &nbsp</strong><em style="color:red;"> (required)</em></h4>
					 <textarea id="text" name="text" rows="5" onkeyup="onTextKeyUp()" onkeydown="onTextKeyDown(event)" style="width:100%;"></textarea>
					 
					</div>
				</div>

				<div class="sub_frame">	
						
					<h4 class="question-text"><strong>How would you rate your level of design expertise?</strong> </h4>				
					<table border="0" cellpadding="5" cellspacing="0" style="text-align: center;width:30%;">
							<td  class="radio-label" ></td>
							<td><label class="radio-cell">1</label></td> 
							<td><label class="radio-cell">2</label></td> 
							<td><label class="radio-cell">3</label></td> 
							<td><label class="radio-cell">4</label></td>
							<td><label class="radio-cell">5</label></td>  
							<td  class="radio-label" ></td>
						</tr>
						
						<tr>
							<td class="radio-label" >Novice</td>
							<td class="radio-cell"><input type="radio" class="radio-inline" name="expertiseRadios" id="expertiseRadios1" value="1"></td>
						<td class="radio-cell"><input type="radio" class="radio-inline" name="expertiseRadios" id="expertiseRadios2" value="2"></td>
						<td class="radio-cell"><input type="radio" class="radio-inline" name="expertiseRadios" id="expertiseRadios3" value="3"></td>
						<td class="radio-cell"><input type="radio" class="radio-inline" name="expertiseRadios" id="expertiseRadios4" value="4"></td>
						<td class="radio-cell"><input type="radio" class="radio-inline" name="expertiseRadios" id="expertiseRadios5" value="5"></td>
						<td class="radio-label">Expert</td>		
						</tr>
					</table>

					<h4 class="question-text"  style="margin-top:35px;" ><strong>What gender do you identify with? <strong></h4>
					<label class="radio-inline">
						<input type="radio" name="genderRadios" id="genderRadios1" value="male"> Male
					</label>
					<label class="radio-inline">
						<input type="radio" name="genderRadios" id="genderRadios2" value="female"> Female
					</label>
					<label class="radio-inline">
						<input type="radio" name="genderRadios" id="genderRadios3" value="other"> Other
					</label>
		

					<h4 class="question-text" style="margin-top:35px;" ><strong>What is your age range? <strong></h4>
					<label class="radio-inline">
					  <input type="radio" name="ageRadios" id="ageRadios1" value="under18"> under 18
					</label>
					<label class="radio-inline">
					  <input type="radio" name="ageRadios" id="ageRadios2" value="18to25"> 18-25
					</label>
					<label class="radio-inline">
					  <input type="radio" name="ageRadios" id="ageRadios3" value="26to35"> 26-35
					</label>
					<label class="radio-inline">
					  <input type="radio" name="ageRadios" id="ageRadios4" value="36to45"> 36-45
					</label>
					<label class="radio-inline">
					  <input type="radio" name="ageRadios" id="ageRadios5" value="46to55"> 46-55
					</label>
					<label class="radio-inline">
					  <input type="radio" name="ageRadios" id="ageRadios6" value="56Older"> 56 or Older
					</label>

				</div><!--END OF optional question section-->


				</div><!--end row-->

			
			

			<div style="text-align:center;margin-top:20px;" >
			<button type="submit" class="btn-submit" name="submit-bn" id="submit-bn" onclick="submit();">Submit</button> 
			</div>
			
			<form class="hidden" action="webpage-utility/save_feedback.php?mid=<?php echo $mid;?>" method="post" id="feedback_form" name="feedback_form">
				<input type="hidden" name="_fbk-text">
				<input type="hidden" name="_age">
				<input type="hidden" name="_expertL">
				<input type="hidden" name="_gender">
				<input type="hidden" name="_quality">
				<input type="hidden" name="_behavior">
				<input type="hidden" name="_turkerID">
				<input type="hidden" name="_ip" value="<?php echo $ip;?>">
				<input type="hidden" name="_proxy" value="<?php echo $proxy;?>">

				<input type="hidden" name="_type" id="_type" value="<?php echo $type;?>">
				<input type="hidden" id="startTime" name="startTime" value=""/>
				<input type="hidden" id="submitTime" name="submitTime" value=""/>
        		<input type="hidden" id="prepareTime" name="prepareTime" value=""/>
        		<input type="hidden" id="taskTime" name="taskTime" value=""/>
        		<input type="hidden" id="numberOfOps" name="numberOfOps" value=""/>
        		<input type="hidden" id="numberOfPause" name="numberOfPause" value=""/>
        		<input type="hidden" id="numberOfDel" name="numberOfDel" value=""/>
        		<input type="hidden" id="timeStamps" name="timeStamps" value=""/>        	
        		<input type="hidden" id="eventHistory" name="eventHistory" value=""/>
			</form>

			<div style="margin-top:25px;"></div>

		</div>

	</div>
	</div><!--end container-->





</div><!--end main-section-->
<script>
var provider_ok=1;
var isOkay=1;

var hitStartTime;

var annoStartTime;
var annoEndTime;

var opsCount = 0;
var typingTimer;
var doneTypingInterval = 1000;
var pauseCount = 0;
var delCount = 0;

var annotationFlag = false;
var delFlag = false;

var prevStroke;
var eventLogs = [];

function view(mid) {

window.open("viewpic.php?image="+mid);

//viewwin = window.open(imgsrc.src,'viewwin', 'width=1000,height=auto'); 
}

//Check TurkID 
document.getElementById('turkerID').focusout = function(e){  	
	if ($('#turkerID').val() != "") {
		turkID();
	}

};


function turkID() {
     
	$.post( "check_turker.php", { turker: $.trim($('#turkerID').val()) })
  	.done(function( data ) {
    
    	switch(data)
                {
                  case "exists":
                 
          			$('#survey-part').hide();
          			
          			$('#info').show();
          			isOkay = false;
          			provider_ok=0;
          			//window.location.href ='already_exist.php';             
                    break;
                   case "success":
          
                   	provider_ok=1;
                  	$('#info').hide();
                  	$('#survey-part').show();
                    break;
                  default:
                  	
                }
  });
   
}



function logAction(action, param) {
  console.log(action);
  if (typeof param === "undefined") {
    eventLogs.push([(new Date()).getTime(), action]);
  }
  else {
    eventLogs.push([(new Date()).getTime(), action, param])
  }
}



$(document).ready(function() {
  // var task_params = document.getElementById("survey").href.substring(56).toString();
  // (new Image).src = 'http://128.174.241.28:8080/?' + task_params;
 
  hitStartTime = (new Date()).getTime();
  logAction("init");

 $('textarea').bind('cut copy paste', function (e) {
    e.preventDefault(); //disable cut,copy,paste
});


  $(window).focus(function() {
    logAction("focus");
  });

  $(window).blur(function() {
    logAction("blur");
  });

	$('input[type=radio][name=expertiseRadios]').change(function(){
		turkID();
		  logAction("expert");
	})

	$('input[type=radio][name=ageRadios]').change(function(){
		turkID();
		  logAction("age");
	})

	$('input[type=radio][name=qualRadios]').change(function(){
		turkID();
		  logAction("quality");
		  $("#qual_div").removeClass("has-error-text");
	})

	$('input[type=radio][name=genderRadios]').change(function(){
		turkID();
		  logAction("gender");
	})

	$("#text").bind("keydown", function(){
		turkID();
    	$('#fbk_div').removeClass("has-error-text");

	}
	);

	$("#turkerID").bind("keydown", function(){
    	$('#turker-div').removeClass("has-error-text");
	}
	);


/* Count Page Visit
	$.ajax({
		type: "POST",
		url: "countvisit.php",
		data: { starttime:  $.trim( $("#feedback_form [name=_starttime]").val()) },
		success: function(data){

		}
	});
*/
 
});




function counting(textvalue){
  // var value = $('#text').val();
  var value = textvalue;
    var regex = /\s+/gi;
    var wordCount = value.trim().replace(regex, ' ').split(' ').length;
    var totalChars = value.length;
    var charCount = value.trim().length;
    var charCountNoSpace = value.replace(regex, '').length;
    return wordCount; 
}

function onTextKeyUp() {

  clearTimeout(typingTimer);
  typingTimer = setTimeout(recordPause, doneTypingInterval);
  //$('#word-good').html(counting(document.getElementById('text').value));
  logAction("text_update", document.getElementById("text").value);
}

function onTextKeyDown(e) {

  if (annotationFlag == false) {
   	annoStartTime = (new Date()).getTime();
    annotationFlag = true;
    logAction("start");
  }



  clearTimeout(typingTimer);
  var unicode = e.keyCode ? e.keyCode : e.charCode;
  if (unicode == 8 || unicode == 46) {
    if (!delFlag) {
      delCount += 1;
      delFlag = true;
    }
  }
  else if (delFlag) {
    delFlag = false;
  }
}

function recordPause() {
  pauseCount += 1;
}

function getParameterByName(name) {
  name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
  var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
  results = regex.exec(location.search);
  return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}



function verified(){
				var errorMsg='';
	  	$("#error_alert").hide();
		$(".has-error").removeClass("has-error");
		 var isOkay = true;


	if ($('#turkerID').val() == "") {
		 $("#error_alert").show();
		 errorMsg=errorMsg+'\n'+"Provide your Turker ID.";
		 $('#turker-div').addClass("has-error-text");
		 isOkay = false;
		}
		//var multiline= $('#text').val().replace(/\r?\n/g, '<br />');
	 	//$('#text').val( $.trim( multiline ));

		if ($('#text').val() == "") {
			 $("#error_alert").show();
			 $('#fbk_div').addClass("has-error-text");
			 isOkay = false;
			 errorMsg=errorMsg+'\n'+"Provide your feedback.";
		}
		else{
			if(counting(document.getElementById('text').value)<30)
			{	
				 errorMsg=errorMsg+'\n'+"You feedback is too short. Please elaborate on your comments more.";
				$('#fbk_div').addClass("has-error-text");
				 isOkay = false;
			}
		}



	    if ($("input[name='qualRadios']:checked").size() == 0 ) {
          $("#qual_div").addClass("has-error-text");
          errorMsg=errorMsg+'\n'+"Rate your perceive quality of the design.";
			 
          isOkay = false;
        }


		

		if(isOkay==true && provider_ok==1){
			logAction("submit");
			
			$("#feedback_form [name=_fbk-text]").val( $("#text").val() );
			$("#feedback_form [name=_age]").val($('input[name="ageRadios"]:checked').val() );
			$("#feedback_form [name=_expertL]").val($('input[name="expertiseRadios"]:checked').val() );
			$("#feedback_form [name=_gender]").val($('input[name="genderRadios"]:checked').val() );
			$("#feedback_form [name=_quality]").val($('input[name="qualRadios"]:checked').val() );
			$("#feedback_form [name=_turkerID]").val( $("#turkerID").val() );
			

			$("#feedback_form [name=_behavior]").val(JSON.stringify(eventLogs));
 			$("#feedback_form [name=prepareTime]").val( annoStartTime - hitStartTime);
 			$("#feedback_form [name=taskTime]").val( (new Date()).getTime() - annoStartTime );
 			$("#feedback_form [name=numberOfPause]").val(pauseCount);
 			$("#feedback_form [name=numberOfDel]").val(delCount);
 			$("#feedback_form [name=startTime]").val( annoStartTime );
 			$("#feedback_form [name=submitTime]").val((new Date()).getTime());
			$("#feedback_form").submit();
			
		}
		else
		{
			$("#error_alert").show();
		   alert("Before submitting, your response should: "+errorMsg);
		}
}
function submit() {

	$.post( "check_turker.php", { turker: $.trim($('#turkerID').val()) })
  	.done(function( data ) {
    
    	switch(data)
                {
                  case "exists":
                 
          			$('#survey-part').html("Submission failed. The Turker ID have already been used to submit HIT in this batch.");
          			$('#submit-bn').hide();
          			$('#info').show();
          			isOkay = false;
          			provider_ok=0;
          			//window.location.href ='already_exist.php';             
                    break;
                   case "success":
                   	verified();
                    break;
                  default:
                  	
                }
  });

}


</script>

</body>
</html>