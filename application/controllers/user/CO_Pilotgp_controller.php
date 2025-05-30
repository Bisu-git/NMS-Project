<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . 'core/User_Controller.php');

class CO_Pilotgp_controller extends User_Controller
{
    function __construct()
    {
        parent::__construct();
        if (! $this->session->userdata('uid'))
            redirect('user/login');
        $this->load->model('State_Details_Model');
    }

    public function index()
    {
        $data['userid'] = $this->session->userdata('uid');
        $data['states_count'] = $this->State_Details_Model->get_total_count();
        $data['table_list'] = $this->State_Details_Model->get_datetime_tables();
        $data['state_list'] = $this->State_Details_Model->get_copilot_states();
        $data['title'] = 'PILOT GP';
        // echo '<pre>';print_r($data);die();
        $this->load->view('user/copilot_blocksgp.php', $data);
    }

    public function Copilot_GP_data()
    {
        $input_table = $this->input->get('table_name');

        if (!$input_table) {
            echo json_encode(['data' => []]);
            return;
        }

        // Convert '13_05_2025_11_28_34' to '13_th_may25_pilot'
        $parts = explode('_', $input_table);
        $day = $parts[0];
        $month = (int)$parts[1];
        $year = substr($parts[2], -2);

        $month_map = [
            1 => 'jan', 2 => 'feb', 3 => 'mar', 4 => 'apr',
            5 => 'may', 6 => 'jun', 7 => 'jul', 8 => 'aug',
            9 => 'sep', 10 => 'oct', 11 => 'nov', 12 => 'dec'
        ];
        $month_name = $month_map[$month] ?? 'unknown';
        $final_table = "{$day}_th_{$month_name}{$year}_pilot";

        $data = $this->State_Details_Model->get_table_wise_data($final_table);

        $output = [];
        $i = 1;
        $total_gp = 0;
        $total_unmatched = 0;
        $total_matched = 0;

        foreach ($data as $row) {
            $output[] = [
                'sl_no' => $i++,
                'STATE_NAME' => $row['STATE_NAME'],
                'Count' => $row['total_count'],
                'up_count' => $row['up_count'],
                'down_count' => $row['down_count'],
                'other_count' => $row['other_count'],
                'matched_lgdcode_count' => $row['matched_lgdcode_count'],
                'unmatched_lgdcode_count' => $row['unmatched_lgdcode_count']
            ];
            $total_gp += (int)$row['total_count'];
            $total_unmatched += (int)$row['unmatched_lgdcode_count'];
            $total_matched += (int)$row['matched_lgdcode_count'];
        }

        echo json_encode([
            "data" => $output,
            "total_gp_count" => $total_gp,
            "total_unmatched" => $total_unmatched,
            "total_matched" => $total_matched
        ]);
    }



    public function Copilot_GP_datas()
    {
        $table_name = $this->input->get('table_name');

        if (!$table_name) {
            echo json_encode(['data' => []]);
            return;
        }

        $data = $this->State_Details_Model->get_state_up_datas($table_name);

        $output = [];
        $i = 1;
        foreach ($data as $row) {
            $output[] = [
                'sl_no' => $i++,
                'STATE_NAME' => $row['STATE_NAME'],
                'Count' => $row['total_count'],
                'up_count' => $row['up_count'],
                'down_count' => $row['down_count']
            ];
        }

        echo json_encode(["data" => $output]);
    }


    public function view_up_data()
    {
        $state = $this->input->get('state');
        $table = $this->input->get('table');

        // Extract date parts from the table name
        $parts = explode('_', $table);
        $day = isset($parts[0]) ? (int)$parts[0] : 1;
        $month = isset($parts[1]) ? (int)$parts[1] : 1;
        $year_full = isset($parts[2]) ? (int)$parts[2] : (int)date('Y'); // fallback to current year

        // Build suffix for day
        $suffix = 'th';
        if (!in_array(($day % 100), [11, 12, 13])) {
            switch ($day % 10) {
                case 1: $suffix = 'st'; break;
                case 2: $suffix = 'nd'; break;
                case 3: $suffix = 'rd'; break;
            }
        }

        $monthName = strtolower(date("F", mktime(0, 0, 0, $month, 10))); // "may", "june"
        $year_short = substr($year_full, -2); // e.g. 25
        $formatted_date = $day . $suffix . ' ' . ucfirst($monthName) . ' ' . $year_short;

        // Determine last day of the month
        $last_day_of_month = date("t", mktime(0, 0, 0, $month, 1, $year_full)); // e.g. 30

        $prev_day = $day - 1;
        $prev_day_table = ($prev_day > 0)
            ? str_pad($prev_day, 2, '0', STR_PAD_LEFT) . '_' . str_pad($month, 2, '0', STR_PAD_LEFT)
            : '';

        // Last-N-days table always till last day of month
        $last_N_days_table = "1_to_" . $last_day_of_month . "_" . $monthName . $year_short;

        // Previous month
        $prev_month_ts = mktime(0, 0, 0, $month - 1, 10, $year_full);
        $prev_month_name = strtolower(date("F", $prev_month_ts));
        $prev_month_table = $prev_month_name . "_month_" . $year_short;

        $data = [
            'state' => $state,
            'table' => $table,
            'prev' => $prev_day,
            'month' => str_pad($month, 2, '0', STR_PAD_LEFT),
            'hiis' => ucwords(strtolower($state)),
            'formatted_date' => $formatted_date,
            'last_N_days_table' => $last_N_days_table,
            'prev_day_table' => $prev_day_table,
            'prev_month_table' => $prev_month_table
        ];

            // echo '<pre>';
            // print_r($data);
            // die('Check Output');
            $this->load->view('user/pilot_view_up_details', $data);
    }




    public function get_up_details_ajax()
{
    $state = $this->input->get('state_name');
    $table = $this->input->get('table_name');
    $prevMonth = $this->input->get('prev_month');
    $prevDay = $this->input->get('prev_day');
    $prevNdays = $this->input->get('prev_ndays');

    $start = $this->input->get('start');
    $length = $this->input->get('length');
    $search = $this->input->get('search')['value'];

    $results = $this->State_Details_Model->get_up_details_query($prevMonth, $prevDay, $prevNdays, $state, $table, $search, $start, $length);

    $data = [];
    $i = $start + 1;

    foreach ($results['data'] as $row) {
        $data[] = [
            '#' => $i++,
            'GP_Name' => $row['GP_Name'],
            'ONT_AVAILABILITY_per_' => $row['ONT_AVAILABILITY_per_'] . '%',
            'ONT_AVAILABILITY' => $row['ONT_AVAILABILITY'] == 'NA' ? $row['ONT_AVAILABILITY'] : $row['ONT_AVAILABILITY'] . '%',
            'avg_ont_availability' => $row['avg_ont_availability'] . '%',
            'ont_Ndays_hours' => $row['ont_Ndays_hours'] . 'Hrs',
            'ont_monthly__hours' => $row['ont_monthly__hours'] . 'Hrs',
            'ont_Per_day_hour' => $row['ont_Per_day_hour'] == 'NA' ? $row['ont_Per_day_hour'] : $row['ont_Per_day_hour'] . 'Hrs'
        ];
    }

    echo json_encode([
        'draw' => intval($this->input->get('draw')),
        'recordsTotal' => $results['total'],
        'recordsFiltered' => $results['filtered'],
        'data' => $data
    ]);
}


    public function view_unmatched_data()
    {
        $state = $this->input->get('state');
        $table = $this->input->get('table');

        $data['state'] = $state;
        $data['table'] = $table;
        $data['details'] = $this->State_Details_Model->get_unmatched_details($state, $table);

        $this->load->view('user/pilot_view_unmatched_details', $data);
    }

    public function view_down_data()
    {
        $state = $this->input->get('state');
        $table = $this->input->get('table');

        // Extract parts: e.g. '28_05_2025_14_21_31'
        $parts = explode('_', $table);
        $day = isset($parts[0]) ? (int)$parts[0] : 1;
        $month = isset($parts[1]) ? (int)$parts[1] : 1;
        $year_full = isset($parts[2]) ? (int)$parts[2] : (int)date('Y'); // e.g. 2025
        $year_short = substr($year_full, -2); // e.g. 25

        // Get the last day of the month (e.g., 31 for May)
        $last_day = cal_days_in_month(CAL_GREGORIAN, $month, $year_full);

        // Month name (e.g., 'may')
        $month_name = strtolower(date("F", mktime(0, 0, 0, $month, 10)));

        // Previous day (e.g., '27_05')
        $prev_day = $day - 1;
        if ($prev_day <= 0) {
            // Handle case where previous day is in the previous month
            $prev_month_ts = mktime(0, 0, 0, $month - 1, 10, $year_full);
            $prev_month = (int)date('m', $prev_month_ts);
            $prev_day = cal_days_in_month(CAL_GREGORIAN, $prev_month, $year_full);
            $prev_day_formatted = str_pad($prev_day, 2, '0', STR_PAD_LEFT);
            $prev_day_str = $prev_day_formatted . '_' . str_pad($prev_month, 2, '0', STR_PAD_LEFT);
        } else {
            $prev_day_str = str_pad($prev_day, 2, '0', STR_PAD_LEFT) . '_' . str_pad($month, 2, '0', STR_PAD_LEFT);
        }
        // Last N days table: e.g., '1_31_may25_down'
        $last_N_days_table = '1_' . $last_day . '_' . $month_name . $year_short . '_down';
        // Previous month name (e.g., 'april')
        $prev_month_ts = mktime(0, 0, 0, $month - 1, 10, $year_full);
        $prev_month_name = strtolower(date("F", $prev_month_ts));
        $prev_month_table = $prev_month_name . '_month_' . $year_short;
        // Prepare data to send to the view
        $data['state'] = $state;
        $data['table'] = $table;
        $data['last_n_days'] = $last_N_days_table;
        $data['prev_month_table'] = $prev_month_table;
        $data['previous_day'] = $prev_day_str;
        // echo '<pre>'; print_r($data); die('debug');
        
        $this->load->view('user/pilot_view_down_details', $data);
    }

    public function view_down_data_ajax()
    {
        $state = $this->input->get('state_name');
        $table = $this->input->get('table_name');
        $prevMonth = $this->input->get('prev_month');
        $prevDay = $this->input->get('prev_day');
        $prevNdays = $this->input->get('prev_ndays');

        // Pagination & Search
        $start = $this->input->get('start');
        $length = $this->input->get('length');
        $draw = $this->input->get('draw');

        // Fetch from model with pagination
        $results = $this->State_Details_Model->get_down_details($state, $table, $prevNdays, $prevMonth, $prevDay, $start, $length);

        $data = [];
        $i = $start + 1;
        foreach ($results['details'] as $row) {
            $data[] = [
                '#' => $i++,
                'GP_Name' => $row['GP_Name'],
                'reasonForDown' => $row['reasonForDown'],
                'PREVIOUSMONTH_DOWN_TIME' => $row['PREVIOUSMONTH_DOWN_TIME'],
                'Previous_Day' => $row['Previous_Day'],
                'LAST_N_DAY_availability' => $row['LAST_N_DAY_availability'] . ' Hrs'
            ];
        }

        echo json_encode([
            'draw' => intval($draw),
            'recordsTotal' => $results['total'],
            'recordsFiltered' => $results['filtered'],
            'data' => $data
        ]);
    }




}
