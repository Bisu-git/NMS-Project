<?php
defined('BASEPATH') or exit('No direct script access allowed');
class User_Profile_Model extends CI_Model
{

  public function getprofile($userid)
  {
    $query = $this->db->select('
              tblusers.firstName,
              tblusers.lastName,
              tblusers.emailId,
              tblusers.profileImage,
              tblusers.mobileNumber,
              tblusers.regDate,
              tblusers.scope_id,
              tblusers.role_id,
              tblusers.state_id,
              tblusers.district_id,
              user_roles.role_name,
              district_lists.district_names,
              state_lists.state_name
          ')
      ->from('tblusers')
      ->where('tblusers.id', $userid)
      ->join('user_roles', 'tblusers.role_id = user_roles.id', 'left')
      ->join('state_lists', 'tblusers.state_id = state_lists.state_code', 'left')
      ->join('district_lists', 'tblusers.district_id = district_lists.district_code', 'left')
      ->get();

    return $query->row();
  }

  public function update_profile($fname, $lname, $mnumber, $userid, $profileImage = null)
  {
    $data = array(
      'firstName' => $fname,
      'lastName' => $lname,
      'mobileNumber' => $mnumber,
    );

    if ($profileImage) {
      $data['profileImage'] = $profileImage;
    }

    $this->db->where('id', $userid)->update('tblusers', $data);
  }
}
