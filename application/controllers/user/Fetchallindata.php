<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . 'core/User_Controller.php');

class Fetchallindata extends User_Controller
{
    function __construct()
    {
        parent::__construct();
        if (! $this->session->userdata('uid'))
            redirect('user/login');
        $this->load->model('Fetch_Apis_Model');
        $this->load->model('State_Details_Model');
    }

    public function index()
    {
        $data['userid'] = $this->session->userdata('uid');
        $data['table_list'] = $this->State_Details_Model->get_datetime_tables();
        // echo '<pre>'; print_r($data); die('message');
        $this->load->view('user/user_allindiadata', $data);
    }


    public function fetch_dynamic_alltable_data()
    {
        $limit = (int) $this->input->get('length');
        $start = (int) $this->input->get('start');
        $draw = (int) $this->input->get('draw');
        $searchArr = $this->input->get('search');
        $search = isset($searchArr['value']) ? trim($searchArr['value']) : '';
        $table_name = $this->input->get('table_name');

        if (!$table_name) {
            echo json_encode(['draw' => $draw, 'recordsTotal' => 0, 'recordsFiltered' => 0, 'data' => []]);
            return;
        }

        $dataList = $this->Fetch_Apis_Model->get_statewise_data($table_name, $limit, $start, $search);
        // $totalRecords = $this->Fetch_Apis_Model->get_statewise_count($table_name, $search);
        $totalRecords = $this->Fetch_Apis_Model->get_statewise_count('', $table_name, $search);
        $state_gp_sum = $this->Fetch_Apis_Model->get_total_state_gp_count($table_name, $search);

        // echo '<pre>';
        // print_r($dataList);
        // print_r($totalRecords);
        // die();

        $data = [];
        $serial = $start + 1;
        foreach ($dataList as $row) {
            $state_encoded = rawurlencode($row->stateName);
            $data[] = [
                'id' => $serial++,
                'stateName' => '<a href="' . site_url("user/Fetchallindata/district_page/{$state_encoded}/{$table_name}") . '">' . $row->stateName . '</a>',
                'state_count' => '<a href="' . site_url("user/Fetchallindata/state_wise_districtraj/{$state_encoded}/{$table_name}") . '">' . $row->state_count . '</a>',
                // 'state_count' => '<a href="' . site_url("user/Fetchallindata/state_data_page/{$state_encoded}/{$table_name}") . '">' . $row->state_count . '</a>',
                'status_up' => '<a href="' . site_url("user/Fetchallindata/statusup_page/{$state_encoded}/{$table_name}") . '">' . $row->status_up . '</a>',
                'status_down' => '<a href="' . site_url("user/Fetchallindata/status_down_page/{$state_encoded}/{$table_name}") . '">' . $row->status_down . '</a>',
                'others' => '<a href="' . site_url("user/Fetchallindata/status_others_page/{$state_encoded}/{$table_name}") . '">' . $row->others . '</a>',
                // 'others' => $row->others,
            ];
        }

        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data,
            'total_gp_count' => $state_gp_sum
        ]);
    }
    public function statusup_page($stateName, $table_name)
    {
        $data['state'] = urldecode($stateName);
        $data['table'] = urldecode($table_name);
        $data['status'] = "UP";

        $this->load->view('user/statusup_data_page', $data);
    }

    public function get_status_up_data_ajax()
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $stateName = urldecode($this->input->get("state_name"));
        $tableName = urldecode($this->input->get("table_name"));
        $status = urldecode($this->input->get("status"));

        // Since we are fetching state-wise only, pass districtName as null
        $distName = null;
        $blockName = null;

        // Fetch data from model
        $data = $this->Fetch_Apis_Model->get_state_data_paginated($status, $blockName, $distName, $stateName, $tableName, $start, $length);
        $totalRecords = $this->Fetch_Apis_Model->get_state_data_count($status, $blockName, $distName, $stateName, $tableName);

        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords,
            "data" => $data
        ]);
    }

    public function status_down_page($stateName, $table_name)
    {
        $data['state'] = urldecode($stateName);
        $data['table'] = urldecode($table_name);
        $data['status'] = "DOWN";

        $this->load->view('user/status_down_page', $data);
    }

    public function status_others_page($stateName, $table_name)
    {
        $data['state'] = urldecode($stateName);
        $data['table'] = urldecode($table_name);
        $data['status'] = "NOC";
        // echo '<pre>';print_r($data);die();

        $this->load->view('user/status_others_page', $data);
    }

    public function state_data_page($stateName, $table_name)
    {
        $decodedState = urldecode($stateName);
        $decodedTable = urldecode($table_name);
        $nugut = ucwords(strtolower($decodedState));

        $data['records'] = $this->Fetch_Apis_Model->get_state_data($decodedState, $decodedTable);
        $data['title'] = $decodedState;

        $this->load->view('user/state_data_page', $data);
    }

    public function get_state_data_ajax()
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $stateName = urldecode($this->input->get("state_name"));
        $tableName = urldecode($this->input->get("table_name"));

        // Since we are fetching state-wise only, pass districtName as null
        $status = null;
        $distName = null;
        $blockName = null;

        // Fetch data from model
        $data = $this->Fetch_Apis_Model->get_state_data_paginated($status, $blockName, $distName, $stateName, $tableName, $start, $length);
        $totalRecords = $this->Fetch_Apis_Model->get_state_data_count($status, $blockName, $distName, $stateName, $tableName);

        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords,
            "data" => $data
        ]);
    }

    public function state_wise_districtraj($stateName, $table_name)
    {
        $decoded = urldecode($stateName);
        $search = null;

        $data['states_count'] = $this->Fetch_Apis_Model->get_statewise_count($decoded, $table_name, $search);
        $data['title'] = $decoded;
        $data['tablename'] = $table_name;
        // echo'<pre>';print_r($data);die('hii');
        $this->load->view('user/state_wise_district', $data);
    }

    public function all_data_page($table_name)
    {
        $data['tablename'] = $table_name;
        $this->load->view('user/allindia_wise_state', $data);
    }

    public function get_allindia_data_ajax()
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $tableName = urldecode($this->input->get("table_name"));

        // Since we are fetching state-wise only, pass districtName as null
        $distName = null;
        $status = null;
        $blockName = null;
        $stateName = null;

        // Fetch data from model
        $data = $this->Fetch_Apis_Model->get_state_data_paginated($status, $blockName, $distName, $stateName, $tableName, $start, $length);
        $totalRecords = $this->Fetch_Apis_Model->get_state_data_count($status, $blockName, $distName, $stateName, $tableName);

        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords,
            "data" => $data
        ]);
    }

    public function state_wise_district()
    {
        $stateName = urldecode($_GET['state_name']);
        $tableName = urldecode($_GET['table_name']);
        $search = null;

        $list = $this->Fetch_Apis_Model->get_districtwise_data($stateName, $tableName);
        $stateCount = $this->Fetch_Apis_Model->get_statewise_count($stateName, $tableName, $search);

        $data = [];
        $no = $_GET['start'];

        // Encode values once
        $encodedState = rawurlencode($stateName);
        $encodedTable = rawurlencode($tableName);

        // Static hyperlink for state count
        $stateCountLink = '<a href="' . site_url("user/Fetchallindata/state_data_page/{$encodedState}/{$encodedTable}") . '">' . $stateCount . '</a>';

        foreach ($list as $r) {
            $no++;
            $row = [];

            $row['id'] = $no;

            $encodedDistrict = rawurlencode($r->districtName);

            $row['districtName'] = '<a href="' . site_url("user/Fetchallindata/block_page/{$encodedDistrict}/{$encodedState}/{$encodedTable}") . '">' . $r->districtName . '</a>';
            $row['district_count'] = '<a href="' . site_url("user/Fetchallindata/district_details/{$encodedDistrict}/{$encodedState}/{$encodedTable}") . '">' . $r->district_count . '</a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $this->Fetch_Apis_Model->count_all_districts($stateName, $tableName),
            "recordsFiltered" => $this->Fetch_Apis_Model->count_filtered_districts($stateName, $tableName),
            "data" => $data,
        );

        echo json_encode($output);
    }




    // Show district summary
    public function district_page($stateName, $table_name)
    {
        $decoded = urldecode($stateName);
        $data['districts'] = $this->Fetch_Apis_Model->get_districtwise_data($decoded, $table_name);
        $data['title'] = "District Data for State: $decoded";
        $this->load->view('user/district_data_page', $data);
    }

    public function district_page_ajax()
    {
        $stateName = $this->input->get('state_name');
        $tableName = $this->input->get('table_name');

        $list = $this->Fetch_Apis_Model->get_districtwise_data($stateName, $tableName);
        $data = [];
        $no = $_GET['start'];
        foreach ($list as $r) {
            $no++;
            $row = [];
            $row['id'] = $no;

            $encodedDistrict = rawurlencode($r->districtName);
            $encodedState = rawurlencode($stateName);
            $encodedTable = rawurlencode($tableName);

            $row['districtName'] = '<a href="' . site_url("user/Fetchallindata/block_page/{$encodedDistrict}/{$encodedState}/{$encodedTable}") . '">' . $r->districtName . '</a>';

            $row['district_count'] = '<a href="' . site_url("user/Fetchallindata/district_details/{$encodedDistrict}/{$encodedState}/{$encodedTable}") . '">' . $r->district_count . '</a>';

            $data[] = $row;
        }


        $output = array(
            "draw" => intval($_GET['draw']),
            "recordsTotal" => $this->Fetch_Apis_Model->count_all_districts($stateName, $tableName),
            "recordsFiltered" => $this->Fetch_Apis_Model->count_filtered_districts($stateName, $tableName),
            "data" => $data,
        );

        echo json_encode($output);
    }

    public function district_details($districtName, $stateName, $tableName)
    {
        // Show full district data here
        $data['district_name'] = urldecode($districtName);
        $data['state_name'] = urldecode($stateName);
        $data['table_name'] = urldecode($tableName);
        // echo '<pre>';print_r($data);die();
        $this->load->view('user/district_gpcount_page', $data);
    }

    public function get_district_data_ajax()
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $distName = urldecode($this->input->get("district_name"));
        $stateName = urldecode($this->input->get("state_name"));
        $tableName = urldecode($this->input->get("table_name"));
        $blockName = null;
        $status = null;
        // echo '<pre>';print_r($distName);die('hiis');

        // Call your model to fetch filtered data
        $data = $this->Fetch_Apis_Model->get_state_data_paginated($status, $blockName, $distName, $stateName, $tableName, $start, $length);

        // Total record count
        $totalRecords = $this->Fetch_Apis_Model->get_state_data_count($status, $blockName, $distName, $stateName, $tableName);

        // Output correct format
        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords,
            "data" => $data
        ]);
    }

    public function block_page($districtName, $stateName, $tableName)
    {
        $data['district_name'] = urldecode($districtName);
        $data['state_name'] = urldecode($stateName);
        $data['table_name'] = urldecode($tableName);
        $this->load->view('user/block_data_page', $data);
    }

    public function block_page_ajax()
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));

        $state = $this->input->get("state_name");
        $district = $this->input->get("district_name");
        $table = $this->input->get("table_name");

        $this->load->model('Fetch_Apis_Model');
        $data = $this->Fetch_Apis_Model->get_block_data($state, $district, $table, $start, $length);

        $result = array(
            "draw" => $draw,
            "recordsTotal" => $data['total'],
            "recordsFiltered" => $data['total'],
            "data" => $data['records']
        );

        echo json_encode($result);
    }

    public function block_count_data($blockName, $districtName, $stateName, $tableName)
    {
        $data['block_name'] = str_replace(['_slash_', '_'], ['/', ' '], urldecode($blockName));
        $data['district_name'] = str_replace(['_slash_', '_'], ['/', ' '], urldecode($districtName));
        $data['state_name'] = str_replace(['_slash_', '_'], ['/', ' '], urldecode($stateName));
        $data['table_name'] = urldecode($tableName);

        $this->load->view('user/block_gpcount_page', $data);
    }


    public function get_block_data_ajax()
    {
        $draw = intval($this->input->get("draw"));
        $start = intval($this->input->get("start"));
        $length = intval($this->input->get("length"));
        $distName = urldecode($this->input->get("district_name"));
        $stateName = urldecode($this->input->get("state_name"));
        $tableName = urldecode($this->input->get("table_name"));
        $blockName = urldecode($this->input->get("block_name"));
        $status = null;

        // Call your model to fetch filtered data
        $data = $this->Fetch_Apis_Model->get_state_data_paginated($status, $blockName, $distName, $stateName, $tableName, $start, $length);

        // Total record count
        $totalRecords = $this->Fetch_Apis_Model->get_state_data_count($status, $blockName, $distName, $stateName, $tableName);

        // Output correct format
        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords,
            "data" => $data
        ]);
    }


    public function export_all_data_excel()
    {
        $district = urldecode($this->input->get('district_name'));
        $state = urldecode($this->input->get('state_name'));
        $table = urldecode($this->input->get('table_name'));

        $result = $this->Fetch_Apis_Model->get_all_export_data($district, $state, $table);

        // Load PHPExcel library or simple CSV generator
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=state_data_export.xls");

        $heading = false;
        if (!empty($result)) {
            foreach ($result as $row) {
                if (!$heading) {
                    echo implode("\t", array_keys((array)$row)) . "\n";
                    $heading = true;
                }
                echo implode("\t", array_values((array)$row)) . "\n";
            }
        }
    }

    // public function export_all_data_pdf()
    // {
    //     $district = urldecode($this->input->get('district_name'));
    //     $state = urldecode($this->input->get('state_name'));
    //     $table = urldecode($this->input->get('table_name'));

    //     $result = $this->Fetch_Apis_Model->get_all_export_data($district, $state, $table);

    //     // Load MPDF
    //     require_once APPPATH . 'third_party/vendor/autoload.php';
    //     $mpdf = new \Mpdf\Mpdf();

    //     $html = '<h3>Data Export - PDF</h3><table border="1" cellpadding="5" cellspacing="0">';

    //     if (!empty($result)) {
    //         $html .= '<tr>';
    //         foreach (array_keys((array)$result[0]) as $key) {
    //             $html .= "<th>$key</th>";
    //         }
    //         $html .= '</tr>';

    //         foreach ($result as $row) {
    //             $html .= '<tr>';
    //             foreach ((array)$row as $value) {
    //                 $html .= "<td>$value</td>";
    //             }
    //             $html .= '</tr>';
    //         }
    //     } else {
    //         $html .= '<tr><td colspan="100%">No data found</td></tr>';
    //     }

    //     $html .= '</table>';

    //     $mpdf->WriteHTML($html);
    //     $mpdf->Output('data_export.pdf', 'D'); // 'D' forces download
    // }
}
