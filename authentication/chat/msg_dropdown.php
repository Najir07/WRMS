<?php 

include "chat_functions.php";
session_start();
$email = $_SESSION["user_login"];
$user = get_user_data($email);
$id = $user["id"];
$output = "";
$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
if ($conn->connect_error) {
	die("Connection Failed: ".$conn->connect_error);
} else{
	$sql = "SELECT * FROM message WHERE to_id='$id' ORDER BY id DESC LIMIT 6";
	$result = $conn->query($sql);

	if ($result->num_rows == 0) {
		$output = "No Message For You!!!";
	} else {
		foreach ($result as $row) {
			$to_user_id = $row["from_id"];
			$img = get_userimage($to_user_id);
			$username = get_username($to_user_id);
			$status = get_status($to_user_id);

			$output .= '<a class="dropdown-item d-flex align-items-center" href="messenger.php?to='.$to_user_id.'">';
			$output .= '<div class="dropdown-list-image mr-3">';
			$output .= '<img class="rounded-circle" src="'.$img.'" >';
			$output .= '<div class="status-indicator '.$status.'"></div>';
			$output .= '</div>';
			$output .= '<div class="font-weight-bold">';
			$output .= '<div class="text-truncate">'.$row["msg"].'</div>';
			$output .= '<div class="small text-gray-500">'.$username.'</div>';
			$output .= '</div>';
			$output .= '</a>';

		}
	}
	
	
}

$conn->close();
echo $output;


 ?>