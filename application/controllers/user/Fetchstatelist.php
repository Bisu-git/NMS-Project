<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . 'core/User_Controller.php');

class Fetchstatelist extends User_Controller
{
    function __construct()
    {
        parent::__construct();
        if (! $this->session->userdata('uid'))
            redirect('user/login');
        $this->load->model('User_Profile_Model');
        $this->load->model('State_Details_Model');
    }

    public function index()
    {
        $data['userid'] = $this->session->userdata('uid');
        $data['show_all_nms_details'] = $this->State_Details_Model->nmsdetails(); // fixed typo
        $data['state_details'] = $this->State_Details_Model->nmsstate();
        $this->load->view('user/state_listsapis', $data);
    }

    public function fetch_by_state()
    {
        $state_id = $this->input->post('state_id');
        if ($state_id) {
            $result = $this->State_Details_Model->get_nms_by_state($state_id);
            echo json_encode($result);
        } else {
            echo json_encode([]);
        }
    }

    public function fetch_data_python()
    {
        ini_set('max_execution_time', 0); // Wait for long scripts

        // Use full path to Python interpreter and script
        $pythonPath = '"C:\\Users\\PC\\AppData\\Local\\Programs\\Python\\Python313\\python.exe"';
        $scriptPath = '"C:\\NODES\\Python Vlog\\PycharmProjects\\API FLASK\\More_statelist.py"';
        $command = "$pythonPath $scriptPath";

        // Enable output buffering to capture command output
        $output = [];
        $returnVar = null;
        exec($command . ' 2>&1', $output, $returnVar);

        // Process the Python script output
        $message = '';
        $csvFilepath = '';
        $rowCount = 0;

        // Loop through output to find useful information
        foreach ($output as $line) {
            // Look for the CSV file path
            if (strpos($line, 'Data saved to') !== false) {
                preg_match('/Data saved to (.+)$/', $line, $matches);
                if (!empty($matches[1])) {
                    $csvFilepath = trim($matches[1]);
                    $fileName = basename($csvFilepath);
                }
            }

            // Look for row count information
            if (strpos($line, 'Inserted:') !== false) {
                preg_match('/Inserted: (\d+) rows/', $line, $matches);
                if (!empty($matches[1])) {
                    $rowCount = (int)$matches[1];
                }
            }
        }

        // Determine the appropriate message
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

        // For debugging purposes - store the output in a session variable
        // Remove this in production
        $this->session->set_userdata('debug_output', $output);

        // Fetch state details
        $data['userid'] = $this->session->userdata('uid');
        $data['state_details'] = $this->State_Details_Model->statelists();
        $data['message'] = $message;

        $this->load->view('user/state_listsapis', $data);
    }
}
