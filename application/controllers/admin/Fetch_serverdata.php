<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Admin_Controller.php');

class Fetch_serverdata extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();
        if (! $this->session->userdata('adid'))
            redirect('admin/login');
        $this->load->model('Admin_Dashboard_Model');
        $this->load->model('State_Details_Model');
    }

    public function index()
    {
        $data['adminid'] = $this->session->userdata('adid');
        $data['state_details'] = $this->State_Details_Model->statelists();
        $this->load->view('admin/fertch_server_data', $data);
    }


    public function fetch_data()
    {
        if ($this->Admin_Dashboard_Model->is_data_already_fetched_for_today()) {
            $data['message'] = "⚠️ Data already fetched for today. Try again tomorrow.";
            $data['userid'] = $this->session->userdata('adid');
            $this->load->view('admin/fertch_server_data', $data);
            return;
        }
        // No data fetched yet, proceed with script execution
        ini_set('max_execution_time', 0);

        $pythonPath = '"C:\\Users\\PC\\AppData\\Local\\Programs\\Python\\Python313\\python.exe"';
        $scriptPath = '"C:\\NODES\\Python Vlog\\PycharmProjects\\API FLASK\\More_statelist.py"';
        $command = "$pythonPath $scriptPath";

        $output = [];
        $returnVar = null;
        exec($command . ' 2>&1', $output, $returnVar);

        $message = '';
        $csvFilepath = '';
        $rowCount = 0;

        foreach ($output as $line) {
            if (strpos($line, 'Data saved to') !== false) {
                preg_match('/Data saved to (.+)$/', $line, $matches);
                if (!empty($matches[1])) {
                    $csvFilepath = trim($matches[1]);
                }
            }

            if (strpos($line, 'Inserted:') !== false) {
                preg_match('/Inserted: (\d+) rows/', $line, $matches);
                if (!empty($matches[1])) {
                    $rowCount = (int)$matches[1];
                }
            }
        }

        if (!empty($csvFilepath)) {
            $fileName = basename($csvFilepath);
            if ($rowCount > 0) {
                $message = "✅ Operation completed successfully. Data saved to file: {$fileName} and {$rowCount} rows inserted into database.";
            } else {
                $message = "✅ Data saved to file: {$fileName}, but there was an issue inserting into database.";
            }
        } else {
            $message = "⚠️ Operation completed with warnings. Check logs for details.";
        }

        $this->session->set_userdata('debug_output', $output);

        $data['userid'] = $this->session->userdata('adid');
        $data['state_details'] = $this->State_Details_Model->statelists();
        $data['message'] = $message;

        $this->load->view('admin/fertch_server_data', $data);
    }
}
