<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_Controller extends CI_Controller
{
    public $profile;

    public function __construct()
    {
        parent::__construct();

        // Check if user is logged in
        if (! $this->session->userdata('uid')) {
            redirect('user/login');
        }

        // Load user profile data
        $this->load->model('User_Profile_Model');
        $userid = $this->session->userdata('uid');
        $this->profile = $this->User_Profile_Model->getprofile($userid);
        $this->load->vars(['profile' => $this->profile]);
    }
}
