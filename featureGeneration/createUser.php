<?php
	require_once 'config.php';
	$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
	$adminUserName = "admin";
	$adminUserPassword = "IAmAdmin01";
	$salt = "ILoveCoding";
	$adminUserPassword_hash = password_hash( $salt.$adminUserPassword, PASSWORD_DEFAULT);
	$user_values = [$adminUserPassword_hash, $adminUserName];
	$user_values_list = implode( "','", $user_values);
	$sql_insert_user = "INSERT INTO info230_SP16_cs2238sp16.users ( hashpassword, username) VALUES ( '$user_values_list');";

	$mysqli->query($sql_insert_user);
?>
