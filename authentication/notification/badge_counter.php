<?php 

require "notification_functions.php";
session_start();

$n_for_id = get_user_id($_SESSION["user_login"]);

$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
$count = 0;
$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
if ($conn->connect_error) {
	die("Connection Failed: ".$conn->connect_error);
} else{
	$sql = "SELECT * FROM notification WHERE for_id='$n_for_id' AND is_read=0";
	$result = $conn->query($sql);
	$count = $result->num_rows;
}
$conn->close();
echo $count;

 ?>