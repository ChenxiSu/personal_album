<?php
	require_once 'config.php';
	$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	// whether request for new album creation has been created
	$sql = "Select album_id, title from Album;";
	$results = $mysqli->query($sql);
	
	while($row = $results->fetch_row()){
		$value="".$row[0]."_".$row[1];
		// echo "<h1>$value</h1>";
		echo "<li id='$row[0]'><label>$row[1]</label> <input type='checkbox' name='albumChoice[]' value='$value' /></li>";
							    
	} 
	
	$mysqli->close();
?>