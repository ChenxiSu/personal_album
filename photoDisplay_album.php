<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Scanning Albums</title>
		<link rel="stylesheet" type="text/css" href="css/areaGeneration.css"/>
		<!-- <link rel="stylesheet" type="text/css" href="css/album.css"/> -->
		<link rel="stylesheet" type="text/css" href="css/photoDisplay.css"/>
		<script type="text/javascript" src="js/jquery-1.12.1.min.js"></script>
		<script type="text/javascript" src ="js/setNav.js"></script>
		<script type="text/javascript" src="js/photo_display_add_new.js"></script>
		<script type="text/javascript" src="js/interaction.js"></script>
		<script type="text/javascript" src="js/albumInfoEdition.js"></script>
		<script type="text/javascript" src="js/photoDeletion.js"></script>
	</head>
	<body>
		<div id="container">
			<div id="header">
				<!-- header image source: http://www.freewebheaders.com/wordpress/wp-content/gallery/water-coast/water-coast-header-47711-1024x300.jpg -->
				<!-- generate header -->
				<?php include('featureGeneration/header.php') ?>
				<!-- generate navigation bar -->
				<?php 
					include('featureGeneration/nav.php'); ?>
			</div>

			<div id="content">
			<?php
				$rows = "";
				$photosInfo=array();
				$album_id;
				include ('featureGeneration/function.php');
				if (isset($_POST['album_id']) && isset($_POST['album_name'])) {
					$album_id = $_POST['album_id'];
					$albumDescription;
					//$album_id=filter_input(INPUT_POST, 'album_id',FILTER_SANITIZE_STRING);
					$album_name = $_POST['album_name'];
					//connect to database 
					require_once 'featureGeneration/config.php';
					$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
					$sql = "Select albumDescription from Album where album_id='$album_id';";
					$result = $mysqli->query($sql);

					if($result && $result->num_rows==1){
						$row= $result->fetch_row();
						$albumDescription= $row[0]; 
					}
					else{
						$albumDescription=" ";
					}
					// if new photos got uploaded, insert info into database first
					if(!empty($_FILES['new_file']) ){
						$description = htmlentities($_POST['description']);
					// photo information in db : name, src=src/photos/ , 
						// type, updated date [location,description]
						$newPhoto = $_FILES['new_file'];
						//$originalName = str_replace(' ', '%20', $newPhoto['name']);
						$originalName = $newPhoto['name'];
						$type = $newPhoto['type'];
						$fileName=split("\.", $originalName);
						$file_type=$fileName[1];
						$photoName = $fileName[0];
						$directory = "src/photos/";

						if($newPhoto['error'] == 0){
							//search db by name to figure out whether the
							// same photo has been 
							
							$searchedPhotoID = checkPhotoByName($originalName);
							
							if($searchedPhotoID<0){
								$tempName = $newPhoto['tmp_name'];
								//$tempName = str_replace(' ','%20', $newPhoto['tmp_name']);
								move_uploaded_file($tempName, "src/photos/$originalName");
								
								$sql_getMaxID = "Select Max(photo_id) From info230_SP16_cs2238sp16.photo;";
								$result_id = $mysqli->query($sql_getMaxID);
								$row = $result_id->fetch_row();
								$maxId = $row[0];
								$curPhoto_id = $maxId+1;

								//1.2 insert photo into photo table
								
								$field_values=[$curPhoto_id, $photoName, $directory, $file_type];
								$value_list = implode( "','", $field_values );
								$sql_insert_photo = "INSERT INTO info230_SP16_cs2238sp16.photo ( photo_id, photo_name, directory, file_type) VALUES ( '$value_list');";
								$result = $mysqli->query($sql_insert_photo);

								//1.3 every time I upload a photo,
								//I create a thumbnail for the photo with same name diff directory
								// include ('featureGeneration/function.php'); 
								$src="src/photos/".$originalName;
								$thumPathAndFile = "src/thumbNails/".$originalName;
								$thumbNailHeight=250;
								$transfer_result = save_thumbnail($src, $thumPathAndFile, $thumbNailHeight);
								
								// 2. insert record into album_contain_photo
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
							else{
								//1.photo already in photo table,
								//no need to upload again
								$curPhoto_id=$searchedPhotoID;
								//2.check whether photo already in album using album and photoid
								// include ('featureGeneration/function.php');
								$recordCheck = checkAlbumRecordByID($album_id, $curPhoto_id);
								
								if($recordCheck==true){
									echo "<h1>Photo already in this album: $album_name</h1>";
								}
								else{
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
							
							
							//print("The file $originalName was uploaded successfully.\n");
							// now starting change the database
		
							// do another query to get the max id numebr currently	

						}else{

							print("Error: The file $originalName was not uploaded.\n");
						}
					}
					// now consider reading data from updated database and generate display!

					//div: for showing the current location and uploading file(filename)e button
					echo "<div id='cur_album_position'>";
					echo "<a id='back_to_album' href='albums.php'><h2>personal albums > </h2></a><h2 id='albumNameInPosition'> $album_name</h2>";
					echo "</div>";
					//div :save space for uploading new photo
					echo "<div id='add_new_photo'>";
						echo "<div id='preview'>";
						echo "</div>";
						echo "<div id='uploading_form'>";
							echo "<form action='photoDisplay_album.php' method='post' enctype='multipart/form-data'>";
								echo "<input id='chooseFileButton' type='file' name='new_file' onchange='readURL(this)'/><br/>";
								echo "<label>Description:</label><input id='input_description' type='text' name='description'/><br><br>";
								echo "<input type='hidden' name='album_name' value='$album_name' />";
								echo "<input type='hidden' name='album_id' value='$album_id' />";
								echo "<input type='hidden' name='curNav' value='albums' />";
								echo "<input type='submit' id='uploadButton' value='upload' onclick='return descriptionValidation()' />";
							echo "</form>";
						echo "</div>";
					echo "</div>";

					echo "<div id='edit_album'>";
						//echo "<form id='albumInfoChangeForm' action='photoDisplay_album.php' method='post'>";
						echo "<label>Album Name:</label><input type='text' id='albumNameInput' value='$album_name'><br><br>";
						echo "<label>Album Description:</label>";
						echo "<textarea id='descriptionArea' name='albumDes' >$albumDescription</textarea><br>";
						echo "<button type='button' id='updateAlbumButton'>Update</button>";
						//echo "</form>";
						
					echo "</div>";
					
					//div :build a whole space for left photo display area and right bar
					echo "<div id='main_display'>";
				
					$sql = "Select photo.photo_name, photo.directory, photo.file_type, photo.photo_id, description, record_id From album_contain_photo inner join photo on album_contain_photo.photo_id=photo.photo_id where album_id =$album_id";

					//show all photos in this album in thumbnails
					$rows = $mysqli->query($sql);
					if(!empty($rows)){
						$rows_count = $rows->num_rows;
					
						echo "<div id='thumbnailArea'>";

						for ($i=0; $i < $rows_count; $i++) { 					
							$curRow = $rows->fetch_row();
							//save database information into an array
							array_push($photosInfo, $curRow);
							$src ="";
							$src .= $curRow[1];
							$src .= $curRow[0];
							$src .= ".".$curRow[2];
							$thumPathAndFile = "src/thumbNails/".$curRow[0].".".$curRow[2];
							//$thumbNailHeight=250;
							//$transfer_result = save_thumbnail($src, $thumPathAndFile, $thumbNailHeight);
							if(empty($curRow[4]) ){
								$curRow[4]="no description";
							}
							echo "<div class='thumbnailContainer'>";
								echo "<img class='thumbNailImg' src='$thumPathAndFile'>";//href='?photo_id=$curRow[3]'
								echo "<br><label id='$curRow[5]'>record id:$curRow[5]</label><br>";
								echo "<p  photo_id='$curRow[3]'>$curRow[4]</p>";
								echo "<input album_id='$album_id' class='editDesc' id='$curRow[3]' type='text' value='$curRow[4]'>";
							echo "</div>";
						}
					}

					echo "</div>";

					echo "<div id='right_album_bar'>";
						echo "<div id='display_album_info'>";
							echo "<p>Album ID:<span id='al_id'>$album_id</span></p>";
							echo "<p>Album Name:<span id='name'>$album_name</span></p>";
							echo "<p>Album Description:<span id='desc'>$albumDescription</span></p>";
						echo "</div>";
						if(isset($_SESSION['logged_user'])){
							echo "<button id='uploading' class='button'>Upload photos</button>";
							echo "<button id='editAlbum' class='button'>Edit Album Info</button>";
							echo "<button id='deletePhoto' class='button'>Delete photo</button>";
						}
						echo "<div id='display_photo_list'>";
							echo "<ul id='photoUL'>";
							$result = $mysqli->query($sql);	
							for($i=0; $i<$result->num_rows; $i++){
								$row = $result->fetch_row();
								$recordId = $row[5];
								echo  "<li id='$recordId'><label>record_ID: $recordId</label> <input id='$recordId' type='checkbox' name='albumChoice[]'  /></li>";;
							}
							echo "</ul>";
							echo "<button id='deletionButton'>delete</button>";
						echo "</div>";
						
					echo "</div>";
				echo "</div>";
				}
			?>
			</div>
			<div id="myModel" class="photoDisplayModel">
				<span id="close">x</span>
				<div id="mainModel">
					<div id="leftClickArea">
					</div>
					<div id="imgFrame">
						<div id="imgWrapper">
							<img id="curImg" class="displayedImg">
						</div>	
					</div>
					<div id="rightClickArea"></div>
				</div>
				
			</div>

			<div id="footer">
				<!-- generate foot -->
				<?php include('featureGeneration/footer.php'); ?>
			</div>
		</div>
	</body>
</html>