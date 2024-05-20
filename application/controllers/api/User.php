<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class User extends REST_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model("UserModel");
		$this->load->library('form_validation');
	}


    public function signup_post(){
		// Decode the JSON data from the request body
		$input_data = json_decode(file_get_contents('php://input'), TRUE);

		// Assign the decoded JSON data to $_POST
		$_POST = $input_data;	

		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'required|matches[password]');

		if ($this->form_validation->run() == FALSE) {
			// Initialize an array to hold error messages
			$errors = array();

			// Check each field for errors and store them in the $errors array
			if(form_error('firstName')) {
				$errors['firstName'] = form_error('firstName');
			}
			if(form_error('lastName')) {
				$errors['lastName'] = form_error('lastName');
			}
			if(form_error('email')) {
				$errors['email'] = form_error('email');
			}
			if(form_error('password')) {
				$errors['password'] = form_error('password');
			}
			if(form_error('confirmPassword')) {
				$errors['confirmPassword'] = form_error('confirmPassword');
			}
	
			// Send error response with error messages
			$this->response(array(
				'status' => FALSE,
				'message' => 'Validation failed.',
				'errors' => $errors
			), REST_Controller::HTTP_BAD_REQUEST);
			return;
		}else{

			// Extract data from $_POST
			$first_name = $this->input->post('first_name');
			$last_name = $this->input->post('last_name');
			$email = $this->input->post('email');
			$password = $this->input->post('password');

			// Check if all required fields are provided
			if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($password)){
				// Check if the email is already registered
				if($this->UserModel->checkUserEmail($email)){
					$this->response("There is already an account has created for this email", 409);
				}else{
					$userDetails = array (
						"first_name" => $first_name,
						"last_name" => $last_name,
						"email" => $email,
						"password" => sha1($password), // Password is hashed using SHA1
					);
					$userRegistration = $this -> UserModel-> signup_user($userDetails);
					if($userRegistration){
						$this->response(array(
							'status' => TRUE,
							'message' => 'The user registered successfully.',
							'data' => $userRegistration)
						, REST_Controller::HTTP_OK);
					}else{
						$this->response("User has not registered successfully", REST_Controller::HTTP_BAD_REQUEST);
					}
				}
			}
		}
	}
	public function login_post(){
		// Decode the JSON data from the request body
		$input_data = json_decode(file_get_contents('php://input'), TRUE);

		// Assign the decoded JSON data to $_POST
		$_POST = $input_data;	
		
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == FALSE) {
			// Initialize an array to hold error messages
			$errors = array();

			// Check each field for errors and store them in the $errors array
			
			if(form_error('email')) {
				$errors['email'] = form_error('email');
			}
			if(form_error('password')) {
				$errors['password'] = form_error('password');
			}
	
			// Send error response with error messages
			$this->response(array(
				'status' => FALSE,
				'message' => 'Validation failed.',
				'errors' => $errors
			), REST_Controller::HTTP_BAD_REQUEST);
			return;
		}else{
			// Extract data from $_POST
			$email = $this->input->post('email');
			$password = $this->input->post('password');

			$result = $this->UserModel->loginUser($email, sha1($password));
			if ($result != false) {

				$this->response(array(
						'status' => TRUE,
						'message' => 'User has logged in successfully.',
						'data' => true,
						'user_id' =>  $result -> user_id,
						'first_name' => $result -> first_name,
						'last_name' => $result -> last_name,
						'email' => $result -> email,
						'created_at' => $result -> created_at
						//photo
					)
					, REST_Controller::HTTP_OK);
			} else {
				$this->response("Enter valid username and password", REST_Controller::HTTP_BAD_REQUEST);
			}
		}
		
	}
}
