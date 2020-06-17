<?php 

$personal_success = "";
$user_id = $candidate["id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	//Personal Info handeller
	if (isset($_POST["submit_personal"])) {

		if (!empty($_POST["phone"])) {
			$connect = new mysqli($server_name,$user_name,$db_pass,$db_name);
		    if ($connect->connect_error) {
		      die("Connection Failed: ".$connect->connect_error);
		    } else{
		    	$sql = "UPDATE candidates SET phone = 1 WHERE id = '$user_id'";
		    	$connect->query($sql);
		    }
		    $connect->close();
		}

		$file_name = $candidate["user_directory"] . "/" . "personal_info.json";
		//Open file in Read-only mode
		$handle = fopen($file_name, "r");
		$content = fread($handle, filesize($file_name));
		$json_array = json_decode($content, true);
		fclose($handle);
		//Setting Varriables
		$json_array["Personal_info"]["fname"] = $_POST["fname"];
		$json_array["Personal_info"]["lname"] = $_POST["lname"];
		$json_array["Personal_info"]["email"] = $_POST["email"];
		$json_array["Personal_info"]["phone"] = $_POST["phone"];
		$json_array["Personal_info"]["language"] = $_POST["language"];
		//Write datas to file
		$handle = fopen($file_name, "w");
		$content = json_encode($json_array, JSON_PRETTY_PRINT);
		if (file_put_contents($file_name, $content)) {
			$personal_success = TRUE;
		} else {
			$personal_success = FALSE;
		}
		fclose($handle);
		
	}

	//Educational Background handeller
	if (isset($_POST["submit_edu"])) {
		$file_name = $candidate["user_directory"] . "/" . "edu.json";
		//Open file in Read-only mode
		$handle = fopen($file_name, "r");
		$content = fread($handle, filesize($file_name));
		$json_array = json_decode($content, true);
		fclose($handle);
		//print_r($json_array);
		$index = count($json_array["edu"]);
		//Setting data to array
		$json_array["edu"][$index]["inst_name"] = $_POST["inst_name"];
		$json_array["edu"][$index]["ins_type"] = $_POST["ins_type"];
		$json_array["edu"][$index]["degree"] = $_POST["degree"];
		$json_array["edu"][$index]["ins_join"] = $_POST["ins_join"];
		$json_array["edu"][$index]["ins_pass"] = $_POST["ins_pass"];

		//Write datas to file
		$handle = fopen($file_name, "w");
		$content = json_encode($json_array, JSON_PRETTY_PRINT);
		if (file_put_contents($file_name, $content)) {
			$personal_success = TRUE;
			$connect = new mysqli($server_name,$user_name,$db_pass,$db_name);
		    if ($connect->connect_error) {
		      die("Connection Failed: ".$connect->connect_error);
		    } else{
		    	$sql = "UPDATE candidates SET edu = 1 WHERE id = '$user_id'";
		    	$connect->query($sql);
		    }
		    $connect->close();
		} else {
			$personal_success = FALSE;
		}
		fclose($handle);
		
	}
	//Employment History handler
	if (isset($_POST["submit_em_history"])) {
		$file_name = $candidate["user_directory"] . "/" . "em_history.json";
		//Open file in Read-only mode
		$handle = fopen($file_name, "r");
		$content = fread($handle, filesize($file_name));
		$json_array = json_decode($content, true);
		fclose($handle);
		//print_r($json_array);
		$index = count($json_array["em_history"]);
		//Setting data to array
		$json_array["em_history"][$index]["com_name"] = $_POST["com_name"];
		$json_array["em_history"][$index]["com_role"] = $_POST["com_role"];
		$json_array["em_history"][$index]["com_join"] = $_POST["com_join"];
		if (empty($_POST["com_end"])) {
			$json_array["em_history"][$index]["com_end"] = "Currently Working There.";
		} else {
			$json_array["em_history"][$index]["com_end"] = $_POST["com_end"];
		}
		
		
		//Write datas to file
		$handle = fopen($file_name, "w");
		$content = json_encode($json_array, JSON_PRETTY_PRINT);
		if (file_put_contents($file_name, $content)) {
			$personal_success = TRUE;
			$connect = new mysqli($server_name,$user_name,$db_pass,$db_name);
		    if ($connect->connect_error) {
		      die("Connection Failed: ".$connect->connect_error);
		    } else{
		    	$sql = "UPDATE candidates SET em_history = 1 WHERE id = '$user_id'";
		    	$connect->query($sql);
		    }
		    $connect->close();
		} else {
			$personal_success = FALSE;
		}
		fclose($handle);
		
	}
	//Skills Handler
	if (isset($_POST["submit_skills"])) {
		$file_name = $candidate["user_directory"] . "/" . "skills.json";
		//Open file in Read-only mode
		$handle = fopen($file_name, "r");
		$content = fread($handle, filesize($file_name));
		$json_array = json_decode($content, true);
		fclose($handle);
		//print_r($json_array);
		$x = count($_POST["skills"]);
		for ($i = 0; $i < $x ; $i++) { 
			$json_array["skills"][$i] = $_POST["skills"][$i];
		}

		//Write datas to file
		$handle = fopen($file_name, "w");
		$content = json_encode($json_array, JSON_PRETTY_PRINT);
		if (file_put_contents($file_name, $content)) {
			$personal_success = TRUE;
			$connect = new mysqli($server_name,$user_name,$db_pass,$db_name);
		    if ($connect->connect_error) {
		      die("Connection Failed: ".$connect->connect_error);
		    } else{
		    	$sql = "UPDATE candidates SET skills = 1 WHERE id = '$user_id'";
		    	$connect->query($sql);
		    }
		    $connect->close();
		} else {
			$personal_success = FALSE;
		}
		fclose($handle);

		
	}





}




 ?>