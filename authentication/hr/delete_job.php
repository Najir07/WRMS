<?php 

include "../database.php";

$job_id = $_GET['job_id'];
$d_success = "";
$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
//check connection
if ($conn->connect_error) {
	die("Connection Failed: ".$conn->connect_error);
} else{
	$sql = "SELECT * FROM jobs WHERE id='$job_id'";
	$result = $conn->query($sql)->fetch_assoc();
	$posted_by = $result["posted_by"];

	$sql = "DELETE FROM jobs WHERE id='$job_id'";
	if ($conn->query($sql) == TRUE) {
		$sql = "SELECT * FROM hrs WHERE id='$posted_by'";
		$hr_result = $conn->query($sql)->fetch_assoc();
		$hr_id = $hr_result["id"];
		echo $hr_result["num_of_posted_job"];
		if($hr_result["num_of_posted_job"] > 0){
			$num_posted_job = $hr_result["num_of_posted_job"] - 1;
			$sql = "UPDATE hrs SET num_of_posted_job='$num_posted_job' WHERE id='$hr_id'";
			$conn->query($sql);
		}
		
		$d_success = 1;
		echo $d_success;
		//redirect to previous page
		echo "<script type='text/javascript'> window.location.href = 'posted_jobs.php?d_success=".$d_success."';</script>";
		
	} else {
		$d_success = 0;
		echo $d_success;
		//redirect to previous page
		echo "<script type='text/javascript'> window.location.href = 'posted_jobs.php?d_success=".$d_success."';</script>";
	}
	
}



 ?>