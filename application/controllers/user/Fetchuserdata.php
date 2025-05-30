<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Fetchuserdata extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (! $this->session->userdata('uid'))
            redirect('user/login');
        $this->load->model('Fetch_Apis_Model');
        $this->load->model('User_Profile_Model');
        $this->load->model('State_Details_Model');
    }

    public function index()
    {
        $data['userid'] = $this->session->userdata('uid');
        $data['profile'] = $this->User_Profile_Model->getprofile($data['userid']);
        $data['table_list'] = $this->State_Details_Model->get_datetime_tables();
        $data['state_list'] = $this->State_Details_Model->get_all_states();
        // echo '<pre>'; print_r($data); die('message');
        $this->load->view('user/user_apidata', $data);
    }
    

    public function fetch_dynamic_table_data()
    {
        $limit = (int) $this->input->get('length');
        $start = (int) $this->input->get('start');
        $draw = (int) $this->input->get('draw');
        $searchArr = $this->input->get('search');
        $search = isset($searchArr['value']) ? trim($searchArr['value']) : '';
        $table_name = $this->input->get('table_name');
        $scope_id = $this->input->get('scopeid');
        $stateCode = $this->input->get('state_name');
        $districtCode = $this->input->get('district_name');
        // $statName = $this->input->get('state_names')

        if (!$table_name) {
            echo json_encode(['draw' => $draw, 'recordsTotal' => 0, 'recordsFiltered' => 0, 'data' => []]);
            return;
        }


        $dataList = $this->State_Details_Model->get_dynamic_table_data($table_name, $limit, $start, $search, $scope_id,   $stateCode, $districtCode);
        $totalRecords = $this->State_Details_Model->get_dynamic_table_count($table_name, $search, $scope_id,  $stateCode, $districtCode);

        $data = [];
        $serial = $start + 1;
        foreach ($dataList as $row) {
            $data[] = [
                'id' => $serial++,
                'stateName' => $row->stateName ?? '',
                'districtName' => $row->districtName ?? '',
                'blockName' => $row->blockName ?? '',
                'gpName' => $row->gpName ?? '',
                'locationname' => $row->locationname ?? '',
                'status' => $row->status ?? '',
                'lgdcode' => $row->lgdcode ?? '',
                'reasonForDown' => $row->reasonForDown ?? '',
                'neType' => $row->neType ?? '',
                'stateChangeTime' => $row->stateChangeTime ?? ''
            ];
        }

        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $data,
        ]);
    }


    public function get_district_by_state()
    {
        $id = $this->input->post('dep_id');
        $data = $this->State_Details_Model->getdistrict_bystate($id);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
