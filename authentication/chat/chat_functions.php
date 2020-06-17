<?php 

require "../database.php";

function get_user_data($email){
	include "../database.php";
	$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
	if ($conn->connect_error) {
		die("Connection Failed: ".$conn->connect_error);
	} else{
		$sql = "SELECT * FROM users WHERE email='$email'";
		$result = $conn->query($sql)->fetch_assoc();
		return $result;
	}
	$conn->close();
}

function get_username($id){
	include "../database.php";
	$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
	$username = "";
	if ($conn->connect_error) {
		die("Connection Failed: ".$conn->connect_error);
	} else{
		$sql = "SELECT * FROM users WHERE id='$id'";
		$result = $conn->query($sql)->fetch_assoc();
		$table_name = "";
		$email = $result["email"];
		if ($result["user_type"] == "hr") {
			$table_name = "hrs";
			$sql = "SELECT * FROM $table_name WHERE email='$email'";
			$user = $conn->query($sql)->fetch_assoc();
			$username = $user["fname"]." ".$user["lname"];
		} else {
			$table_name = "candidates";
			$sql = "SELECT * FROM $table_name WHERE email='$email'";
			$user = $conn->query($sql)->fetch_assoc();
			$username = $user["fname"]." ".$user["lname"];
		}
		
	}
	$conn->close();
	return $username;

}


function get_userimage($id){
	include "../database.php";
	$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
	$userimage = "";
	$img_server = "http://localhost/wrms/authentication/";
	if ($conn->connect_error) {
		die("Connection Failed: ".$conn->connect_error);
	} else{
		$sql = "SELECT * FROM users WHERE id='$id'";
		$result = $conn->query($sql)->fetch_assoc();
		$table_name = "";
		$email = $result["email"];
		if ($result["user_type"] == "hr") {
			$table_name = "hrs";
			$sql = "SELECT * FROM $table_name WHERE email='$email'";
			$user = $conn->query($sql)->fetch_assoc();
			$userimage = $img_server."hr/".$user["pro_img_location"];
		} else {
			$table_name = "candidates";
			$sql = "SELECT * FROM $table_name WHERE email='$email'";
			$user = $conn->query($sql)->fetch_assoc();
			$userimage = $img_server."candidate/".$user["pro_img_location"];
		}
		
	}
	$conn->close();
	return $userimage;

}

function get_status($id){
	include "../database.php";
	$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
	$status = "";
	if ($conn->connect_error) {
		die("Connection Failed: ".$conn->connect_error);
	} else{
		$sql = "SELECT status FROM users WHERE id='$id'";
		$result = $conn->query($sql)->fetch_assoc();

		if ($result["status"] == 1) {
			$status = "bg-success";
		}
	}
	$conn->close();
	return $status;
}

function fetch_user_chat_history($from_id, $to_id){
	include "../database.php";
	$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
	$output = "";
	if ($conn->connect_error) {
		die("Connection Failed: ".$conn->connect_error);
	} else{
		$sql = "SELECT * FROM message WHERE (from_id = '$from_id' AND to_id = '$to_id') OR (from_id = '$to_id' AND to_id = '$from_id') ORDER BY id ASC";
		$result = $conn->query($sql);
		
		if ($result->num_rows == 0) {
			$output = "No Chat Found!!";
			return $output;
		} else {
			$output .= '<div class="chat-list" id="chat_area">';
			$chat_bg = "";
			foreach ($result as $row) {
				$username = "";
				$img = "";
				$status = get_status($row["from_id"]);
				if($row["from_id"] == $from_id){
					$chat_bg = "bg-dark";
					$username = "You";
					$img = get_userimage($from_id);
				} else{
					$chat_bg = "bg-primary";
					$username = get_username($row["from_id"]);
					$img = get_userimage($row["from_id"]);
				}

				$output .= '<div class="chat-item d-flex border-0 mt-2 mb-2">';
				$output .= '<div class="chat-list-image mr-3">';
				$output .= '<img class="rounded-circle" src="'.$img.'">';
				$output .= '<div class="status-indicator '.$status.'"></div>';
				$output .= '</div>';
				$output .= '<div class="'.$chat_bg.' p-4">';
				$output .= '<div class="text-white">'.$row["msg"].'</div>';
				$output .= '<div class="small text-gray-500">'.$username.'</div>';
				$output .= '</div></div>';
			}
		}
		
	}
	$conn->close();
	return $output;

}





 ?>