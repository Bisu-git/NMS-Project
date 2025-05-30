<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Admin_Dashboard_Model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        if (! $this->session->userdata('adid'))
            redirect('admin/login');
    }

    public function totalcount()
    {
        $query = $this->db->select('id')
            ->get('tblusers');
        return  $query->num_rows();
    }

    public function countlastsevendays()
    {
        $query2 = $this->db->select('id')
            ->where('regDate >=  DATE(NOW()) - INTERVAL 10 DAY')
            ->get('tblusers');
        return  $query2->num_rows();
    }

    public function countthirtydays()
    {
        $query3 = $this->db->select('id')
            ->where('regDate >=  DATE(NOW()) - INTERVAL 30 DAY')
            ->get('tblusers');
        return  $query3->num_rows();
    }

    public function insert_admin($data)
    {
        $inserted = $this->db->insert('tbladmin', $data);
        return $inserted;
    }

    public function adminprofile($userid)
    {
        $query = $this->db->select('userName,profile,emailid ,contactno,admin_role')
            ->where('id', $userid)
            ->from('tbladmin')
            ->get();
        return $query->row();
    }

    public function getadminsdetails()
    {
        $query = $this->db->select('userName,profile,emailid ,contactno ,id')
            ->get('tbladmin');
        return $query->result();
    }
    public function deleteadmins($uid)
    {
        $sql_query = $this->db->where('id', $uid)
            ->delete('tbladmin');
    }
    public function geteditadmindetail($uid)
    {
        $ret = $this->db->select('userName,profile,emailid,contactno,admin_role,id')
            ->where('id', $uid)
            ->get('tbladmin');
        return $ret->row();
    }



    public function update_admin_profile($username, $contactno, $adminrole, $userid, $profileImage = null)
    {
        $data = array(
            'userName' => $username,
            'contactno' => $contactno,
            'admin_role' => $adminrole,
        );

        if (!empty($profileImage)) {
            $data['profile'] = $profileImage;
        }

        return $this->db->where('id', $userid)->update('tbladmin', $data);
    }

    public function user_roals($data)
    {
        return $this->db->insert('user_roles', $data);
    }

    public function user_scope($data)
    {
        return $this->db->insert('user_scopes', $data);
    }

    // public function get_all_roles()
    // {
    //     $query = $this->db->get('user_roles');
    //     return $query->result_array(); 
    // }

    // public function get_all_scopes()
    // {
    //     $query = $this->db->get('user_scopes');
    //     return $query->result_array();
    // }

    public function get_all_roles()
    {
        return $this->db->get('user_roles')->result_array(); // Assuming 'roles' is the table name
    }

    public function get_all_scopes()
    {
        return $this->db->get('user_scopes')->result_array(); // Assuming 'scopes' is the table name
    }

    public function is_data_already_fetched_for_today()
    {
        // Get today's date in the expected format
        $today = date('d_m_Y');

        // Get all table names
        $query = $this->db->query("SHOW TABLES");
        $tables = $query->result_array();

        foreach ($tables as $row) {
            $table_name = reset($row);

            // If a table exists with today's date in the format: 23_04_2025_10_37_34
            if (preg_match("/^{$today}_\d{2}_\d{2}_\d{2}$/", $table_name)) {
                return true;
            }
        }

        return false;
    }
}
