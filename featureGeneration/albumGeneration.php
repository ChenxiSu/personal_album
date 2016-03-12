<?php
	require_once 'config.php';
	$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$results = $mysqli->query("Select * From Album");
	while($row = $results->fetch_row()){
		echo "<div class='album'>";
		//https://www.google.com/url?sa=i&rct=j&q=&esrc=s&source=images&cd=&cad=rja&uact=8&ved=0ahUKEwip8MHS7bjLAhUKPCYKHQp1AicQjRwIBw&url=https%3A%2F%2Fpixabay.com%2Fen%2Fnothing-is-written-in-stone-rock-527756%2F&psig=AFQjCNH2BUH-_EhweqJQieDc2n5dvUvWjw&ust=1457793282739410
		//The address of the nothing image
		if($row[3] == 0){
			echo "<img src='src/nothing.jpg' alt='nothing' />";
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
			echo "<a href='albumDisplay.php?albumName=$result[3]'><img class='coverPhoto' src=$src alt='nothing' /></a>";
		}
		echo "<p>album name: $row[0]</p>";
		echo "<p>number of photos: $row[3]</p>";
		echo "</div>";
	}
?>