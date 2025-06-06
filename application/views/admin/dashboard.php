<!DOCTYPE html>
<html lang="en">

<head>
  <title>Admin - Dashboard</title>

  <!-- Bootstrap core CSS-->
  <?php echo link_tag('assests/vendor/bootstrap/css/bootstrap.min.css'); ?>
  <!-- FontAwesome -->
  <?php echo link_tag('assests/vendor/fontawesome-free/css/all.min.css'); ?>
  <!-- DataTables -->
  <?php echo link_tag('assests/vendor/datatables/dataTables.bootstrap4.css'); ?>
  <!-- Custom CSS -->
  <?php echo link_tag('assests/css/sb-admin.css'); ?>

  <style>
    body {
      background: url('<?php echo base_url("assests/Images/Background_img.jpg"); ?>') no-repeat center center fixed;
      background-size: cover;
      background-color: transparent !important;
    }

    .dashboard-card {
      border-radius: 10px;
    }

    .card {
      background-color: rgba(255, 255, 255, 0.85); /* Slight transparency */
    }

    .breadcrumb {
      background: rgba(255, 255, 255, 0.7);
    }

    .container-fluid {
      background-color: transparent !important;
    }
  </style>
</head>

<body id="page-top">

  <?php include APPPATH . 'views/admin/includes/header.php'; ?>

  <div id="wrapper">
    <!-- Sidebar -->
    <?php include APPPATH . 'views/admin/includes/sidebar.php'; ?>

    <div id="content-wrapper">
      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">Overview</li>
        </ol>

        <!-- Icon Cards-->
        <div class="row">
          <div class="col-xl-4 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon"><i class="fas fa-fw fa-comments"></i></div>
                <div class="mr-5"><?php echo htmlentities($tcount); ?> Users</div>
              </div>
              <a class="card-footer text-white clearfix small z-1">
                <span class="float-left">Total Registered Users</span>
                <span class="float-right"><i class="fas fa-angle-right"></i></span>
              </a>
            </div>
          </div>

          <div class="col-xl-4 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon"><i class="fas fa-fw fa-list"></i></div>
                <div class="mr-5"><?php echo htmlentities($tsevencount); ?> Users</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">Registered in Last 10 Days</span>
                <span class="float-right"><i class="fas fa-angle-right"></i></span>
              </a>
            </div>
          </div>

          <div class="col-xl-4 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon"><i class="fas fa-fw fa-shopping-cart"></i></div>
                <div class="mr-5"><?php echo htmlentities($tthirycount); ?> Users</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="#">
                <span class="float-left">Registered in Last 30 Days</span>
                <span class="float-right"><i class="fas fa-angle-right"></i></span>
              </a>
            </div>
          </div>
        </div>

        <!-- Admin Info Card -->
        <div class="container my-4">
          <div class="row justify-content-center">
            <div class="col-xl-6 col-md-8">
              <div class="card p-4 text-center shadow">
                <img src="<?php echo base_url('assests/Images/Admins/' . $profile->profile); ?>"
                  alt="No Img"
                  class="rounded-circle mb-3 mx-auto d-block"
                  style="width: 100px; height: 100px; object-fit: cover;" />
                <h4 class="text-primary">Welcome, <?php echo htmlentities($profile->userName); ?>!</h4>
                <h5>📞 Contact No: <span class="text-dark"><?php echo $profile->contactno; ?></span></h5>
                <p class="mb-1">📧 <strong><?php echo htmlentities($profile->emailid); ?></strong></p>
                <p class="mb-0">📅 <strong><?php echo htmlentities($currentDate); ?></strong></p>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- Footer -->
      <?php include APPPATH . 'views/admin/includes/footer.php'; ?>

    </div>
  </div>

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Scripts -->
  <script src="<?php echo base_url('assests/vendor/jquery/jquery.min.js'); ?>"></script>
  <script src="<?php echo base_url('assests/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
  <script src="<?php echo base_url('assests/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
  <script src="<?php echo base_url('assests/vendor/chart.js/Chart.min.js'); ?>"></script>
  <script src="<?php echo base_url('assests/vendor/datatables/jquery.dataTables.js'); ?>"></script>
  <script src="<?php echo base_url('assests/vendor/datatables/dataTables.bootstrap4.js'); ?>"></script>
  <script src="<?php echo base_url('assests/js/sb-admin.min.js'); ?>"></script>
  <script src="<?php echo base_url('assests/js/demo/datatables-demo.js'); ?>"></script>
  <script src="<?php echo base_url('assests/js/demo/chart-area-demo.js'); ?>"></script>

</body>

</html>
