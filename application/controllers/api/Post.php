<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

class Post extends REST_Controller {
    public function __construct(){
        parent:: __construct();
        $this->load->model('PostModel');
    }
    public function createpost_post(){
        // Decode the JSON data from the request body
		$input_data = json_decode(file_get_contents('php://input'), TRUE);

        // Assign the decoded JSON data to $_POST	

        $user_id = strip_tags($this->post('user_id'));
		$description = strip_tags($this->post('description'));
        $post_picture = strip_tags($this->post('post_picture'));

        //intialize varibe to keep image path
        $post_picture_path='';

        // checking whether user has uploaded a image or not
        if (!empty($_FILES['post_picture']['name'])){
            $uploadDirectory = 'C:/xampp/htdocs/shutterSpace/assets/images/posts/';
            $uploadFilePath = $uploadDirectory . basename($_FILES['post_picture']['name'] );

            // move the uploaded image to /assets/images/posts
            if (move_uploaded_file($_FILES['post_picture']['tmp_name'], $uploadFilePath)){
                //update the image path
                $post_picture_path = $uploadFilePath;
            }
        }

        if (!empty($description) && !empty($post_picture_path) && !empty($user_id)) {
            //console.log("hi");
            $postData = array (
                "user_id" => $user_id,
                "post_picture" => $post_picture_path,
                "description" => $description
            );
            $postCreation = $this -> PostModel-> createPost($postData);
            if($postCreation){
                $this->response(array(
                    'status' => TRUE,
                    'message' => 'The post created successfully.',
                    'data' => $postCreation)
                , REST_Controller::HTTP_OK);
            }else{
                $this->response("The post has not created successfully", REST_Controller::HTTP_BAD_REQUEST);
            }
        }else{
            $this->response("Enter valid inputs", REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    public function displayAllPosts_get() {
            $all_posts= $this->PostModel->getAllPosts();
            // Check if the posts data exists
		if (!empty($all_posts)) {
			$this->response($all_posts, REST_Controller::HTTP_OK);
		} else {
			$this->response(array(
				'status' => FALSE,
				'message' => 'There is no posts'
			), REST_Controller::HTTP_NOT_FOUND);
		}
    }
}