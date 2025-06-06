<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Login extends CI_Controller
{


    public function index()
    {
        // $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('emailid', 'Email id', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run()) {
            // $username = $this->input->post('username');
            $emailid = $this->input->post('emailid');
            $password = $this->input->post('password');
            $this->load->model('Admin_Login_Model');
            $validate = $this->Admin_Login_Model->validatelogin($emailid, $password);
            if ($validate) {
                $this->session->set_userdata('adid', $validate);
                return redirect('admin/dashboard');
            } else {
                $this->session->set_flashdata('error', 'Invalid details. Please try again with valid details');
                redirect('admin/login');
            }
        } else {
            $this->load->view('admin/login');
        }
    }

    //function for logout
    public function logout()
    {
        $this->session->unset_userdata('adid');
        $this->session->sess_destroy();
        return redirect('admin/login');
    }
}
