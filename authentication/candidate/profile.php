<?php session_start(); ?>
<?php 
if (!isset($_SESSION["user_login"])) {
  header("location: ../../");
}
 ?>

<?php 
require '../database.php';
require 'functions.php';
 ?>

<?php
$user = $_SESSION["user_login"];
$table_name = "candidates";
$candidate = get_user_data($server_name,$user_name,$db_pass,$db_name,$table_name,'email',$user);

  ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Candidate - Profile</title>

  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="../css/auth_style.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-info sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-hands-helping"></i>
        </div>
        <div class="sidebar-brand-text mx-3">WRMS</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Interface
      </div>

      <!-- Nav Item --->
      <li class="nav-item active">
        <a class="nav-link" href="profile.php">
          <i class="fas fa-fw fa-edit"></i>
          <span>Edit CV</span>
        </a>
      </li>


      <!-- Nav Item --->
      <li class="nav-item">
        <a class="nav-link" href="view_cv.php">
          <i class="fas fa-eye"></i>
          <span>View CV</span>
        </a>
      </li>

      <!-- Nav Item --->
      <li class="nav-item">
        <a class="nav-link" href="messenger.php">
          <i class="fas fa-envelope"></i>
          <span>Live Chat</span>
        </a>
      </li>

      

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <?php include "topbar.php"; ?>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <?php include 'profile_handeler.php'; ?>

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Edit Profile</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
          </div>
          <!-- Message Area -->
          <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6 mb-4">
                <?php if($personal_success){include "messages/personal_info_success.php";} ?>
              </div>
              <div class="col-lg-3"></div>
          </div>

          <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-6">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Personal Information</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <?php $personal_obj = get_personal_info($candidate["user_directory"]); //print_r($personal_obj); ?>
                  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <div class="form-group">
                      <label for="InputFname">First Name:</label>
                      <input type="text" class="form-control" id="InputFname" name="fname" value="<?php echo $personal_obj["Personal_info"]["fname"]; ?>" placeholder="First Name">
                    </div>
                    <div class="form-group">
                      <label for="InputLname">Last Name:</label>
                      <input type="text" class="form-control" id="InputLname" name="lname" value="<?php echo $personal_obj["Personal_info"]["lname"]; ?>" placeholder="Last Name">
                    </div>
                    <div class="form-group">
                      <label for="InputEmail">Email Address:</label>
                      <input type="email" class="form-control" id="InputEmail" name="email" value="<?php echo $personal_obj["Personal_info"]["email"]; ?>" placeholder="Email Address" readonly>
                    </div>
                    <div class="form-group">
                      <label for="InputPhone">Phone No:</label>
                      <input type="text" class="form-control" id="InputPhone" name="phone" value="<?php echo $personal_obj["Personal_info"]["phone"]; ?>" placeholder="Phone No">
                    </div>
                    <div class="form-group">
                      <label for="InputLanguage">Language:</label>
                      <input type="text" class="form-control" id="InputLanguage" name="language" value="<?php echo $personal_obj["Personal_info"]["language"]; ?>" placeholder="i.e English, Bangla">
                    </div>
                    <div class="form-group">
                      <input type="submit" name="submit_personal" value="Save Personal Info" class="btn btn-primary btn-user btn-block">
                    </div>
                  </form>
                  
                </div>
              </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-6">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Educational Background</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <?php get_edu_info($candidate["user_directory"]); ?>
                  <div class="row">
                    <div class="col-lg-12">
                      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <div class="form-group">
                          <label for="InputInstitute">Institution Name:</label>
                          <input type="text" class="form-control" id="InputInstitute" name="inst_name" value="" placeholder="Name Of the Institution">
                        </div>
                        <div class="form-group">
                          <label for="InputInstitute_type">Institution Type:</label>
                          <select class="form-control" name="ins_type" id="InputInstitute_type">
                            <option>High School</option>
                            <option>Graduate School</option>
                            <option>College</option>
                            <option>University</option>
                          </select>
                        </div>
                        <div class="form-group">
                          <label for="InputDegree">Degree:</label>
                          <input type="text" class="form-control" id="InputDegree" name="degree" value="" placeholder="i.e HSC / BSC in CSE">
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col">
                              <label for="InputJoin">Admission Year:</label>
                              <input type="number" name="ins_join" id="InputJoin" class="form-control" value="" placeholder="i.e 2013">
                            </div>
                            <div class="col">
                              <label for="InputPass">Passing Year:</label>
                              <input type="number" name="ins_pass" id="InputPass" class="form-control" value="" placeholder="i.e 2018">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <input type="submit" name="submit_edu" value="Add Institution" class="btn btn-primary btn-user btn-block">
                        </div>
                      </form>
                    </div>
                  </div>
                  
                </div>
              </div>
              
            </div>
          </div>

          <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-6">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Skills</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                    <?php get_skills_info($candidate["user_directory"]); ?>
                    <div class="form-group">
                      <input type="submit" name="submit_skills" value="Add Skills" class="btn btn-primary btn-user btn-block">
                    </div>
                  </form>
                  
                </div>
              </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-xl-6">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Employment History</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <?php get_em_history($candidate["user_directory"]); ?>
                  <div class="row">
                    <div class="col-lg-12">
                      <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        <div class="form-group">
                          <label for="InputCompany">Company Name:</label>
                          <input type="text" class="form-control" id="InputCompany" name="com_name" value="" placeholder="Name Of the Company">
                        </div>
                        <div class="form-group">
                          <label for="InputRole">Your Role:</label>
                          <input type="text" class="form-control" id="InputRole" name="com_role" value="" placeholder="i.e Team Leader">
                        </div>
                        <div class="form-group">
                          <div class="row">
                            <div class="col">
                              <label for="InputJoin_com">Joining Date:</label>
                              <input type="date" name="com_join" id="InputJoin_com" class="form-control" value="">
                            </div>
                            <div class="col">
                              <label for="InputEnd">Ending Date:</label>
                              <input type="date" name="com_end" id="InputEnd" class="form-control" value="">
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <input type="submit" name="submit_em_history" value="Add Employment History" class="btn btn-primary btn-user btn-block">
                        </div>
                      </form>
                    </div>
                  </div>
                  
                </div>
              </div>
              
            </div>
          </div>

          

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; WRMS 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="../logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="../vendor/jquery/jquery.min.js"></script>
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="../vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="../js/sb-admin-2.min.js"></script>

</body>

</html>
