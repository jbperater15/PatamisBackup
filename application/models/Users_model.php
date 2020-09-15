<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Users_model extends CI_Model { 
     
    function __construct() { 
        $this->tableName = 'users'; 
    } 
     
    public function checkUser($data = array()){ 
        $this->db->select('id'); 
        $this->db->from($this->tableName); 
         
        $con = array( 
            'oauth_provider' => $data['oauth_provider'], 
            'oauth_uid' => $data['oauth_uid'] 
        ); 
        $this->db->where($con); 
        $query = $this->db->get(); 
         
        $check = $query->num_rows(); 
        if($check > 0){ 
            // Get prev user data 
            $result = $query->row_array(); 
             
            // Update user data 
            $data['modified'] = date("Y-m-d H:i:s"); 
            $update = $this->db->update($this->tableName, $data, array('id' => $result['id'])); 
             
            // Get user ID 
            $userID = $result['id']; 
        }else{ 
            // Insert user data 
            $data['created'] = date("Y-m-d H:i:s"); 
            $data['modified'] = date("Y-m-d H:i:s"); 
            $insert = $this->db->insert($this->tableName, $data); 
             
            // Get user ID 
            $userID = $this->db->insert_id(); 
        } 
         
        // Return user ID 
        return $userID?$userID:false; 
    } 

    public function login($data){
        $this->db->where('username', $data['user_name']);
        $this->db->where('password', password_verify($data['password'], 'pwd'));
        $this->db->limit(1);
        $query = $this->db->get('users');
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return $query->result();
        }
    }

    public function getUserList(){
        $query = $this->db->query("SELECT * FROM users");
        return $query->result();
    }

    public function insertUsers($data){ 
        $this->db->query("call user_ins(?,?,?,?,?,?,?,@id,@err,@msg)",$data);
        $que = $this->db->query("SELECT @id as id , @err as error , @msg as msg");
        echo json_encode($que->result());
    }   

    public function updateUsers($data){
        $this->db->query("call user_upd(?,?,?,?,?,?,?,?,@err,@msg)",$data); 
        $que = $this->db->query("SELECT @err as error, @msg as msg");
        echo json_encode($que->result());
    }

    public function getUser($id){
        $query = $this->db->query("SELECT * FROM users where user_id = ".$id." ");
        return $query->result();
    }

    public function deleteUser($data){
        $this->db->query("call user_del(?,@err,@msg)",$data);
        $que = $this->db->query("SELECT @err as error, @msg as msg");
        echo json_encode($que->result());
    }
 
}