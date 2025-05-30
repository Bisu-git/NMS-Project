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

    <?php include APPPATH . 'views/user/includes/header.php'; ?>

    <div id="wrapper">
        <?php include APPPATH . 'views/user/includes/sidebar.php'; ?>

        <div id="content-wrapper">
            <div class="container-fluid">
                <!-- Breadcrumbs-->
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?php echo site_url('user/Dashboard'); ?>">User</a>
                    </li>
                    <li class="breadcrumb-item active">NMS List</li>
                </ol>

                <div class="overlay-container">
                    <h1 class="text-center">Display BharatNet 5C Report</h1>
                    <div class="card p-4 mb-4">
                        <form id="fetchNMSForm">

                            <div class="form-group statedetails">
                                <label for="tableSelect">Select State</label>
                                <select id="stateSelect" class="form-control" name="stateSelect">
                                    <option value="">-- Select State --</option>
                                    <?php foreach ($state_details as $state): ?>
                                        <option value="<?= $state['id'] ?>"><?= $state['State'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary"><i class="fas fa-download"></i> Display Data</button>
                        </form>
                    </div>
                    <!-- Success Message Container -->
                    <div id="success-message" class="text-center">
                        <?php if (isset($message) && !empty($message)): ?>
                            <?php echo $message; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Data Table -->
                    <div class="table-responsive mt-4">
                        <table id="nmsdetailsTable" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>STATE</th>
                                    <th>GPs VISIBLE NMS</th>
                                    <th>GPs up + Unk Prev up</th>
                                    <th>UP any time during the Prev Day</th>
                                    <th>UP any time during the last 3 days</th>
                                    <th>GP Down No Fiber fault</th>
                                    <th>GP Down No Fiber fault no AMC date</th>
                                    <th>CSC VLE Issues</th>
                                    <th>AMC start date</th>
                                    <th>100m fibre faults</th>
                                    <th>100-500m fibre faults</th>
                                    <th>500m fibre faults</th>
                                    <th>Leased Lossy Fibre</th>
                                    <th>ONT Faulty</th>
                                    <th>ONT Missing</th>
                                    <th>CCU Faulty</th>
                                    <th>CCU Missing</th>
                                    <th>Power</th>
                                    <th>Recent</th>
                                    <th>Power Off by custodian</th>
                                    <th>No TT</th>
                                    <th>ONT Faulty (1)</th>
                                    <th>ONT Missing (1)</th>
                                    <th>CCU Faulty (1)</th>
                                    <th>CCU Missing (1)</th>
                                    <th>Power (1)</th>
                                    <th>Recent Faults</th>
                                </tr>
                            </thead>

                            <!-- inside <tbody> -->
                            <tbody>
                                <?php foreach ($show_all_nms_details as $row): ?>
                                    <tr>
                                        <td><?= $row->id ?></td>
                                        <td><?= $row->State ?></td>
                                        <td><?= $row->GPs_visible_in_NMS ?></td>
                                        <td><?= $row->GPs_UP_Unk_Prev_UP ?></td>
                                        <td><?= $row->UP_any_time_during_the_Prev__Day ?></td>
                                        <td><?= $row->UP_any_time_during_the_last_3_days ?></td>
                                        <td><?= $row->GP_Down___No_Fiber_fault ?></td>
                                        <td><?= $row->GP_Down___No_Fiber_fault___no_amc_date ?></td>
                                        <td><?= $row->CSC_VLE_Issues ?></td>
                                        <td><?= $row->AMC_start_date ?></td>
                                        <td><?= $row->_100_m_fibre_faults ?></td>
                                        <td><?= $row->_100_500_m_fibre_faults ?></td>
                                        <td><?= $row->__500_m_fibre_faults ?></td>
                                        <td><?= $row->Leased_Lossy_Fibre ?></td>
                                        <td><?= $row->ONT_Faulty ?></td>
                                        <td><?= $row->ONT_Missing ?></td>
                                        <td><?= $row->CCU_Faulty ?></td>
                                        <td><?= $row->CCU_Missing ?></td>
                                        <td><?= $row->Power ?></td>
                                        <td><?= $row->Recent ?></td>
                                        <td><?= $row->Power_Off_by_custodian ?></td>
                                        <td><?= $row->No_TT ?></td>
                                        <td><?= $row->ONT_Faulty_1 ?></td>
                                        <td><?= $row->ONT_Missing_1 ?></td>
                                        <td><?= $row->CCU_Faulty_1 ?></td>
                                        <td><?= $row->CCU_Missing_1 ?></td>
                                        <td><?= $row->Power_1 ?></td>
                                        <td><?= $row->Recent_Faults ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>


                        </table>
                    </div>
                </div>

            </div>

            <?php include APPPATH . 'views/user/includes/footer.php'; ?>
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
            var table = $('#nmsdetailsTable').DataTable({
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

            $('#statelist_loader').fadeOut(500);

            $('#fetchNMSForm').submit(function(e) {
                e.preventDefault();
                var state_id = $('#stateSelect').val();

                $.ajax({
                    url: "<?php echo site_url('user/Fetchstatelist/fetch_by_state'); ?>",
                    type: "POST",
                    data: {
                        state_id: state_id
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $('#statelist_loader').fadeIn();
                    },
                    success: function(data) {
                        table.clear().draw();
                        if (data.length > 0) {
                            $.each(data, function(i, row) {
                                table.row.add([
                                    row.id,
                                    row.State,
                                    row.GPs_visible_in_NMS,
                                    row.GPs_UP_Unk_Prev_UP,
                                    row.UP_any_time_during_the_Prev__Day,
                                    row.UP_any_time_during_the_last_3_days,
                                    row.GP_Down___No_Fiber_fault,
                                    row.GP_Down___No_Fiber_fault___no_amc_date,
                                    row.CSC_VLE_Issues,
                                    row.AMC_start_date,
                                    row._100_m_fibre_faults,
                                    row._100_500_m_fibre_faults,
                                    row.__500_m_fibre_faults,
                                    row.Leased_Lossy_Fibre,
                                    row.ONT_Faulty,
                                    row.ONT_Missing,
                                    row.CCU_Faulty,
                                    row.CCU_Missing,
                                    row.Power,
                                    row.Recent,
                                    row.Power_Off_by_custodian,
                                    row.No_TT,
                                    row.ONT_Faulty_1,
                                    row.ONT_Missing_1,
                                    row.CCU_Faulty_1,
                                    row.CCU_Missing_1,
                                    row.Power_1,
                                    row.Recent_Faults
                                ]).draw(false);
                            });
                        }
                        $('#statelist_loader').fadeOut();
                    },
                    error: function() {
                        alert('Error fetching data');
                        $('#statelist_loader').fadeOut();
                    }
                });
            });
        });
    </script>
</body>

</html>