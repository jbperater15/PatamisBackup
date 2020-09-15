<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Roles extends CI_Controller {
    //AIzaSyCM_JFNmKMPDoLQm2Bkbh9ajomhmfljuDE

    var $access='';

    function __construct(){ 
        parent::__construct(); 
        $this->load->model('roles_model');  
        $this->load->model('access_model');
        $this->access = $this->access_model->getUserAccess($this->router->fetch_class(),$this->session->userdata('user_id')); 
    } 
     

     
    public function index(){

        $access = $this->access_model->getUserAccess('ROLES',$this->session->userdata('user_id')); 

        $this->load->view('layout/header');
        $this->load->view('roles/roles_main');
        $this->load->view('layout/footer',array(
            'create_acc'    => $this->access[0]->create_flag,
            'read_acc'      => $this->access[0]->read_flag,
            'update_acc'    => $this->access[0]->update_flag,
            'delete_acc'    => $this->access[0]->delete_flag,
        ));

    }

    public function add_role(){
        $this->load->view('layout/header');
        $this->load->view('roles/roles_add');
        $this->load->view('roles/roles_modal');
        $this->load->view('layout/footer',array(
            'create_acc'    => $this->access[0]->create_flag,
            'read_acc'      => $this->access[0]->read_flag,
            'update_acc'    => $this->access[0]->update_flag,
            'delete_acc'    => $this->access[0]->delete_flag,
        ));
    }

    public function edit_role(){
        $this->load->view('layout/header');
        $this->load->view('roles/roles_edit',array(
            'roles' =>  $this->roles_model->getRole($this->input->post('roleId'))
        ));
        $this->load->view('roles/roles_modal');
        $this->load->view('layout/footer',array(
            'create_acc'    => $this->access[0]->create_flag,
            'read_acc'      => $this->access[0]->read_flag,
            'update_acc'    => $this->access[0]->update_flag,
            'delete_acc'    => $this->access[0]->delete_flag,
        ));
    }

    public function role_add(){
        $data = array(
            ':p_role_code'          => $this->input->post('r_code'),
            ':p_role_name'          => $this->input->post('r_name'),
            ':p_role_description'   => $this->input->post('r_desc'),
            ':p_user_id'            => $this->session->userdata('user_id'),
        );
        $this->roles_model->insertRoles($data);
    }

    public function role_edit(){
        $data = array(
            ':p_role_id'            => $this->input->post('e_r_id'),
            ':p_role_code'          => $this->input->post('e_r_code'),
            ':p_role_name'          => $this->input->post('e_r_name'),
            ':p_role_description'   => $this->input->post('e_r_desc'),
            ':p_user_id'            => $this->session->userdata('user_id'),
        );

        $this->roles_model->updateRoles($data);
    }

    public function role_delete(){
        $data = array (':p_role_id' => $this->input->post('roleId'));
        $this->roles_model->deleteRole($data);
    }

    public function get_forms(){
        echo json_encode($this->roles_model->getForms($this->input->post('role_id')));
    }

    public function add_role_access(){

     $data = array(
        ':p_role_id'        =>  $this->input->post('role_id'),
        ':p_form_id'        =>  $this->input->post('form_id'),
        ':p_create_flag'    =>  ($this->input->post('create_cb') == '' ? 'N' : 'Y'),
        ':p_read_flag'      =>  ($this->input->post('read_cb')   == '' ? 'N' : 'Y'),
        ':p_update_flag'    =>  ($this->input->post('update_cb') == '' ? 'N' : 'Y'),
        ':p_delete_flag'    =>  ($this->input->post('delete_cb') == '' ? 'N' : 'Y'),
        ':p_user_id'        =>  $this->session->userdata('user_id'),
     );
     $this->roles_model->insertRoleAccess($data);

    }

    public function edit_role_access(){

        $data = array(
            ':p_role_acc_id'    =>  $this->input->post('e_role_acc_id'),
            ':p_create_flag'    =>  ($this->input->post('e_create_cb') == '' ? 'N' : 'Y'),
            ':p_read_flag'      =>  ($this->input->post('e_read_cb')   == '' ? 'N' : 'Y'),
            ':p_update_flag'    =>  ($this->input->post('e_update_cb') == '' ? 'N' : 'Y'),
            ':p_delete_flag'    =>  ($this->input->post('e_delete_cb') == '' ? 'N' : 'Y'),
            ':p_user_id'        =>  $this->session->userdata('user_id'),
        );
        $this->roles_model->updateRoleAccess($data);

    }

    public function delete_role_access(){
        $data = array(':p_role_acc_id'  =>  $this->input->post('role_acc_id'));
        $this->roles_model->deleteRoleAccess($data);
    }

    public function get_role_access(){
        echo json_encode($this->roles_model->getAccess($this->input->post('role_id')));
    }

    public function role_list(){
        echo json_encode($this->roles_model->getRoleList());
    }


}


