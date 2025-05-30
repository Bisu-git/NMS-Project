<?php
defined('BASEPATH') or exit('No direct script access allowed');
require_once(APPPATH . 'core/Admin_Controller.php');

class Manage_Admins extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();
        if (! $this->session->userdata('adid'))
            redirect('admin/login');
        $this->load->model('Admin_Dashboard_Model');
        $this->load->model('State_Details_Model');
    }

    public function index()
    {
        $admin = $this->Admin_Dashboard_Model->getadminsdetails();
        $this->load->view('admin/manage_admins', ['admindetails' => $admin]);
    }

    // For particular Record
    public function geteditadmindetail($uid)
    {
        $editdetail = $this->Admin_Dashboard_Model->geteditadmindetail($uid);
        $this->load->view('admin/getadmindetails', ['ud' => $editdetail]);
    }

    public function deleteadmin($uid)
    {
        $this->Admin_Dashboard_Model->deleteadmins($uid);
        $this->session->set_flashdata('success', 'Admin data deleted');
        redirect('admin/manage_admins');
    }

    public function updateadminprofile()
    {
        // Updated validation rule
        $this->form_validation->set_rules('userName', 'User Name', 'required|regex_match[/^[a-zA-Z ]+$/]');
        $this->form_validation->set_rules('contactno', 'Contact Number', 'required|numeric|exact_length[10]');
        $this->form_validation->set_rules('role', 'Role', 'required');

        if ($this->form_validation->run()) {
            $contactno = $this->input->post('contactno');
            $username = $this->input->post('userName');
            $adminrole = $this->input->post('role');
            $userid = $this->input->post('userid');

            $profileImage = null;

            // Handle image upload
            if (!empty($_FILES['profileImage']['name'])) {
                if ($_FILES['profileImage']['size'] > 2097152) {
                    $this->session->set_flashdata('aprofile_error', 'Image should not be more than 2 MB.');
                    return redirect('admin/manage_admins');
                }

                $upload_path = './assets/Images/profiles/';
                $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                $ext = pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION);
                $file_name = $contactno . '.' . $ext;

                foreach ($allowed_extensions as $extension) {
                    $existing_file = $upload_path . $contactno . '.' . $extension;
                    if (file_exists($existing_file)) {
                        unlink($existing_file);
                    }
                }

                $config['upload_path']   = $upload_path;
                $config['allowed_types'] = implode('|', $allowed_extensions);
                $config['max_size']      = 2048;
                $config['file_name']     = $file_name;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('profileImage')) {
                    $this->session->set_flashdata('aprofile_error', $this->upload->display_errors());
                    return redirect('admin/manage_admins');
                } else {
                    $upload_data = $this->upload->data();
                    $profileImage = $upload_data['file_name'];
                }
            }

            // Now update the DB
            $this->Admin_Dashboard_Model->update_admin_profile($username, $contactno, $adminrole, $userid, $profileImage);

            $this->session->unset_userdata('aprofile_error');
            $this->session->set_flashdata('aprofile_success', 'Profile updated successfully.');
            return redirect('admin/manage_admins');
        } else {
            $this->session->unset_userdata('aprofile_success');
            $this->session->set_flashdata('aprofile_error', 'Validation failed. Please try again.');
            return redirect('admin/manage_admins');
        }
    }

    public function get_district_and_state()
    {
        $id = $this->input->post('dep_id');
        $data = $this->State_Details_Model->getdistrict_bystate($id);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
