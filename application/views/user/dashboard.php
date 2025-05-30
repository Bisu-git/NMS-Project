<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>User Dashboard</title>

  <!-- Bootstrap core CSS-->
  <?php echo link_tag('assests/vendor/bootstrap/css/bootstrap.min.css'); ?>
  <!-- Custom fonts for this template-->
  <?php echo link_tag('assests/vendor/fontawesome-free/css/all.min.css'); ?>
  <!-- Page level plugin CSS-->
  <?php echo link_tag('assests/vendor/datatables/dataTables.bootstrap4.css'); ?>
  <!-- Custom styles for this template-->
  <?php echo link_tag('assests/css/sb-admin.css'); ?>

  <style>
    body {
      background-image: url('<?php echo base_url(); ?>assests/Images/Background_img.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center center;
      background-attachment: fixed;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .dashboard-card {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      padding: 30px;
      transition: 0.3s ease;
    }

    .dashboard-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }

    .user-img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 50%;
      box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
      border: 2px solid #007bff;
    }

    h3,
    h4 {
      margin-bottom: 15px;
    }

    .breadcrumb {
      background: transparent;
    }
  </style>
</head>

<body id="page-top">

  <?php include APPPATH . 'views/user/includes/header.php'; ?>

  <div id="wrapper">

    <!-- Sidebar -->
    <?php include APPPATH . 'views/user/includes/sidebar.php'; ?>

    <div id="content-wrapper">
      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="<?php echo site_url('user/Dashboard'); ?>">User</a>
          </li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>

        <!-- Icon Cards -->
        <div class="row justify-content-center">
          <div class="col-xl-10 col-md-12 mb-4">
            <div class="dashboard-card text-center">
              <img src="<?php echo base_url(); ?>assests/Images/profiles/<?php echo $profile->profileImage; ?>" alt="No Img" class="user-img mb-3" />
              <h3 class="text-primary">Welcome, <?php echo $profile->firstName . ' ' . $profile->lastName; ?>!</h3>
              <h4>📞 Contact No: <span class="text-dark"><?php echo $profile->mobileNumber; ?></span></h4>
              <h4>👤 User Role: <span class="text-dark"><?php echo $profile->role_name; ?></span></h4>

              <?php if ($profile->scope_id == 'STATE'): ?>
                <h4>🗺️ Assign State: <span class="text-dark"><?php echo $profile->state_name; ?></span></h4>

              <?php elseif ($profile->scope_id == 'STATE & DISTRICT'): ?>
                <h4>🗺️ Assign State: <span class="text-dark"><?php echo $profile->state_name; ?></span></h4>
                <h4>🏙️ Assign District: <span class="text-dark"><?php echo $profile->district_names; ?></span></h4>

              <?php else: ?>
                <h4>🌍 Assign For: <span class="text-dark">ALL INDIA</span></h4>
              <?php endif; ?>

            </div>
          </div>
        </div>



      </div>
      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
      <?php include APPPATH . 'views/user/includes/footer.php'; ?>
    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url('assests/vendor/jquery/jquery.min.js'); ?>"></script>
  <script src="<?php echo base_url('assests/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>

  <!-- Core plugin JavaScript-->
  <script src="<?php echo base_url('assests/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>

  <!-- Page level plugin JavaScript-->
  <script src="<?php echo base_url('assests/vendor/chart.js/Chart.min.js'); ?>"></script>
  <script src="<?php echo base_url('assests/vendor/datatables/jquery.dataTables.js'); ?>"></script>
  <script src="<?php echo base_url('assests/vendor/datatables/dataTables.bootstrap4.js'); ?>"></script>

  <!-- Custom scripts for all pages-->
  <script src="<?php echo base_url('assests/js/sb-admin.min.js'); ?>"></script>
  <script src="<?php echo base_url('assests/js/demo/datatables-demo.js'); ?>"></script>
  <script src="<?php echo base_url('assests/js/demo/chart-area-demo.js'); ?>"></script>

</body>

</html>