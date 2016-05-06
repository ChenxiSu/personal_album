<?php
	require_once 'config.php';
	$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$album_id = filter_input(INPUT_GET, 'IDs', FILTER_SANITIZE_STRING);
	$ids = split("_", $album_id);
	if(!empty($album_id)){
		for ($i=0; $i < sizeof($ids); $i++) { 
			$id = intval($ids[$i]);
			$sql1 = "Delete from Album where album_id='$id';";
			$result1 = $mysqli->query($sql1);
			$sql2 = "Delete from album_contain_photo where album_id='$id';";
			$result2 = $mysqli->query($sql2);
		}

		if($result1 && $result2){
			echo "success";
		}
		else{
			echo "failed";
		}
	}
	else{
		echo "empty input";
	}
	die();
	


?>