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
                    <li class="breadcrumb-item active">Pilot Down Data</li>
                </ol>

                <h1 class="text-center mb-4">Display Pilot Project Status Down Data</h1>

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
                                <th>#</th>
                                <th>GP Name</th>
                                <th>Prev. Month</th>
                                <th>Previous Day</th>
                                <th>Last N Days</th>
                                <th>Reason For Down</th>
                            </tr>
                        </thead>
                        

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

        $(document).ready(function() {
            let tableName = '<?php echo $table; ?>';
            let stateName = '<?php echo $state; ?>';
            let prevMonth = '<?php echo $prev_month_table; ?>';
            let prevDay = '<?php echo $previous_day; ?>';
            let prevNdays = '<?php echo $last_n_days; ?>';

            console.log(tableName, stateName, prevMonth, prevDay, prevNdays);

            $('#loader').fadeIn();

            $('#stateDataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "<?php echo site_url('user/CO_Pilotgp_controller/view_down_data_ajax'); ?>",
                    type: "GET",
                    data: {
                        state_name: stateName,
                        table_name: tableName,
                        prev_month: prevMonth,
                        prev_day: prevDay,
                        prev_ndays: prevNdays
                    },
                    complete: function() {
                        $('#loader').fadeOut();
                    }
                },
                pageLength: 10,
                lengthChange: false,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: false,
                columns: [
                    { data: "#" },
                    { data: "GP_Name" },
                    { data: "PREVIOUSMONTH_DOWN_TIME" },
                    { data: "Previous_Day" },
                    { data: "LAST_N_DAY_availability" },
                    { data: "reasonForDown" }
                ]
            });
        });


       
    </script>


</body>

</html>