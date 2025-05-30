<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Admin_Controller.php');
class Admin_signup extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();
        if (! $this->session->userdata('adid'))
            redirect('admin/login');
        $this->load->model('Admin_Dashboard_Model');
    }

    public function index()
    {
        // Validation rules
        $this->form_validation->set_rules('firstname', 'First Name', 'required|regex_match[/^[a-zA-Z ]+$/]');
        $this->form_validation->set_rules('emailid', 'Email ID', 'required|valid_email|is_unique[tbladmin.emailid]');
        $this->form_validation->set_rules('mobilenumber', 'Mobile Number', 'required|numeric|exact_length[10]|is_unique[tbladmin.contactno]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('role', 'Role', 'required');


        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/admin_signup');
            return;
        }

        // File upload handling
        $img_url = null;
        if (!empty($_FILES['admin_profile']['name'])) {
            $mobile_number = $this->input->post('mobilenumber');
            $extension = pathinfo($_FILES['admin_profile']['name'], PATHINFO_EXTENSION);

            $config = array(
                'upload_path'   => './assests/Images/Admins/',
                'allowed_types' => 'jpg|jpeg|png|gif',
                'max_size'      => 2048,
                'overwrite'     => true,
                'file_name'     => $mobile_number . '.' . $extension
            );

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('admin_profile')) {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                $this->load->view('admin/admin_signup');
                return;
            } else {
                $img_data = $this->upload->data();
                $img_url = $img_data['file_name'];
            }
        }


        $data = array(
            'userName'    => $this->input->post('firstname'),
            'emailid'     => $this->input->post('emailid'),
            'contactno'   => $this->input->post('mobilenumber'),
            'admin_role'    => $this->input->post('role'),
            'password'    => $this->input->post('password'),
            'profile'     => $img_url
        );

        if ($this->Admin_Dashboard_Model->insert_admin($data)) {
            $this->session->set_flashdata('asignup_success', 'Registration successful');
        } else {
            $this->session->set_flashdata('asignup_error', 'Something went wrong');
        }

        redirect('admin/Admin_signup');
    }
}
