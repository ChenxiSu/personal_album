<?php

	echo "<ul id='nav_ul'>";
	if(!isset($_SESSION['logged_user'])){
		echo "<li id='about'><a href='index.php'>About</a></li>";
	}
		
	if(isset($_POST['curNav'])) {
		$curNav = $_POST['curNav'];
		if($curNav == "albums")	echo "<li id='albums' class='navActive'><a href='albums.php'>Albums</a></li>";
		else  echo "<li id='albums'><a href='albums.php'>Albums</a></li>";
	}
	else{
		echo "<li id='albums'><a href='albums.php'>Albums</a></li>";
	}
	echo "<li id='gallery'><a href='photoDisplay_all.php'>Gallery</a></li>";
	echo "<li id='search'><a href='search.php'>Search</a></li>";
	if( isset( $_SESSION['logged_user'] ) ){
		echo "<li id='logout'><a href='logout.php'>Logout?</a></li>";
	}else{
		//echo "<li id='contact'><a href='contact.php'>Contact</a></li>";
		echo "<li id='login'><a href='login.php'>Login</a></li>";
	}
		
	echo "</ul>";
?>
