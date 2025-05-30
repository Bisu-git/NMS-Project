<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Admin_Controller.php');

class Auser_signup extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('adid'))
            redirect('admin/login');
        
        $this->load->model('Admin_Dashboard_Model');
        $this->load->model('State_Details_Model');
        $this->load->model('Signup_Model');
    }

    public function index()
    {
        $data['roles'] = $this->Admin_Dashboard_Model->get_all_roles();
        $data['scopes'] = $this->Admin_Dashboard_Model->get_all_scopes();
        $data['state_list'] = $this->State_Details_Model->get_all_states();

        $this->form_validation->set_rules('firstname', 'First Name', 'required|alpha');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required|alpha');
        $this->form_validation->set_rules('emailid', 'Email ID', 'required|valid_email|is_unique[tblusers.emailId]');
        $this->form_validation->set_rules('mobilenumber', 'Mobile Number', 'required|numeric|exact_length[10]|is_unique[tblusers.mobileNumber]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'required|matches[password]');
        $this->form_validation->set_rules('role_id', 'Role', 'required');
        $this->form_validation->set_rules('scope_id', 'Scope', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/users_signup', $data);
            return;
        }

        // File Upload Handling
        $img_url = null;
        if (!empty($_FILES['file_assets']['name'])) {
            $ext = pathinfo($_FILES['file_assets']['name'], PATHINFO_EXTENSION);
            $new_file_name = $this->input->post('mobilenumber') . '.' . $ext;

            $config = array(
                'file_name'     => $new_file_name,
                'upload_path'   => './assests/Images/profiles/',
                'allowed_types' => 'gif|jpg|png|jpeg',
                'overwrite'     => TRUE,
                'max_size'      => 2048,
            );

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('file_assets')) {
                $this->session->set_flashdata('error', $this->upload->display_errors());
                $this->load->view('admin/users_signup', $data);
                return;
            } else {
                $path = $this->upload->data();
                $img_url = $path['file_name'];
            }
        }

        $insertData = array(
            'firstName'    => $this->input->post('firstname'),
            'lastName'     => $this->input->post('lastname'),
            'emailId'      => $this->input->post('emailid'),
            'mobileNumber' => $this->input->post('mobilenumber'),
            'userPassword' => $this->input->post('password'),
            'profileImage' => $img_url,
            'role_id'      => $this->input->post('role_id'),
            'scope_id'     => $this->input->post('scope_id'),
            'state_id'      => $this->input->post('stateSelect'),
            'district_id'     => $this->input->post('districtSelect'),
            'isActive'     => 1
        );

        if ($this->Signup_Model->insert($insertData)) {
            $this->session->set_flashdata('usignup_success', 'Registration successful');
        } else {
            $this->session->set_flashdata('usignup_error', 'Something went wrong');
        }

        redirect('admin/Auser_signup');
    }
}
