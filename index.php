<?php
    session_start();
    $_SESSION["experimentID"]=3;
    $_SESSION["role"]=1; //Designer login
//    header('Location: sign-up-close.php');
    if(!$_SESSION["designer_id"])
    {
      //haven't login;
    }else{
      //Already login
      header('Location: designer/homepage.php');
    }

?>


<!DOCTYPE html>
<html lang="en">
  <head>
   <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <?php include($_SERVER['DOCUMENT_ROOT'].'/mentoring/webpage-utility/ele_header.php');?>
   <title>Signin Page </title>
    <!-- Custom styles for this template -->
    <link href="/mentoring/css/signin.css" rel="stylesheet">

  </head>

  <body>
<!-- Nav Bar-->
<nav class="navbar navbar-fixed-top navbar-inverse" style="background:#002058">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" style="color:#E87722" href="/mentoring/index.php">CRAFT</a>
            </div>
         
        </div>
      
  </nav>
  <!-- End Nav Bar-->

  
  <div class="main-section">
      <div class="container">

        <form class="form-signin">
          <h2 class="form-signin-heading">Please sign in</h2>
          <label for="inputEmail" class="sr-only">Email address</label>
          <input type="email" name="inputEmail" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
          <label for="inputPassword" class="sr-only">Password</label>
          <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" required>
          <div class="checkbox">
           
          </div>
          <div id="result" style="color:red;"></div>
          
         
        </form>
        
        <div class="row" style="text-align:center; padding-bottom:20px">
         <button type="button" class="btn btn-large btn-primary" onclick="submit()">Sign in</button>
         <!--<button type="button" class="btn btn-large btn-success" onclick="window.location.href='./sign-up.php'">Register</button>-->
       </div>
         <?php include("webpage-utility/footer.php") ?>
      </div> <!-- /container -->
  </div>


<script type="text/javascript">

$( "#inputEmail" ).keydown(function() {
   $("#result").text("");
});

$( "#inputPassword" ).keydown(function() {
   $("#result").text("");
});

function submit(){
     
      
            $.ajax({
                type: "POST",
                url: "login_verify.php",
                data: { inputEmail:$.trim($("input#inputEmail").val()),inputPassword:$.trim($("input#inputPassword").val())},
                success: function(data){
                  switch(data)
                  {
                    case "email_not_exit":
                      $("#result").text("You haven't signed up for the system, please contact the administrator.");
                      break;
                    case "pwd_incorrect":
                      $("#result").text("Your password is incorrect.");
                      break;
                    case "success":
                      window.location.href = "designer/homepage.php";
                      break;
                    case "finished":
                      $("#result").text("You have completed the study. Thank you.");
                      break;
                    case "remove":
                      window.location.href = "sign-up-close.php";
                      break;
                    default:
                       $("#result").text("Log in failed. Please contact the administrator at design4uiuc@gmail.com .");
                      break;
                  }
                   
                }
            });
      
}
</script>


  </body>

</html>