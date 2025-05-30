<!DOCTYPE html>
<html lang="en">

<head>
  <title>Admin Change Password</title>

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
      background: url('<?php echo base_url("assests/Images/Background_img.jpg"); ?>') no-repeat center center fixed;
      background-size: cover;
    }

    .form-control {
      background-color: #fff !important;
      /* Prevent transparency in inputs */
    }

    .form-label-group label {
      color: #000;
      /* Ensure label text is visible */
    }

    .breadcrumb,
    h1,
    hr,
    p {
      color: #fff;
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
          <li class="breadcrumb-item"><a href="<?php echo site_url('admin/Dashboard'); ?>">Admin</a></li>
          <li class="breadcrumb-item active">Change Password</li>
        </ol>

        <h1>Change Password</h1>
        <hr>

        <?php if ($this->session->flashdata('adminpwd_success')) { ?>
          <p style="color:limegreen; font-size:18px;"><?php echo $this->session->flashdata('adminpwd_success'); ?></p>
        <?php } ?>

        <?php if ($this->session->flashdata('adminpwd_error')) { ?>
          <p style="color:red; font-size:18px;"><?php echo $this->session->flashdata('adminpwd_error'); ?></p>
        <?php } ?>

        <?php echo form_open('admin/Change_password'); ?>

        <div class="form-group">
          <div class="form-row">
            <div class="col-md-6">
              <div class="form-label-group">
                <?php echo form_password([
                  'name' => 'currentpassword',
                  'id' => 'currentpassword',
                  'class' => 'form-control',
                  'autofocus' => 'autofocus',
                  'value' => set_value('currentpassword')
                ]); ?>
                <?php echo form_label('Current Password', 'currentpassword'); ?>
                <?php echo form_error('currentpassword', "<div style='color:red'>", "</div>"); ?>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="form-row">
            <div class="col-md-6">
              <div class="form-label-group">
                <?php echo form_password([
                  'name' => 'password',
                  'id' => 'password',
                  'class' => 'form-control',
                  'value' => set_value('password')
                ]); ?>
                <?php echo form_label('New Password', 'password'); ?>
                <?php echo form_error('password', "<div style='color:red'>", "</div>"); ?>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="form-row">
            <div class="col-md-6">
              <div class="form-label-group">
                <?php echo form_password([
                  'name' => 'confirmpassword',
                  'id' => 'confirmpassword',
                  'class' => 'form-control',
                  'value' => set_value('confirmpassword')
                ]); ?>
                <?php echo form_label('Confirm Password', 'confirmpassword'); ?>
                <?php echo form_error('confirmpassword', "<div style='color:red'>", "</div>"); ?>
              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="form-row">
            <div class="col-md-6">
              <?php echo form_submit([
                'name' => 'chnagepwd',
                'value' => 'Change',
                'class' => 'btn btn-primary btn-block'
              ]); ?>
            </div>
          </div>
        </div>

        <?php echo form_close(); ?>

      </div>

      <?php include APPPATH . 'views/admin/includes/footer.php'; ?>
    </div>
  </div>

  <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

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