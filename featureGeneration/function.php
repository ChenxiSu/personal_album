<?php
	function checkAlbumRecordByID($album_id, $photo_id){
		require_once 'featureGeneration/config.php';
		$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		$sql = "Select * from album_contain_photo where album_id='$album_id' and photo_id='$photo_id';";
		$result = $mysqli->query($sql);
		if($result->num_rows ==1){
			return true;
		}
		else return false;
	}
	function checkPhotoByName($photoName){
		require_once 'featureGeneration/config.php';
		$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		$newPhoto = split("\.", $photoName);
		$newPhotoName = $newPhoto[0];
		$newPhotoType = $newPhoto[1];
		$sql = "Select * From photo where photo_name='$newPhotoName' and file_type='$newPhotoType' ";
		$result = $mysqli->query($sql);
		if($result->num_rows==1){
			$row = $result->fetch_row();
			return $row[0];
		}
		else{
			return -1;
		}
	}

	function  save_thumbnail ($source, $thumPathAndFile, $thumbHeight){
							// echo "<h1>$source</h1>";
		$img;
		$type = explode(".", $source)[1];
		if($type === "jpg" || $type === "JPG"){
			
			$img = imagecreatefromjpeg( $source );
		}
		else if($type === "png" || $type ==="PNG"){
			$img = imagecreatefrompng($source);
		}
		else if($type === "gif" || $type ==="GIF"){
			$img = imagecreatefromgif($source);
		}							
		
		
		//get width and height of original file
		$width = imagesx($img);
		$height = imagesy($img);
		// width and height of new file
		$new_height = $thumbHeight;
		$new_width = floor(($width*$thumbHeight)/$height);
		$new_img = imagecreatetruecolor($new_width, $new_height);
		imagecopyresampled($new_img,$img,0,0,0,0,$new_width,$new_height,$width,$height);
		$return = imagejpeg($new_img,$thumPathAndFile);
		imageDestroy($img);
		imageDestroy($new_img);
		return $return;
	}

	function displayAllPhoto(){
		require_once 'featureGeneration/config.php';
		$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		$sql = "Select photo.photo_name, photo.file_type, album_name, description,uploaded_date From  photo left join album_contain_photo on photo.photo_id=album_contain_photo.photo_id;";
		$rows = $mysqli->query($sql);

		if(!empty($rows)){
			//echo "<h1>Query correct</h1>";
			$thumDirectory = "src/thumbNails/";
			$rows_count = $rows->num_rows;
			for ($i=0; $i < $rows_count; $i++) { 
				$curRow = $rows->fetch_row();
				$src = $thumDirectory.$curRow[0].".".$curRow[1];
				
				echo "<div class='thumbnailContainer'>";
					echo "<img class='thumbNailImg' src=$src>";
					echo "<label class='album'><br>Album: $curRow[2]</label><br>";
					echo "<label class='description'>Description: $curRow[3]</label><br>";
					echo "<label class='uploadTime'>Uploaded time:$curRow[4]</label>";
				echo "</div>";
			}

		}else{
			echo "<h1>Query empty</h1>";
		}	
		
	}
	function searchPhotoByTextAndAlbum($album_ID, $text){
		require_once 'featureGeneration/config.php';
		$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		$sql = "Select photo.photo_name, photo.file_type, album_name, description,uploaded_date From  photo left join album_contain_photo on photo.photo_id=album_contain_photo.photo_id where album_contain_photo.album_id='$album_ID' ;";
		$rows = $mysqli->query($sql);

		if(!empty($rows)){
			//echo "<h1>Query correct</h1>";
			$thumDirectory = "src/thumbNails/";
			$rows_count = $rows->num_rows;
			for ($i=0; $i < $rows_count; $i++) { 
				$curRow = $rows->fetch_row();
				$src = $thumDirectory.$curRow[0].".".$curRow[1];
				$description = $curRow[3];
				


				if(strpos($description,$text ) !== false){
					echo "<div class='thumbnailContainer'>";
						echo "<img class='thumbNailImg' src=$src>";
						echo "<label class='album'><br>Album: $curRow[2]</label><br>";
						echo "<label class='description'>Description: $curRow[3]</label><br>";
						echo "<label class='uploadTime'>Uploaded time:$curRow[4]</label>";
					echo "</div>";
				}
			}

		}else{
			echo "<h1>Search empty</h1>";
		}	


	}
	function disAllPhotoInSpecifiedAlbum($album_ID){
		require_once 'featureGeneration/config.php';
		$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		$sql = "Select photo.photo_name, photo.file_type, album_name, description,uploaded_date From  photo left join album_contain_photo on photo.photo_id=album_contain_photo.photo_id where album_contain_photo.album_id='$album_ID' ;";
		$rows = $mysqli->query($sql);

		if(!empty($rows)){
			//echo "<h1>Query correct</h1>";
			$thumDirectory = "src/thumbNails/";
			$rows_count = $rows->num_rows;
			for ($i=0; $i < $rows_count; $i++) { 
				$curRow = $rows->fetch_row();
				$src = $thumDirectory.$curRow[0].".".$curRow[1];
				
				echo "<div class='thumbnailContainer'>";
					echo "<img class='thumbNailImg' src=$src>";
					echo "<label class='album'><br>Album: $curRow[2]</label><br>";
					echo "<label class='description'>Description: $curRow[3]</label><br>";
					echo "<label class='uploadTime'>Uploaded time:$curRow[4]</label>";
				echo "</div>";
			}

		}else{
			echo "<h1>Query empty</h1>";
		}

	}

	function displayAllPhotoByText($text){
		require_once 'featureGeneration/config.php';
		$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
		$sql = "Select photo.photo_name, photo.file_type, album_name, description,uploaded_date From  photo left join album_contain_photo on photo.photo_id=album_contain_photo.photo_id;";
		$rows = $mysqli->query($sql);

		if(!empty($rows)){
			//echo "<h1>Query correct</h1>";
			$thumDirectory = "src/thumbNails/";
			$rows_count = $rows->num_rows;
			for ($i=0; $i < $rows_count; $i++) { 
				$curRow = $rows->fetch_row();
				$src = $thumDirectory.$curRow[0].".".$curRow[1];
				$description = $curRow[3];
				


				if(strpos($description,$text ) !== false){
					echo "<div class='thumbnailContainer'>";
						echo "<img class='thumbNailImg' src=$src>";
						echo "<label class='album'><br>Album: $curRow[2]</label><br>";
						echo "<label class='description'>Description: $curRow[3]</label><br>";
						echo "<label class='uploadTime'>Uploaded time:$curRow[4]</label>";
					echo "</div>";
				}
			}

		}else{
			echo "<h1>Search empty</h1>";
		}	

	}

	function showLoginForm(){
		echo "<h2>Please log in";
		echo "<form action='login.php' method='post'>";
		echo "<label>Username:</label>";
		echo "<input type='text' name='username'>";
		echo "<label>Password:</label>";
		echo "<input type='password' name='password'>";

		echo "<input type='submit' value='Submit'>";
		echo "</form>";
	}

?>