<?php
	require_once 'config.php';
	$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$recordIDStr = filter_input(INPUT_GET, 'recordIDs', FILTER_SANITIZE_STRING);;
	//get album id and max photo number

	$finalResult=true;
	if(!empty($recordIDStr)){
		$recordStrs = split("_", $recordIDStr);
		$albumID = intval($recordStrs[0]);
		$sqlNumberOfPhoto = "Select number_photo from Album where album_id='$albumID';";
		$result = $mysqli->query($sqlNumberOfPhoto);
		$row = $result->fetch_row();
		$maxNumber = intval($row[0]);

		for ($i=1; $i < sizeof($recordStrs); $i++) { 
			$record_id = intval($recordStrs[$i]);
			$sql = "Delete from album_contain_photo where record_id='$record_id';";
			$result = $mysqli->query($sql);
			$finalResult = $finalResult && $result;
		}

		if($finalResult){
			$curNumber = $maxNumber - sizeof($recordStrs)+1;
			$sqlSetNumber = "Update Album Set number_photo='$curNumber' where album_id='$albumID' ;";
			$mysqli->query($sqlSetNumber);
			echo "success";
		}
	}
	else{
		echo "empty request content";
	}
?>