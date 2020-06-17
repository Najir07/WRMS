<?php 

include "chat_functions.php";

session_start();

$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
if ($conn->connect_error) {
	die("Connection Failed: ".$conn->connect_error);
} else{
	$from_user = get_user_data($_SESSION['user_login']);

	$to_user_id =	$_POST['to_id'];
	$from_user_id =	$from_user['id'];
	$chat_message =	$_POST['chat_msg'];
	$is_read =	0;


	$sql = "INSERT INTO message (msg, from_id, to_id, is_read) VALUES ('$chat_message', '$from_user_id', '$to_user_id', '$is_read')";
	if ($conn->query($sql)) {
		echo fetch_user_chat_history($from_user["id"], $_POST["to_id"]);
	}else{
		echo "Message Not sent!!";
	}

}

$conn->close();

 ?>