<?php
	require_once 'config.php';
	$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$al_id = filter_input(INPUT_GET, 'alID', FILTER_SANITIZE_STRING);
	$p_id =  filter_input(INPUT_GET, 'pID', FILTER_SANITIZE_STRING);
	$text = filter_input(INPUT_GET, 'newtext', FILTER_SANITIZE_STRING);

	
	$sql = "Update album_contain_photo SET description='$text' where  album_id='$al_id' and photo_id='$p_id' ;";
	$result = $mysqli->query($sql);
	if($result ){
		// header('Content-Type: application/json');
		// echo json_encode(array(
		// 	'result'=>"success",
		// 	''
		// ))
		echo "success";
	}else{
		echo "failed";
	}
	die();

?>