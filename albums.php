<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Scanning Albums</title>
		<link rel="stylesheet" type="text/css" href="css/areaGeneration.css"/>
		<link rel="stylesheet" type="text/css" href="css/album.css"/>
		<script type="text/javascript" src="js/jquery-1.12.1.min.js"></script>
		<script type="text/javascript" src="js/interaction.js"></script>
		<script type="text/javascript" src ="js/setNav.js"></script>
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
				<?php include('featureGeneration/albumGeneration.php'); ?>
			</div>

			<div id="footer">
				<!-- generate foot -->
				<?php include('featureGeneration/footer.php'); ?>
			</div>
		</div>
	</body>
</html>