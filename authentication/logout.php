<?php 
session_start();
require "database.php";

$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
if ($conn->connect_error) {
	die("Connection failed: ".$conn->connect_error);
} else{
	$email = $_SESSION["user_login"];
	$sql = "UPDATE users SET status=0 WHERE email='$email'";
	$conn->query($sql);
	if (session_destroy()) {
		header("location: ../");
	}
}

$conn->close();

 ?>