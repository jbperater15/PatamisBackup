<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
 
class Projecttypes_model extends CI_Model { 

    public function insertPrjType($data){ 
        $this->db->query("call prjType_ins(?,?,?,@id,@err,@msg)",$data);
        $que = $this->db->query("SELECT @id as id , @err as error , @msg as msg");
        echo json_encode($que->result());
    }   

    public function getReqs($id){
        $query = $this->db->query("SELECT * FROM requirements_checklist rc where project_type_id = ".$id." ");
        return $query->result();
    }

    public function insertReq($data){
        $this->db->query("call prjReq_ins(?,?,?,@id,@err,@msg)",$data);
        $que = $this->db->query("SELECT @id as id,@err as error, @msg as msg");
        echo json_encode($que->result());
    }

    // public function updateRoleAccess($data){
    //     $this->db->query("call role_access_upd(?,?,?,?,?,?,@err,@msg)",$data);
    //     $que = $this->db->query("SELECT @err as error, @msg as msg");
    //     echo json_encode($que->result());
    // }

    // public function getAccess($id){
    //     $query = $this->db->query("SELECT * FROM role_access_v ra Where ra.role_id =  ".$id." ");
    //     return $query->result();
    // }

    public function getPrjTypeList(){
        $query = $this->db->query("SELECT * FROM project_types");
        return $query->result();
    }

    public function getPrjTYpe($id){
        $query = $this->db->query("SELECT * FROM project_types where project_type_id = ".$id." ");
        return $query->result();
    }

    public function updatePrjType($data){
        $this->db->query("call prjType_upd(?,?,?,?,@err,@msg)",$data); 
        $que = $this->db->query("SELECT @err as error, @msg as msg");
        echo json_encode($que->result());
    }

    public function deletePrjType($data){
        $this->db->query("call prjType_del(?,@err,@msg)",$data);
        $que = $this->db->query("SELECT @err as error, @msg as msg");
        echo json_encode($que->result());
    }

    public function updateReq($data){
        $this->db->query("call prjReq_upd(?,?,?,@err,@msg)",$data);
        $que = $this->db->query("SELECT @err as error, @msg as msg");
        echo json_encode($que->result());

    }

    public function deleteReq($data){
        $this->db->query("call prjReq_del(?,@err,@msg)",$data);
        $que = $this->db->query("SELECT @err as error, @msg as msg");
        echo json_encode($que->result());
    }

    // public function deleteRoleAccess($data){
    //     $this->db->query("call role_access_del(?,@err,@msg)",$data);
    //     $que = $this->db->query("SELECT @err as error, @msg as msg");
    //     echo json_encode($que->result());
    // }

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