<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Gallery</title>
		<link rel="stylesheet" type="text/css" href="css/areaGeneration.css"/>
		<!-- <link rel="stylesheet" type="text/css" href="css/album.css"/> -->
		<link rel="stylesheet" type="text/css" href="css/photoDisplayAll.css"/>
		<script type="text/javascript" src="js/jquery-1.12.1.min.js"></script>
		<script type="text/javascript" src ="js/setNav.js"></script>
		<script type="text/javascript" src="js/photo_display_add_new.js"></script>
		<script type="text/javascript" src="js/interaction.js"></script>
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
				
				<div id="add_new_photo">
					<div id="preview">
					</div>
					<div id="uploading_form">
						<form action="photoDisplay_album.php" method="post" enctype="multipart/form-data">
							<input id="chooseFileButton" type="file" name="new_file" onchange="readURL(this)"/><br/>
							<label>Description:</label><input id="input_description" type="text" name="description"/><br><br>
							<input type="submit" id="uploadButton" value="upload" onclick="return descriptionValidation()" />
						</form>
					</div>
				</div>

				<div id="main_display">

					<div id="thumbnailArea">
						<?php
							include('featureGeneration/function.php');
							displayAllPhoto();
						?>
					</div>
				</div>

			</div>
			<div id="myModel" class="photoDisplayModel">
				<span id="close">x</span>
				<div id="mainModel">
					<div id="leftClickArea">
					</div>
					<div id="imgFrame">
						<div id="imgWrapper">
							<div><img id="curImg" class="displayedImg"></div>	
						</div>	
						<!-- <div id="ImgInfo">
								<div>
								<p>Album Name:<span id="albumNameSPan"></span>Description:<span id="photoDescSpan"></span></p>
								</div>
							</div> -->
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