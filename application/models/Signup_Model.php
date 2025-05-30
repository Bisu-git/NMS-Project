<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Signup_Model extends CI_Model
{

	public function insert($data)
	{
		$inserted = $this->db->insert('tblusers', $data);
		return $inserted;
	}

	// public function inserta($fname, $lname, $emailid, $mnumber, $password, $status)
	// {
	// 	$data = array(
	// 		'firstName' => $fname,
	// 		'lastName' => $lname,
	// 		'emailId' => $emailid,
	// 		'mobileNumber' => $mnumber,
	// 		'userPassword' => $password,
	// 		'isActive' => $status
	// 	);
	// 	$sql_query = $this->db->insert('tblusers', $data);
	// 	if ($sql_query) {
	// 		$this->session->set_flashdata('success', 'Registration successfull');
	// 		redirect('user/signup');
	// 	} else {
	// 		$this->session->set_flashdata('error', 'Somthing went worng. Error!!');
	// 		redirect('user/signup');
	// 	}
	// }
}
