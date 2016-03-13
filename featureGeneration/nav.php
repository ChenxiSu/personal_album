<?php
	echo "<ul id='nav_ul'>";
		echo "<li id='about'><a href='index.php'>About</a></li>";
		if(isset($_GET['curNav'])) {
						$curNav = $_GET['curNav'];
						if($curNav == "albums")	echo "<li id='albums' class='navActive'><a href='albums.php'>Albums</a></li>";
						else  echo "<li id='albums'><a href='albums.php'>Albums</a></li>";
		}
		else{
			echo "<li id='albums'><a href='albums.php'>Albums</a></li>";
		}
		
		echo "<li id='contact'><a href='contact.php'>Contact</a></li>";
	echo "</ul>";
?>
