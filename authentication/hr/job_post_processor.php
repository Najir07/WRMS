<?php 

//set all the varriables to empty
$title = $desc = $salary = "";
$required_skills = array();
$success = FALSE;
//error varriables set to empty
$titleErr = $descErr = $salaryErr = $required_skillsErr = "";
$got_error = FALSE;

//validation
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($_POST["job_title"])) {
    $titleErr = "Please Enter Job Title...";
    $got_error = TRUE;
  } else {
    $title = test_input($_POST["job_title"]);
    
  }
  if (empty($_POST["job_desc"])) {
    $descErr = "Please Enter Job Description..";
    $got_error = TRUE;
  } else{
    $desc = test_input($_POST["job_desc"]);
  }
  

	if (empty($_POST["salary"])) {
    $salaryErr = "Select your Salary";
    $got_error = TRUE;
  } else {
    $salary = test_input($_POST["salary"]);
  }
  if (empty($_POST["skills"])) {
    $required_skillsErr = "Chosse required skills..";
    $got_error = TRUE;
  } else {
    for ($i=0; $i < count($_POST["skills"]); $i++) { 
      $required_skills[$i] = $_POST["skills"][$i];
    }
  }
    



  //cheking if there is any errors than proceeding
	if(!$got_error){
    //creating db connection
    $connect = new mysqli($server_name,$user_name,$db_pass,$db_name);
    if ($connect->connect_error) {
      die("Connection Failed: ".$connect->connect_error);
    } else {
      $file_name = rand(100, 99999) . time() . '.json';
      $json_file = 'jobs/' . $file_name;
      $skill_json_file = 'jobs/skill-'.$file_name;
      //create json files
      if (!$handle_skill = fopen($skill_json_file, "w")) {
        die("Unable to create Skill-Json File!!");
      } else {
        try{
          //Convert arry to JSON
          $jsonData = json_encode($required_skills, JSON_PRETTY_PRINT);
          //write JSON data into skill-json file
          if (file_put_contents($skill_json_file, $jsonData)) {
            fclose($handle_skill);
            if(!$handle_json = fopen($json_file, "w")){
              die("Unable to create Json File!!");
            } else{
              $empty = array();
              $data = json_encode($empty, JSON_PRETTY_PRINT);
              file_put_contents($json_file, $data);
              //hr id
              $post_maker = $hr["id"];
              //prepare and bind params
              $job_table = $connect->prepare("INSERT INTO jobs (job_title,job_des,salary,posted_by,job_json_file) VALUES (?,?,?,?,?)");
              $job_table->bind_param("ssiis",$title,$desc,$salary,$post_maker,$file_name);
              //execute statements
              $job_table->execute();
              $job_table->close();
              fclose($handle_json);
              $num_of_post = $hr["num_of_posted_job"] + 1;
              //update number of job post for hr table
              $hr_table = "UPDATE hrs SET num_of_posted_job = '$num_of_post' WHERE id = '$post_maker'";
              $connect->query($hr_table);
              $success = TRUE;

            }
          } else {
            die("Unable to write Json File!!!");
          }
          
        }
        catch(Exception $e){
          echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
      }
      //Closing database connection
      $connect->close();

      
    }
    
	}
  
}






function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

 ?>