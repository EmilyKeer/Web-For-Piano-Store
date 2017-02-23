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

  function errors() {
		if (isset($_SESSION["errors"])) {
			$errors_output = $_SESSION["errors"];

			// clear message after use
			$_SESSION["errors"] = null;

			return $errors_output;
		}
	}
 ?>
