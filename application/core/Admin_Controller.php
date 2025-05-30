<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_Controller extends CI_Controller
{
    public $admin_profile;

    public function __construct()
    {
        parent::__construct();

        // Check session
        if (! $this->session->userdata('adid')) {
            redirect('admin/login');
        }

        // Load models globally
        $this->load->model('Admin_Dashboard_Model');

        // Set global admin profile
        $this->admin_profile = $this->Admin_Dashboard_Model->adminprofile($this->session->userdata('adid'));

        // Make available to all views
        $this->load->vars(['profile' => $this->admin_profile]);
    }
}
