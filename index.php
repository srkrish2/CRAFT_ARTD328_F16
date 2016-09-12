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
    <?php include('./webpage-utility/ele_header.php');?>
   <title>Signin Page </title>
    <!-- Custom styles for this template -->
    <link href="./css/signin.css" rel="stylesheet">

  </head>

  <body>
<!-- Nav Bar-->
  <div class="main-section">
    <div class="container" >
<nav class="navbar navbar-fixed-top navbar-inverse" style="background:#002058">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" style="color:#E87722" href="~/public_html/CRAFT_ARTD328_F16/index.php">CRAFT</a>
            </div>
         
        </div>
      
  </nav>
  <!-- End Nav Bar-->
      
         <div class="row">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">


        <form class="form-signin" >
          <h2 class="form-signin-heading">Please sign in</h2>
          <label for="inputEmail" class="sr-only">Email address</label>
          <input type="email" width="100px" name="inputEmail" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
          <label for="inputPassword" class="sr-only">Password</label>
          <input type="password" width="100px" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" required>
          <div class="checkbox">
           
          </div>
          <div id="result" style="color:red;"></div>
          
         
        </form>
        </div>

            <div class="col-sm-4"></div>
  </div>
        
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
                    default:
                       $("#result").text("Log in failed. Please contact the administrator at design4uiuc@gmail.com .");
                      break;
                  }
                  error:function(exception){
                    $("#result").text('Exeption:'+exception));
                  }
                   
                }
            });
      
}
</script>


  </body>

</html>