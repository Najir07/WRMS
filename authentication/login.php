<?php session_start(); ?>
<?php require 'database.php'; ?>

<?php 
//define varriables and set them to empty
$user_email = $user_pass = $user_role = "";
//Error varriables set to empty
$user_emailErr = $user_passErr = $user_roleErr = "";
$server_errors = array();
$got_error = FALSE;

//validating input
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["submit"])) {
    if (empty($_POST["user_email"])) {
      $user_emailErr = "You forgot to enter your Email Address..!!";
      $got_error = TRUE;
    } else {
      $user_email = test_input($_POST["user_email"]);
      if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        $user_emailErr = "Invalid Email Address";
        $got_error = TRUE;
      }
    }

    if (empty($_POST["user_pass"])) {
      $user_passErr = "You forgot to enter your Password..!!";
      $got_error = TRUE;
    } else{
      $user_pass = test_input($_POST["user_pass"]);
    }

    if ($_POST["role"] == 0) {
      $user_roleErr = "Please select your Role";
      $got_error = TRUE;
    } else {
      $user_role = $_POST["role"];
    }

    //Checking for errors and proceding
    if (!$got_error) {
      //connect to database
      $conn = new mysqli($server_name,$user_name,$db_pass,$db_name);
      //checking connection
      if ($conn->connect_error) {
        die("Connection failed: ".$conn->connect_error);
      } else {
        $sql = "SELECT * FROM users WHERE email ='$user_email'";
        $find_user = $conn->query($sql);
        if ($find_user->num_rows == 1) {
          $user_found = $find_user->fetch_assoc();
          if (password_verify($user_pass, $user_found["password"])) {
            
            //match the role of the user
            $match_user_role = "";
            switch ($user_role) {
              case 1:
                $match_user_role = "hr";
                break;
              case 2:
                $match_user_role = "candidate";
                break;
              
              default:
                $server_errors["unmatched_role"] = "User Role did not match.";
                $user_roleErr = "Wrong Role Selected.";
                break;
            }
            if ($match_user_role == $user_found["user_type"]) {
              //initialize _SESSION verriables
              $_SESSION["user_login"] = $user_found["email"];
              $_SESSION["user_type"] = $user_found["user_type"];
              //set status to online
              $user_id = $user_found["id"];
              $online_sql = "UPDATE users SET status=1 WHERE id='$user_id'";
              $conn->query($online_sql);
              //redirect to user dashboard
              switch ($user_role) {
                case 1:
                //redirect to hr dashboard
                echo "<script type='text/javascript'> window.location.href = 'hr/';</script>";
                break;

                case 2:
                  //redirect to candidate dashboard
                  echo "<script type='text/javascript'> window.location.href = 'candidate/';</script>";
                  break;
                
                default:
                  $server_errors["role"] = "Something went Wrong";
                  break;
              }
            } else {
              $server_errors["unmatched_role"] = "User Role did not match.";
              $user_roleErr = "Wrong Role Selected.";
            }
            
            
          } else {
            $server_errors["wrong_pass"] = "Incorrect Password.";
            $user_passErr = "Incorrect Password.";
          }
          
        } else {
          $server_errors["user_not_found"] = "Account not found!!";
        }
        
      }

      $conn->close();
      
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




<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>WRMS - Login</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/auth_style.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-lg-block bg-login-image">
                <?php
                if (count($server_errors) > 0) {
                   include "server_error.php";
                 } else{
                  include "login_page_info.php";
                 }
                 ?>
              </div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">LOGIN TO WRMS</h1>
                  </div>
                  <form class="user" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" id="exampleInputEmail" name="user_email" value="<?php echo $user_email;?>" aria-describedby="emailHelp" placeholder="Enter Email Address...">
                      <span class="input-error"><?php echo $user_emailErr; ?></span>
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" id="exampleInputPassword" name="user_pass" value="<?php $user_pass;?>" placeholder="Password">
                      <span class="input-error"><?php echo $user_passErr; ?></span>
                    </div>
                    <div class="form-group">
                      <select class="custom-select" name="role" style="border-radius: 10rem">
                        <option class="form-control" value="0" selected>Select your role</option>
                        <option value="1">HR</option>
                        <option value="2">Candidate</option>
                      </select>
                      <span class="input-error"><?php echo $user_roleErr; ?></span>
                    </div>
                    <input type="submit" class="btn btn-primary btn-user btn-block" name="submit" value="Login">
                     
                    <!-- <hr>
                    <a href="index.html" class="btn btn-google btn-user btn-block">
                      <i class="fab fa-google fa-fw"></i> Login with Google
                    </a>
                    <a href="index.html" class="btn btn-facebook btn-user btn-block">
                      <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                    </a> -->
                    <!--
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="register.html">Create an Account!</a>
                  </div> -->
                  <!-- <div class="text-center">
                    <a class="small" href="../">Go back to Home</a>
                  </div> -->
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
