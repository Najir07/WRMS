<?php 
include "../database.php";
include "functions.php";
session_start();


$dir = "jobs/";
$S_assign = 0;
$S_waiting = 0;
$S_reject = 0;


if (isset($_GET["assign"])) {
	$job_id = $_GET["assign"];
	$appl_id = $_GET["appl-id"];
	$job_file = $dir ."assign-". $_GET["job_json"];
	$assigned = FALSE;
	if (check($job_file)) {
		$handle = fopen($job_file, "r");
		$content = fread($handle, filesize($job_file));
		$json_data = json_decode($content,TRUE);
		fclose($handle);
		$index = count($json_data);
		for ($i=0; $i < $index; $i++) { 
			if ($json_data[$i] == $appl_id) {
				$assigned = TRUE;
				break;
			}
		}
		if (!$assigned) {
			$json_data[$index] = $appl_id;
			$handle = fopen($job_file, "w");
			$data = json_encode($json_data, JSON_PRETTY_PRINT);
			file_put_contents($job_file, $data);
			fclose($handle);
			$user = get_user_data_by_param("hrs","email",$_SESSION["user_login"]);
			$assign_count = $user["assigned"] + 1;
			update_data_by_param("hrs","assigned",$assign_count,"email",$_SESSION["user_login"]);
			$applicant = get_user_data_by_param("candidates", "id", $appl_id);
			$active_count = $applicant["active_job"] + 1;
			update_data_by_param("candidates", "active_job", $active_count, "id", $appl_id);
			

			//send notification
			$from = get_user_data_by_param("users", "email", $_SESSION["user_login"]);
			$from_id = $from["id"];
			$to = get_user_data_by_param("users", "email", $applicant["email"]);
			$to_id = $to["id"];
			$job = get_user_data_by_param("jobs", "id", $job_id);
			$notifi = "Congratulation!!! You have assigend to the Job <em>".$job["job_title"]."</em>";
			echo $notifi;
			$is_read = 0;
			$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
			//check connection
			if ($conn->connect_error) {
				die("Connection Failed: ".$conn->connect_error);
			} else{
				$sql = "INSERT INTO notification (notify, from_id, for_id, is_read) VALUES ('$notifi', '$from_id', '$to_id', '$is_read')";
				$conn->query($sql);
			}
			$conn->close();

			//send email
			$sub = "Job Assignment";
			$msg = "Congratulation!!! You have assigend to the Job ".$job["job_title"]."\r\n";
			$msg .= "Here is the Job Details:\r\n";
			$msg .= $job["job_des"]."\r\n";
			$msg .= "\r\n\nBest Regards\r\nWRMS";
			$msg = wordwrap($msg,70,"\r\n");
			$header = "From: WRMS";
			mail($to["email"], $sub, $msg, $header);

			//redirect to previous page
			$S_assign = 1;
			echo "<script type='text/javascript'> window.location.href = 'posted_jobs.php?S_assign=".$S_assign."';</script>";

		} else{
			//redirect to previous page
			echo "<script type='text/javascript'> window.location.href = 'posted_jobs.php?S_assign=".$S_assign."';</script>";
		}

	} else {
		$handle = fopen($job_file, "w");
		$ids = array();
		$ids[0] = $appl_id;
		$data = json_encode($ids, JSON_PRETTY_PRINT);
		file_put_contents($job_file, $data);
		fclose($handle);
		$user = get_user_data_by_param("hrs","email",$_SESSION["user_login"]);
		$assign_count = $user["assigned"] + 1;
		update_data_by_param("hrs","assigned",$assign_count,"email",$_SESSION["user_login"]);
		$applicant = get_user_data_by_param("candidates", "id", $appl_id);
		$active_count = $applicant["active_job"] + 1;
		update_data_by_param("candidates", "active_job", $active_count, "id", $appl_id);

		//send notification
		$from = get_user_data_by_param("users", "email", $_SESSION["user_login"]);
		$from_id = $from["id"];
		$to = get_user_data_by_param("users", "email", $applicant["email"]);
		$to_id = $to["id"];
		$job = get_user_data_by_param("jobs", "id", $job_id);
		$notifi = "Congratulation!!! You have assigend to the Job <em>".$job["job_title"]."</em>";
		echo $notifi;
		$is_read = 0;
		$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
		//check connection
		if ($conn->connect_error) {
			die("Connection Failed: ".$conn->connect_error);
		} else{
			$sql = "INSERT INTO notification (notify, from_id, for_id, is_read) VALUES ('$notifi', '$from_id', '$to_id', '$is_read')";
			$conn->query($sql);
		}
		$conn->close();

		//send email
		$sub = "Job Assignment";
		$msg = "Congratulation!!! You have assigend to the Job ".$job["job_title"]."\r\n";
		$msg .= "Here is the Job Details:\r\n";
		$msg .= $job["job_des"]."\r\n";
		$msg .= "\r\n\nBest Regards\r\nWRMS";
		$msg = wordwrap($msg,70,"\r\n");
		$header = "From: WRMS";
		mail($to["email"], $sub, $msg, $header);

		//redirect to previous page
		$S_assign = 1;
		echo "<script type='text/javascript'> window.location.href = 'posted_jobs.php?S_assign=".$S_assign."';</script>";
	}
	
	

}


if (isset($_GET["waiting"])) {
	$job_id = $_GET["waiting"];
	$appl_id = $_GET["appl-id"];
	$job_file = $dir ."waiting-". $_GET["job_json"];
	$wait_listed = FALSE;
	if (check($job_file)) {
		$handle = fopen($job_file, "r");
		$content = fread($handle, filesize($job_file));
		$json_data = json_decode($content,TRUE);
		fclose($handle);
		$index = count($json_data);
		for ($i=0; $i < $index; $i++) { 
			if ($json_data[$i] == $appl_id) {
				$wait_listed = TRUE;
				break;
			}
		}
		if (!$wait_listed) {
			$json_data[$index] = $appl_id;
			$handle = fopen($job_file, "w");
			$data = json_encode($json_data, JSON_PRETTY_PRINT);
			file_put_contents($job_file, $data);
			fclose($handle);
			$user = get_user_data_by_param("hrs","email",$_SESSION["user_login"]);
			$waiting_count = $user["wait_listed"] + 1;
			update_data_by_param("hrs","wait_listed",$waiting_count,"email",$_SESSION["user_login"]);
			$applicant = get_user_data_by_param("candidates", "id", $appl_id);
			$pending_count = $applicant["pending_job"] + 1;
			update_data_by_param("candidates", "pending_job", $pending_count, "id", $appl_id);

			//send notification
			$from = get_user_data_by_param("users", "email", $_SESSION["user_login"]);
			$from_id = $from["id"];
			$to = get_user_data_by_param("users", "email", $applicant["email"]);
			$to_id = $to["id"];
			$job = get_user_data_by_param("jobs", "id", $job_id);
			$notifi = "You have been waiting listed for the Job <em>".$job["job_title"]."</em>";
			echo $notifi;
			$is_read = 0;
			$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
			//check connection
			if ($conn->connect_error) {
				die("Connection Failed: ".$conn->connect_error);
			} else{
				$sql = "INSERT INTO notification (notify, from_id, for_id, is_read) VALUES ('$notifi', '$from_id', '$to_id', '$is_read')";
				$conn->query($sql);
			}
			$conn->close();

			//send email
			$sub = "Job Waiting Listed";
			$msg = "You have been waiting listed to the Job ".$job["job_title"]."\r\n";
			$msg .= "Here is the Job Details:\r\n";
			$msg .= $job["job_des"]."\r\n";
			$msg .= "\r\n\nBest Regards\r\nWRMS";
			$msg = wordwrap($msg,70,"\r\n");
			$header = "From: WRMS";
			mail($to["email"], $sub, $msg, $header);

			//redirect to previous page
			$S_waiting = 1;
			echo "<script type='text/javascript'> window.location.href = 'posted_jobs.php?S_waiting=".$S_waiting."';</script>";

		} else{
			//redirect to previous page
			echo "<script type='text/javascript'> window.location.href = 'posted_jobs.php?S_waiting=".$S_waiting."';</script>";
		}

	} else {
		$handle = fopen($job_file, "w");
		$ids = array();
		$ids[0] = $appl_id;
		$data = json_encode($ids, JSON_PRETTY_PRINT);
		file_put_contents($job_file, $data);
		fclose($handle);
		$user = get_user_data_by_param("hrs","email",$_SESSION["user_login"]);
		$waiting_count = $user["wait_listed"] + 1;
		update_data_by_param("hrs","wait_listed",$waiting_count,"email",$_SESSION["user_login"]);
		$applicant = get_user_data_by_param("candidates", "id", $appl_id);
		$pending_count = $applicant["pending_job"] + 1;
		update_data_by_param("candidates", "pending_job", $pending_count, "id", $appl_id);

		//send notification
		$from = get_user_data_by_param("users", "email", $_SESSION["user_login"]);
		$from_id = $from["id"];
		$to = get_user_data_by_param("users", "email", $applicant["email"]);
		$to_id = $to["id"];
		$job = get_user_data_by_param("jobs", "id", $job_id);
		$notifi = "You have been waiting listed for the Job <em>".$job["job_title"]."</em>";
		echo $notifi;
		$is_read = 0;
		$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
		//check connection
		if ($conn->connect_error) {
			die("Connection Failed: ".$conn->connect_error);
		} else{
			$sql = "INSERT INTO notification (notify, from_id, for_id, is_read) VALUES ('$notifi', '$from_id', '$to_id', '$is_read')";
			$conn->query($sql);
		}
		$conn->close();

		//send email
		$sub = "Job Waiting Listed";
		$msg = "You have been waiting listed to the Job ".$job["job_title"]."\r\n";
		$msg .= "Here is the Job Details:\r\n";
		$msg .= $job["job_des"]."\r\n";
		$msg .= "\r\n\nBest Regards\r\nWRMS";
		$msg = wordwrap($msg,70,"\r\n");
		$header = "From: WRMS";
		mail($to["email"], $sub, $msg, $header);

		//redirect to previous page
		$S_waiting = 1;
		echo "<script type='text/javascript'> window.location.href = 'posted_jobs.php?S_waiting=".$S_waiting."';</script>";
	}

}

if (isset($_GET["reject"])) {

	$job_id = $_GET["reject"];
	$appl_id = $_GET["appl-id"];
	$job_file = $dir.$_GET["job_json"];
	$handle = fopen($job_file, "r");
	$content = fread($handle, filesize($job_file));
	$json_data = json_decode($content,TRUE);
	fclose($handle);
	$new_data = array();
	$x = 0;
	for ($i=0; $i < count($json_data); $i++) { 
		if ($json_data[$i] == $appl_id) {
			$i++;
		} else{
			$new_data[$x] = $json_data[$i];
			$x++;
		}
		
	}

	$handle = fopen($job_file, "w");
	$data = json_encode($new_data, JSON_PRETTY_PRINT);
	file_put_contents($job_file, $data);
	fclose($handle);

	//send notification
	$from = get_user_data_by_param("users", "email", $_SESSION["user_login"]);
	$from_id = $from["id"];
	$applicant = get_user_data_by_param("candidates", "id", $appl_id);
	$to = get_user_data_by_param("users", "email", $applicant["email"]);
	$to_id = $to["id"];
	$job = get_user_data_by_param("jobs", "id", $job_id);
	$notifi = "You have been rejected from the Job <em>".$job["job_title"]."</em>";
	echo $notifi;
	$is_read = 0;
	$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
	//check connection
	if ($conn->connect_error) {
		die("Connection Failed: ".$conn->connect_error);
	} else{
		$sql = "INSERT INTO notification (notify, from_id, for_id, is_read) VALUES ('$notifi', '$from_id', '$to_id', '$is_read')";
		$conn->query($sql);
	}
	$conn->close();

	//send email
	$sub = "Job Rejection";
	$msg = "You have been rejected from the Job ".$job["job_title"]."\r\n";
	$msg .= "Here is the Job Details:\r\n";
	$msg .= $job["job_des"]."\r\n";
	$msg .= "\r\n\nBest Regards\r\nWRMS";
	$msg = wordwrap($msg,70,"\r\n");
	$header = "From: WRMS";
	mail($to["email"], $sub, $msg, $header);

	//redirect to previous page
	$S_reject = 1;
	echo "<script type='text/javascript'> window.location.href = 'posted_jobs.php?S_reject=".$S_reject."';</script>";

}


function check($path){
	$handle = fopen($path, "r");
	if (!$handle) {
		return FALSE;
	} else {
		return TRUE;
	}
	
}

 ?>