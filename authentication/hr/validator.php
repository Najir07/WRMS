<?php session_start(); ?>
<?php
//Database configuration file 
require '../database.php';
?>

<?php 

//include 'upload_processor.php';

//set all the varriables to empty
$fname = $lname = $email = $pass = $repass = $coname = "";
$success = FALSE;
//error varriables set to empty
$fnameErr = $lnameErr = $emailErr = $passErr = $repassErr = $conameErr = $uploadeImageErr = "";
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
  if (empty($_POST["coname"])) {
    $conameErr = "Company Name is required";
    $got_error = TRUE;
  } else {
    $coname = test_input($_POST["coname"]);
    // check if name only contains capital letters and whitespace
    if (!preg_match("/^[a-zA-Z. ]*$/",$coname)) {
      $conameErr = "Only letters and white space allowed";
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
        //setting user type to HR
        $user_type = "hr";
        //prepare and bind data
        $first_data_table = $connect->prepare("INSERT INTO users (email,password,user_type) VALUES (?,?,?)");
        $first_data_table->bind_param("sss",$email,$pass,$user_type);
        //execute statements
        $first_data_table->execute();
        $first_data_table->close();

        //prepare and bind data for the second data table
        $second_data_table = $connect->prepare("INSERT INTO hrs (fname,lname,email,company,pro_img_location) VALUES (?,?,?,?,?)");
        $second_data_table->bind_param("sssss",$fname,$lname,$email,$coname,$uploadedImageLocation);
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