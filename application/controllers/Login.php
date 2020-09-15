<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    //AIzaSyCM_JFNmKMPDoLQm2Bkbh9ajomhmfljuDE
    function __construct(){ 
        parent::__construct(); 

        $this->load->model('users_model');
         
    } 
     
    public function index()
    {
        require_once 'vendor/autoload.php';
        $redirectUri = base_url();
        // create Client Request to access Google API
        $client = new Google_Client();
        $client->setAuthConfigFile($_SERVER['DOCUMENT_ROOT'].'\patamis\client_credentials.json');
        // $client->setAuthConfigFile('C:\xampp\htdocs\patamis\client_credentials.json');
         $client->setRedirectUri($redirectUri);
        //  Set the scopes required for the API you are going to call
        $client->addScope("email");
        $client->addScope("profile");

// authenticate code from Google OAuth Flow
        if (isset($_GET['code'])) {
            $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

            $this->_accessToken = [
                'access_token'  => $token['access_token'],
                'expires_in'    => $token['expires_in'],
            ];

            $client->setAccessToken($this->_accessToken);
            $google_oauth = new Google_Service_Oauth2($client);
            $google_account_info = $google_oauth->userinfo->get();

            echo $google_account_info->email;

            // now you can use this profile info to create account in your website and make user logged in.
        } else {
            $this->load->view('layout/header');
            $this->load->view('login', array(
                'loginUrl'  => $client->createAuthUrl()
            ));
            $this->load->view('layout/footer');
        }
    }

    public function req_login(){
        $data = array(
            'user_name' => filter_var($this->input->post('uname'), FILTER_SANITIZE_STRING),
            'password'  => filter_var($this->input->post('pass'), FILTER_SANITIZE_STRING),
        );

        $q = $this->users_model->login($data);
        if (!empty($q)) {

            foreach ($q as $key) {
                if (password_verify($data['password'], $key->password) == true) {                    
                    $this->session->set_userdata(array(
                        'logged_in'    => 1,
                        'username'     => $key->username,
                        'user_id'      => $key->user_id
                    ));
                    echo json_encode(array('msg' => 'success'));
                } else {
                    echo json_encode(array('msg' => 'invalid username/password.'));
                }
            }
        }else{
            echo json_encode(array('msg' => 'invalid username/password.'));
        }
    }

    public function check_session(){
        $controller = $this->router->fetch_class();
        $this->load->view('layout/header');
        $this->load->view('dashboard',array(
            'controller'    =>  $controller
        ));
        $this->load->view('layout/footer');
    }

}


