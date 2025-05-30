<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User_profile extends CI_Controller
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
		$userid = $this->session->userdata('uid');
		$profiledetails = $this->User_Profile_Model->getprofile($userid);
		// echo '<pre>'; print_r($profiledetails); die('message');
		$this->load->view('user/user_profile', ['profile' => $profiledetails]);
	}


	public function updateprofileera()
	{
		echo '<pre>';
		print_r($_POST);
		print_r($_FILES);
		die('message');
		$this->form_validation->set_rules('firstname', 'First Name', 'required|alpha');
		$this->form_validation->set_rules('lastname', 'Last  Name', 'required|alpha');
		$this->form_validation->set_rules('mobilenumber', 'Mobile Number', 'required|numeric|exact_length[10]');
		if ($this->form_validation->run()) {
			$fname = $this->input->post('firstname');
			$lname = $this->input->post('lastname');
			$mnumber = $this->input->post('mobilenumber');
			$userid = $this->session->userdata('uid');
			$this->User_Profile_Model->update_profile($fname, $lname, $mnumber, $userid);
			$this->session->set_flashdata('success', 'Profile updated successfull.');
			return redirect('user/user_profile');
		} else {
			$this->session->set_flashdata('error', 'Something went wrong. Please try again with valid format.');
			redirect('user/user_profile');
		}
	}

	public function updateprofile()
	{
		$this->form_validation->set_rules('firstname', 'First Name', 'required|alpha');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required|alpha');
		$this->form_validation->set_rules('mobilenumber', 'Mobile Number', 'required|numeric|exact_length[10]');

		if ($this->form_validation->run()) {
			$fname = $this->input->post('firstname');
			$lname = $this->input->post('lastname');
			$mnumber = $this->input->post('mobilenumber');
			$userid = $this->session->userdata('uid');

			$profileImage = null;

			if (!empty($_FILES['profileImage']['name'])) {
				$upload_path = './assests/Images/profiles/';
				$allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
				$ext = pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION);
				$file_name = $mnumber . '.' . $ext;
				$full_path = $upload_path . $file_name;

				// Check if file with same mobile exists in any extension, then delete
				foreach ($allowed_extensions as $extension) {
					$existing_file = $upload_path . $mnumber . '.' . $extension;
					if (file_exists($existing_file)) {
						unlink($existing_file);
					}
				}

				// Upload config
				$config['upload_path']   = $upload_path;
				$config['allowed_types'] = implode('|', $allowed_extensions);
				$config['max_size']      = 2048;
				$config['file_name']     = $file_name;

				$this->load->library('upload', $config);

				if (!$this->upload->do_upload('profileImage')) {
					$this->session->set_flashdata('error', $this->upload->display_errors());
					return redirect('user/user_profile');
				} else {
					$upload_data = $this->upload->data();
					$profileImage = $upload_data['file_name'];
				}
			}

			// Call model
			$this->User_Profile_Model->update_profile($fname, $lname, $mnumber, $userid, $profileImage);

			$this->session->set_flashdata('update_profile_success', 'Profile updated successfully.');
			return redirect('user/user_profile');
		} else {
			$this->session->set_flashdata('error_profile', 'Something went wrong. Please try again with valid format.');
			return redirect('user/user_profile');
		}
	}
}
