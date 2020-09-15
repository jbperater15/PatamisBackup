<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Projecttypes extends CI_Controller {
    //AIzaSyCM_JFNmKMPDoLQm2Bkbh9ajomhmfljuDE

    var $access='';

    function __construct(){ 
        parent::__construct(); 
        $this->load->model('projecttypes_model');  
        $this->load->model('access_model');
        
    } 
     

     
    public function index(){
        $access = $this->access_model->getUserAccess('PRJ_TYPES',$this->session->userdata('user_id')); 
        $this->load->view('layout/header');
        $this->load->view('projecttypes/projecttypes_main');
        $this->load->view('layout/footer',array(
            'create_acc'    => $access[0]->create_flag
        ));

    }



    public function add_prjtype(){
        $this->load->view('layout/header');
        $this->load->view('projecttypes/projecttypes_add');
        $this->load->view('projecttypes/projecttypes_modal');
        $this->load->view('layout/footer');
    }

    public function edit_prjtype(){
        $this->load->view('layout/header');
        $this->load->view('projecttypes/projecttypes_edit',array(
            'prjType' =>  $this->projecttypes_model->getPrjTYpe($this->input->post('prjType_id'))
        ));
        $this->load->view('projecttypes/projecttypes_modal');
        $this->load->view('layout/footer');
    }

    public function prjtype_add(){
        $data = array(
            ':p_prj_type'          => $this->input->post('prj_type'),
            ':p_prj_name'          => $this->input->post('prj_name'),
            ':p_user_id'           => $this->session->userdata('user_id'),
        );
        $this->projecttypes_model->insertPrjType($data);
    }

    public function prjtype_edit(){
        $data = array(
            ':p_prjtype_id'           => $this->input->post('e_prjtype_id'),
            ':p_prjtype'              => $this->input->post('e_prj_type'),
            ':p_type_name'            => $this->input->post('e_prj_name'),
            ':p_user_id'              => $this->session->userdata('user_id'),
        );

        $this->projecttypes_model->updatePrjType($data);
    }

    public function projecttype_delete(){
        $data = array (':p_project_type_id' => $this->input->post('projecttypeId'));
        $this->projecttypes_model->deletePrjType($data);
    }

    public function get_reqs(){
        echo json_encode($this->projecttypes_model->getReqs($this->input->post('prjtype_id')));
    }

    public function add_req(){

     $data = array(
        ':p_prjtype_id'        =>  $this->input->post('prjtype_id'),
        ':p_req_chklst'        =>  $this->input->post('req_item'),
        ':p_user_id'           =>  $this->session->userdata('user_id'),
     );
     $this->projecttypes_model->insertReq($data);

    }

    public function edit_req(){

        $data = array(
            ':p_chklst_id'    =>  $this->input->post('e_req_id'),
            ':p_req_items'    =>  $this->input->post('e_req_item'),
            ':p_user_id'      =>  $this->session->userdata('user_id'),
        );
        $this->projecttypes_model->updateReq($data);

    }

    public function delete_req(){
        $data = array(':p_chklst_id'  =>  $this->input->post('checklist_id'));
        $this->projecttypes_model->deleteReq($data);
    }

    // public function get_role_access(){
    //     echo json_encode($this->roles_model->getAccess($this->input->post('role_id')));
    // }

    public function prjtype_list(){
        echo json_encode($this->projecttypes_model->getPrjTypeList());
    }


}



