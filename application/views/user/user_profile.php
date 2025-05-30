<!DOCTYPE html>
<html lang="en">

<head>
  <title>My Profile</title>
  <?php echo link_tag('assests/vendor/bootstrap/css/bootstrap.min.css'); ?>
  <?php echo link_tag('assests/vendor/fontawesome-free/css/all.min.css'); ?>
  <?php echo link_tag('assests/vendor/datatables/dataTables.bootstrap4.css'); ?>
  <?php echo link_tag('assests/css/sb-admin.css'); ?>

  <style>
    body {
      background: url('<?php echo base_url(); ?>assests/Images/Background_img.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card-custom {
      background-color: rgba(255, 255, 255, 0.85);
      border-radius: 10px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
      padding: 30px;
      margin-top: 20px;
    }

    .form-label-group label {
      margin-top: 5px;
      font-weight: 600;
    }

    h1 {
      font-weight: 700;
      color: #333;
    }

    .btn-primary {
      border-radius: 50px;
    }

    .breadcrumb {
      background-color: rgba(255, 255, 255, 0.8);
      border-radius: 8px;
      padding: 10px 15px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .form-control {
      background-color: rgba(255, 255, 255, 0.75);
      border: 1px solid #ccc;
      color: #333;
    }

    .form-control::placeholder {
      color: #999;
    }

    .success-msg,
    .error-msg {
      font-size: 16px;
      padding: 10px;
      border-radius: 5px;
      margin-top: 10px;
    }

    .success-msg {
      background-color: rgba(212, 237, 218, 0.8);
      color: #155724;
    }

    .error-msg {
      background-color: rgba(248, 215, 218, 0.8);
      color: #721c24;
    }
  </style>
</head>

<body id="page-top">

  <?php include APPPATH . 'views/user/includes/header.php'; ?>

  <div id="wrapper">
    <?php include APPPATH . 'views/user/includes/sidebar.php'; ?>

    <div id="content-wrapper">
      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="<?php echo site_url('user/Dashboard'); ?>">User</a>
          </li>
          <li class="breadcrumb-item active">My Profile</li>
        </ol>

        <h1>My Profile</h1>
        <hr>

        <!-- Flash Messages -->
        <?php if ($this->session->flashdata('update_profile_success')) { ?>
          <div class="success-msg"><?php echo $this->session->flashdata('update_profile_success'); ?></div>
        <?php } ?>

        <?php if ($this->session->flashdata('error_profile')) { ?>
          <div class="error-msg"><?php echo $this->session->flashdata('error_profile'); ?></div>
        <?php } ?>

        <div class="card card-custom">
          <?php echo form_open_multipart('user/User_profile/updateprofile'); ?>

          <p><strong>Reg Date :</strong> <?php echo $profile->regDate; ?></p>

          <!-- First Name -->
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <div class="form-label-group">
                  <?php echo form_input(['name' => 'firstname', 'id' => 'firstname', 'class' => 'form-control', 'autofocus' => 'autofocus', 'value' => set_value('firstname', $profile->firstName)]); ?>
                  <?php echo form_label('Enter your first name', 'firstname'); ?>
                  <?php echo form_error('firstname', "<div style='color:red'>", "</div>"); ?>
                </div>
              </div>
            </div>
          </div>

          <!-- Last Name -->
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <div class="form-label-group">
                  <?php echo form_input(['name' => 'lastname', 'id' => 'lastname', 'class' => 'form-control', 'autofocus' => 'autofocus', 'value' => set_value('lastname', $profile->lastName)]); ?>
                  <?php echo form_label('Enter your last name', 'lastname'); ?>
                  <?php echo form_error('lastname', "<div style='color:red'>", "</div>"); ?>
                </div>
              </div>
            </div>
          </div>

          <!-- Email ID (readonly) -->
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <div class="form-label-group">
                  <?php echo form_input(['name' => 'emailid', 'id' => 'emailid', 'class' => 'form-control', 'readonly' => 'true', 'value' => set_value('emailid', $profile->emailId)]); ?>
                  <?php echo form_label('Enter valid email id', 'emailid'); ?>
                  <?php echo form_error('emailid', "<div style='color:red'>", "</div>"); ?>
                </div>
              </div>
            </div>
          </div>

          <!-- Mobile Number -->
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <div class="form-label-group">
                  <?php echo form_input(['name' => 'mobilenumber', 'id' => 'mobilenumber', 'class' => 'form-control', 'autofocus' => 'autofocus', 'value' => set_value('mobilenumber', $profile->mobileNumber)]); ?>
                  <?php echo form_label('Enter Mobile Number', 'mobilenumber'); ?>
                  <?php echo form_error('mobilenumber', "<div style='color:red'>", "</div>"); ?>
                </div>
              </div>
            </div>
          </div>

          <!-- Current Profile Image -->
          <div class="form-group">
            <label><strong>Current Profile Image:</strong></label><br>
            <img src="<?php echo base_url('assests/Images/profiles/' . $profile->profileImage); ?>"
              alt="Profile Image"
              style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%; border: 2px solid #ddd;">
          </div>

          <!-- Upload New Profile Image -->
          <div class="form-group">
            <div class="form-label-group">
              <?php echo form_upload([
                'name'  => 'profileImage',
                'id'    => 'profileImage',
                'class' => 'form-control',
                'accept' => 'image/*'
              ]); ?>
              <?php echo form_label('Upload New Profile Image', 'profileImage'); ?>
              <?php echo form_error('profileImage', "<div style='color:red'>", "</div>"); ?>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="form-row">
            <div class="col-md-6">
              <?php echo form_submit(['name' => 'Update', 'value' => 'Update', 'class' => 'btn btn-primary btn-block']); ?>
            </div>
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

  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="<?php echo base_url('assests/vendor/jquery/jquery.min.js'); ?>"></script>
  <script src="<?php echo base_url('assests/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
  <script src="<?php echo base_url('assests/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
  <script src="<?php echo base_url('assests/js/sb-admin.min.js'); ?>"></script>

</body>

</html>