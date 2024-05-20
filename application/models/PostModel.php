<?php
defined('BASEPATH') OR exit('No direct script access allowed');//This line of code prevents direct access to the file

class PostModel extends CI_Model {

    // inserting post details to the posts table
    public function createPost($postData){
        $insertPostDetails = $this->db->insert('posts', $postData);
        return $insertPostDetails;
    }

    // retrieve all the records of post table along with the user details
    public function getAllPosts(){
        $posts = $this->db->get("posts");
        if($posts->num_rows() > 0){
            $post_array = $posts->result();
            foreach ($post_array as $post) {
                $user_query = $this->db->select('user_id, first_name, last_name, email, profile_picture')
                                       ->from('users')
                                       ->where('user_id', $post->user_id)
                                       ->get();
                if ($user_query->num_rows() > 0) {
                    $post->user_details = $user_query->row();
                } else {
                    $post->user_details = null; // Or you can handle it differently if user not found
                }
            }
            return $post_array;
        } else {
            return [];
        }
    }
    
}