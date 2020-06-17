<?php 
require "../database.php";

function get_n_from_type($id){
	include "../database.php";
	$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
	$output = "";
	if ($conn->connect_error) {
		die("Connection Failed: ".$conn->connect_error);
	} else{
		$sql = "SELECT * FROM users WHERE id='$id'";
		$result = $conn->query($sql)->fetch_assoc();
		if ($result["user_type"] == "hr") {
			$output = "HR";
		} else {
			$output = "Candidate";
		}
		
		return $output;
	}
	$conn->close();
}

function get_user_id($email){
	include "../database.php";
	$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
	if ($conn->connect_error) {
		die("Connection Failed: ".$conn->connect_error);
	} else{
		$sql = "SELECT * FROM users WHERE email='$email'";
		$result = $conn->query($sql)->fetch_assoc();
		return $result["id"];
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

 ?>