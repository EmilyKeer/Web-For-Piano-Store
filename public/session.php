<?php
  session_start();
  function message(){
    if (isset($_SESSION["message"])){
      $output = "<div class=\"message\">";
      $output .= htmlentities($_SESSION["message"]);
      $output .= "</div>";
    //  $_SESSION["message"] = null; //clear message after use
      return $output;
    }
  }
 ?>
