<?php
	require_once 'config.php';
	$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$results = $mysqli->query("Select * From Album");
	echo "<div id='albumsContainer'>";
	while($row = $results->fetch_row()){
		echo "<div class='album'>";
		//img generation
		echo "<div class='imgContainer'>";
		//https://www.google.com/url?sa=i&rct=j&q=&esrc=s&source=images&cd=&cad=rja&uact=8&ved=0ahUKEwjM55Tk9rvLAhXGHB4KHSfPCEwQjRwIBw&url=%2Furl%3Fsa%3Di%26rct%3Dj%26q%3D%26esrc%3Ds%26source%3Dimages%26cd%3D%26cad%3Drja%26uact%3D8%26ved%3D0ahUKEwjM55Tk9rvLAhXGHB4KHSfPCEwQjRwIBw%26url%3Dhttps%253A%252F%252Fwww.one.org%252Finternational%252Fblog%252Fleaders-do-nothing%252F%26psig%3DAFQjCNEEyTJmzkhlEYsITKpkXPpmZc0Ppg%26ust%3D1457898896935693&psig=AFQjCNEEyTJmzkhlEYsITKpkXPpmZc0Ppg&ust=1457898896935693
		//The address of the nothing image
		if($row[3] == 0){
			echo "<a href='#'><img class='coverPhoto' src='src/nothing.jpg' alt='nothing' /></a>";
		}
		else{
			$sql="Select photo.photo_name, photo.directory, photo.file_type, album_name From album_contain_photo inner join photo on album_contain_photo.photo_name=photo.photo_name where album_name= '$row[0]'  ";
			// $sql="select * from photo";//     
			$mysqli2 = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
			$temp = $mysqli2->query($sql);
			$result = $temp->fetch_row();
			if(!empty($result)){
				$src="";		
				$src .= $result[1];
				$src .= $result[0];
				$src .= ".".$result[2];
			}
			echo "<a href='albumDisplay.php?albumName=$result[3]&curNav=albums'><img class='coverPhoto' src=$src alt='nothing' /></a>";
		}
		echo "</div>";
		//description generation
		echo "<div class='description'>";
		echo "<p>album name: $row[0]</p>";
		echo "<p>number of photos: $row[3]</p>";
		echo "</div>";

		echo "</div> ";
	}
	// create a new album
	echo "<div class='album'>";

	echo "<div class='imgContainer'>";
	// https://www.google.com/url?sa=i&rct=j&q=&esrc=s&source=images&cd=&cad=rja&uact=8&ved=0ahUKEwjVws3a-LvLAhXMJB4KHW7SBnYQjRwIBw&url=https%3A%2F%2Fwww.iconfinder.com%2Ficons%2F311141%2Fadd_document_file_new_page_paper_icon&psig=AFQjCNFBUdtA0DUFjRJEFFbXKiHDQq3-3A&ust=1457899401604547
	echo "<a href='#'><img class='coverPhoto' src='src/addNewAlbum.png' alt='add new album' /></a>";
	echo "</div>";

	echo "<div class='description'>";
		echo "<p>Create a new album</p>";
	echo "</div>";
	echo "</div> ";
	echo "</div>";
?>