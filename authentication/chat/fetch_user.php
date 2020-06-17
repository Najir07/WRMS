<?php 

require "chat_functions.php";

session_start();
$user = $_SESSION["user_login"];
$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);

if ($conn->connect_error) {
	die("Connection Failed: ".$conn->connect_error);
} else{
	$sql = "SELECT * FROM users WHERE email != '$user'";
	$result = $conn->query($sql);
	$output = "";
	foreach ($result as $row) {
		$id = $row["id"];
		$status = get_status($id);
		$name = get_username($id);
		$type = $row["user_type"];
		$email = $row["email"];
		$img = get_userimage($id);
				
		$output .= '<div class="chat-item d-flex align-items-center user" id="'.$id.'">';
		$output .= '<div class="chat-list-image mr-3">';
		$output .= '<img class="rounded-circle" src="'.$img.'">';
		$output .= '<div class="status-indicator '.$status.'"></div>';
		$output .= '</div>';
		$output .= '<div class="font-weight-bold">';
		$output .= '<div class="text-truncate">'.$name.'</div>';
		$output .= '<div class="small text-gray-500">'.$type.'</div>';
		$output .= '</div></div>';
	}
	echo $output;
}

$conn->close();



 ?>