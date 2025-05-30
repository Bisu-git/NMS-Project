<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Admin_Controller.php');

class Manage_Users extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();
        if (! $this->session->userdata('adid'))
            redirect('admin/login');
        $this->load->model('Admin_Dashboard_Model');
        $this->load->model('ManageUsers_Model');
    }

    
    public function index()
    {
        $user = $this->ManageUsers_Model->getusersdetails();
        $this->load->view('admin/manage_users', ['userdetails' => $user]);
    }

    // For particular Record
    public function getuserdetail($uid)
    {
        $this->load->model('ManageUsers_Model');
        $udetail = $this->ManageUsers_Model->getuserdetail($uid);
        $this->load->view('admin/getuserdetails', ['ud' => $udetail]);
    }

    public function deleteuser($uid)
    {
        $this->load->model('ManageUsers_Model');
        $this->ManageUsers_Model->deleteuser($uid);
        $this->session->set_flashdata('success', 'User data deleted');
        redirect('admin/manage_users');
    }
}
