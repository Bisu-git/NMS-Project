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

            #stateDataTable thead {
                background-color: #343a40;
                color: white;
            }

            #stateDataTable tbody tr:hover {
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
                    </ol>

                    <h1 class="text-center mb-4">
                        Display BBNL <?php echo ucwords(strtolower($title)); ?> Monitoring
                    </h1>

                    <!-- Form Section -->
                    <div class="card p-4 mb-4">
                        <form id="fetchAllForm">
                            <div class="form-group">
                                <label for="tableSelect"> </label>
                                <select id="tableSelect" class="form-control" name="selected_table" required>
                                    <option value="">-- Date Wise Table --</option>
                                    <?php foreach ($table_list as $table_name): ?>
                                        <option value="<?= $table_name ?>"><?= $table_name ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group statedetails d-none">
                                <label for="tableSelect">Select State</label>
                                <select id="stateSelect" class="form-control" name="stateSelect">
                                    <option value="">-- Select State --</option>
                                    <?php foreach ($state_list as $state): ?>
                                        <option value="<?= $state['STATE_NAME'] ?>"><?= $state['STATE_NAME'] ?></option>
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
                        <table id="stateDataTable" class="table table-bordered table-striped" width="100%">
                            <thead>
                                <tr>
                                    <th>SL.NO</th>
                                    <th>STATE Name</th>
                                    <th>GP Count</th>
                                    <th>GP UP Count</th>
                                    <th>GP DOWN</th>
                                    <th>Other Count</th>
                                    <th>Un Matched LGD:</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Initial blank body -->
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td><strong>Total GP:</strong></td>
                                    <td id="totalGpCount">0</td>
                                    <td><strong>Matched GP:</strong></td>
                                    <td id="matchedLgdcodeCount"></td>
                                    <td><strong>Un Matched GP:</strong></td>
                                    <td id="unmatchedLgdcodeCount">0</td>
                                </tr>
                            </tfoot>



                        </table>
                    </div>


                </div>
                <input name="stateName" style="display: none;">
                <input name="tableName" style="display: none;">
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

            $('#fetchAllForm').on('submit', function(e) {
                e.preventDefault();

                const selectedTable = $('#tableSelect').val();
                const selectedState = $('#stateSelect').val();
                console.log(selectedTable);

                if (selectedTable != "") {
                    $('#totalGpCount').removeClass('d-none');
                }

                if (!selectedTable) {
                    alert('Please select a table');
                    return;
                }

                $('#loader').fadeIn();

                // Destroy existing DataTable if exists
                if ($.fn.dataTable.isDataTable('#stateDataTable')) {
                    dataTable.destroy();
                    $('#stateDataTable tbody').empty();
                }

                // Initialize with server-side processing
                dataTable = $('#stateDataTable').DataTable({
                    processing: true,
                    // serverSide: true,
                    searching: true,
                    paging: true,
                    ordering: true,
                    pageLength: 10,
                    ajax: {
                        url: "<?php echo site_url('user/CO_Pilotgp_controller/Copilot_GP_data'); ?>",
                        type: "GET",
                        data: function(d) {
                            return {
                                table_name: $('#tableSelect').val()
                            };
                        },
                        dataSrc: function(json) {
                            // Set footer values
                            $('#totalGpCount').html(json.total_gp_count);
                            $('#unmatchedLgdcodeCount').html(json.total_unmatched);
                            $('#matchedLgdcodeCount').html(json.total_matched);
                            return json.data;
                        },
                        complete: function() {
                            $('#loader').fadeOut();
                        }
                    },


                    columns: [{
                            data: "sl_no"
                        },
                        {
                            data: "STATE_NAME"
                        },
                        {
                            data: "Count"
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                const state = encodeURIComponent(row.STATE_NAME);
                                const table = $('#tableSelect').val();
                                return `<a href="<?php echo site_url('user/CO_Pilotgp_controller/view_up_data'); ?>?state=${state}&table=${table}">${row.up_count}</a>`;
                            }
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                const state = encodeURIComponent(row.STATE_NAME);
                                const table = $('#tableSelect').val();
                                return `<a href="<?php echo site_url('user/CO_Pilotgp_controller/view_down_data'); ?>?state=${state}&table=${table}">${row.down_count}</a>`;
                            }
                        },
                        {
                            data: "other_count"
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                const state = encodeURIComponent(row.STATE_NAME);
                                const table = $('#tableSelect').val();
                                return `<a href="<?php echo site_url('user/CO_Pilotgp_controller/view_unmatched_data'); ?>?state=${state}&table=${table}">${row.unmatched_lgdcode_count}</a>`;
                            }
                        }
                    ],


                });
            });
        </script>



    </body>

    </html>