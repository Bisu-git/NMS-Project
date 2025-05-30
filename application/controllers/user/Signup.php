<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Signup extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (! $this->session->userdata('adid'))
            redirect('admin/login');
    }

    public function index()
    {
        // Set validation rules first
        $this->form_validation->set_rules('firstname', 'First Name', 'required|alpha');
        $this->form_validation->set_rules('lastname', 'Last Name', 'required|alpha');
        $this->form_validation->set_rules('emailid', 'Email ID', 'required|valid_email|is_unique[tblusers.emailId]');
        $this->form_validation->set_rules('mobilenumber', 'Mobile Number', 'required|numeric|exact_length[10]|is_unique[tblusers.mobileNumber]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirmpassword', 'Confirm Password', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('user/signup');
            return;
        }

        // Proceed only if form is valid
        $img_url = null;
        if (!empty($_FILES['file_assets']['name'])) {
            $ext = pathinfo($_FILES['file_assets']['name'], PATHINFO_EXTENSION);
            $new_file_name = $this->input->post('mobilenumber') . '.' . $ext;

            $config = array(
                'file_name'     => $new_file_name,
                'upload_path'   => './assests/Images/profiles/',
                'allowed_types' => 'gif|jpg|png|jpeg',
                'overwrite'     => TRUE,
                'max_size'      => 2048, // 2MB
            );

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('file_assets')) {
                // If upload fails
                $this->session->set_flashdata('error', $this->upload->display_errors());
                $this->load->view('user/signup');
                return;
            } else {
                // If upload succeeds
                $path = $this->upload->data();
                $img_url = $path['file_name'];
            }
        }
        // Collect data
        $data = array(
            'firstName'     => $this->input->post('firstname'),
            'lastName'      => $this->input->post('lastname'),
            'emailId'       => $this->input->post('emailid'),
            'mobileNumber'  => $this->input->post('mobilenumber'),
            'userPassword'  => $this->input->post('password'),
            'profileImage'  => $img_url,
            'isActive'      => 1
        );

        // Save to DB
        $this->load->model('Signup_Model');
        if ($this->Signup_Model->insert($data)) {
            $this->session->set_flashdata('success', 'Registration successful');
        } else {
            $this->session->set_flashdata('error', 'Something went wrong');
        }

        redirect('user/signup');
    }

}
