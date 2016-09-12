<nav class="navbar navbar-fixed-top navbar-inverse" style="background:#002058">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" style="color:#E87722" href="/mentoring/index.php">CRAFT</a>
            </div>
            <button type="button" class="btn btn-default navbar-btn navbar-right" id="logout">Logout</button>
            
        </div>
      
  </nav>
<script>
  $(document).ready(function(){
    $('#logout').click(function(){
        
        $.post('/mentoring/webpage-utility/logout.php', function (response) {
            window.location.href='/mentoring/index.php';
        });
    });

});
</script>
