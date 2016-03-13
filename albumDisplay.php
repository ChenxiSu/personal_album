<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Scanning Albums</title>
		<link rel="stylesheet" type="text/css" href="css/areaGeneration.css"/>
		<!-- <link rel="stylesheet" type="text/css" href="css/album.css"/> -->
		<link rel="stylesheet" type="text/css" href="css/albumDisplay.css"/>
		<script type="text/javascript" src="js/jquery-1.12.1.min.js"></script>
		<script type="text/javascript" src="js/interaction.js"></script>
		<script type="text/javascript" src ="js/setNav.js"></script>
		<script type="text/javascript" src="js/photoDisplay.js"></script>
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

				if (isset($_GET['albumName'])) {
					$albumName = $_GET['albumName'];
					echo "<div>";
					echo "<h2>Welcome to Chenxi's album: $albumName</h2>";
					echo "</div>";
					//connect to database to fetch photo info which belongs to current album
					require_once 'featureGeneration/config.php';
					$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
					$sql = "Select photo.photo_name, photo.directory, photo.file_type, album_name From album_contain_photo inner join photo on album_contain_photo.photo_name=photo.photo_name where album_name ='$albumName'";

					//generate a preview bar of thumbnails
					$rows = $mysqli->query($sql);
					$rows_count = $rows->num_rows;
					
					echo "<div id='thumbnailBar'>";
					for ($i=0; $i < $rows_count; $i++) { 					
						$curRow = $rows->fetch_row();
						//save database information into an array
						array_push($photosInfo, $curRow);
						$src ="";
						$src .= $curRow[1];
						$src .= $curRow[0];
						$src .= ".".$curRow[2];
						echo "<div class='thumbNailPhoto'>";
						echo "<a href='?curId=$i'><img src=$src /></a>";
						echo "</div>";
					}
					echo "</div>";

					//generate the big photo display frame
					$curSrc="";
					$curId=0;
					if(!isset($_GET['next'])){
						//initialize the display of album to its first recorded photo
						$curPhoto=$photosInfo[0];
						$curSrc = $curPhoto[1].$curPhoto[0].".".$curPhoto[2];
						showPhoto(0, $curSrc, $albumName);
					}
					else{
						$next = $_GET['next'];
						$curId = $_GET['curId'];
						$curId+=$next;
						if($curId<0 ){
							//already the first one
							$curPhoto=$photosInfo[0];
							$curSrc = $curPhoto[1].$curPhoto[0].".".$curPhoto[2];
							showPhoto(0, $curSrc,$albumName);

						}
						else if($curId == sizeof($photosInfo)){
							//already the last one
							$curPhoto=$photosInfo[$curId-1];
							$curSrc = $curPhoto[1].$curPhoto[0].".".$curPhoto[2];
							showPhoto($curId-1, $curSrc, $albumName);
						}
						else{
							// show the photo of curId
							$curPhoto = $photosInfo[$curId];
							$curSrc = $curPhoto[1].$curPhoto[0].".".$curPhoto[2];
							showPhoto($curId, $curSrc, $albumName);
						}
					}
					
				}
				// write a showPhoto function to generate html in different situations
				function showPhoto($thisId, $thisSrc, $albumName){
					echo "<div id='mainDisplay'>";	
					//left arrow
					echo "<div id='leftArrow'>";
					echo "<a href='?albumName=$albumName&next=-1&curId=$thisId&curNav=albums'><img src='src/leftArrow.png'></a>";
					echo "</div>";
					//main frame
					echo "<div id='mainDisplayFrame'>";
					echo "<img src='$thisSrc'>";
					echo "</div>";
					//right arrow
					echo "<div id='rightArrow'>";
					echo "<a href='?albumName=$albumName&next=1&curId=$thisId&curNav=albums'><img src='src/rightArrow.png'></a>";
					echo "</div>";

					echo "</div>";
				}
			?>

			<div id="footer">
				<!-- generate foot -->
				<?php include('featureGeneration/footer.php'); ?>
			</div>
		</div>
	</body>
</html>