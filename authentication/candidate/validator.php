<?php session_start(); ?>
<?php
//Database configuration file 
require '../database.php';
?>

<?php 

//include 'upload_processor.php';

//set all the varriables to empty
$fname = $lname = $email = $pass = $repass = "";
$success = FALSE;
//error varriables set to empty
$fnameErr = $lnameErr = $emailErr = $passErr = $repassErr = $uploadeImageErr = "";
$got_error = FALSE;
$old_user = FALSE;
//uploaded image location
$uploadedImageLocation = "../img/placeholder250.png";

//validation
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($_POST["email"])) {
    $emailErr = "E-mail Address is required..";
    $got_error = TRUE;
  } else {
    $email = test_input($_POST["email"]);
    //validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid Email Address!!!";
      $got_error = TRUE;
    }
  }
  if (empty($_POST["pass"])) {
    $passErr = "Please choose a password...";
    $got_error = TRUE;
  } else{
    $pass = test_input($_POST["pass"]);
    //validate password
    if (strlen($pass) < 8) {
      $passErr = "Password is too small!!";
      $got_error = TRUE;
    }
  }
  if (empty($_POST["repass"])) {
    $repassErr = "Please retype your password..";
    $got_error = TRUE;
  } else {
    $repass = test_input($_POST["repass"]);
    //validating password
    if ($repass != $pass) {
      $repassErr = "Password doesn't match!!!";
      $got_error = TRUE;
    }
  }
  

	if (empty($_POST["fname"])) {
    $fnameErr = "First Name is required";
    $got_error = TRUE;
  } else {
    $fname = test_input($_POST["fname"]);
    // check if name only contains capital letters and whitespace
    if (!preg_match("/^[a-zA-Z. ]*$/",$fname)) {
      $fnameErr = "Only letters and white space allowed"; 
      $got_error = TRUE;
    }
  }
  if (empty($_POST["lname"])) {
    $lnameErr = "Last Name is required";
    $got_error = TRUE;
  } else {
    $lname = test_input($_POST["lname"]);
    // check if name only contains capital letters and whitespace
    if (!preg_match("/^[a-zA-Z. ]*$/",$lname)) {
      $lnameErr = "Only letters and white space allowed";
      $got_error = TRUE; 
    }
  }

  //image validation
  $uploadedImageLocation = $_POST["uploadedImageLocation"];
  if ($uploadedImageLocation == "../img/placeholder250.png") {
  	$uploadeImageErr = "Please select an image.";
  	$got_error = TRUE;
  }
  



  //cheking if there is any errors than proceeding
	if(!$got_error){
    //creating db connection
    $connect = new mysqli($server_name,$user_name,$db_pass,$db_name);
    if ($connect->connect_error) {
      die("Connection Failed: ".$connect->connect_error);
    } else {
      $sql = "SELECT * FROM users WHERE email='$email'";
      $result = $connect->query($sql);
      if ($result->num_rows == 1) {
        $old_user = TRUE;
      } else {
        //encrypt password
        $pass = password_hash($pass, PASSWORD_BCRYPT);
        //setting user type to Candidate
        $user_type = "candidate";
        //prepare and bind data
        $first_data_table = $connect->prepare("INSERT INTO users (email,password,user_type) VALUES (?,?,?)");
        $first_data_table->bind_param("sss",$email,$pass,$user_type);
        //execute statements
        $first_data_table->execute();
        $first_data_table->close();

        //Creating Candidate directory
        $dir_name = "u-dir/";
        $candidate_folder = rand(100, 99999) . bin2hex(random_bytes(10)) . time();
        $location = $dir_name . $candidate_folder;
        if (!mkdir($location)) {
          die("Folder Creation Failed...");
        } else {
          //Creating Personal Info json file
          $file_name = "personal_info.json";
          $file_location = $location . '/' . $file_name;
          $handle = fopen($file_location, "w");
          $personal_info_array = array();
          $personal_info_array["Personal_info"]["fname"] = $fname;
          $personal_info_array["Personal_info"]["lname"] = $lname;
          $personal_info_array["Personal_info"]["email"] = $email;
          $personal_info_array["Personal_info"]["phone"] = "";
          $personal_info_array["Personal_info"]["language"] = "";
          //convert array to json data
          $personal_json_data = json_encode($personal_info_array, JSON_PRETTY_PRINT);
          //write data to json file
          file_put_contents($file_location, $personal_json_data);
          fclose($handle);

          //Educational info json file
          $file_name = "edu.json";
          $file_location = $location . '/' . $file_name;
          $handle = fopen($file_location, "w");
          $edu_array = array();
          $edu_array["edu"] = array();
          //convert array to json data
          $edu_json_data = json_encode($edu_array, JSON_PRETTY_PRINT);
          //write data to json file
          file_put_contents($file_location, $edu_json_data);
          fclose($handle);

          //skills json file
          $file_name = "skills.json";
          $file_location = $location . '/' . $file_name;
          $handle = fopen($file_location, "w");
          $skills_array = array();
          $skills_array["skills"] = array();
          //convert array to json data
          $skills_json_data = json_encode($skills_array, JSON_PRETTY_PRINT);
          //write data to json file
          file_put_contents($file_location, $skills_json_data);
          fclose($handle);

          //Employment history json file
          $file_name = "em_history.json";
          $file_location = $location . '/' . $file_name;
          $handle = fopen($file_location, "w");
          $em_history_array = array();
          $em_history_array["em_history"] = array();
          //convert array to json data
          $em_history_json_data = json_encode($em_history_array, JSON_PRETTY_PRINT);
          //write data to json file
          file_put_contents($file_location, $em_history_json_data);
          fclose($handle);


        }
        

        //prepare and bind data for the second data table
        $second_data_table = $connect->prepare("INSERT INTO candidates (fname,lname,email,pro_img_location,user_directory) VALUES (?,?,?,?,?)");
        $second_data_table->bind_param("sssss",$fname,$lname,$email,$uploadedImageLocation,$location);
        //execute statements
        $second_data_table->execute();
        $second_data_table->close();
        //closing database connection
        $connect->close();
        //redirecting to success page
        //header("Location: register.php?success=TRUE");
        $success = TRUE;

      }
      
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