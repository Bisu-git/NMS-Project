<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Admin_Controller.php');

class Daily_ont_report extends Admin_Controller
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
        $this->load->view('admin/daily_ont_report', $data);
    }


    public function fetch_ont_data()
    {
        if ($this->Admin_Dashboard_Model->is_data_already_fetched_for_today()) {
            $data['message'] = "⚠️ Data already fetched for today. Try again tomorrow.";
        } else {
            ini_set('max_execution_time', 0);

            $pythonPath = '"C:\\Program Files\\Python313\\python.exe"';
            $scriptPath = '"F:\\Biswojeet PC\\PycharmProjects\\API FLASK\\More_state_list_other.py"';
            $command = "$pythonPath $scriptPath";

            $output = [];
            $returnVar = null;
            exec($command . ' 2>&1', $output, $returnVar);

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
                    $data['message'] = "✅ Operation completed successfully. Data saved to file: {$fileName} and {$rowCount} rows inserted.";
                } else {
                    $data['message'] = "✅ File saved: {$fileName}, but no rows inserted.";
                }
            } else {
                $data['message'] = "⚠️ Python script did not return expected output. Check logs.";
            }

            $this->session->set_userdata('debug_output', $output);
        }

        // Send only message partial if AJAX
        if ($this->input->is_ajax_request()) {
            $this->load->view('admin/partials/success_message', $data); // Create a partial view
        } else {
            $data['userid'] = $this->session->userdata('adid');
            $data['state_details'] = $this->State_Details_Model->statelists();
            $this->load->view('admin/daily_ont_report', $data); // full page load
        }
    }

}
