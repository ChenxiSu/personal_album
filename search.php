<?php session_start();?>
<!DOCTYPE html>
<html>
	<head>
		<title>Search</title>
		<link rel="stylesheet" type="text/css" href="css/areaGeneration.css"/>
		<link rel="stylesheet" type="text/css" href="css/search.css"/>
		<script type="text/javascript" src="js/jquery-1.12.1.min.js"></script>
		<script type="text/javascript" src ="js/setNav.js"></script>
		<script type="text/javascript" src ="js/search.js"></script>

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
				<form id="searchForm" action="search.php" method="post">
					<div id="selectAlbum">
						<span>Specify Album</span>
						<select id="albumNameSelector" name = "album">
							<?php
								require_once 'featureGeneration/config.php';
								$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
								// whether request for new album creation has been created
								$sql = "Select album_id, title from Album;";
								$results = $mysqli->query($sql);
								echo "<option id='-1'>unspecified</option>";
								while($row = $results->fetch_row()){
									$value="".$row[0]."_".$row[1];
									// echo "<h1>$value</h1>";
									echo "<option id='$row[0]'>$row[1]</option>";						    
								} 
								$mysqli->close();
							?>
							 
					
						</select> 

					</div>
					<div id="captionCondition">
						<span id="caption">Caption</span><input id="captionInput"type="text" name="searchText" />
					</div>
					<input id="hiddenSpan" type="text" name="albumID" value="">
					<input id="searchButton" type="submit" name="submit" value="Start Search"/>
				</form>

				<?php
				echo "<div id='searchResult'>";
				include('featureGeneration/function.php');
					if(isset($_POST["submit"])){
						$albumID = intval(filter_input(INPUT_POST, 'albumID', FILTER_SANITIZE_STRING));
						$albumName = filter_input(INPUT_POST, 'album', FILTER_SANITIZE_STRING);
						$searchText = filter_input(INPUT_POST, 'searchText', FILTER_SANITIZE_STRING);

						if($albumName === "unspecified"){
							if(empty($searchText)){
								//show all photo
								
								displayAllPhoto();
							}
							else{
								//search photo table by text
								displayAllPhotoByText($searchText);
							}
						}
						else{
							if(empty($searchText)){
								//show all photos in $albumID
								disAllPhotoInSpecifiedAlbum($albumID);
							}
							else{
								//search photo in a albm


							}
						}


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