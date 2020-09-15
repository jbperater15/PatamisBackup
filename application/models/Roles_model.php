<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Roles_model extends CI_Model { 

    public function insertRoles($data){ 
        $this->db->query("call role_ins(?,?,?,?,@id,@err,@msg)",$data);
        $que = $this->db->query("SELECT @id as id , @err as error , @msg as msg");
        echo json_encode($que->result());
    }   

    public function getForms($id){
        $query = $this->db->query("SELECT * FROM forms frm where frm.form_id NOT IN (SELECT ra.form_id from role_access ra where ra.role_id = ".$id.")");
        return $query->result();
    }

    public function insertRoleAccess($data){
        $this->db->query("call role_access_ins(?,?,?,?,?,?,?,@id,@err,@msg)",$data);
        $que = $this->db->query("SELECT @id as id,@err as error, @msg as msg");
        echo json_encode($que->result());
    }

    public function updateRoleAccess($data){
        $this->db->query("call role_access_upd(?,?,?,?,?,?,@err,@msg)",$data);
        $que = $this->db->query("SELECT @err as error, @msg as msg");
        echo json_encode($que->result());
    }

    public function getAccess($id){
        $query = $this->db->query("SELECT * FROM role_access_v ra Where ra.role_id =  ".$id." ");
        return $query->result();
    }

    public function getRoleList(){
        $query = $this->db->query("SELECT * FROM roles");
        return $query->result();
    }

    public function getRole($id){
        $query = $this->db->query("SELECT * FROM roles where role_id = ".$id." ");
        return $query->result();
    }

    public function updateRoles($data){
        $this->db->query("call role_upd(?,?,?,?,?,@err,@msg)",$data); 
        $que = $this->db->query("SELECT @err as error, @msg as msg");
        echo json_encode($que->result());
    }

    public function deleteRole($data){
        $this->db->query("call role_del(?,@err,@msg)",$data);
        $que = $this->db->query("SELECT @err as error, @msg as msg");
        echo json_encode($que->result());
    }

    public function deleteRoleAccess($data){
        $this->db->query("call role_access_del(?,@err,@msg)",$data);
        $que = $this->db->query("SELECT @err as error, @msg as msg");
        echo json_encode($que->result());
    }

    // public function getRoleAccess($id){
    //     $query = $this->db->query("SELECT ra.*
    //                                     ,frm.form_code
    //                                     ,frm.form_name 
    //                               FROM role_access ra
    //                                 inner join forms frm On frm.form_id = ra.form_id
    //                               Where role_id = ".$id." ");
    //     return $query->result();
    // }
    
 
}