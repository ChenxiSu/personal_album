<?php 

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Logout</title>
		<link rel="stylesheet" type="text/css" href="css/areaGeneration.css"/>
	</head>
	<body>
		<div id="container">

			<div id="header">
				<!-- header image source: http://www.freewebheaders.com/wordpress/wp-content/gallery/water-coast/water-coast-header-47711-1024x300.jpg -->
				<!-- generate header -->
				<?php include('featureGeneration/header.php') ?>
				<!-- generate navigation -->
				<!--?php include('featureGeneration/nav.php'); ?-->
				<?php
				session_start();
				if(isset($_SESSION['logged_user'])){
					$oldUser = $_SESSION['logged_user'];
					echo "<h1>Gonan logged out in a miniute</h1>";
					unset($_SESSION['logged_user']);
					session_unset();
					session_destroy();
				}else{
					$oldUser = false;
				}


					echo "<ul id='nav_ul'>";
		echo "<li id='about'><a href='index.php'>About</a></li>";
		if(isset($_POST['curNav'])) {
			$curNav = $_POST['curNav'];
			if($curNav == "albums")	echo "<li id='albums' class='navActive'><a href='albums.php'>Albums</a></li>";
			else  echo "<li id='albums'><a href='albums.php'>Albums</a></li>";
		}
		else{
			echo "<li id='albums'><a href='albums.php'>Albums</a></li>";
		}
		echo "<li id='gallery'><a href='photoDisplay_all.php'>Gallery</a></li>";
		echo "<li id='contact'><a href='contact.php'>Contact</a></li>";
		if($oldUser){
			echo "<li><h1>in nav</h1></li>";
			echo "<li id='logout'><a href='logout.php'>Logout?</a></li>";
		}else{
			echo "<li id='login'><a href='login.php'>Login</a></li>";
			echo "shit";
		}
		
	echo "</ul>";
				?>
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