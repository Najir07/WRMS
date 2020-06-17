<?php 

include "chat_functions.php";
session_start();

$email = $_SESSION["user_login"];
$user = get_user_data($email);
$id = $user["id"];
$count = 0;
$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
if ($conn->connect_error) {
	die("Connection Failed: ".$conn->connect_error);
} else{
	$sql = "SELECT * FROM message WHERE to_id='$id' AND is_read=0";
	$result = $conn->query($sql);
	$count = $result->num_rows;
}
$conn->close();
echo $count;

 ?>