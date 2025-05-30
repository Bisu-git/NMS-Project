<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Fetch API Data</title>

    <!-- Bootstrap -->
    <?php echo link_tag('assests/vendor/bootstrap/css/bootstrap.min.css'); ?>
    <?php echo link_tag('assests/vendor/fontawesome-free/css/all.min.css'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <?php echo link_tag('assests/css/sb-admin.css'); ?>

    <style>
        body {
            background: #e9ecef;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        h1 {
            font-weight: bold;
            color: #2c3e50;
        }

        .breadcrumb {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 10px 20px;
            border-radius: 8px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .card form .form-group label {
            font-weight: 600;
            color: #495057;
        }

        .form-control,
        .btn {
            border-radius: 6px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        #loader {
            display: none;
            text-align: center;
            padding: 20px;
        }

        #loader .spinner-border {
            width: 3rem;
            height: 3rem;
        }

        .table-responsive {
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        #blockDataTable thead {
            background-color: #343a40;
            color: white;
        }

        #blockDataTable tbody tr:hover {
            background-color: #f1f1f1;
        }

        .dataTables_filter input,
        .dataTables_length select {
            border-radius: 4px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background-color: #f8f9fa;
            border-radius: 6px;
            margin: 0 2px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #e2e6ea;
            color: #000 !important;
        }

        .select-title {
            font-size: 1.1rem;
            font-weight: 600;
        }
    </style>



</head>

<body id="page-top">

    <?php include APPPATH . 'views/user/includes/header.php'; ?>

    <div id="wrapper">

        <?php include APPPATH . 'views/user/includes/sidebar.php'; ?>

        <div id="content-wrapper">
            <div class="container-fluid">

                <!-- Breadcrumbs -->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo site_url('user/Dashboard'); ?>">User</a></li>
                    <li class="breadcrumb-item active">State Data</li>
                    <li class="breadcrumb-item active">District Data</li>
                    <li class="breadcrumb-item active">Block Data</li>
                </ol>

                <h1 class="text-center mb-4">Get BBNL Block Wise Data</h1>

                <!-- Loader -->
                <div id="loader" class="mb-3">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2">Loading data, please wait...</p>
                </div>

                <!-- Table Section -->
                <div class="table-responsive">
                    <table id="blockDataTable" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Block Name</th>
                                <th>GP Count</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>

            <?php include APPPATH . 'views/user/includes/footer.php'; ?>
        </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>

    <!-- Core JS -->
    <script src="<?php echo base_url('assests/vendor/jquery/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assests/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('assests/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
    <script src="<?php echo base_url('assests/js/sb-admin.min.js'); ?>"></script>

    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

    <!-- Custom JS -->
    <script>
        let dataTable;

        $(document).ready(function() {
            const urlParts = window.location.pathname.split('/');
            const districtName = decodeURIComponent(urlParts[5]);
            const stateName = decodeURIComponent(urlParts[6]);
            const tableName = decodeURIComponent(urlParts[7]);

            console.log("District Name:", districtName);
            console.log("State Name:", stateName);
            console.log("Table Name:", tableName);

            $('#loader').fadeIn();

            dataTable = $('#blockDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "<?php echo site_url('user/Fetchallindata/block_page_ajax'); ?>",
                    type: "GET",
                    data: function(d) {
                        d.state_name = stateName;
                        d.district_name = districtName;
                        d.table_name = tableName;
                    },
                    dataType: 'json',
                    error: function(xhr, error, thrown) {
                        console.error("AJAX Error:", xhr.responseText);
                        alert("Error fetching data. Check console.");
                    },
                    complete: function() {
                        $('#loader').fadeOut();
                    }
                },
                columns: [{
                        data: "id"
                    },
                    {
                        data: "blockName"
                    },
                    {
                        data: "block_count"
                    }
                ]
            });
        });
    </script>



</body>

</html>