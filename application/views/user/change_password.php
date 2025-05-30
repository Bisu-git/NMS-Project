<!DOCTYPE html>
<html lang="en">

<head>
  <title>User Change Password</title>

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
      background: url('<?php echo base_url(); ?>assests/Images/Background_img.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .form-card {
      background: rgba(255, 255, 255, 0.85); /* semi-transparent white */
      border-radius: 12px;
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
      padding: 30px;
      margin-top: 30px;
    }

    h1 {
      font-weight: 600;
      margin-bottom: 20px;
      color: #333;
    }

    .breadcrumb {
      background: transparent;
    }

    .btn-primary {
      background-color: #6a11cb;
      background-image: linear-gradient(315deg, #6a11cb 0%, #2575fc 74%);
      border: none;
    }

    .btn-primary:hover {
      background-image: linear-gradient(315deg, #2575fc 0%, #6a11cb 74%);
    }

    .form-control {
      background-color: rgba(255, 255, 255, 0.8);
      border: 1px solid #ccc;
    }

    .form-control:focus {
      background-color: rgba(255, 255, 255, 1);
      border-color: #6a11cb;
      box-shadow: 0 0 5px rgba(106, 17, 203, 0.5);
    }

    .message {
      font-size: 16px;
      font-weight: 500;
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
          <li class="breadcrumb-item active">Change Password</li>
        </ol>

        <!-- Page Content -->
        <div class="form-card col-md-8 mx-auto">
          <h1>Change Password</h1>
          <hr>

          <!-- Success Message -->
          <?php if ($this->session->flashdata('success_userpwd')) { ?>
            <p class="message text-success"><?php echo $this->session->flashdata('success_userpwd'); ?></p>
          <?php } ?>

          <!-- Error Message -->
          <?php if ($this->session->flashdata('error_user_pwd')) { ?>
            <p class="message text-danger"><?php echo $this->session->flashdata('error_user_pwd'); ?></p>
          <?php } ?>

          <?php echo form_open('user/Change_password'); ?>

          <div class="form-group">
            <?php echo form_label('Current Password', 'currentpassword'); ?>
            <?php echo form_password(['name' => 'currentpassword', 'id' => 'currentpassword', 'class' => 'form-control', 'value' => set_value('currentpassword')]); ?>
            <?php echo form_error('currentpassword', "<div class='text-danger'>", "</div>"); ?>
          </div>

          <div class="form-group">
            <?php echo form_label('New Password', 'password'); ?>
            <?php echo form_password(['name' => 'password', 'id' => 'password', 'class' => 'form-control', 'value' => set_value('password')]); ?>
            <?php echo form_error('password', "<div class='text-danger'>", "</div>"); ?>
          </div>

          <div class="form-group">
            <?php echo form_label('Confirm Password', 'confirmpassword'); ?>
            <?php echo form_password(['name' => 'confirmpassword', 'id' => 'confirmpassword', 'class' => 'form-control', 'value' => set_value('confirmpassword')]); ?>
            <?php echo form_error('confirmpassword', "<div class='text-danger'>", "</div>"); ?>
          </div>

          <div class="form-group">
            <?php echo form_submit(['name' => 'chnagepwd', 'value' => 'Change', 'class' => 'btn btn-primary btn-block']); ?>
          </div>

          <?php echo form_close(); ?>
        </div>

      </div>
      <!-- /.container-fluid -->

      <?php include APPPATH . 'views/user/includes/footer.php'; ?>
    </div>
    <!-- /.content-wrapper -->
  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Scripts -->
  <script src="<?php echo base_url('assests/vendor/jquery/jquery.min.js'); ?>"></script>
  <script src="<?php echo base_url('assests/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
  <script src="<?php echo base_url('assests/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
  <script src="<?php echo base_url('assests/js/sb-admin.min.js'); ?>"></script>

</body>
</html>
