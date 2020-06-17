<?php 

function get_user_data($server_name,$user_name,$password,$db_name,$table_name,$user_param,$user_param_value){
	$conn = new mysqli($server_name,$user_name,$password,$db_name);
	//check connection
	if ($conn->connect_error) {
		die("Connection Failed: ".$conn->connect_error);
	} else {
		$sql = "SELECT * FROM $table_name WHERE $user_param='$user_param_value'";
		$fetch_data = $conn->query($sql);
	}
	if($fetch_data->num_rows == 1){
		$user_data = $fetch_data->fetch_assoc();
		return $user_data;
	}else{
		$error = "Something Went Wrong!!!";
		return $error;
	}
	
	$conn->close();

}

function get_user_data_by_param($table_name,$user_param,$user_param_value){
	include "../database.php";
	$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
	//check connection
	if ($conn->connect_error) {
		die("Connection Failed: ".$conn->connect_error);
	} else {
		$sql = "SELECT * FROM $table_name WHERE $user_param='$user_param_value'";
		$fetch_data = $conn->query($sql);
	}
	if($fetch_data->num_rows == 1){
		$user_data = $fetch_data->fetch_assoc();
		return $user_data;
	}else{
		$error = "Something Went Wrong!!!";
		return $error;
	}
	
	$conn->close();
}

function update_data_by_param($table,$param,$value,$cond,$cond_value){
	include "../database.php";
	$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
	//check connection
	if ($conn->connect_error) {
		die("Connection Failed: ".$conn->connect_error);
	} else{
		$sql = "UPDATE $table SET $param='$value' WHERE $cond='$cond_value'";
		$conn->query($sql);
	}
}

function get_skills_chekboxes(){
	include "../database.php";
	$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
	//check connection
	if ($conn->connect_error) {
		die("Connection Failed: ".$conn->connect_error);
	} else {
		$data = array();
		$sql = "SELECT * FROM skills";
		$fetch_data = $conn->query($sql);
		for ($i=0; $i < $fetch_data->num_rows ; $i++) { 
			$data = $fetch_data->fetch_assoc();
			$html_data = '<div class="form-group">';
			$html_data .= '<div class="custom-control custom-checkbox">';
			$html_data .= '<input type="checkbox" class="custom-control-input" name="skills[]" id="customCheck'.$data["id"].'" value="'.$data["id"].'">';
			$html_data .= '<label class="custom-control-label" for="customCheck'.$data["id"].'">'.$data["skill_name"].'</label>';
			$html_data .= '</div></div>';
			echo $html_data;	
		}
		
	}
	$conn->close();
	

}


function get_personal_info($user_dir){
	$dir = $user_dir . "/";
	$file_name = $dir  . "personal_info.json";
	$handle = fopen($file_name, "r");
	$json_data = array();
	$content = fread($handle, filesize($file_name));
	$json_data = json_decode($content, true);
	fclose($handle);
	return $json_data;

}
function get_cv_edu_info($user_dir){
	$dir = $user_dir . "/";
	$file_name = $dir  . "edu.json";
	$handle = fopen($file_name, "r");
	$content = fread($handle, filesize($file_name));
	$json_data = json_decode($content, true);
	fclose($handle);
	if (count($json_data["edu"]) == 0) {
		$html = '<div class="row">';
		$html .= '<div class="col-lg-12 mb-4"><div class="card bg-danger text-white shadow"><div class="card-body">';
		$html .= 'No Educational Data Added!!';
		$html .= '</div></div></div></div>';
		echo $html;
	} else{
		for ($i = 0; $i < count($json_data["edu"]); $i++) { 
			$html = '<div class="row">';
			$html .= '<div class="col-lg-12 mb-4"><div class="card bg-info text-white shadow"><div class="card-body">';
			$html .= '<div>'.$json_data["edu"][$i]["inst_name"].'</div>';
			$html .= '<div class="text-white-50">'.$json_data["edu"][$i]["degree"].'</div>';
			$html .= '<div class="text-white-50 small">From : '.$json_data["edu"][$i]["ins_join"].' To : '.$json_data["edu"][$i]["ins_pass"].'</div>';
			$html .= '</div></div></div></div>';
			echo $html;
		}
		
	}
}
function get_em_history($user_dir){
	$dir = $user_dir . "/";
	$file_name = $dir  . "em_history.json";
	$handle = fopen($file_name, "r");
	$content = fread($handle, filesize($file_name));
	$json_data = json_decode($content, true);
	fclose($handle);
	if (count($json_data["em_history"]) == 0) {
		$html = '<div class="row">';
		$html .= '<div class="col-lg-12 mb-4"><div class="card bg-danger text-white shadow"><div class="card-body">';
		$html .= 'No Employment History Added!!';
		$html .= '</div></div></div></div>';
		echo $html;
	} else{
		for ($i = 0; $i < count($json_data["em_history"]); $i++) { 
			$html = '<div class="row">';
			$html .= '<div class="col-lg-12 mb-4"><div class="card bg-info text-white shadow"><div class="card-body">';
			$html .= '<div>'.$json_data["em_history"][$i]["com_name"].'</div>';
			$html .= '<div class="text-white-50">'.$json_data["em_history"][$i]["com_role"].'</div>';
			$html .= '<div class="text-white-50 small">From : '.$json_data["em_history"][$i]["com_join"].' To : '.$json_data["em_history"][$i]["com_end"].'</div>';
			$html .= '</div></div></div></div>';
			echo $html;
		}
		
	}
}
function get_cv_skills($user_dir){
	include "../database.php";
	$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
	//check connection
	if ($conn->connect_error) {
		die("Connection Failed: ".$conn->connect_error);
	} else{
		$dir = $user_dir . "/";
		$file_name = $dir  . "skills.json";
		$handle = fopen($file_name, "r");
		$content = fread($handle, filesize($file_name));
		$json_data = json_decode($content, true);
		fclose($handle);
		
		if (count($json_data["skills"]) == 0) {
			$html = '<span class="text-danger">No Skills are added!!!!</span>';
			echo $html;

		} else {
			for ($i=0; $i < count($json_data["skills"]); $i++) { 
				$id = $json_data["skills"][$i];
				$sql = "SELECT skill_name FROM skills WHERE id = '$id'";
				$result = $conn->query($sql)->fetch_assoc();
				$html = '<span class="d-inline-block bg-secondary text-white p-2 m-2 rounded">'.$result["skill_name"].'</span>';
				echo $html;
			}
		}
		

	}
	$conn->close();
}






function generate_job_table($user_id){
	include "../database.php";
	$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
	//check connection
	if ($conn->connect_error) {
		die("Connection Failed: ".$conn->connect_error);
	} else{
		$hr_id = $user_id;
		$sql = "SELECT * FROM jobs WHERE posted_by = '$hr_id'";
		$data = $conn->query($sql);
		if ($data->num_rows == 0) {
			echo "No job Posted yet!!!";
		} else{
			for ($i = 0; $i < $data->num_rows; $i++) { 
				$job = $data->fetch_assoc();
				$job_file = "jobs/" .$job["job_json_file"];
				$handle = fopen($job_file, "r");
				$content = fread($handle, filesize($job_file));
				fclose($handle);
				$json_data = json_decode($content, true);
				$num_of_appl = count($json_data);
				$html = '<tr>';
				$html .= '<td>'.$job["id"].'</td>';
				$html .= '<td>'.$job["job_title"].'</td>';
				$html .= '<td>'.$num_of_appl.'</td>';
				$html .= '<td>';
				$html .= '<a href="view_applicants.php?job_id='.$job["id"].'&num='.$num_of_appl.' " class="btn btn-primary m-2">View Applicants</a>';
				$html .= '<a href="delete_job.php?job_id='.$job["id"].'&num='.$num_of_appl.' " class="btn btn-danger m-2">Delete Job</a>';
				$html .= '</td></tr>';
				echo $html;
			}
		}

	}
	$conn->close();

}


function generate_applicant_table($job_id, $num){
	include "../database.php";
	$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
	//check connection
	if ($conn->connect_error) {
		die("Connection Failed: ".$conn->connect_error);
	} else{
		$sql = "SELECT * FROM jobs WHERE id = '$job_id'";
		$data = $conn->query($sql);
		if ($data->num_rows == 1) {
			$job = $data->fetch_assoc();
			$job_file = "jobs/" .$job["job_json_file"];
			$handle = fopen($job_file, "r");
			$content = fread($handle, filesize($job_file));
			fclose($handle);
			$json_data = json_decode($content, true);
			for ($i=0; $i < $num; $i++) { 
				$appl_id = $json_data[$i];
				$sql = "SELECT * FROM candidates WHERE id='$appl_id'";
				$appl_data = $conn->query($sql)->fetch_assoc();
				$name = $appl_data["fname"]." ".$appl_data["lname"];
				$html = '<tr>';
				$html .= '<td>'.$name.'</td>';
				$html .= '<td><a href="appl_cv.php?id='.$appl_id.'" class="btn btn-primary btn-block">View CV</a></td>';
				$html .= '<td>';
				$html .= '<a href="appl_processor.php?assign='.$job_id.'&appl-id='.$appl_id.'&job_json='.$job["job_json_file"].'" class="btn btn-success m-2"><i class="fa fa-check"></i> Assign</a>';
				$html .= '<a href="appl_processor.php?waiting='.$job_id.'&appl-id='.$appl_id.'&job_json='.$job["job_json_file"].'" class="btn btn-warning m-2"><i class="fa fa-exclamation-triangle"></i> Waiting</a>';
				$html .= '<a href="appl_processor.php?reject='.$job_id.'&appl-id='.$appl_id.'&job_json='.$job["job_json_file"].'" class="btn btn-danger m-2"><i class="fa fa-times"></i> Reject</a>';
				$html .= '</td>';
				$html .= '</tr>';
				echo $html;
			}
		} else {
			echo "Job Not Found";
		}
		
	}
	$conn->close();
}

function get_cand_skills($user_dir){
	include "../database.php";
	$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
	//check connection
	if ($conn->connect_error) {
		die("Connection Failed: ".$conn->connect_error);
	} else{
		$dir = "../candidate/".$user_dir . "/";
		$file_name = $dir  . "skills.json";
		$handle = fopen($file_name, "r");
		$content = fread($handle, filesize($file_name));
		$json_data = json_decode($content, true);
		fclose($handle);
		$output = "";
		if (count($json_data["skills"]) == 0) {
			$output = 'No Skills are added!!!!';
			return $output;

		} else {
			for ($i=0; $i < count($json_data["skills"]); $i++) { 
				$id = $json_data["skills"][$i];
				$sql = "SELECT skill_name FROM skills WHERE id = '$id'";
				$result = $conn->query($sql)->fetch_assoc();
				$output .= $result["skill_name"] ."<br>";
				
			}
			return $output;
		}
		

	}
	$conn->close();
}


function fetch_candidates(){
	include "../database.php";
	$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
	//check connection
	if ($conn->connect_error) {
		die("Connection Failed: ".$conn->connect_error);
	} else{
		$sql = "SELECT * FROM candidates";
		$result = $conn->query($sql);
		$output = "";
		$x = 1;
		foreach ($result as $row) {
			$id = $row["id"];
			$name = $row["fname"]." ".$row["lname"];
			$skills = get_cand_skills($row["user_directory"]);
			$output .= '<tr>';
			$output .= '<td>'.$x.'</td>';
			$output .= '<td>'.$name.'</td>';
			$output .= '<td>'.$skills.'</td>';
			$output .= '<td><a href="appl_cv.php?id='.$id.'" class="btn btn-primary btn-block">View CV</a></td>';
			$output .= '</tr>';
			$x++;
		}
		echo $output;
	}
}

 ?>