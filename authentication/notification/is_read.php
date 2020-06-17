<?php 

require "notification_functions.php";
session_start();

$n_for_id = get_user_id($_SESSION["user_login"]);

$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);

$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
if ($conn->connect_error) {
	die("Connection Failed: ".$conn->connect_error);
} else{
	$sql = "UPDATE notification SET is_read=1 WHERE for_id='$n_for_id'";
	$conn->query($sql);
}
$conn->close();


 ?>