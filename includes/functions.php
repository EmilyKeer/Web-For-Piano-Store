<?php
	function redirect_to ($new_location){
		header("Location: ".$new_location);
		exit;
	}

	function mysql_prep($string){
		//prepare before use to avoid injection
		global $connection;
		$escaped_string = mysqli_real_escape_string ($connection, $string);
		return $escaped_string;
	}

	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed.");
		}
	}

	function form_errors($errors=array()) {
		//display errors
	$output = "";
	if (!empty($errors)) {
	  $output .= "<div class=\"error\">";
	  $output .= "Please fix the following errors:";
	  $output .= "<ul>";
	  foreach ($errors as $key => $error) {
	    $output .= "<li>{$error}</li>";
	  }
	  $output .= "</ul>";
	  $output .= "</div>";
	}
	return $output;
}

	function find_all_subjects(){
		global $connection; //already difine $connection at the top
		$query  = "SELECT * ";
		$query .= "FROM subjects ";
		//$query .= "WHERE visible = 1 ";
		$query .= "ORDER BY position ASC";
		$subject_set = mysqli_query($connection, $query);
		confirm_query($subject_set);
		return $subject_set;
	}

	function find_pages_for_subject($subject_id){
		global $connection;
		$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);
		$query  = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE visible = 1 ";
		$query .= "AND subject_id = {$safe_subject_id} ";//space at the end
		$query .= "ORDER BY position ASC";
		$page_set = mysqli_query($connection, $query);
		confirm_query($page_set);
		return $page_set;
	}

	function find_subject_by_id($subject_id){
		global $connection;
		$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);//avoid sql injection;slash special chars
		$query  = "SELECT * ";
		$query .= "FROM subjects ";
		$query .= "WHERE id = {$safe_subject_id} ";
		$query .= "LIMIT 1";
		$subject_set = mysqli_query($connection, $query);
		confirm_query($subject_set);
		if ($subject = mysqli_fetch_assoc($subject_set)) //to return assoc array
		{
			return $subject;
		}
		else{
			return null;
		}

	}

	function find_page_by_id($page_id){
		global $connection;
		$safe_page_id = mysqli_real_escape_string($connection, $page_id);//avoid sql injection;slash special chars
		$query  = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE id = {$safe_page_id} ";
		$query .= "LIMIT 1";
		$page_set = mysqli_query($connection, $query);
		confirm_query($page_set);
		if ($page = mysqli_fetch_assoc($page_set)) //to return assoc array
		{
			return $page;
		}
		else{
			return null;
		}

	}

	function find_selected_page(){
		global $current_subject;//you can: 1.define in main then global in func;
		global $current_page; // 2.global in func first and use in main
		if(isset($_GET["subject"])){
			$current_subject = find_subject_by_id($_GET["subject"]);
			$current_page = null; //think of all case
		}
		elseif(isset($_GET["page"])){
			$current_page = find_page_by_id($_GET["page"]);
			$current_subject = null;
		}
		else{
			$current_subject = null;
			$current_page = null;
		}
	}

	function navigation($subject_array, $page_array){
    //subject array or null, page array or null
				$output = "<ul class=\"subjects\">";
				$subject_set = find_all_subjects();
				while($subject = mysqli_fetch_assoc($subject_set)) {
				$output .=  "<li "; //space at the end
				if($subject_array && ($subject["id"] == $subject_array["id"])){ //latter is unique in one single load page
					$output .= "class=\"selected\"";
				}
				$output .= ">";
				$output .= "<a href=\"manage_content.php?subject=";
				$output .= urlencode($subject["id"]);
				$output .= "\">";
				$output .= $subject["menu_name"];
				$output .= "</a>";
				$page_set = find_pages_for_subject($subject["id"]);
				$output .= "<ul class=\"pages\">";
					while($page = mysqli_fetch_assoc($page_set)) {
						$output .= "<li ";
						if($page_array && ($page["id"] == $page_array["id"])){ //latter is unique in one single load page
							$output .=  "class=\"selected\"";
						}
						$output .=  ">";
						$output .= "<a href=\"manage_content.php?page=";
						$output .= urlencode($page["id"]);
						$output .= "\">";
						$output .=  $page["menu_name"];
						$output .= "</a></li>";

						} //attention to ending brace
				$output .= "</ul>";
				mysqli_free_result($page_set);
				$output .= "</li></br>";
			}
		  mysqli_free_result($subject_set);
		$output .= "</ul>";

		return $output;
	}



?>
