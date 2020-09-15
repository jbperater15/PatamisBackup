<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    //AIzaSyCM_JFNmKMPDoLQm2Bkbh9ajomhmfljuDE
    var $access='';
    function __construct(){ 
        parent::__construct(); 
        $this->load->model('users_model');   
    } 
     
    public function index(){
        
        $this->load->view('layout/header');
        $this->load->view('users/users_main');
        $this->load->view('layout/footer');
    }

    public function add_user(){
        $this->load->view('layout/header');
        $this->load->view('users/users_add');
        $this->load->view('layout/footer');
    }

    public function edit_user(){
        $id =  $this->input->post('userId');
        $this->load->view('layout/header');
        $this->load->view('users/users_edit',array(
            'users' =>  $this->users_model->getUser($id)
        ));
        $this->load->view('layout/footer');
    }

    public function user_delete(){
        $data = array (':p_user_id' => $this->input->post('userId'));
        $this->users_model->deleteUser($data);
    }

    public function user_list(){
        echo json_encode($this->users_model->getUserList());
    }

    public function user_add(){
        $data = array(
            ':p_username'           => $this->input->post('username'),
            ':p_password'           => $this->input->post('password'),
            ':p_fname'              => $this->input->post('fname'),
            ':p_lname'              => $this->input->post('lname'), 
            ':p_email'              => $this->input->post('email'), 
            ':p_role_id'            => $this->input->post('role_id'), 
            ':p_session_id'            => $this->session->userdata('user_id'),
        );
        $this->users_model->insertUsers($data);
    }

    public function user_edit(){
        $options = [
            'cost' => 12,
        ];
        $data = array(
            ':p_user_id'            => $this->input->post('e_u_id'),
            ':p_username'           => $this->input->post('e_username'),
            ':p_password'           => password_hash($this->input->post('e_password'), PASSWORD_BCRYPT, $options),
            ':p_fname'              => $this->input->post('e_fname'), 
            ':p_lname'              => $this->input->post('e_lname'),
            ':p_email'              => $this->input->post('e_email'),
            ':p_role_id'            => $this->input->post('e_r_id'),
            ':p_session_id'         => $this->session->userdata('user_id'),
        );
        $this->users_model->updateUsers($data);
    }

}


