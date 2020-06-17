<?php 

require "notification_functions.php";
session_start();

$n_for_id = get_user_id($_SESSION["user_login"]);

$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);

if ($conn->connect_error) {
	die("Connection Failed: ".$conn->connect_error);
} else{
	$sql = "SELECT * FROM notification WHERE for_id='$n_for_id' ORDER BY id DESC LIMIT 5";
	$result = $conn->query($sql);
	$output = "";
	if ($result->num_rows > 0) {
		foreach ($result as $row) {
			$n_from_type = get_n_from_type($row["from_id"]);
			$n_from_name = get_username($row["from_id"]);
			$output .= '<a class="dropdown-item d-flex align-items-center" href="notification_center.php">';
			$output .= '<div class="mr-3">';
			$output .= '<div class="icon-circle bg-success">';
			$output .= '<i class="fas fa-bell text-white"></i>';
			$output .= '</div></div>';
			$output .= '<div>';
			$output .= '<span class="font-weight-bold">'.$row["notify"].'</span>';
			$output .= '<div class="small text-gray-500">From: '.$n_from_name.' . '.$n_from_type.'</div>';
			$output .= '<div class="small text-gray-500">'.$row["timestamp"].'</div>';
			$output .= '</div>';
			$output .= '</a>';

		}
	} else {
		$output .= '<a class="dropdown-item d-flex align-items-center" href="notification_center.php">';
		$output .= '<div class="mr-3">';
		$output .= '<div class="icon-circle bg-warning">';
		$output .= '<i class="fas fa-bell text-white"></i>';
		$output .= '</div></div>';
		$output .= '<div>';
		$output .= '<span class="font-weight-bold">No notifications to show!!!!</span>';
		$output .= '</div>';
		$output .= '</a>';

	}
	echo $output;
	
}
$conn->close();





 ?>