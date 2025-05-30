<!DOCTYPE html>
<html lang="en">

<head>

    <title>Admin - Dashboard</title>

    <!-- Bootstrap core CSS-->
    <?php echo link_tag('assests/vendor/bootstrap/css/bootstrap.min.css'); ?>
    <!-- Custom fonts for this template-->
    <?php echo link_tag('assests/vendor/fontawesome-free/css/all.min.css'); ?>
    <!-- Page level plugin CSS-->
    <?php echo link_tag('assests/vendor/datatables/dataTables.bootstrap4.css'); ?>
    <!-- Custom styles for this template-->
    <?php echo link_tag('assests/css/sb-admin.css'); ?>
    <style>
        /* Set the background image for the body */
        body {
            background-image: url('<?php echo base_url(); ?>assests/Images/Background_img.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            color: #495057;
        }

        .card {
            border-radius: 1rem;
            background-color: rgba(255, 255, 255, 0.8);
            /* Transparent white background */
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.7) !important;
            /* Slight transparency */
            border-color: #ccc;
            color: #495057;
            /* Dark color for the text */
        }

        .form-control:focus {
            border-color: #19312952;
            /* Green color for focus */
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
            /* Light green shadow */
        }

        .btn-primary {
            background-color: #1b1115a1;
            /* Changed button to a fresh green color */
            border: none;
        }

        .btn-primary:hover {
            background-color: rgba(69, 54, 60, 0.5);
            /* Darker green when hovered */
        }

        .card-header {
            background-color: #383d41;
            /* Changed header to fresh green */
            color: white;
        }

        .breadcrumb {
            background-color: #f8f9fc;
        }

        .form-label {
            font-weight: bold;
        }

        /* Make form controls more transparent but readable */
        .form-group input,
        .form-group select,
        .form-group textarea {
            background-color: rgba(255, 255, 255, 0.7);
            /* Slight transparency */
            border: 1px solid #ccc;
            color: #495057;
        }

        /* Additional focus effect on input fields */
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            background-color: rgba(255, 255, 255, 0.9);
            /* Slightly more opaque when focused */
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
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
                <ol class="breadcrumb bg-light shadow-sm rounded">
                    <li class="breadcrumb-item">
                        <a href="#">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Admin Signup</li>
                </ol>

                <div class="card shadow-lg border-0 rounded-lg mt-4 mb-5">
                    <div class="card-header">
                        <h4 class="text-center m-0">Register as Admin</h4>
                    </div>
                    <div class="card-body px-4 py-4">

                        <!-- Success Message -->
                        <?php if ($this->session->flashdata('asignup_success')) { ?>
                            <div class="alert alert-success">
                                <?php echo $this->session->flashdata('asignup_success'); ?>
                            </div>
                        <?php } ?>

                        <!-- Error Message -->
                        <?php if ($this->session->flashdata('asignup_error')) { ?>
                            <div class="alert alert-danger">
                                <?php echo $this->session->flashdata('asignup_error'); ?>
                            </div>
                        <?php } ?>

                        <?php echo form_open_multipart('admin/Admin_signup'); ?>

                        <div class="form-row">
                            <?php echo form_label('Admin Name', 'adminname'); ?>
                            <?php echo form_input([
                                'name' => 'firstname',
                                'id' => 'adminname',
                                'class' => 'form-control',
                                'value' => set_value('firstname')
                            ]); ?>
                            <?php echo form_error('firstname', "<small class='text-danger'>", "</small>"); ?>
                        </div>

                        <div class="form-group">
                            <?php echo form_label('Email ID', 'emailid'); ?>
                            <?php echo form_input(['name' => 'emailid', 'id' => 'emailid', 'class' => 'form-control', 'value' => set_value('emailid')]); ?>
                            <?php echo form_error('emailid', "<small class='text-danger'>", "</small>"); ?>
                        </div>

                        <div class="form-group">
                            <?php echo form_label('Mobile Number', 'mobilenumber'); ?>
                            <?php echo form_input(['name' => 'mobilenumber', 'id' => 'mobilenumber', 'class' => 'form-control', 'value' => set_value('mobilenumber')]); ?>
                            <?php echo form_error('mobilenumber', "<small class='text-danger'>", "</small>"); ?>
                        </div>

                        <div class="form-group">
                            <?php echo form_label('Role', 'role'); ?>
                            <?php
                            $options = [
                                '' => 'Select Role',
                                'ADMIN' => 'ADMIN',
                                'SUPER ADMIN' => 'Super Admin',
                                'MODULE ADMIN' => 'Module Admin',
                                'REGIONAL ADMIN' => 'Regional Admin'
                            ];
                            echo form_dropdown('role', $options, set_value('role'), [
                                'class' => 'form-control custom-select',
                                'required' => 'required'
                            ]);
                            ?>
                            <?php echo form_error('role', "<small class='text-danger'>", "</small>"); ?>
                        </div>


                        <div class="form-group">
                            <?php echo form_label('Upload Profile Image', 'admin_profile'); ?>
                            <?php echo form_input([
                                'type'  => 'file',
                                'name'  => 'admin_profile',
                                'id'    => 'admin_profile',
                                'class' => 'form-control-file',
                                'accept' => 'image/*',
                                'required' => 'required'
                            ]); ?>
                            <?php echo form_error('admin_profile', "<small class='text-danger'>", "</small>"); ?>
                            <small id="image_error" class="form-text text-danger"></small>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <?php echo form_label('Password', 'password'); ?>
                                <?php echo form_password(['name' => 'password', 'id' => 'password', 'class' => 'form-control']); ?>
                                <?php echo form_error('password', "<small class='text-danger'>", "</small>"); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <?php echo form_label('Confirm Password', 'confirmpassword'); ?>
                                <?php echo form_password(['name' => 'confirmpassword', 'id' => 'confirmpassword', 'class' => 'form-control']); ?>
                                <?php echo form_error('confirmpassword', "<small class='text-danger'>", "</small>"); ?>
                            </div>
                        </div>

                        <?php echo form_submit(['name' => 'Register', 'value' => 'Register', 'class' => 'btn btn-primary btn-lg btn-block']); ?>

                        </form>
                    </div>
                </div>
            </div>

            <!-- /.container-fluid -->

            <!-- Sticky Footer -->
            <?php include APPPATH . 'views/admin/includes/footer.php'; ?>

        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

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