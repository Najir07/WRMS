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


function get_user_data_by_email($email){
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

function calculate_profile_progress($user_id){
	include "../database.php";
	$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
	//check connection
	if ($conn->connect_error) {
		die("Connection Failed: ".$conn->connect_error);
	} else {
		$sql = "SELECT * FROM candidates WHERE id = '$user_id' ";
		$data = $conn->query($sql)->fetch_assoc();
		$progress = 0.5;
		$progress_ratio = 0.125;

		if($data["phone"] == 1){
			$progress += $progress_ratio;
		}
		if($data["edu"] == 1){
			$progress += $progress_ratio;
		}
		if($data["skills"] == 1){
			$progress += $progress_ratio;
		}
		if($data["em_history"] == 1){
			$progress += $progress_ratio;
		}

		$conn->close();

		return $progress * 100;


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

function get_skills_info($user_dir){
	include "../database.php";
	$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
	//check connection
	if ($conn->connect_error) {
		die("Connection Failed: ".$conn->connect_error);
	} else {
		$data = array();
		$sql = "SELECT * FROM skills";
		$fetch_data = $conn->query($sql);
		//read json data
		$dir = $user_dir . "/";
		$file_name = $dir  . "skills.json";
		$handle = fopen($file_name, "r");
		$content = fread($handle, filesize($file_name));
		$json_data = json_decode($content, true);
		fclose($handle);

		$x = count($json_data["skills"]);
		$y = "";
		for ($i=0; $i < $fetch_data->num_rows ; $i++) { 
			$data = $fetch_data->fetch_assoc();
			for ($j = 0; $j < $x ; $j++) { 
				if ($json_data["skills"][$j] == $data["id"]) {
					$y = "checked";
					break;
				} else{
					$y = "";
				}
			}
			
			$html_data = '<div class="form-group">';
			$html_data .= '<div class="custom-control custom-checkbox">';
			$html_data .= '<input type="checkbox" class="custom-control-input" name="skills[]" id="customCheck'.$data["id"].'" value="'.$data["id"].'" '.$y.'>';
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

function get_edu_info($user_dir){
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
		$html = '<div class="row">';
		$html .= '<div class="col-lg-12 mb-4"><div class="card bg-info text-white shadow"><div class="card-body">';
		$html .= 'You Have Added '.count($json_data["edu"]).' Educational Institute';
		$html .= '</div></div></div></div>';
		echo $html;
		
	}
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


function show_jobs($folder){
	include "../database.php";
	$conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
	//check connection
	if ($conn->connect_error) {
		die("Connection Failed: ".$conn->connect_error);
	} else {
		$sql = "SELECT * FROM jobs ORDER BY id DESC";
		$result = $conn->query($sql);
		for ($i = 0; $i < $result->num_rows ; $i++) { 
			$job = $result->fetch_assoc();
			$title = $job["job_title"];
			$timestamp = $job["post_date"];
			$date = date_create($timestamp);
			$date = date_format($date, "d-m-Y");
			$desc = $job["job_des"];
			$salary = $job["salary"];
			$file_name = $job["job_json_file"];
			$json_file = "../hr/jobs/skill-" . $file_name;
			$handle = fopen($json_file, "r");
			$content = fread($handle, filesize($json_file));
			$skills = json_decode($content, true);
			fclose($handle);
			$sk_sql = "SELECT * FROM skills";
			$skill_db = $conn->query($sk_sql);

			$author_id = $job["posted_by"];
			$sql = "SELECT * FROM hrs WHERE id = '$author_id'";
			$author = $conn->query($sql)->fetch_assoc();
			$author_name = $author["fname"] . " " . $author["lname"];
			$company = $author["company"];
			$img = "../hr/".$author["pro_img_location"];
			$num_posted_job = $author["num_of_posted_job"];

			$msnger_link = get_user_data_by_email($author["email"]);
			$msnger_link_id = $msnger_link["id"];

			//filter jobs
			$f_sucess = FALSE;
			$can_skill_file_name = $folder."/"."skills.json";
			$handle = fopen($can_skill_file_name, "r");
			$content = fread($handle, filesize($can_skill_file_name));
			$can_skills = json_decode($content,true);
			fclose($handle);
			for ($p=0; $p < count($skills); $p++) { 
				for ($q=0; $q < count($can_skills["skills"]); $q++) { 
					if($skills[$p] == $can_skills["skills"][$q]){
						$f_sucess = TRUE;
						break;
					}
				}
			}

			//for incomplete profile
			if (count($can_skills["skills"]) <= 0) {
				$output = '<div class="col-xl-2"></div>';
				$output .= '<div class="col-xl-8">';
				$output .= '<div class="card alert bg-dark text-white shadow alert-dismissible" role="alert">';
				$output .= '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
				$output .= '<span aria-hidden="true">&times;</span>';
				$output .= '</button>';
				$output .= '<div class="card-body">';
				$output .= 'Your Profile is incomplete';
				$output .= '<div class="text-white-50 small">Please Go to Edit CV and Add Skills to view jobs.</div>';
				$output .= '</div></div></div>';
				$output .= '<div class="col-xl-2"></div>';
				echo $output;
				break;
			}

			//filter success
			if ($f_sucess) {
				$html = '<div class="col-xl-12">';
				$html .= '<div class="card shadow mb-4">';
				$html .= '<!-- Card Header - Dropdown --><div class="card-header py-3 d-flex flex-row align-items-center justify-content-between"><h6 class="m-0 font-weight-bold text-primary">Recent Jobs</h6><div class="dropdown no-arrow"><a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i></a><div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink"><div class="dropdown-header">Action Menu:</div><a class="dropdown-item" href="#">View Author</a><div class="dropdown-divider"></div><a class="dropdown-item" href="messenger.php?to='.$msnger_link_id.'">Chat With Author</a></div></div></div>';
				$html .= '<!-- Card Body --><div class="card-body"><div class="row">';
				$html .= '<div class="col-xl-12">';
				$html .= '<h2 class="mb-4">'.$title.'</h2>';
				$html .= '<p class="small text-uppercase text-secondary">Job Post Date : '.$date.'</p>';
				$html .= '</div></div>';
				$html .= '<div class="row">';
				$html .= '<div class="col-xl-8">';
				$html .= '<div class="job_details">';
				$html .= '<h6 class="text-primary text-uppercase">Job Description:</h6>';
				$html .= '<p>'.$desc.'</p></div>';
				$html .= '<div class="job_skils">';
				$html .= '<h6 class="text-primary text-uppercase">Required Skills:</h6>';
				$new_html = "";
				echo $html;
				for ($j = 0; $j < count($skills); $j++) { 
					for ($k = 0; $k < $skill_db->num_rows ; $k++) { 
						$x = $skill_db->fetch_assoc();

						if ($x["id"] == $skills[$j]) {
							//echo $x["id"] . "=".$skills[$j];
							$new_html .= '<span class="d-inline-block bg-secondary text-white p-2 m-2 rounded">'.$x["skill_name"].'</span>';
							break;
						}
					}
				}
				$html_2 = "";
				$html_2 .= $new_html;
				$html_2 .= '</div>';
				$html_2 .= '<div class="job_salary">';
				$html_2 .= '<h6 class="text-uppercase text-primary mt-2">Offered Salary:</h6>';
				$html_2 .= '<span class="salary">$'.$salary.'</span>';
				$html_2 .= '</div>';
				$html_2 .= '<div class="job_apply mt-4 mb-4">';
				$html_2 .= '<form method="GET" >';
				$html_2 .= '<input type="hidden" name="job_id" value="'.$job["id"].'">';
				$html_2 .= '<input type="submit" name="apply" value="Apply To This Job" class="btn btn-primary btn-block"></form>';
				$html_2 .= '</div></div>';
				$html_2 .= '<div class="col-xl-4"><div class="row"><div class="col-xl-12"><div class="about_author"><h5 class="text-primary text-uppercase text-center">About the HR</h5></div></div></div>';
				$html_2 .= '<div class="row"><div class="col-xl-12"><div class="author_img text-center m-2">';
				$html_2 .= '<img src="'.$img.'" class="img-responsive rounded-circle mb-4"></div>';
				$html_2 .= '<div class="col-xl-12">';
				$html_2 .= ' <h6 class="text-success text-uppercase text-center">'.$author_name.'</h6>';
				$html_2 .= ' <h6 class="text-uppercase text-center">'.$company.'</h6>';
				$html_2 .= '<p class="text-center text-primary">Posted Job: <span class="text-success">'.$num_posted_job.'</span></p>';
				$html_2 .= '</div></div></div></div></div></div></div></div>';

				echo $html_2;
			} 

		}
		
	}
	
	$conn->close();
	
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

 ?>