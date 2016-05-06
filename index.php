<!DOCTYPE html>
<html lang="en">
	<head>
		<title>My personal album</title>
		<link rel="stylesheet" type="text/css" href="css/areaGeneration.css"/>
		<link rel="stylesheet" type="text/css" href="css/aboutMe.css"/>
		<script type="text/javascript" src="js/jquery-1.12.1.min.js"></script>
		<script type="text/javascript" src="js/interaction.js"></script>
		<script type="text/javascript" src ="js/setNav.js"></script>
	</head>
	<body>
		<div id="container">
			<div id="header">
				<!-- header image source: http://www.freewebheaders.com/wordpress/wp-content/gallery/water-coast/water-coast-header-47711-1024x300.jpg -->
				<?php include('featureGeneration/header.php'); ?>
				<?php include('featureGeneration/nav.php'); ?>
			</div>

			<div id="content">
				<h2>Welcome to my personal website!</h2>
				<div id="description">
					<div id="imgWrapper"><img src="src/me.jpg" /></div>
					
					<p class="info">Name:Chenxi Su</p>
					<p class="info">Origin:China</p>
					<p class="info">Major:Information Science</p>
					<p class="info">Goal:Full Stack!</p>
					
				</div>
			</div>

			<div id="footer">
				<?php include('featureGeneration/footer.php'); ?>
			</div>
		</div>
	</body>
</html>