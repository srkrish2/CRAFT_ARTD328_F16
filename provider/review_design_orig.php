<?php
session_start();

$mid=$_GET['mid'];
$dfolder="a";

//$_SESSION['mid']=$_GET['mid'];

if(!$mid){header('Location: feedback_error.php');}

$_SESSION['condition']='peer';


require_once('webpage-utility/db_config.php');
$conn = mysqli_connect($DB_HOST, $SQL_ACC ,  $SQL_PWD , $DB);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//Get design informaion
$query="Select * From Design WHERE mid ='".$mid."'";
$result= mysqli_query($conn,$query);

if (mysqli_num_rows($result) > 0) {
	$row = mysqli_fetch_assoc($result);
	
	/************ Get Reference ****************/
	$_SESSION['reference']= (!$_SERVER['HTTP_REFERER'] ? "User Invited" : $_SERVER['HTTP_REFERER']);
	$_SESSION['mturk_code']=$row['mturk_code'];
	
	/************ Get IP ****************/
	if(!$_SERVER['REMOTE_ADDR']){$ip="0";}
	else{	$ip=$_SERVER['REMOTE_ADDR'];}

	if(!$_SERVER['HTTP_X_FORWARDED_FOR']){	$proxy="0";}
	else{	$proxy=$_SERVER['HTTP_X_FORWARDED_FOR'];}

	$_SESSION['ip']=$ip;
	$_SESSION['proxy']=$proxy;



	$design_id=$row['DesignID'];
	$title=$row['title'];
	$title=htmlspecialchars($row['title']);
	$title=preg_replace('#&lt;(/?(?:br /))&gt;#', '<\1>', $title);

	$type=$row['stage'];
	$description=htmlspecialchars($row['description']);
	$description=preg_replace('#&lt;(/?(?:br /))&gt;#', '<\1>', $description);
	
	$filename=$row['file'];

	$_ip = mysqli_real_escape_string($conn, $ip);
	$_proxy = mysqli_real_escape_string($conn, $proxy);




	/************ Check Provider Existence ****************/
	$sql="SELECT * FROM `u_Provider` WHERE `IP`= '".$_ip."' AND `PROXY` = '".$_proxy."'" ;
	$result = mysqli_query($conn, $sql);
	if (mysqli_num_rows($result) > 0) 
	{
	    $row = mysqli_fetch_assoc($result); 
	    $_SESSION['c_provider']=$row['ProviderID'];    
	}
	else 
	{
		$_SESSION['c_provider']=0;
	}
}
else
{
	header('Location: feedback_error.php');
}


?>

<!DOCTYPE html>
<html>
<head>
  <?php include('webpage-utility/ele_header.php'); ?>
  <title> Review My Design </title>
	<script src="js/jquery-1.11.3.min.js"></script>
<style>
.project-description{
	text-align: justify;
	font-size:120%;
}

.question-text{
	text-align: justify;
	font-size:120%;
	color:#0B614B;
}
.task-title{
	color: red;
	text-align: center;
}
.sub_frame{
	background-color: #FAFAFA;
	padding-right: 30px;
    padding-left: 30px;
	padding-top: 10px;
    padding-bottom: 20px;
    margin-top: 20px;
    border-radius: 20px;

}
#submit-bn{
	padding-top:"10px";
	width: "500px"


}
.radio-cell{
	width: 25px;
	text-align: center;
} 
.radio-label{
	width: 50px;
	text-align: center;
} 
.img-div{
    float: left;
    padding-right: 30px;
    margin-left: 30px;
    text-align:right;
}

.btn-submit {
  background: #288a5c;
  background-image: -webkit-linear-gradient(top, #288a5c, #305242);
  background-image: -moz-linear-gradient(top, #288a5c, #305242);
  background-image: -ms-linear-gradient(top, #288a5c, #305242);
  background-image: -o-linear-gradient(top, #288a5c, #305242);
  background-image: linear-gradient(to bottom, #288a5c, #305242);
  -webkit-border-radius: 25;
  -moz-border-radius: 25;
  border-radius: 25px;
  -webkit-box-shadow: 1px 3px 5px #666666;
  -moz-box-shadow: 1px 3px 5px #666666;
  box-shadow: 1px 3px 5px #666666;
  font-family: Arial;
  color: #ffffff;
  font-size: 20px;
  padding: 10px 20px 10px 20px;
  text-decoration: none;
}

.btn-submit:hover {
  background:  #a8e6bb;;
  text-decoration: none;

}

.required h4:after{

	content:" *";
	color:red;
}

.has-error
{
	background-color:#f2dede;
}
</style>
</head>
<body>

	
	<div class="main-section" style="padding-top:50px">
		<div class="container">


			<!--Design -->			
			<div class="row">				
				 <div class="img-div" onmouseover="" style="cursor: pointer;" >
				 <img width="auto" height="200px" src="<?php echo "design/".$filename ?>" onClick="view(this);" >
				 <p><em style="color:grey">* Click on the image to enlarge </em></p>
				</div>
			 	<div style="margin-right:30px;">
			 		<h3><?php echo htmlspecialchars($title)?></h3>
			 		<p class="project-description" style='text-align: justify;'><?php echo $description;?> </p>
			 	</div>
	
			
			</div><!--end Design row--><!--end Design row-->
		  <!--Empty field alert -->	
	      <div class="alert alert-danger" role="alert" id="error_alert" style="display:none;">
			  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
			  Please fill out the empty fields.
		  </div>

			<!--Feedback -->
		
			
			<div class="sub_frame required" id="fbk-div">				
				<h4 class="question-text"><strong>Please provide feedback (in English) for how to improve the design &nbsp</strong><em style="color:red;"> (required)</em></h4>
						
				<textarea id="fbk-text" name="fbk-text" rows="7" style="width:100%;"></textarea> 	
				 <!--
				 <div class="progress">
				  <div class="progress-bar progress-bar-striped" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" >
				    <span class="sr-only">40% Complete (success)</span>
				  </div>
				</div>
				 -->
			</div>

			<!--Reason -->	
				<div class="sub_frame required" id="reason-div">
					<form class="form-horizontal" name="rank_taste">
						<h4 class="question-text"><strong>Please rank the following reasons for why you provided the feedback. </strong><em style="color:red;">(required)</em></h4>
						<p><strong>(1= Most Relevant, 3=Least Relevant or you can select Not Relevant.)</strong></p>
						
						<div class="ranking" style="margin-bottom:10px;">
							<select name="design" onchange="check_index(this.name, window.document.rank_taste.design.options[selectedIndex].value)">
								<option value="0" id="design_0">Not Relevent</option>
								<option value="1" id="design_1">1</option>
								<option value="2" id="design_2">2</option>
								<option value="3" id="design_3">3</option>
							</select>
							Because I am interested in this design or design in general.
						</div>

						<div class="ranking" style="margin-bottom:10px;">
							<select name="support" onchange="check_index(this.name, window.document.rank_taste.support.options[selectedIndex].value)">
								<option value="0" id="design_0">Not Relevent</option>
								<option value="1" id="support_1">1</option>
								<option value="2" id="support_2">2</option>
								<option value="3" id="support_3">3</option>
							</select>
							Because of my relationship with the person who created the design.
						</div>

						<div class="ranking">
							<select name="money" onchange="check_index(this.name, window.document.rank_taste.money.options[selectedIndex].value)">
								<option value="0" id="design_0">Not Relevent</option>
								<option value="1" id="money_1">1</option>
								<option value="2" id="money_2">2</option>
								<option value="3" id="money_3">3</option>
							</select>
							Because I am being paid. 
						</div>



					</form>
				</div>
<!--Survey -->


				<div class="sub_frame">			
					<h4 class="question-text"><strong>How would you rate your level of design expertise?</strong> </h4>					

					<table border="0" cellpadding="5" cellspacing="0" id="entry_1519429516">
						<tr aria-hidden="true">
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

				</div><!--END OF SURVEY-->

				<div style="text-align:center;margin-top:20px;">
				<button type="submit" class="btn-submit" id="submit-bn" onclick="submit();">Submit</button> 
				</div>
				
				<form class="hidden" action="webpage-utility/save_feedback.php?designID=<?php echo $design_id;?>" method="post" id="feedback_form" name="feedback_form">
					<input name="_fbk-text">
					<input name="_age">
					<input name="_expertL">
					<input name="_gender">
					<input name="_reason">
					<input name="_behavior">
					<input name="_starttime">
					<input name="_submittime">
				</form>

				<div style="margin-top:25px;"></div>

			</div>
	</div><!--end container-->

</div><!--end main-section-->
<script>

 var behavior=[];

 function addlabel(_tag)
 {	

 	var tmp = new Object();
 	tmp.tag=_tag;
 	//tmp.timestamp= new Date().toISOString().slice(0, 19).replace('T', ' ');
 	var current_time =new Date();

 	tmp.timestamp= new Date().toISOString().slice(0, 19).replace('T', ' ');
 	behavior.push(tmp);

 }


 jQuery(function() {

 		//$('#fbk-text').keydown(addlabel("key-down"));

 		var starttime=new Date().toISOString().slice(0, 19).replace('T', ' ');
 		$("#feedback_form [name=_starttime]").val(starttime);

 		$.ajax({
                type: "POST",
                url: "countvisit.php",
                data: { starttime:  $.trim( $("#feedback_form [name=_starttime]").val()) },
                success: function(data){
            
                }
        });




 		$( "#fbk-text" ).keydown(function() {
		 addlabel("key-down");
		});
		$( "#fbk-text" ).keypress(function() {
		 addlabel("key-press");
		});
   	//	$('#fbk-text').keypress(addlabel("key-press"));

   		$('input[type=radio][name=expertiseRadios]').change(function(){
			  addlabel("expert");
		})

		$('input[type=radio][name=ageRadios]').change(function(){
			  addlabel("age");
		})

		$('input[type=radio][name=genderRadios]').change(function(){
			  addlabel("gender");
		})



		$('.ranking select').change(function(){
			  addlabel("ranking");
			  $('#reason-div').removeClass("has-error");
		})
		$("#fbk-text").bind("keydown", function(){
		    $('#fbk-div').removeClass("has-error");
		});


	  }); // jQuery(function(){})






//*************** Ranking **************************//
var rank= {};//object
var stuff;
 
rank["design"]=0;
rank["support"]=0;
rank["knowledge"]=0;
rank["reputation"]=0;
rank["money"]=0;
rank["other"]=0;

function check_index(x,y)
{ // x is bread, y is 3
var idValue;
var clash = "nope";

if (y>0) {
   for (stuff in rank) {
      var col_stuff;
      if (rank[stuff]==y) // selected position is already taken
         {
         clash="yup";
         col_stuff=stuff;
       
         var new_value=0;       
         idValue = col_stuff + '_' + new_value.toString();
         document.getElementById(idValue).selected=true;
         
           rank[col_stuff]=new_value;
         
      } // end if already taken
   } // end for
} // end if
rank[x]=y; 

if (clash=="yup") {
   alert('Selected rank is already taken. Your previous selection has been reset.');
}   
 //
	return false;
} // end function

function check_reason(teat_array){
	for(item in teat_array) {
		if(teat_array[item] == 1) {
			return true;
		}
	}

	console.log( JSON.stringify(teat_array) );
	return false;

}

//***************END Ranking **************************//





function submit(){
		

		var submittime=new Date().toISOString().slice(0, 19).replace('T', ' ');
 		$("#feedback_form [name=_submittime]").val(submittime);

		var errorMsg='';
	  	$("#error_alert").hide();
		$(".has-error").removeClass("has-error");
		 var isOkay = true;

		var multiline= $('#fbk-text').val().replace(/\r?\n/g, '<br />');
	 	$('#fbk-text').val( $.trim( multiline ));

		if ($('#fbk-text').val() == "") {
			 $("#error_alert").show();
			 $('#fbk-div').addClass("has-error");
			 errorMsg += 'Please provide feedback on the design. ';
			 isOkay = false;
		}

		
		if(check_reason(rank)==false)
		{
			$("#error_alert").show();
 			$('#reason-div').addClass("has-error");
 			if(errorMsg!=''){errorMsg+=' And select at least one top reason ( 1 should be selected) for why you provided feedback.';}
 			else {errorMsg='Please select at least one top reason ( 1 should be selected) for why you provided feedback.';}

 		}	


		if(isOkay==true && check_reason(rank)==true){

			$("#feedback_form [name=_fbk-text]").val( $("#fbk-text").val() );
			$("#feedback_form [name=_age]").val($('input[name="ageRadios"]:checked').val() );
			$("#feedback_form [name=_expertL]").val($('input[name="expertiseRadios"]:checked').val() );
			$("#feedback_form [name=_gender]").val($('input[name="genderRadios"]:checked').val() );

			$("#feedback_form [name=_behavior]").val(JSON.stringify(behavior));
 			var reasons = JSON.stringify(rank);
			$("#feedback_form [name=_reason]").val(reasons);
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


		




//***************COUNT WORD (UNUSED NOW)**************************//
/*
counter = function() {
    var value = $('#fbk-text').val();

//Now only use word count
    if (value.length == 0) {
        $('#wordCount').html(0);
        return;
    }

    var regex = /\s+/gi;
    var wordCount = value.trim().replace(regex, ' ').split(' ').length;


    $('.progress-bar').removeClass("progress-bar-danger");
    $('.progress-bar').removeClass("progress-bar-sucess");
    $('.progress-bar').removeClass("progress-bar-warning");
    $('.progress-bar').removeClass("active");
 	

 	$('.progress-bar').css('width', wordCount+'%').attr('aria-valuenow', wordCount); 
 	if(wordCount<10){
 		$('.progress-bar').addClass("progress-bar-danger");

 	}
 	else if(wordCount>=10&&wordCount<20)
 	{	
 		$('.progress-bar').addClass("progress-bar-warning");
 	}
 	else
 	{
 		$('.progress-bar').addClass("progress-bar-sucess");
 		$('.progress-bar').addClass("active");
 	}

    $('#wordCount').html(wordCount);
};

$(document).ready(function() {
    $('#submit-bn').click(counter);
    $('#fbk-text').change(counter);
    $('#fbk-text').keydown(counter);
    $('#fbk-text').keypress(counter);
    $('#fbk-text').keyup(counter);
    $('#fbk-text').blur(counter);
    $('#fbk-text').focus(counter);
});

*/
//***************END COUNT WORD (UNUSED NOW)**************************//





</script>


</body>
</html>


