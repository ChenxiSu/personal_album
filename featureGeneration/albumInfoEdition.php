<?php
	require_once 'config.php';
	$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$album_id = intval(filter_input(INPUT_GET, 'ID', FILTER_SANITIZE_STRING));
	$album_name = filter_input(INPUT_GET, 'Name', FILTER_SANITIZE_STRING);
	$album_description = filter_input(INPUT_GET, 'Desc', FILTER_SANITIZE_STRING);
	
	// echo "$album_name<br>";
	// echo "$album_description";
	if(!empty($album_name) ){
		$sql = "Update Album SET title='$album_name',albumDescription='$album_description' where album_id=$album_id;";
		$result = $mysqli->query($sql);
		if($result) echo "success";
		else echo "fail";
	
	}
	else{
		echo "wrong request";
	}
	die();
?>