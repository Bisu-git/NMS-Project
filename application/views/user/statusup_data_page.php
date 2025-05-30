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
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap4.min.css">


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

        #statusupDataTable thead {
            background-color: #343a40;
            color: white;
        }

        #statusupDataTable tbody tr:hover {
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
                    <li class="breadcrumb-item active">All Data</li>
                </ol>

                <h1 class="text-center mb-4">
                    Display BBNL <?php echo ucwords(strtolower($state)); ?>  <?php echo strtoupper($status); ?> Status
                </h1>


                <!-- Loader -->
                <div id="loader" class="mb-3">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2">Loading data, please wait...</p>
                </div>

                <!-- Table Section -->
                <div class="table-responsive">
                    <table id="statusupDataTable" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>State Name</th>
                                <th>District Name</th>
                                <th>Block Name</th>
                                <th>GP Name</th>
                                <th>Location</th>
                                <th>Status</th>
                                <th>Reason For Down</th>
                                <th>LGD CODE</th>
                                <th>NE Type</th>
                                <th>Change Time</th>
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

    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script> -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>


    <!-- Custom JS -->
    <script>
        let dataTable;

        $(document).ready(function() {
            // const urlParts = window.location.pathname.split('/');
            // const tableName = decodeURIComponent(urlParts[6]); 
            let tableName = '<?php echo $table ?>';
            let stateName = '<?php echo $state ?>';
            let status = '<?php echo $status ?>';

            console.log("Table Name:", tableName);
            console.log("Table Name:", stateName);
            console.log("Table Name:", status);

            $('#loader').fadeIn();

            dataTable = $('#statusupDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "<?php echo site_url('user/Fetchallindata/get_status_up_data_ajax'); ?>",
                    type: "GET",
                    data: {
                        state_name: stateName,
                        table_name: tableName,
                        status: status
                    },
                    complete: function() {
                        $('#loader').fadeOut();
                    }
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: "stateName"
                    },
                    {
                        data: "districtName"
                    },
                    {
                        data: "blockName"
                    },
                    {
                        data: "gpName"
                    },
                    {
                        data: "locationname"
                    },
                    {
                        data: "status"
                    },
                    {
                        data: "reasonForDown"
                    },
                    {
                        data: "lgdcode"
                    },
                    {
                        data: "neType"
                    },
                    {
                        data: "stateChangeTime"
                    }
                ],

                dom: 'Bfrtip', // This enables the buttons section
                buttons: [{
                        extend: 'csvHtml5',
                        title: 'State_Data_Export',
                        className: 'btn btn-info mb-3',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'State_Data_Export',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        className: 'btn btn-danger mb-3',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ]

            });
        });
    </script>


</body>

</html>