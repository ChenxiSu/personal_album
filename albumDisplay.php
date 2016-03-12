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
				<!-- generate navigation -->
				<?php include('featureGeneration/nav.php'); ?>
			</div>

			<div id="content">
			<?php
				$rows = "";
				if (isset($_GET['albumName'])) {
					$albumName = $_GET['albumName'];
					echo "<div>";
					echo "<h2>Welcome to Chenxi's album: $albumName</h2>";
					echo "</div>";
					//connect to database to fetch photo info which belongs to current album
					require_once 'featureGeneration/config.php';
					$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
					$sql = "Select photo.photo_name, photo.directory, photo.file_type, album_name From album_contain_photo inner join photo on album_contain_photo.photo_name=photo.photo_name where album_name ='$albumName'";

					//generate a preview bar
					$rows = $mysqli->query($sql);
					$rows_count = $rows->num_rows;
					$firstRow;
					echo "<div id='thumbnailBar'>";
					for ($i=0; $i < $rows_count; $i++) { 
						if($i==0){
							$firstRow = $rows->fetch_row();							
							$src ="";
							$src .= $firstRow[1];
							$src .= $firstRow[0];
							$src .= ".".$firstRow[2];
							echo "<div class='thumbNailPhoto'>";
							echo "<a href='#'><img src=$src /></a>";
							echo "</div>";
						}
						else{
							$curRow = $rows->fetch_row();
							$src ="";
							$src .= $curRow[1];
							$src .= $curRow[0];
							$src .= ".".$curRow[2];
							echo "<div class='thumbNailPhoto'>";
							echo "<a href='#'><img src=$src /></a>";
							echo "</div>";
						}

					}
					echo "</div>";	

					//generate the main big display frame
					echo "<div id='mainDisplay'>";	
					$src = "";
					$src .= $firstRow[1];
					$src .= $firstRow[0];
					$src .= ".".$firstRow[2];
					echo "<div id='mainDisplayFrame'>";
					echo "<a href='#'><img src='$src'></a>";
					echo "</div>";
					echo "</div>";	

				}
				else {
					$albumName = "";
				}
			?>

			<div id="footer">
				<!-- generate foot -->
				<?php include('featureGeneration/footer.php'); ?>
			</div>
		</div>
	</body>
</html>