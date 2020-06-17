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
$table_name = "hrs";
$hr = get_user_data($server_name,$user_name,$db_pass,$db_name,$table_name,'email',$user);

  ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>HR - Dashboard</title>

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
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

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
      <li class="nav-item">
        <a class="nav-link" href="post_job.php">
          <i class="fas fa-fw fa-plus"></i>
          <span>Post a Job</span>
        </a>
      </li>

      <!-- Nav Item --->
      <li class="nav-item">
        <a class="nav-link" href="find_candidate.php">
          <i class="fas fa-fw fa-search"></i>
          <span>Find Candidates</span>
        </a>
      </li>

      <!-- Nav Item --->
      <li class="nav-item">
        <a class="nav-link" href="posted_jobs.php">
          <i class="fas fa-eye"></i>
          <span>Job Activites</span>
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

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">View Applicant CV</h1>
            <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
          </div>


          <!-- Content Row -->
          <?php
          $can_id = $_GET["id"];
          $candidate = get_user_data($server_name,$user_name,$db_pass,$db_name,'candidates','id',$can_id);
          
          $can_dir = "../candidate/".$candidate["user_directory"];
           ?>

          <div class="row">

            <div class="col-xl-12">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-info">CV</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <?php $personal_obj = get_personal_info($can_dir); //print_r($personal_obj); ?>
                  <div class="row">
                    <div class="col-lg-6">
                      <h5 class="font-weight-bold text-primary">Personal Information:</h5>
                      <p><span class="font-weight-bold">Full Name:</span> <?php echo $personal_obj["Personal_info"]["fname"] ." ".$personal_obj["Personal_info"]["lname"]; ?></p>
                      <p><span class="font-weight-bold">Email-Address:</span> <?php echo $personal_obj["Personal_info"]["email"]; ?></p>
                      <p><span class="font-weight-bold">Phone No:</span> <?php echo $personal_obj["Personal_info"]["phone"]; ?></p>
                      <p><span class="font-weight-bold">Language(s):</span> <?php echo $personal_obj["Personal_info"]["language"]; ?></p>
                    </div>
                    <div class="col-lg-6 text-center">
                      <img src="../candidate/<?php echo $candidate["pro_img_location"]; ?>" class="img-responsive rounded-circle mb-4 w-50">
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xl-6">
                      <h5 class="font-weight-bold text-primary mb-4">Educational Background:</h5>
                      <?php get_cv_edu_info($can_dir); ?>
                    </div>
                    <div class="col-xl-6">
                      <h5 class="font-weight-bold text-primary mb-4">Employment History:</h5>
                      <?php get_em_history($can_dir); ?>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xl-12">
                      <h5 class="font-weight-bold text-primary mb-4">Area of Experties:</h5>
                      <div class="m-4">
                        <?php get_cv_skills($can_dir); ?>
                      </div>
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
