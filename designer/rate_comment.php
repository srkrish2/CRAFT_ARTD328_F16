<?php 

session_start();
//Get Designer ID
$designer_id=$_SESSION['designer_id'];
if(!$designer_id) { 	header("Location: ../index.php?"); die(); }
//Get Design ID
if(is_null($_GET['design_id']) ){header("Location: designer_home.php"); die();}
$design_id=$_GET['design_id'];

$title="";
$description="";
$type="";
$filename="";
 
include_once('../webpage-utility/db_utility.php');
$conn = connect_to_db();

//Get Design Info
  $sql="SELECT * FROM Designs WHERE DesignID=?";
  if($stmt=mysqli_prepare($conn,$sql))
  {
    mysqli_stmt_bind_param($stmt,"i",$design_id);
    mysqli_stmt_execute($stmt);
    $result = $stmt->get_result();
	$design_information = $result->fetch_assoc();
		$title=htmlspecialchars($design_information['title']);
		$title=preg_replace('#&lt;(/?(?:br /))&gt;#', '<\1>', $title); 	
			
   		$description=htmlspecialchars($design_information['description']);
		$description=preg_replace('#&lt;(/?(?:br /))&gt;#', '<\1>', $description);
   		
		$filename=$design_information['file'];
		$mid=$design_information['mid'];
    mysqli_stmt_close($stmt); 
  }

//Get Feedback
  $sql="SELECT * FROM Feedback WHERE DesignID=? ORDER BY FeedbackID ASC";
  if($stmt=mysqli_prepare($conn,$sql))
  {
  	$feedbacks = array();
    mysqli_stmt_bind_param($stmt,"i",$design_id);
    mysqli_stmt_execute($stmt);
    $result = $stmt->get_result();
    if (mysqli_num_rows($result) > 0) {
		// output data of each row
		while($row = mysqli_fetch_assoc($result)) {
			$feedbacks[] = $row;
		}
	}
    mysqli_stmt_close($stmt); 
  }

?>
<!DOCTYPE html>
<html>
<head>
  <title> CRAFT - View Feedback  </title>
  <?php include('../webpage-utility/ele_header.php');?>
  <script src="../js/jquery-1.11.3.min.js"></script>
 <link href="rate_comment.css" rel="stylesheet">
 <link href="../css/provider.css" rel="stylesheet">
</head>

<body>

<?php include('../webpage-utility/ele_nav.php');?>
  

<div class="main-section">
			
		<div class="container" style="background-color:white; padding-top:20px;   border-radius: 15px; ">
			<!--Design -->			
<!--Design -->			
			<div class="row">				
				 <div class="img-div" onmouseover="" style="cursor: pointer;" >
				 <img width="auto" height="300px" src=<?php echo $filename; ?> onClick="view(this);" >
				 <p><em style="color:grey">* Click on the image to enlarge </em></p>
				</div>
			 	<div style="margin-right:30px;">
			 		<h3><?php echo $title;?></h3>
			 		<p class="project-description"><?php echo $description;?> </p>
			 	</div>
	
			
			</div><!--end Design row--><!--end Design row-->

			
<hr>
				
			<?php
					if (count($feedbacks) > 0)
					{
						echo "<div id='head_frame'>";
						echo "<p class='question-text'><strong> Please read each piece of feedback below, rate its perceived quality, and indicate whether you will use the feedback. Also respond to the feedback. You may want to talk about if the feedback was helpful, what made it helpful, and what the feedback writer can do better next time.<br/><br/>Your response should reflect your personal opinions on the feedback.</strong></p>";
						echo "</div>";
						echo "<form name='rating-form' id='rating-form' action='save_rating.php?design_id=".$design_id."' method='post'>";
  						  echo "<table class='table table-hover table-nonfluid'>";
  						  //echo "<thead class='table-text'><th width='70%'>Feedback</th><th width='5%'></th><th width='25%'>Perceived Quality</th></tr></thead>";
  						   // echo " <thead><td></td><td width='70%' align='left'><strong>Feedback Content</strong></td><td width='25%' align='center'><strong>Perceived Quality</strong></td><td align='center'><strong>Intended Action</td></strong></thead>";
  						  echo " <tbody>";
  						  $count_feedback=1;
						 foreach($feedbacks as  $value)
					    {
					    	echo "<div id='div-".$value['FeedbackID']."' >";
						   	echo "<tr>";

						   	  $sql="SELECT * FROM Feedback_Rating WHERE FeedbackID=? AND RaterID=?";
							  if($stmt=mysqli_prepare($conn,$sql))
							  {
							    mysqli_stmt_bind_param($stmt,"ii",$value['FeedbackID'],$designer_id);
							    mysqli_stmt_execute($stmt);
							    $result = $stmt->get_result();
							    $designer_rating = $result['rating'];
								$action = $result['action'];
								$response = $result['response'];
								echo "<script>alert(".$response.")</script>";
							  }

							$content=htmlspecialchars($value['content']);
							$content=preg_replace('#&lt;(/?(?:br /))&gt;#', '<\1>', $content); 	
						echo '<p><?php echo $designer_rating." ".$action."?></p>';

						//content
				       		echo 
				       		"<td rowspan='2'><strong>#".$count_feedback."</strong></td>
				       		<td rowspan='2' width='60%' style='text-align: justify; padding-bottom:10px; padding-right:25px;' class='table-text'>
				       			<p><strong>Content</strong></p>
				       			<p>".$content."</p>
				       		</td>	
				       		
				       		<td width='35%'>
					       		<p><strong>Rating</strong></p>
					       		<table border='0' cellpadding='5' cellspacing='0'>
									<tr aria-hidden='true'>
										<td  class='radio-label'></td>
										<td><label class='radio-cell'>1</label></td> 
										<td><label class='radio-cell'>2</label></td> 
										<td><label class='radio-cell'>3</label></td> 
										<td><label class='radio-cell'>4</label></td>
										<td><label class='radio-cell'>5</label></td> 
										<td><label class='radio-cell'>6</label></td>
										<td><label class='radio-cell'>7</label></td> 
										<td  class='radio-label' ></td>
									</tr>
									
									<tr>
										<td class='radio-label' ><strong>Low</strong></td>
										<td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."1'  value='1' "; if ($designer_rating==1){echo "checked ";} echo "onclick='rate(this.name,1);'></td>
										<td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."2'  value='2' "; if ($designer_rating==2){echo "checked ";} echo "onclick='rate(this.name,2);'></td>
										<td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."3'  value='3' "; if ($designer_rating==3){echo "checked ";} echo "onclick='rate(this.name,3);'></td>
										<td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."4'  value='4' "; if ($designer_rating==4){echo "checked ";} echo "onclick='rate(this.name,4);'></td>
										<td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."5'  value='5' "; if ($designer_rating==5){echo "checked ";} echo "onclick='rate(this.name,5);'></td>
										<td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."6'  value='6' "; if ($designer_rating==6){echo "checked ";} echo "onclick='rate(this.name,6);'></td>
										<td class='radio-cell'><input type='radio' class='radio-inline' name='".$value['FeedbackID']."' id='".$value['FeedbackID']."7'  value='7' "; if ($designer_rating==7){echo "checked ";} echo "onclick='rate(this.name,7);'></td>
										<td class='radio-label'><strong>High</strong></td>		
									</tr>

								</table>
							</td>
							<td style='text-align:center' class='select1'>
								<p><strong>Action</strong></p>
								<select class='required' name='a".$value['FeedbackID']."' onchange='getval(this.name,this.value);' >
									<option value='0'"; if ($action==0){echo "";} echo "></option>
									<option value='1'"; if ($action==1){echo "selected ";} echo ">Ignore it</option>
									<option value='2'"; if ($action==2){echo "selected ";} echo ">Consider it</option>
									<option value='3'"; if ($action==3){echo "selected ";} echo ">Implement it</option>
								</select>
							</td>
						</tr>
						<tr>
							<td colspan='3' style='border-top:none;'>
								<p><strong>Your Response: </strong></p>";
									if(response==""){
										echo "<textarea id='b".$value['FeedbackID']."' name='b".$value['FeedbackID']."' rows='3' width='100%' />";
									} else {
										echo "<p>.".$response."</p>";
									}
							echo "</td>
						</tr>
						</div>
						";
				        	
		 			    	$count_feedback++;
						}

						 echo " </tbody></table>";
						 echo "</form>";
						 	echo "<div style='text-align:center;margin-top:20px;margin-bottom:20px'>";
							 echo "<button type='submit' class='btn-submit' id='submit-bn' onclick='submit();''>Submit</button> ";
							echo "</div>";
					}
					else
					{
						echo "<div style='padding-left:30px;'><label><h4 style='color:#580000'>We will contact you when the feedback is ready to review. Please wait...</h4></label><br>&nbsp<br>&nbsp<br>&nbsp</div>";
					}
					   
		mysqli_close($conn);
			
				?>
			

</div>
<script>
 function view(imgsrc) {
      viewwin = window.open(imgsrc.src,'viewwin', 'width=800,height=400px'); 
 }

function getval(_name, number)
{
	//var current_id=_name.substring(1);
	//$('#action_'+current_id).val(number);
	//alert($('#action_'+current_id).val());

}

function rate(_name, number){
	$('#div-'+_name).removeClass("has-error");

}


 function submit(){
 	
 	 $(':radio').each(function () {
        name = $(this).attr('name');
       
     $('#div-'+name).removeClass("has-error");
           
      
    });

 	var isOkay = true;
    $(':radio').each(function () {
        name = $(this).attr('name');
        if (  !$(':radio[name="' + name + '"]:checked').length) {
            $('#div-'+name).addClass("has-error");
           
            isOkay = false;
        }
    });

    $("textarea").each(function(){
        name = $(this).attr('name');
        if ( !$.trim(document.getElementsByName(name).val())) {
            $('#div-'+name).addClass("has-error");
            isOkay = false;
        }
    });

	var sels = document.getElementsByTagName("select");
	for (var i=0,n=sels.length;i<n;i++) {
		if(sels[i].selectedIndex <1){
		        isOkay = false; // disallow submit
		}
	}


 	if(isOkay == true)  {
 		$("#rating-form").submit();
 		//alert("Okay");
 	}
 	else{
 		alert("You have some feedback not been rated. (colored in red). Please rate them."); 	
 	}

 	
 }

 //function rate() This is an alternative to save ratings
</script>
</body>
</html>
