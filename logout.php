<?php session_start();
	if(isset($_SESSION['logged_user'])){
		$oldUser = $_SESSION['logged_user'];
		unset($_SESSION['logged_user']);
		//session_unset();
		session_destroy();
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Logout</title>
		<link rel="stylesheet" type="text/css" href="css/areaGeneration.css"/>
		<script type="text/javascript" src="js/jquery-1.12.1.min.js"></script>
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
				<?php
					if(!isset($_SESSION['logged_user'])){
						echo "<h3>You have successfully logged out!";
					}	
				?>
			</div>

			<div id="footer">
				<!-- generate foot -->
				<?php include('featureGeneration/footer.php'); ?>
			</div>
		</div>
	</body>
</html>