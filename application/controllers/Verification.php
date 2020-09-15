<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once (APPPATH.'libraries/google-api-php-client/src/Google_Client.php');
require_once (APPPATH.'libraries/google-api-php-client/src/contrib/Google_DriveService.php');

class Verification extends CI_Controller {
    
    function __construct(){ 
        parent::__construct(); 

        
         
    } 
     
    public function index()
    {
        $this->load->view('layout/header');
        $this->load->view('verification/verification');
        $this->load->view('layout/footer');
    }

    
}


