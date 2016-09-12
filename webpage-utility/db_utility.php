<?php

function connect_to_db(){
   require_once('db_config.php');
   // Create connection
   $connection = mysqli_connect($DB_HOST,$SQL_ACC,$SQL_PWD,$DB);

   // Check connection
   if (!$connection) {
       die("Connection failed: " . mysqli_connect_error());
   }
  
   mysqli_query($connection,"SET NAMES 'utf8'");
   mysqli_query($connection,"SET CHARACTER_SET_CLIENT=utf8");
   mysqli_query($connection,"SET CHARACTER_SET_RESULTS=utf8");

   return $connection;
}
?>
