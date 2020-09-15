<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proposals extends CI_Controller {
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

    public function add_proposal(){
        $this->load->view('layout/header');
        $this->load->view('proposals/proposals_add');
        $this->load->view('layout/footer');
    }

    public function edit_proposal(){
        $id =  $this->input->post('proposalId');
        $this->load->view('layout/header');
        $this->load->view('proposals/proposals_edit',array(
            'proposals' =>  $this->proposals_model->getProposal($id)
        ));
        $this->load->view('layout/footer');
    }

    public function proposal_delete(){
        $data = array (':p_proposal_id' => $this->input->post('proposalId'));
        $this->proposals_model->deleteProposal($data);
    }

    public function proposal_list(){
        echo json_encode($this->proposals_model->getProposalList());
    }

    public function proposal_add(){
        $data = array(
            ':p_username'           => $this->input->post('username'),
            ':p_password'           => $this->input->post('password'),
            ':p_fname'              => $this->input->post('fname'),
            ':p_lname'              => $this->input->post('lname'), 
            ':p_email'              => $this->input->post('email'), 
            ':p_role_id'            => $this->input->post('role_id'), 
            ':p_session_id'            => $this->session->userdata('user_id'),
        );
        $this->proposals_model->insertProposals($data);
    }

    public function proposal_edit(){
        $options = [
            'cost' => 12,
        ];
        $data = array(
            ':p_proposal_id'            => $this->input->post('e_u_id'),
            ':p_username'           => $this->input->post('e_username'),
            ':p_password'           => password_hash($this->input->post('e_password'), PASSWORD_BCRYPT, $options),
            ':p_fname'              => $this->input->post('e_fname'), 
            ':p_lname'              => $this->input->post('e_lname'),
            ':p_email'              => $this->input->post('e_email'),
            ':p_role_id'            => $this->input->post('e_r_id'),
            ':p_session_id'         => $this->session->userdata('user_id'),
        );
        $this->proposals_model->updateProposals($data);
    }

}


