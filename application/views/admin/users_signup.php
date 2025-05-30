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
        body {
            margin: 0;
            padding: 0;
            background: transparent;
        }

        .card {
            border-radius: 1rem;
            background: rgba(255, 255, 255, 0.8);
            /* Transparent background with white overlay */
            border: 1px solid rgba(0, 0, 0, 0.1);
            /* Optional: Light border to make it stand out */
        }

        .card-header {
            background-color: rgba(11, 4, 4, 0.82);
            /* New attractive header color (light teal) */
            color: white;
        }

        .form-control:focus {
            border-color: #34c9c3;
            /* Matching the new teal color */
            box-shadow: 0 0 0 0.2rem rgba(34, 193, 195, 0.25);
            /* Matching focus color */
        }

        .btn-primary {
            background-color: rgba(15, 5, 9, 0.63);
            /* New attractive button color (coral) */
            border: none;
        }

        .btn-primary:hover {
            background-color: rgba(8, 10, 67, 0.6);
            /* Darker shade of coral on hover */
        }

        h4 {
            color: rgba(214, 214, 214, 0.77);
            /* Matching the button color for the heading */
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
                    <li class="breadcrumb-item active">Users Signup</li>
                </ol>

                <div class="card shadow-lg border-0 rounded-lg mt-4 mb-5">
                    <div class="card-header">
                        <h4 class="text-center m-0">Register an Account</h4>
                    </div>
                    <div class="card-body px-4 py-4">

                        <!-- Success Message -->
                        <?php if ($this->session->flashdata('usignup_success')) { ?>
                            <div class="alert alert-success">
                                <?php echo $this->session->flashdata('usignup_success'); ?>
                            </div>
                        <?php } ?>

                        <!-- Error Message -->
                        <?php if ($this->session->flashdata('usignup_error')) { ?>
                            <div class="alert alert-danger">
                                <?php echo $this->session->flashdata('usignup_error'); ?>
                            </div>
                        <?php } ?>

                        <?php echo form_open_multipart('admin/Auser_signup'); ?>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <?php echo form_label('First Name', 'firstname'); ?>
                                <?php echo form_input(['name' => 'firstname', 'id' => 'firstname', 'class' => 'form-control', 'value' => set_value('firstname')]); ?>
                                <?php echo form_error('firstname', "<small class='text-danger'>", "</small>"); ?>
                            </div>
                            <div class="form-group col-md-6">
                                <?php echo form_label('Last Name', 'lastname'); ?>
                                <?php echo form_input(['name' => 'lastname', 'id' => 'lastname', 'class' => 'form-control', 'value' => set_value('lastname')]); ?>
                                <?php echo form_error('lastname', "<small class='text-danger'>", "</small>"); ?>
                            </div>
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
                            <?php echo form_label('Upload Profile Image', 'assets_img'); ?>
                            <?php echo form_input([
                                'type'  => 'file',
                                'name'  => 'file_assets',
                                'id'    => 'assets_img',
                                'class' => 'form-control-file',
                                'accept' => 'image/*',
                                'required' => 'required'
                            ]); ?>
                            <?php echo form_error('file_assets', "<small class='text-danger'>", "</small>"); ?>
                            <small id="current_image_name" class="form-text text-success mt-2"></small>
                            <small id="image_error" class="form-text text-danger"></small>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <?php echo form_label('User Role', 'role_id'); ?>
                                <select name="role_id" id="role_id" class="form-control">
                                    <option value="">-- Select Role --</option>
                                    <?php foreach ($roles as $role): ?>
                                        <option value="<?php echo $role['id']; ?>" <?php echo set_select('role_id', $role['id']); ?>>
                                            <?php echo $role['role_name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php echo form_error('role_id', "<small class='text-danger'>", "</small>"); ?>
                            </div>

                            <div class="form-group col-md-6">
                                <?php echo form_label('User Scope', 'scope_id'); ?>
                                <select name="scope_id" id="scope_id" class="form-control">
                                    <option value="">-- Select Scope --</option>
                                    <?php foreach ($scopes as $scope): ?>
                                        <option value="<?php echo $scope['scope_name']; ?>" <?php echo set_select('scope_id', $scope['id']); ?>>
                                            <?php echo $scope['scope_name']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php echo form_error('scope_id', "<small class='text-danger'>", "</small>"); ?>
                            </div>
                        </div>


                        <div class="form-group statedetails d-none">
                            <label for="tableSelect">Select State</label>
                            <select id="stateSelect" class="form-control" name="stateSelect">
                                <option value="">-- Select State --</option>
                                <?php foreach ($state_list as $state): ?>
                                    <option value="<?= $state['state_code'] ?>"><?= $state['state_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group districtdetails d-none">
                            <label for="tableSelect">Select District</label>
                            <select name="districtSelect" class="form-control" id="districtSelect">
                                <option value="">-- Select District --</option>
                            </select>
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

    <!-- Background Image -->
    <img src="<?php echo base_url('assests/Images/Background_img.jpg'); ?>" alt="Background Image" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; object-fit: cover; opacity: 0.5;">

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

    <script>
        $(document).ready(function() {
            $("#scope_id").change(function() {
                var scope_id = $(this).val();
                console.log("Selected Scope:", scope_id);
                $('#stateSelect').val('').trigger('change');


                // Hide both by default
                $('.statedetails').addClass('d-none');
                $('.districtdetails').addClass('d-none');

                if (scope_id === "STATE") {
                    $('.statedetails').removeClass('d-none');
                    $('#stateSelect').prop('required', true);
                } else if (scope_id === "STATE & DISTRICT") {
                    $('.statedetails').removeClass('d-none');
                    $('.districtdetails').removeClass('d-none');
                    $('#stateSelect').prop('required', true);
                    $('#districtSelect').prop('required', true);
                }else{
                    $('#stateSelect').prop('required', false);
                    $('#districtSelect').prop('required', false);
                }
            });

            // When state is selected, load districts
            $("#stateSelect").change(function() {
                var dep_id = $(this).val();
                $("#districtSelect").html('<option value="">Loading...</option>');

                if (dep_id) {
                    $.ajax({
                        url: "<?php echo site_url('admin/Manage_Admins/get_district_and_state'); ?>",
                        type: "POST",
                        data: {
                            dep_id: dep_id
                        },
                        dataType: "json",
                        success: function(data) {
                            var options = '<option value="">Select District</option>';
                            $.each(data, function(index, item) {
                                options += '<option value="' + item.district_code + '">' + item.district_names + '</option>';
                            });
                            $("#districtSelect").html(options);
                        }
                    });
                } else {
                    $("#districtSelect").html('<option value="">Select District</option>');
                }
            });
        });
    </script>


</body>

</html>