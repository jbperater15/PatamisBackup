<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Forms extends CI_Controller {
    //AIzaSyCM_JFNmKMPDoLQm2Bkbh9ajomhmfljuDE
    var $access='';
    function __construct(){ 
        parent::__construct(); 
        $this->load->model('forms_model');   
        $this->load->model('access_model');
        $this->access = $this->access_model->getUserAccess($this->router->fetch_class(),$this->session->userdata('user_id'));  
    } 
     
    public function index(){
        
        $this->load->view('layout/header');
        $this->load->view('forms/forms_main');
        $this->load->view('layout/footer'
            ,array(
            'create_acc'    => $this->access[0]->create_flag,
            'read_acc'      => $this->access[0]->read_flag,
            'update_acc'    => $this->access[0]->update_flag,
            'delete_acc'    => $this->access[0]->delete_flag,
        )
    );
    }

    public function add_form(){
        $this->load->view('layout/header');
        $this->load->view('forms/forms_add');
        $this->load->view('layout/footer'
            ,array(
            'create_acc'    => $this->access[0]->create_flag,
            'read_acc'      => $this->access[0]->read_flag,
            'update_acc'    => $this->access[0]->update_flag,
            'delete_acc'    => $this->access[0]->delete_flag,
        )
        );
    }

    public function edit_form(){
        $id =  $this->input->post('formId');
        $this->load->view('layout/header');
        $this->load->view('forms/form_edit',array(
            'forms' =>  $this->forms_model->getForm($id)
        ));
        $this->load->view('layout/footer'
            ,array(
            'create_acc'    => $this->access[0]->create_flag,
            'read_acc'      => $this->access[0]->read_flag,
            'update_acc'    => $this->access[0]->update_flag,
            'delete_acc'    => $this->access[0]->delete_flag,
        )
        );
    }

    public function form_delete(){
        $data = array (':p_form_id' => $this->input->post('formId'));
        $this->forms_model->deleteForm($data);
    }

    public function form_list(){
        echo json_encode($this->forms_model->getFormList());
    }

    public function form_add(){
        $data = array(
            ':p_form_code'          => $this->input->post('f_code'),
            ':p_form_name'          => $this->input->post('f_name'),
            ':p_form_description'   => $this->input->post('f_desc'),
            ':p_user_id'            => $this->session->userdata('user_id'),
        );
        $this->forms_model->insertForms($data);
    }

    public function form_edit(){
        $data = array(
            ':p_form_id'            => $this->input->post('e_f_id'),
            ':p_form_code'          => $this->input->post('e_f_code'),
            ':p_form_name'          => $this->input->post('e_f_name'),
            ':p_form_description'   => $this->input->post('e_f_desc'),
            ':p_user_id'            => $this->session->userdata('user_id'),
        );
        $this->forms_model->updateForms($data);
    }

}


