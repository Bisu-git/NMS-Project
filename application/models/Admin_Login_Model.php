<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Admin_Login_Model extends CI_Model
{


	public function validatelogin($emailid, $password)
	{

		$query = $this->db->where(['emailid' => $emailid, 'password' => $password]);
		$account = $this->db->get('tbladmin')->row();
		if ($account != NULL) {

			return $account->id;
		}
		return NULL;
	}
}
