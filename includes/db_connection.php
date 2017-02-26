<?php
  define("DB_SERVER", "localhost");//localhost setting 
	define("DB_USER", "Hebe"); //use your username for database
	define("DB_PASS", "password");//use your password for database
	define("DB_NAME", "piano_store");//use the name of the database

  // 1. Create a database connection
  $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
  // Test if connection succeeded
  if(mysqli_connect_errno()) {
    die("Database connection failed: " .
         mysqli_connect_error() .
         " (" . mysqli_connect_errno() . ")"
    );
  }
?>
