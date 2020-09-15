<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Forms_model extends CI_Model { 

    public function insertForms($data){ 
        $this->db->query("call form_ins(?,?,?,?,?,@id,@err,@msg)",$data);
        $que = $this->db->query("SELECT @id as id , @err as error , @msg as msg");
        echo json_encode($que->result());
    }   

    public function updateForms($data){ 
        $this->db->query("call form_upd(?,?,?,?,?,?,@err,@msg)",$data);
        $que = $this->db->query("SELECT @id as id , @err as error , @msg as msg");
        echo json_encode($que->result());
    }   

    public function deleteForm($data){ 
        $this->db->query("call form_del(?,@err,@msg)",$data);
        $que = $this->db->query("SELECT @err as error , @msg as msg");
        echo json_encode($que->result());
    }   

    public function getFormList(){
        $query = $this->db->query("SELECT * FROM forms");
        return $query->result();
    }

    public function getForm($id){
    	$query = $this->db->query("SELECT * FROM forms WHERE form_id = ".$id." ");
    	return $query->result();
    }
 
}