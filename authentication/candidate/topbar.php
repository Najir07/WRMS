<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-counter" id="notification_badge"></span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Alerts Center
                </h6>
                <div id="notification_area"></div>
                <a class="dropdown-item text-center small text-gray-500" href="notification_center.php">Show All Alerts</a>
              </div>
            </li>

            <!-- Nav Item - Messages -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-envelope fa-fw"></i>
                <!-- Counter - Messages -->
                <span class="badge badge-counter" id="msg_badge"></span>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">
                  Message Center
                </h6>
                <div id="msg_area"></div>
                <a class="dropdown-item text-center small text-gray-500" href="messenger.php">Read More Messages</a>
              </div>
            </li>

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <?php
            $candidate_name = $candidate["fname"]." ".$candidate["lname"];
            $candidate_image = $candidate["pro_img_location"]; 
             ?>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $candidate_name; ?></span>
                <img class="img-profile rounded-circle" src="<?php echo $candidate_image; ?>">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="profile.php">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>


<!-- AJAX Core Scripts -->
<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../../lib/ajax/form_lib.js"></script>
<!-- AJAX Core Scripts -->
<script type="text/javascript">
  $(document).ready(function(){

    generate_msg_dropdown();
    generate_notification_dropdown();

    setInterval(function(){
      update_msg_badge();
      generate_msg_dropdown();
      update_notification_badge();
      generate_notification_dropdown();
    },5000);

    function update_msg_badge(){
      
      $.ajax({
        url:"../chat/badge_counter.php",
        method:"POST",
        success:function(data){
          if (data > 0) {
            $("#msg_badge").addClass("badge-danger");
            $("#msg_badge").html(data);
          }
          if (data <= 0) {
            $("#msg_badge").removeClass("badge-danger");
            $("#msg_badge").html("");
          }
        }
      })
    }

    function generate_msg_dropdown(){
      $.ajax({
        url:"../chat/msg_dropdown.php",
        method:"POST",
        success:function(data){
          $("#msg_area").html(data);
        }
      })
    }



    function update_notification_badge(){
      
      $.ajax({
        url:"../notification/badge_counter.php",
        method:"POST",
        success:function(data){
          if (data > 0) {
            $("#notification_badge").addClass("badge-danger");
            $("#notification_badge").html(data);
          }
          if (data <= 0) {
            $("#notification_badge").removeClass("badge-danger");
            $("#notification_badge").html("");
          }
        }
      })
    }

    function generate_notification_dropdown(){
      $.ajax({
        url:"../notification/notification_dropdown.php",
        method:"POST",
        success:function(data){
          $("#notification_area").html(data);
        }
      })
    }

    $(document).on('click', '#alertsDropdown', function(){
      
      $.ajax({
        url:"../notification/is_read.php",
        method:"POST",
        success:function(){
          
        }
      })
    });



  });
</script>