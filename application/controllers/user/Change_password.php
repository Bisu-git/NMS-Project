<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/User_Controller.php');

class Change_password extends User_Controller
{
	function __construct()
	{
		parent::__construct();
		if (! $this->session->userdata('uid'))
			redirect('user/login');
		$this->load->model('User_Profile_Model');
	}

	public function index()
	{

		// echo '<pre>';print_r($data);die('hiis');
		$this->form_validation->set_rules('currentpassword', 'Current Password', 'required|min_length[6]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
		$this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'required|min_length[6]|matches[password]');
		if ($this->form_validation->run()) {
			$cpassword = $this->input->post('currentpassword');
			$newpassword = $this->input->post('password');
			$userid = $this->session->userdata('uid');
			$this->load->model('User_Changepassword_Model');
			$cpass = $this->User_Changepassword_Model->getcurrentpassword($userid);
			echo $dbpass = $cpass->userPassword;

			if ($dbpass == $cpassword) {
				if ($this->User_Changepassword_Model->updatepassword($userid, $newpassword)) {
					$this->session->set_flashdata('success_userpwd', 'Password chnaged successfully');
					redirect('user/change_password');
				}
			} else {
				$this->session->set_flashdata('error_user_pwd', 'Current password is wrong. Error!!');
				redirect('user/change_password');
			}
		} else {
			// $this->load->view('user/change_password');
			$this->load->view('user/change_password');
		}
	}
}
