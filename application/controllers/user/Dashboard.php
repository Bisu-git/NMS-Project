<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (! $this->session->userdata('uid'))
			redirect('user/login');
	}
	public function index()
	{
		$userid = $this->session->userdata('uid');
		$this->load->model('User_Profile_Model');
		$profiledetails = $this->User_Profile_Model->getprofile($userid);
		// echo '<pre>';print_r($profiledetails);die('Hiis');
		$this->load->view('user/dashboard', ['profile' => $profiledetails]);
	}



	
}
