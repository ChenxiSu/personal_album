<?php
	require_once 'config.php';
	$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	// whether request for new album creation has been created
	if(isset($_POST['album_name'])){
		$album_name = htmlentities($_POST['album_name']);
		$album_description = htmlentities($_POST['album_description']);
		$values = [$album_name,0,$album_description];
		$value_list = implode("','", $values);
		$sql_insert_album = "INSERT INTO info230_SP16_cs2238sp16.Album ( title, number_photo, albumDescription) VALUES ( '$value_list');";
		$result = $mysqli->query($sql_insert_album);
	}

	//generate all albums
	$results = $mysqli->query("Select * From Album");
	echo "<div id='albumsContainer'>";

	while($row = $results->fetch_row()){
		echo "<div class='album' id='$row[0]' >";
		//img generation
		echo "<div class='imgContainer'>";
		//https://www.google.com/url?sa=i&rct=j&q=&esrc=s&source=images&cd=&cad=rja&uact=8&ved=0ahUKEwjM55Tk9rvLAhXGHB4KHSfPCEwQjRwIBw&url=%2Furl%3Fsa%3Di%26rct%3Dj%26q%3D%26esrc%3Ds%26source%3Dimages%26cd%3D%26cad%3Drja%26uact%3D8%26ved%3D0ahUKEwjM55Tk9rvLAhXGHB4KHSfPCEwQjRwIBw%26url%3Dhttps%253A%252F%252Fwww.one.org%252Finternational%252Fblog%252Fleaders-do-nothing%252F%26psig%3DAFQjCNEEyTJmzkhlEYsITKpkXPpmZc0Ppg%26ust%3D1457898896935693&psig=AFQjCNEEyTJmzkhlEYsITKpkXPpmZc0Ppg&ust=1457898896935693
		//The address of the nothing image
		
		// generate albums through looping
		$sql="Select photo.photo_name, photo.directory, photo.file_type, album_name, album_id From album_contain_photo inner join photo on album_contain_photo.photo_id=photo.photo_id where album_id = '$row[0]'  ";
		// $sql="select * from photo";//     
		$mysqli2 = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		$temp = $mysqli2->query($sql);
		$src="";
		if($result = $temp->fetch_row()){
			$src .= $result[1];
			$src .= $result[0];
			$src .= ".".$result[2];			
		}
		else{
			$src = "src/nothing.jpg";	
		}
		echo "<form class='form' method='post' action='photoDisplay_album.php?album=$row[1]&curNav=albums'>";
		// echo "<img class='coverPhoto' src=$src alt='nothing' />";
		echo "<input type='hidden' name='album_name' value='$row[1]' />";
		echo "<input type='hidden' name='album_id' value='$row[0]' />";
		echo "<input type='hidden' name='curNav' value='albums'>";			
		echo "<input type='submit' id='submitButton' value='' style='background-image: url($src); background-repeat:no-repeat;background-size: contain' />";
		echo "</form>";

		echo "</div>";
		//description generation
		echo "<div class='description'>";
		echo "<p>album name: $row[1]</p>";
		echo "<p>number of photos: $row[4]</p>";
		echo "</div>";

		echo "</div> ";
	}
	echo "</div>";
?>