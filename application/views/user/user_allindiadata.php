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

        #AllindiaTable thead {
            background-color: #343a40;
            color: white;
        }

        #AllindiaTable tbody tr:hover {
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
                    <li class="breadcrumb-item active">Display Data</li>
                </ol>

                <h1 class="text-center mb-4">Display BBNL API Data</h1>

                <!-- Form Section -->
                <div class="card p-4 mb-4">
                    <form id="fetchAllForm">
                        <div class="form-group">
                            <label for="tableSelect">Select Table</label>
                            <select id="tableSelect" class="form-control" name="selected_table" required>
                                <option value="">-- Select Table --</option>
                                <?php foreach ($table_list as $table_name): ?>
                                    <option value="<?= $table_name ?>"><?= $table_name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary"><i class="fas fa-download"></i> Display Data</button>
                    </form>
                </div>


                <!-- Loader -->
                <div id="loader" class="mb-3">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="mt-2">Loading data, please wait...</p>
                </div>

                <!-- Table Section -->
                <div class="table-responsive">
                    <table id="AllindiaTable" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>State Name</th>
                                <th>GP Count</th>
                                <th>Status UP</th>
                                <th>Status Down</th>
                                <th>Others</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td><strong>Total GP Count:</strong></td>
                                <td id="gpCountFooter"></td> <!-- Updated with JS -->
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>

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
        // if($("#tableSelect").val() != ""){
        //     $('#fetchAllForm').submit();
        // }
        $(document).ready(function() {

            $('#fetchAllForm').on('submit', function(e) {
                e.preventDefault();
                const selectedTable = $('#tableSelect').val();
                // document.cookie = "selectedTable="+selectedTable+";";
                console.log(selectedTable);

                if (!selectedTable) {
                    alert('Please select a table');
                    return;
                }

                $('#loader').fadeIn();

                if (dataTable) {
                    dataTable.destroy();
                    $('#AllindiaTable tbody').empty();
                }

                dataTable = $('#AllindiaTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "<?php echo site_url('user/Fetchallindata/fetch_dynamic_alltable_data'); ?>",
                        type: "GET",
                        data: {
                            table_name: selectedTable,
                        },
                        dataSrc: function(json) {
                            // Update the footer total here
                            const url = "<?php echo site_url('user/Fetchallindata/all_data_page/'); ?>" + selectedTable;
                            $('#AllindiaTable tfoot td:eq(2)').html(`<a href='${url}'>${json.total_gp_count}</a>`);
                            // $('#AllindiaTable tfoot td:eq(2)').html(`<a href='user/Fetchallindata/all_data_page/${selectedTable}'>${json.total_gp_count}</a>`);
                            return json.data;
                        },
                        complete: function() {
                            $('#loader').fadeOut();
                        }
                    },
                    columns: [{
                            data: "id"
                        },
                        {
                            data: "stateName"
                        },
                        {
                            data: "state_count"
                        },
                        {
                            data: "status_up"
                        },
                        {
                            data: "status_down"
                        },
                        {
                            data:"others"
                        }
                    ]
                });

            });

        });
    </script>

</body>

</html>