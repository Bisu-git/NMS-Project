<!DOCTYPE html>
<html lang="en">

<head>
    <title>Fetch Data</title>
    <?php echo link_tag('assests/vendor/bootstrap/css/bootstrap.min.css'); ?>
    <?php echo link_tag('assests/vendor/fontawesome-free/css/all.min.css'); ?>
    <?php echo link_tag('assests/vendor/datatables/dataTables.bootstrap4.css'); ?>
    <?php echo link_tag('assests/css/sb-admin.css'); ?>

    <style>
        body {
            background: url('<?php echo base_url(); ?>assests/Images/Background_img.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .overlay-container {
            background-color: rgba(255, 255, 255, 0.8);
            /* translucent white overlay */
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
            margin-top: 30px;
        }

        h1 {
            color: #2c3e50;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4a90e2, #007bff);
            border: none;
            transition: all 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #007bff, #0056b3);
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .table {
            background-color: rgba(255, 255, 255, 0.95);
        }

        #success-message {
            padding: 15px;
            border-radius: 5px;
            font-weight: 500;
            margin: 20px 0;
            background-color: rgba(40, 167, 69, 0.1);
            border-left: 5px solid #28a745;
            display: none;
        }
    </style>
</head>

<body id="page-top">

    <!-- Loader -->
    <div id="statelist_loader"
        style="position: fixed;width: 100%;height: 100%;display: flex;align-items: center;justify-content: center;background: #ffffffc9;z-index: 9999;">
        <img src="<?php echo base_url(); ?>assests/Images/Animation_loader.gif" alt="Loading...">
    </div>

    <?php include APPPATH . 'views/admin/includes/header.php'; ?>

    <div id="wrapper">
        <?php include APPPATH . 'views/admin/includes/sidebar.php'; ?>

        <div id="content-wrapper">
            <div class="container-fluid">
                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?php echo site_url('admin/Dashboard'); ?>">Admin</a>
                    </li>
                    <li class="breadcrumb-item active">Fetch Server Data</li>
                </ol>



                <div class="overlay-container">
                    <h1 class="text-center">Fetch BharatNet Data</h1>
                    <form id="fetchDataForm" method="post" action="<?php echo site_url('admin/Fetch_serverdata/fetch_data'); ?>" class="text-center">
                        <button id="fetchDataBtn" class="btn btn-primary mb-3 px-4 py-2" type="submit">
                            <i class="fas fa-download mr-2"></i>Fetch The Data
                        </button>
                    </form>


                    <!-- Success Message Container -->
                    <div id="success-message" class="text-center">
                        <?php if (isset($message) && !empty($message)): ?>
                            <?php echo $message; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Data Table -->
                    <div class="table-responsive mt-4">
                        <table id="StatedetailsTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>STATE</th>
                                    <th>STATE CODE</th>
                                    <th>DATE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php if (!empty($state_details)): ?>
                                    <?php foreach ($state_details as $value): ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td><?php echo htmlspecialchars($value->state_name); ?></td>
                                            <td><?php echo htmlspecialchars($value->state_code); ?></td>
                                            <td><?php echo date('jS \of F Y', strtotime($value->Date)); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

            <?php include APPPATH . 'views/admin/includes/footer.php'; ?>
        </div>
    </div>

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Scripts -->
    <script src="<?php echo base_url('assests/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assests/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assests/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
    <script src="<?php echo base_url('assests/js/sb-admin.min.js'); ?>"></script>

    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#StatedetailsTable').DataTable({
                paging: true,
                searching: true,
                info: true,
                ordering: true,
                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                language: {
                    search: "Search records:",
                    lengthMenu: "Show _MENU_ entries per page",
                    zeroRecords: "No matching records found",
                    info: "Showing page _PAGE_ of _PAGES_",
                    infoEmpty: "No records available",
                    infoFiltered: "(filtered from _MAX_ total records)"
                }
            });

            // Hide loader after page loads
            $('#statelist_loader').fadeOut(500);

            // Show success message if exists
            <?php if (isset($message) && !empty($message)): ?>
                $('#success-message').show();
            <?php endif; ?>

            // Show loader when form is submitted
            $('#fetchDataForm').on('submit', function() {
                $('#statelist_loader').fadeIn(100);
                $('#success-message').hide();
            });
        });
    </script>
</body>

</html>