<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Access_model extends CI_Model { 

    public function getUserAccess($form,$userId){

        $query = $this->db->query("SELECT * FROM user_access_v WHERE form_code = '".$form."' AND user_id = ".$userId." ");
        return $query->result();

    }
 
}