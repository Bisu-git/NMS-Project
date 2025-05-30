<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'core/Admin_Controller.php');

class Roals_scope extends Admin_Controller
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
        $this->load->view('admin/roals_scope');
    }

    public function user_roals()
    {
        $this->form_validation->set_rules(
            'userroles',
            'User Roles',
            'required|regex_match[/^[A-Za-z\s\-\.]+$/]',
            ['regex_match' => 'The %s field may only contain letters, spaces, hyphens, or dots.']
        );
        

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/roals_scope');
            return;
        }

        $data = [
            'role_name' => $this->input->post('userroles')
        ];

        if ($this->Admin_Dashboard_Model->user_roals($data)) {
            $this->session->set_flashdata('rollsc_success', 'Role added successfully');
        } else {
            $this->session->set_flashdata('rollsc_error', 'Failed to add role');
        }

        redirect('admin/Roals_scope');
    }

    public function user_scope()
    {
        $this->form_validation->set_rules(
            'userscope',
            'User Scope',
            'required|regex_match[/^[a-zA-Z\s\-\.\&]+$/]',
            array(
                'regex_match' => 'The %s field may only contain letters, spaces, hyphens, dots, or ampersands.'
            )
        );
        
        

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/roals_scope');
            return;
        }

        $data = [
            'scope_name' => $this->input->post('userscope')
        ];

        if ($this->Admin_Dashboard_Model->user_scope($data)) {
            $this->session->set_flashdata('rollsc_success', 'Scope added successfully');
        } else {
            $this->session->set_flashdata('rollsc_error', 'Failed to add scope');
        }

        redirect('admin/Roals_scope');
    }
}
