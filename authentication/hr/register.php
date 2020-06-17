<?php 
// form validator file
require 'validator.php';

 ?>


<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>WRMS HR - Register</title>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/auth_style.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <div class="col-lg-5 d-lg-block bg-register-image">
            <div class="w-100 d-block" id="logo_link">
              <h2><a href="">WRMS</a></h2>
            </div>
            <img src="<?php echo $uploadedImageLocation;?>" class="d-block img-responisve rounded-circle" id="placeholderImg">
          </div>
          <div class="col-lg-7">
            <div class="p-5">
              <?php 

              if ($old_user) {
                include 'old_user.php';
              }
              if ($success == TRUE) {
                include 'success.php';
              }

               ?>
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account</h1>
              </div>
              <form class="user" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" id="FirstName" name="fname" value="<?php echo $fname;?>" placeholder="First Name">
                    <span class="input-error"><?php echo $fnameErr; ?></span>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" id="LastName" name="lname" value="<?php echo $lname;?>" placeholder="Last Name">
                    <span class="input-error"><?php echo $lnameErr; ?></span>
                  </div>
                </div>
                <div class="form-group">
                  <input type="email" class="form-control form-control-user" id="InputEmail" name="email" value="<?php echo $email;?>" placeholder="Email Address">
                  <span class="input-error"><?php echo $emailErr; ?></span>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" class="form-control form-control-user" id="InputPassword" name="pass" value="<?php echo $pass;?>" placeholder="Password">
                    <span class="input-error"><?php echo $passErr; ?></span>
                  </div>
                  <div class="col-sm-6">
                    <input type="password" class="form-control form-control-user" id="RepeatPassword" name="repass" value="<?php echo $repass;?>" placeholder="Repeat Password">
                    <span class="input-error"><?php echo $repassErr; ?></span>
                  </div>
                  <span class="text-muted input-msg">Password must contain at least 8 charecters.</span>
                </div>
                <div class="form-group">
                  <input type="text" class="form-control form-control-user" id="company" name="coname" value="<?php echo $coname;?>" placeholder="Company Name">
                  <span class="input-error"><?php echo $conameErr; ?></span>
                </div>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="file" aria-describedby="file" name="file">
                    <label class="custom-file-label" for="file" id="fileName">Choose image</label>
                    
                  </div>

                </div>
                <br>
                <span class="text-muted input-msg">Image should not be grater than 2MB in size and should not exceed the dimension of 250x250</span>
                <br>
                <span class="input-error"><?php echo $uploadeImageErr; ?></span>
                <br>
                <input type="hidden" name="uploadedImageLocation" id="imgInput" value="<?php $uploadedImageLocation; echo $uploadedImageLocation;?>">
                <input type="submit" name="submit" value="Register Account" class="btn btn-primary btn-user btn-block">
                
              </form>
              <hr>
              <!--<div class="text-center">
                <a class="small" href="../forgot-password.php">Forgot Password?</a>
              </div> -->
              <div class="text-center">
                <a class="small" href="../login.php">Already have an account? Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

  <!-- Core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Ajax library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

  <!-- Bootstrap js -->
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- image processor scripts for all pages-->
  <script src="../js/upload-pro-img.js"></script>

  

</body>

</html>
