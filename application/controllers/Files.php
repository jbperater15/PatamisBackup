<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once (APPPATH.'libraries/google-api-php-client/src/Google_Client.php');
require_once (APPPATH.'libraries/google-api-php-client/src/contrib/Google_DriveService.php');

class Files extends CI_Controller {
    
    function __construct(){ 
        parent::__construct(); 
                
    }
  
    public function index(){

        $this->load->view('layout/header');
        $url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        $url = $url_array[0];
        $client = new Google_Client();
        $client->setClientId('863284018800-kt6vu2rsmolcgri8a8f6fsjaj3a0tq68.apps.googleusercontent.com');
        $client->setClientSecret('8sJoFcVoDyEDKjm0P8H8Jq9s');
        $client->setRedirectUri($url);
        $client->setScopes(array('https://www.googleapis.com/auth/drive','https://www.googleapis.com/auth/drive.file','https://www.googleapis.com/auth/drive.appdata','https://docs.google.com/feeds','https://spreadsheets.google.com/feeds','https://www.googleapis.com/auth/calendar'));

        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $_SESSION['token'] = $client->getAccessToken();
            //header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
          }
          if (isset($_SESSION['token'])) {
            $client->setAccessToken($_SESSION['token']);
          }
        if ($client->getAccessToken()){
          $service = new Google_DriveService($client);
          $parameters['q'] = "mimeType='application/vnd.google-apps.folder' and trashed=false and parents='1_j-tnQY_7rFGVuv4QvlLu9-VzktuM7sC'";
          //$parameters['q'] = "trashed=false and parents='1_j-tnQY_7rFGVuv4QvlLu9-VzktuM7sC'";
          $files['files'] = $service->files->listFiles($parameters);
          //$this->load->view('Files/files', $files);
          var_dump($files['files']);
          $this->load->view('Files/datatable', $files);
          $this->load->view('layout/footer');
      }else{
          $authUrl = $client->createAuthUrl();
          print "<a class='login' href='$authUrl'>Connect Me!</a>";
      }
        
    }  

    function files(){
      //$this->load->view('layout/header');
      $url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
      $url = $url_array[0];
      $client = new Google_Client();
      $client->setClientId('863284018800-kt6vu2rsmolcgri8a8f6fsjaj3a0tq68.apps.googleusercontent.com');
      $client->setClientSecret('8sJoFcVoDyEDKjm0P8H8Jq9s');
      $client->setRedirectUri($url);
      $client->setScopes(array('https://www.googleapis.com/auth/drive','https://www.googleapis.com/auth/drive.file','https://www.googleapis.com/auth/drive.appdata','https://docs.google.com/feeds','https://spreadsheets.google.com/feeds','https://www.googleapis.com/auth/calendar'));
      if (isset($_GET['code'])) {
          $client->authenticate($_GET['code']);
          $_SESSION['token'] = $client->getAccessToken();
          //header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
        }
        if (isset($_SESSION['token'])) {
          $client->setAccessToken($_SESSION['token']);
        }

      if ($client->getAccessToken()){
          $service = new Google_DriveService($client);
          $parameters['q'] = "mimeType         ='application/vnd.google-apps.folder' and trashed=false and parents='1_j-tnQY_7rFGVuv4QvlLu9-VzktuM7sC'";
          //$parameters['q'] = "trashed=false and parents='1_j-tnQY_7rFGVuv4QvlLu9-VzktuM7sC'";
          $files = $service->files->listFiles($parameters);
          //$this->load->view('Files/files', $files);
          $this->load->view('layout/footer');
          //return($service->files->listFiles($parameters));
      }else{
          $authUrl = $client->createAuthUrl();
          print "<a class='login' href='$authUrl'>Connect Me!</a>";
      }

     /* $draw = intval($this->input->get("draw"));
      $start = intval($this->input->get("start"));
      $length = intval($this->input->get("length"));


      $data = [];


      foreach($files['items'] as $r) {
           $data[] = array(
                '<img src="'.$r['iconLink'].'">',
                $r['alternateLink'],
                $r['title']
           );
      }


      $result = array(
               "draw" => $draw,
                 "recordsTotal" => count($files),
                 "recordsFiltered" => count($files),
                 "data" => $data
            );


      echo json_encode($result);
      exit();*/
      
    }

    function folderlist(){
      $parent=$this->uri->segment(3); 
      var_dump($parent);
      $this->load->view('layout/header');
        $url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        $url = $url_array[0];
        $client = new Google_Client();
        $client->setClientId('863284018800-kt6vu2rsmolcgri8a8f6fsjaj3a0tq68.apps.googleusercontent.com');
        $client->setClientSecret('8sJoFcVoDyEDKjm0P8H8Jq9s');
        $client->setRedirectUri($url);
        $client->setScopes(array('https://www.googleapis.com/auth/drive','https://www.googleapis.com/auth/calendar'));

        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $_SESSION['token'] = $client->getAccessToken();
            //header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
          }
          if (isset($_SESSION['token'])) {
            $client->setAccessToken($_SESSION['token']);
          }
        if ($client->getAccessToken()){
          $service = new Google_DriveService($client);
          $parameters['q'] = "mimeType!='application/vnd.google-apps.folder' and trashed=false and parents='$parent'";
          //$parameters['q'] = "trashed=false and parents='1_j-tnQY_7rFGVuv4QvlLu9-VzktuM7sC'";
          $files['files'] = $service->files->listFiles($parameters);
          //$this->load->view('Files/files', $files);
          //var_dump($files['files']);
          $this->load->view('Files/datatable', $files);
          $this->load->view('layout/footer');
      }else{
          $authUrl = $client->createAuthUrl();
          print "<a class='login' href='$authUrl'>Connect Me!</a>";
      }

    }

    
}