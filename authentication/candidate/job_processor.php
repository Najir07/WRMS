<?php 

$applied = FALSE;
$S_applied = FALSE;

if (isset($_GET["apply"])) {
	$job_id = $_GET["job_id"];
	$applicant = $candidate["id"];
	$sql = "SELECT * FROM jobs WHERE id = '$job_id'";
	$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
	//check connection
	if ($conn->connect_error) {
		die("Connection Failed: ".$conn->connect_error);
	} else{
		$result = $conn->query($sql)->fetch_assoc();
		$job_json_file = $result["job_json_file"];
		$hr_id = $result["posted_by"];
		$dir = "../hr/jobs/";
		$file = $dir.$job_json_file;
		$handle = fopen($file, "r");
		$content = fread($handle, filesize($file));
		$job_data = json_decode($content,true);
		fclose($handle);
		$index = count($job_data);
		for ($i = 0; $i < $index; $i++) { 
			if ($job_data[$i] == $applicant) {
				$applied = TRUE;
				break;
			}
		}
		if (!$applied) {
			$job_data[$index] = $applicant;
			$final_data = json_encode($job_data, JSON_PRETTY_PRINT);
			$handle = fopen($file, "w");
			file_put_contents($file, $final_data);
			fclose($handle);
			$job_application = $candidate["applied"] + 1;
			$sql = "UPDATE candidates SET applied = '$job_application' WHERE id = '$applicant'";
			$conn->query($sql);

			//send notification
			$for = get_user_data_by_param("hrs", "id", $hr_id);
			$for_user = get_user_data_by_param("users", "email", $for["email"]);
			$for_id = $for_user["id"];
			$from = get_user_data_by_param("candidates", "id", $applicant);
			$from_user = get_user_data_by_param("users", "email", $from["email"]);
			$from_id = $from_user["id"];
			$notify = $from["fname"]." ".$from["lname"]. " has applied to your job ".$result["job_title"];
			$is_read = 0;
			$sql = "INSERT INTO notification (notify, from_id, for_id, is_read) VALUES ('$notify', '$from_id', '$for_id', '$is_read')";
			$conn->query($sql);

			$S_applied = TRUE;

		}

	}

	$conn->close();
}


 ?>