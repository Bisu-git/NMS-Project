<!DOCTYPE html>
<html lang="en">

<head>
  <title>User - Signup</title>
  <?php echo link_tag('assests/vendor/bootstrap/css/bootstrap.min.css'); ?>
  <?php echo link_tag('assests/vendor/fontawesome-free/css/all.min.css'); ?>
  <?php echo link_tag('assests/css/sb-admin.css'); ?>

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Register an Account</div>
      <div class="card-body">
        <!---- Success Message ---->
        <?php if ($this->session->flashdata('success')) { ?>
          <p style="color:green; font-size:18px;"><?php echo $this->session->flashdata('success'); ?></p>
      </div>


      <?php } ?>

      <!---- Error Message ---->

      <?php if ($this->session->flashdata('error')) { ?>
        <p style="color:red; font-size:18px;"><?php echo $this->session->flashdata('error'); ?></p>

      <?php } ?>



      <?php echo form_open_multipart('user/signup'); ?>
        <div class="form-group">
          <div class="form-row">
            <div class="col-md-6">
              <div class="form-label-group">

                <?php echo form_input(['name' => 'firstname', 'id' => 'firstname', 'class' => 'form-control', 'autofocus' => 'autofocus', 'value' => set_value('firstname')]); ?>
                <?php echo form_label('Enter your first name', 'firstname'); ?>
                <?php echo form_error('firstname', "<div style='color:red'>", "</div>"); ?>

              </div>
            </div>
            <div class="col-md-6">
              <div class="form-label-group">

                <?php echo form_input(['name' => 'lastname', 'id' => 'lastname', 'class' => 'form-control', 'autofocus' => 'autofocus', 'value' => set_value('lastname')]); ?>
                <?php echo form_label('Enter your  last name', 'lastname'); ?>
                <?php echo form_error('lastname', "<div style='color:red'>", "</div>"); ?>

              </div>
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="form-label-group">

            <?php echo form_input(['name' => 'emailid', 'id' => 'emailid', 'class' => 'form-control', 'autofocus' => 'autofocus', 'value' => set_value('emailid')]); ?>
            <?php echo form_label('Enter valid email id', 'emailid'); ?>
            <?php echo form_error('emailid', "<div style='color:red'>", "</div>"); ?>

          </div>
        </div>

        <div class="form-group">
          <div class="form-label-group">

            <?php echo form_input(['name' => 'mobilenumber', 'id' => 'mobilenumber', 'class' => 'form-control', 'autofocus' => 'autofocus', 'value' => set_value('mobilenumber')]); ?>
            <?php echo form_label('Enter Mobile Number', 'mobilenumber'); ?>
            <?php echo form_error('mobilenumber', "<div style='color:red'>", "</div>"); ?>

          </div>
        </div>

        <div class="form-group">
          <div class="form-label-group">
            <?php echo form_input([
              'type'  => 'file',
              'name'  => 'file_assets',
              'id'    => 'assets_img',
              'class' => 'form-control',
              'accept' => 'image/*',
              'required' => 'required'
            ]); ?>
            <?php echo form_label('Upload Profile Image', 'assets_img'); ?>
            <?php echo form_error('file_assets', "<div style='color:red'>", "</div>"); ?>
            <div id="current_image_name" style="margin-top: 5px; color: green; font-size: 14px;"></div>
            <div id="image_error" style="color: red; font-size: 14px;"></div>
          </div>
        </div>


        <div class="form-group">
          <div class="form-row">
            <div class="col-md-6">
              <div class="form-label-group">
                <?php echo form_password(['name' => 'password', 'id' => 'password', 'class' => 'form-control', 'autofocus' => 'autofocus', 'value' => set_value('password')]); ?>
                <?php echo form_label('Password', 'password'); ?>
                <?php echo form_error('password', "<div style='color:red'>", "</div>"); ?>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-label-group">
                <?php echo form_password(['name' => 'confirmpassword', 'id' => 'confirmpassword', 'class' => 'form-control', 'autofocus' => 'autofocus', 'value' => set_value('confirmpassword')]); ?>
                <?php echo form_label('Confirm Password', 'confirmpassword'); ?>
                <?php echo form_error('confirmpassword', "<div style='color:red'>", "</div>"); ?>
              </div>
            </div>
          </div>
        </div>
        <?php echo form_submit(['name' => 'Register', 'value' => 'Register', 'class' => 'btn btn-primary btn-block']); ?>

      </form>
        <div class="text-center">
          <a class="d-block small mt-3" href="<?php echo site_url('user/Login'); ?>">Login Page</a>

        </div>
    </div>
  </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="<?php echo base_url('assests/vendor/jquery/jquery.min.js'); ?>"></script>
  <script src="<?php echo base_url('assests/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
  <script src="<?php echo base_url('assests/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>

  <script>
    document.getElementById("assets_img").addEventListener("change", function() {
      const fileInput = this;
      const file = fileInput.files[0];
      const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
      const maxSize = 2 * 1024 * 1024; // 2MB
      const errorText = document.getElementById("image_error");
      const fileNameDisplay = document.getElementById("current_image_name");

      errorText.textContent = '';
      fileNameDisplay.textContent = '';

      if (file) {
        if (!allowedTypes.includes(file.type)) {
          errorText.textContent = "Only JPG and PNG files are allowed.";
          fileInput.value = "";
          return;
        }

        if (file.size > maxSize) {
          errorText.textContent = "Image size should not exceed 2 MB.";
          fileInput.value = "";
          return;
        }

        fileNameDisplay.textContent = "Selected File: " + file.name;
      }
    });
  </script>



</body>

</html>