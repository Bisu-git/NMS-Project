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
                    <li class="breadcrumb-item active">Roals & Scope</li>
                </ol>

                <div class="card shadow-lg border-0 rounded-lg mt-4 mb-5">
                    <div class="card-header">
                        <h4 class="text-center m-0">Roals & Scope</h4>
                    </div>
                    <div class="card-body px-4 py-4">

                        <!-- Success Message -->
                        <?php if ($this->session->flashdata('rollsc_success')) { ?>
                            <div class="alert alert-success">
                                <?php echo $this->session->flashdata('rollsc_success'); ?>
                            </div>
                        <?php } ?>

                        <!-- Error Message -->
                        <?php if ($this->session->flashdata('rollsc_error')) { ?>
                            <div class="alert alert-danger">
                                <?php echo $this->session->flashdata('rollsc_error'); ?>
                            </div>
                        <?php } ?>

                        <!-- Corrected View Section -->
                        <?php echo form_open_multipart('admin/Roals_scope/user_roals'); ?>
                        <div class="form-row">
                            <div class="form-group">
                                <?php echo form_label('USER ROLES', 'userroles'); ?>
                                <?php echo form_input([
                                    'name' => 'userroles',
                                    'id' => 'userroles',
                                    'class' => 'form-control',
                                    'value' => set_value('userroles')
                                ]); ?>
                                <?php echo form_error('userroles', "<small class='text-danger'>", "</small>"); ?>
                            </div>
                        </div>
                        <?php echo form_submit([
                            'name' => 'submit_roles',
                            'value' => 'Add Role',
                            'class' => 'btn btn-primary btn-lg btn-block'
                        ]); ?>
                        <?php echo form_close(); ?>


                        <?php echo form_open_multipart('admin/Roals_scope/user_scope'); ?>
                        <div class="form-row mt-4">
                            <div class="form-group">
                                <?php echo form_label('USER SCOPE', 'userscope'); ?>
                                <?php echo form_input([
                                    'name' => 'userscope',
                                    'id' => 'userscope',
                                    'class' => 'form-control',
                                    'value' => set_value('userscope')
                                ]); ?>
                                <?php echo form_error('userscope', "<small class='text-danger'>", "</small>"); ?>
                            </div>
                        </div>
                        <?php echo form_submit([
                            'name' => 'submit_scope',
                            'value' => 'Add Scope',
                            'class' => 'btn btn-primary btn-lg btn-block'
                        ]); ?>
                        <?php echo form_close(); ?>

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

</body>

</html>