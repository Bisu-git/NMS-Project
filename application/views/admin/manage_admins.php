<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin - Manage Admins</title>

    <!-- Bootstrap core CSS-->
    <?php echo link_tag('assests/vendor/bootstrap/css/bootstrap.min.css'); ?>
    <!-- Custom fonts for this template-->
    <?php echo link_tag('assests/vendor/fontawesome-free/css/all.min.css'); ?>
    <!-- Page level plugin CSS-->
    <?php echo link_tag('assests/vendor/datatables/dataTables.bootstrap4.css'); ?>
    <!-- Custom styles for this template-->
    <?php echo link_tag('assests/css/sb-admin.css'); ?>

    <style>
        /* Apply the background image to the entire body */
        body {
            background: url('<?php echo base_url(); ?>assests/Images/Background_img.jpg') no-repeat center center fixed;
            background-size: cover;
            background-attachment: fixed;
        }

        /* Ensure the content wrapper has no background, just the image */
        #content-wrapper {
            background: transparent;
            /* Remove background */
            padding: 20px;
        }

        /* Apply the background image to the table container */
        .table-responsive {
            background: url('<?php echo base_url(); ?>assests/Images/Background_img.jpg') no-repeat center center fixed;
            background-size: cover;
            padding: 15px;
            border-radius: 8px;
        }

        /* The table itself should have a transparent background */
        .table {
            background: transparent;
            /* Transparent background for the table */
            color: white;
            /* White text color for the table data */
        }

        /* Ensure the table header is still distinguishable */
        .table thead {
            background-color: rgba(0, 0, 0, 0.5);
            /* Dark background with transparency for the header */
            color: white;
            /* White text for the header */
        }

        /* Ensure the table data text is white */
        .table tbody td {
            color: white;
            /* White text for table data */
        }

        /* Optional: Style the Success Message */
        .success-message {
            color: green;
            font-size: 18px;
        }

        .card-header,
        .card-body {
            background-color: rgb(0 0 0 / 88%);
            color: white;
        }
    </style>

</head>

<body id="page-top">
    <?php include APPPATH . 'views/admin/includes/header.php'; ?>

    <div id="wrapper">

        <?php include APPPATH . 'views/admin/includes/sidebar.php'; ?>

        <div id="content-wrapper">

            <div class="container-fluid">

                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?php echo site_url('admin/Dashboard'); ?>">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">Manage Admins</li>
                </ol>

                <!-- DataTables Example -->
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="fas fa-table"></i> Admin Details
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- Success Message -->
                            <?php if ($this->session->flashdata('success')) { ?>
                                <p class="success-message"><?php echo $this->session->flashdata('success'); ?></p>
                        </div>
                    <?php } ?>

                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Admin Name</th>
                                <th>Email id</th>
                                <th>Profile</th>
                                <th>Contact</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Admin Name</th>
                                <th>Email id</th>
                                <th>Profile</th>
                                <th>Contact</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                            if (count($admindetails)) :
                                $cnt = 1;
                                foreach ($admindetails as $row) :
                            ?>
                                    <tr>
                                        <td><?php echo htmlentities($cnt); ?></td>
                                        <td><?php echo htmlentities($row->userName); ?></td>
                                        <td><?php echo !empty($row->emailid) ? htmlentities($row->emailid) : 'N/A'; ?></td>
                                        <td>
                                            <?php if (!empty($row->profile)) { ?>
                                                <a href="<?php echo base_url(); ?>assests/Images/Admins/<?php echo $row->profile; ?>" target="_blank">
                                                    <img src="<?php echo base_url(); ?>assests/Images/Admins/<?php echo $row->profile; ?>"
                                                        alt="Profile Image"
                                                        style="width: 70px; height: 70px; object-fit: cover; border-radius: 5px;" />
                                                </a>
                                            <?php } else { ?>
                                                <span>No Img</span>
                                            <?php } ?>
                                        </td>
                                        <td><?php echo !empty($row->contactno) ? htmlentities($row->contactno) : 'N/A'; ?></td>
                                        <td>
                                            <?php echo anchor("admin/Manage_Admins/geteditadmindetail/{$row->id}", ' ', 'class="fa fa-edit"'); ?>
                                            <?php echo anchor("admin/Manage_Admins/deleteadmin/{$row->id}", ' ', 'class="fa fa-trash"'); ?>
                                        </td>
                                    </tr>
                                <?php
                                    $cnt++;
                                endforeach;
                            else : ?>
                                <tr>
                                    <td colspan="6">No Record found</td>
                                </tr>
                            <?php
                            endif;
                            ?>
                        </tbody>

                    </table>
                    </div>
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