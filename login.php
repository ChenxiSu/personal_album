<?php session_start(); ?>
<!DOCTYPE html>
<html>
	<head>
			<title>Login</title>
			<link rel="stylesheet" type="text/css" href="css/areaGeneration.css"/>
			<script type="text/javascript" src="js/jquery-1.12.1.min.js"></script>
			<script type="text/javascript" src ="js/setNav.js"></script>
	</head>

	<body>
		<?php
			include('featureGeneration/function.php');
			//if no session has ever been create
			if(!isset($_SESSION['logged_user'])){
				if(isset($_POST['username']) && isset($_POST['password']) ){
		
					$username = filter_input( INPUT_POST, 'username', FILTER_SANITIZE_STRING );
					$password = filter_input( INPUT_POST, 'password', FILTER_SANITIZE_STRING );
					require_once 'featureGeneration/config.php';
					$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
					$sql = "Select * from users where users.username ='$username'";
					$result = $mysqli->query($sql);
					if($result&&$result->num_rows==1){
						$row = $result->fetch_row();
						$db_hashedPassword = $row[1];
						
						if(password_verify(SALT.$password,$db_hashedPassword)){
							$_SESSION['logged_user'] = $username;						
						}
					}
				}
			}
			
		?>
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
					//include('featureGeneration/function.php');
					//showLoginForm();
					
					//if no session has ever been created
					if(!isset($_SESSION['logged_user'])){
						if(!isset($_POST['username']) && !isset($_POST['password']) ){
					
							showLoginForm();
						}
						else{
							$username = filter_input( INPUT_POST, 'username', FILTER_SANITIZE_STRING );
							$password = filter_input( INPUT_POST, 'password', FILTER_SANITIZE_STRING );
							if(empty($username) || empty($password)){
								
								showLoginForm();
								echo "<h1>Password should not be empty</h1>";
							}
							// find username and password in database
							else{
								require_once 'featureGeneration/config.php';
								$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
								$sql = "Select * from users where users.username ='$username'";
								$result = $mysqli->query($sql);
								if($result&&$result->num_rows==1){
									$row = $result->fetch_row();
									$db_hashedPassword = $row[1];
									
									if(!isset($_SESSION['logged_user'])){
										echo "<h1>Wrong password.Try again!</h1>";
										showLoginForm();
										
									
									}
								}else{
									echo "<h1>Wrong name or password.Try again!</h1>";
									showLoginForm();
								}
							}
						}
					}
					else{
						echo "<h1>$username, welcome!</h1>";
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
