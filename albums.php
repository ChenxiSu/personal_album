<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Scanning Albums</title>
		<link rel="stylesheet" type="text/css" href="css/areaGeneration.css"/>
		<link rel="stylesheet" type="text/css" href="css/album.css"/>
		<script type="text/javascript" src="js/jquery-1.12.1.min.js"></script>
		<script type="text/javascript" src="js/interaction.js"></script>
		<script type="text/javascript" src ="js/setNav.js"></script>
		<script type="text/javascript" src ="js/albumDeletion.js"></script>
	</head>
	<body>
		<?php
			include ('featureGeneration/function.php'); 
			if(!empty($_FILES['new_file']) ){
				// data retraction
				$newPhoto = $_FILES['new_file'];
				$description = htmlentities($_POST['description']);
				$checked_albums_id = [];
				$checked_albums_name=[];
				if(!empty($_POST['albumChoice'])){
					foreach ($_POST['albumChoice'] as $choice ) {
						$parameters = explode("_", $choice);
						array_push($checked_albums_id, $parameters[0]);
						array_push($checked_albums_name, $parameters[1]);
					}
				}
				//save the photo file
				$originalName = $newPhoto['name'];
				$type = $newPhoto['type'];
				if($newPhoto['error']==0){

					if(sizeof($checked_albums_id) == 0 ){
						array_push($checked_albums_id, 0);
						array_push($checked_albums_name,"Deafult");
					}

					$tempName = $newPhoto['tmp_name'];
					move_uploaded_file($tempName, "src/photos/$originalName");
					print("The file $originalName was uploaded successfully.\n");
					require_once 'featureGeneration/config.php';
					$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
					
					
					$searchedPhotoID = checkPhotoByName($originalName);

					if($searchedPhotoID < 0){
						// 1.1 do another query to get the max id numebr currently
						$sql_getMaxID = "Select Max(photo_id) From info230_SP16_cs2238sp16.photo;";
						$result_id = $mysqli->query($sql_getMaxID);
						$row = $result_id->fetch_row();
						$maxId = $row[0];
						$photo_id = $maxId+1;

						// 1.2 insert photo file info into photo table
						$photoName=split("\.", $originalName);////////////////////////////////////
						$file_type=$photoName[1];
						$directory = "src/photos/";
						$photo_values=[$photo_id, $photoName[0], $directory, $file_type];
						$photo_values_list = implode( "','", $photo_values);
						$sql_insert_photo = "INSERT INTO info230_SP16_cs2238sp16.photo ( photo_id, photo_name, directory, file_type) VALUES ( '$photo_values_list');";
						$mysqli->query($sql_insert_photo);

						//1.3 every time I upload a photo,
						//I create a thumbnail for the photo with same name diff directory
						
						$src="src/photos/".$originalName;
						$thumPathAndFile = "src/thumbNails/".$originalName;
						$thumbNailHeight=250;
						$transfer_result = save_thumbnail($src, $thumPathAndFile, $thumbNailHeight);
						
						for($i=0; $i<sizeof($checked_albums_id); $i++){

							//2.insert record into album_contain_photo， use for-each to access all albums
							$album_id=$checked_albums_id[$i];
							$album_name = $checked_albums_name[$i];
							$record_values = [$album_id, $photo_id, $photoName[0], $album_name, $description];
							$record_value_list =implode("','", $record_values);
							$sql_insert_record = "INSERT INTO info230_SP16_cs2238sp16.album_contain_photo (album_id, photo_id, photo_name, album_name, description) VALUES ( '$record_value_list' );";
							$result2 = $mysqli->query($sql_insert_record);

							//3.update album's total photo number
							$sql_get_number = "Select number_photo from Album where album_id = $album_id;";
							$result = $mysqli->query($sql_get_number);
							$row = $result->fetch_row();
							$newNumberOfPhoto = $row[0]+1;// do I need to change this into a number ??
							$sql_update_number = "Update Album SET number_photo=$newNumberOfPhoto where album_id=$album_id;";
							$mysqli->query($sql_update_number);
						}
					
					}
					else{
						
						$curPhotoID = $searchedPhotoID;
						// check whether the photo has been existing in one of albums
						for($i=0; $i<sizeof($checked_albums_id); $i++){

							$album_id=$checked_albums_id[$i];
							$album_name = $checked_albums_name[$i];

	
							$recordCheck = checkAlbumRecordByID($album_id, $curPhoto_id);

							if(!$recordCheck){
								//2.insert record into album_contain_photo， use for-each to access all albums
								$record_values = [$album_id, $curPhoto_id, $photoName, $album_name, $description];
								$record_value_list =implode("','", $record_values);
								$sql_insert_record = "INSERT INTO info230_SP16_cs2238sp16.album_contain_photo (album_id, photo_id, photo_name, album_name, description) VALUES ( '$record_value_list' );";
								
								$result2 = $mysqli->query($sql_insert_record);

								//3.update album's total photo number
								$sql_get_number = "Select number_photo from Album where album_id = $album_id";
								$result = $mysqli->query($sql_get_number);
								$row = $result->fetch_row();
								$newNumberOfPhoto = $row[0]+1;// do I need to change this into a number ??
								$sql_update_number = "Update Album SET number_photo=$newNumberOfPhoto where album_id=$album_id;";
								$mysqli->query($sql_update_number);
							}
						}
					}		
				}
				//return a message which will last for 1 second
			}
		?>
		<div id="container">
			<div id="header">
				<!-- header image source: http://www.freewebheaders.com/wordpress/wp-content/gallery/water-coast/water-coast-header-47711-1024x300.jpg -->
				<!-- generate header -->
				<?php include('featureGeneration/header.php') ?>
				<!-- generate navigation -->
				<?php include('featureGeneration/nav.php'); ?>
			</div>

			<div id="photo_uploading_area">
				<div id='preview'>
				</div>
				<div id='uploading_form'>
					<form action='albums.php' method='post' enctype='multipart/form-data'>
						<label class="file_upload_type_limit">File type limit: Currently only support .jpg,.png,.gif files</label><br>
						<input class="imageSelection" type='file' id='file_input' name='new_file' onchange='readURL(this)'/>
						
						<br><label>Description:</label><input id='descriptionInput' type='text' name='description'/><br/>
						<input type='hidden' name='curNav' value='albums' />
						<p>Please check all the albums that you want the photo to show in:</p>
						<ul>
							<?php include('featureGeneration/albumListGeneration.php');?>    
						</ul>
						<input id='uploadButton' type='submit' value='upload' onclick='return validationPhotoUploadingInAlbumPHP()'/><br>
					</form>
				</div>
			</div>
			<div id='album_deletion_form'>
				
					<p>Please check all the albums that you want to delete:</p>
					<ul id="albumList">
						<?php 
							include('featureGeneration/albumListGeneration.php');
							
						?>    
					</ul>
					<button type="button" id="delSubButton">Delete</button>
							
			</div>
			
			<div id="content">
				<?php 
				include('featureGeneration/albumGeneration.php'); 
				//side bar
				
				echo "<div id='rightSideBar'>";
				if(isset($_SESSION['logged_user'])){
					echo "<button id='showButton' class='switchButton'><p id='buttonText'>Upload photos</p></button>";
					echo "<button id='showDeletion'class='switchButton'><p>Album Deletion</p></button>";
					echo "<div id='create_new_album'>";
						echo "<form id='album_form' action='albums.php' method='post'>";
							echo "<br><label>Album name(required):</label><br>";
							echo "<input id='album_name_input' type='text' name='album_name' /><br><br>";
							echo "<label>Description:</label><br>";
							echo "<textarea class='descriptionInput' form='album_form' name='album_description'></textarea><br>";
							echo "<br><input id='submit' type='submit' value='CREATE' onclick='return validationAlbumCreation()' />";
						echo "</form>";
					echo "</div>";
					echo "<div id='userInfo'>";
					echo "<h2>user info display</h2>";
					echo "</div>";
				}
				else{
					// echo "<h2>You are a guest!</h2>";
				}
					
				echo "</div>";
				?>
			</div>

			<div id="footer">
				<!-- generate foot -->
				<?php include('featureGeneration/footer.php'); ?>
			</div>
		</div>
	</body>
</html>