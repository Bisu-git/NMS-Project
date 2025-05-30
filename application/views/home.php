<!DOCTYPE html>
<html lang="en">

<head>
  <title>Home Page</title>
  <?php echo link_tag('assests/vendor/bootstrap/css/bootstrap.min.css'); ?>
  <?php echo link_tag('assests/vendor/fontawesome-free/css/all.min.css'); ?>
  <?php echo link_tag('assests/vendor/datatables/dataTables.bootstrap4.css'); ?>
  <?php echo link_tag('assests/css/sb-admin.css'); ?>

  <style>
    body {
      background: linear-gradient(135deg, #1f1c2c, #928dab);
      color: white;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .breadcrumb {
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 0.5rem;
    }

    h1 {
      font-size: 2.5rem;
      font-weight: 600;
    }

    .card {
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 24px rgba(0, 0, 0, 0.35);
    }

    .card-body-icon {
      position: absolute;
      top: -20px;
      right: 20px;
      opacity: 0.3;
      font-size: 5rem;
    }

    .card-footer {
      background-color: rgba(0, 0, 0, 0.15) !important;
    }

    .container-fluid {
      max-width: 600px;
    }
  </style>
</head>

<body id="page-top">
  <div id="wrapper">
    <div id="content-wrapper">

      <div class="container-fluid d-flex flex-column justify-content-center align-items-center vh-100">

        <ol class="breadcrumb">
          <li class="breadcrumb-item text-white">
            <a class="text-white">Home Page</a>
          </li>
        </ol>

        <h1 class="text-center mb-4">User Details Of BBNL</h1>

        <div class="col-md-12 d-flex justify-content-center">
          <div class="card text-white bg-primary o-hidden h-100 w-75">
            <div class="card-body position-relative">
              <div class="card-body-icon">
                <i class="fas fa-fw fa-users"></i>
              </div>
              <div class="mr-5 h4">User Login</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo site_url('user/login'); ?>">
              <span class="float-left">Click Here</span>
              <span class="float-right">
                <i class="fas fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>

        <!-- Hidden Admin Card -->
        <div class="col-md-12 d-flex justify-content-center">
          <div class="card text-white bg-warning o-hidden h-100 w-75 mt-4 ">
            <div class="card-body position-relative">
              <div class="card-body-icon">
                <i class="fas fa-fw fa-list"></i>
              </div>
              <div class="mr-5 h4">Admin Login</div>
            </div>
            <a class="card-footer text-white clearfix small z-1" href="<?php echo site_url('admin/login'); ?>">
              <span class="float-left">Click Here</span>
              <span class="float-right">
                <i class="fas fa-angle-right"></i>
              </span>
            </a>
          </div>
        </div>

      </div>

    </div>
  </div>

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
