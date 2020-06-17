<?php 

include "chat_functions.php";

session_start();

$from_id = $_POST['from_id'];
$user = get_user_data($_SESSION["user_login"]);
$to_id = $user["id"];

$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
if ($conn->connect_error) {
	die("Connection Failed: ".$conn->connect_error);
} else{
	$sql = "UPDATE message SET is_read=1 WHERE (from_id='$from_id' AND to_id='$to_id')";
	$result = $conn->query($sql);
	

}

$conn->close();


 ?>