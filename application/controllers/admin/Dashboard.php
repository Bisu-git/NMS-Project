<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (! $this->session->userdata('adid'))
            redirect('admin/login');
    }

    
    public function index()
    {
        $this->load->model('Admin_Dashboard_Model');
        $totalcount = $this->Admin_Dashboard_Model->totalcount();
        $sevendayscount = $this->Admin_Dashboard_Model->countlastsevendays();
        $thirtydayscount = $this->Admin_Dashboard_Model->countthirtydays();
        $admindetails = $this->Admin_Dashboard_Model->adminprofile($this->session->userdata('adid'));

        $data = [
            'tcount' => $totalcount,
            'tsevencount' => $sevendayscount,
            'tthirycount' => $thirtydayscount,
            'profile' => $admindetails,
            'currentDate' => date('d M Y') // e.g., 17 Apr 2025
        ];

        $this->load->view('admin/dashboard', $data);
    }
}
