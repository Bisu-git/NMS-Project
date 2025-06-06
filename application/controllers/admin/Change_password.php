<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Admin_Controller.php');
class Change_password extends Admin_Controller
{
	function __construct()
	{
		parent::__construct();
		if (! $this->session->userdata('adid'))
			redirect('admin/login');
	}

	public function index()
	{
		$this->form_validation->set_rules('currentpassword', 'Current Password', 'required|min_length[6]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
		$this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'required|min_length[6]|matches[password]');
		if ($this->form_validation->run()) {
			$cpassword = $this->input->post('currentpassword');
			$newpassword = $this->input->post('password');
			$adminid = $this->session->userdata('adid');
			$this->load->model('Admin_Changepassword_Model');
			$cpass = $this->Admin_Changepassword_Model->getcurrentpassword($adminid);
			$dbpass = $cpass->password;

			if ($dbpass == $cpassword) {
				if ($this->Admin_Changepassword_Model->updatepassword($adminid, $newpassword)) {
					$this->session->set_flashdata('adminpwd_success', 'Password chnaged successfully');
					redirect('admin/change_password');
				}
			} else {
				$this->session->set_flashdata('adminpwd_error', 'Current password is wrong. Error!!');
				redirect('admin/change_password');
			}
		} else {
			$this->load->view('admin/change_password');
		}
	}
}
