<?php
defined('BASEPATH') OR exit('No direct script access allowed');//This line of code prevents direct access to the file

class UserModel extends CI_Model {

    // inserting user given details into 'users' table
    public function signup_user($userData)
	{
		$insertDetails = $this->db->insert('users', $userData);
		if (!$insertDetails) {
            throw new Exception("User sign up process failed");
        }
        return $this->db->insert_id();
	}

    // checking whether user given email exists in the 'users' table or not
    public function checkUserEmail($email)
	{
		$this->db->select('email');
		$this->db->where('email', $email);
		$respond = $this->db->get('users');
		if ($respond->num_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

    // Checks whether there is a record existing with the user-given email address and password in the 'users' table.
    public function loginUser($email, $password)
	{
		$this->db->select('*');
		$this->db->where('email', $email);
		$this->db->where('password', $password);
		$this->db->from('users');

		$respond = $this->db->get();

		if ($respond->num_rows() == 1) {
			return ($respond->row(0));
		} else {
			return false;
		}

	}

}

