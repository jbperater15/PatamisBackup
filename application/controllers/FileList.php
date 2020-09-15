<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once (APPPATH.'libraries/google-api-php-client/src/Google_Client.php');
require_once (APPPATH.'libraries/google-api-php-client/src/contrib/Google_DriveService.php');

class Filelist extends CI_Controller {
    
    function __construct(){ 
        parent::__construct(); 

        $this->load->model('users_model');
         
    } 
     
    public function index()
    {
        $url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        $url = $url_array[0];
        $client = new Google_Client();
        $client->setClientId('863284018800-kt6vu2rsmolcgri8a8f6fsjaj3a0tq68.apps.googleusercontent.com');
        $client->setClientSecret('8sJoFcVoDyEDKjm0P8H8Jq9s');
        $client->setRedirectUri($url);
        $client->setScopes(array('https://www.googleapis.com/auth/drive','https://www.googleapis.com/auth/drive.file','https://www.googleapis.com/auth/drive.appdata','https://docs.google.com/feeds','https://spreadsheets.google.com/feeds'));
        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $_SESSION['token'] = $client->getAccessToken();
            //header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
          }
          if (isset($_SESSION['token'])) {
            $client->setAccessToken($_SESSION['token']);
          }
        $service = new Google_DriveService($client);
        
        //$parameters['q'] = "mimeType!='application/vnd.google-apps.folder' and trashed=false and parents='1_j-tnQY_7rFGVuv4QvlLu9-VzktuM7sC'";
        $parameters['q'] = "trashed=false and parents='1_j-tnQY_7rFGVuv4QvlLu9-VzktuM7sC'";
        $files = $service->files->listFiles($parameters);
              
         foreach ($files['items'] as $item) {
             //echo $item['alternateLink'].'<br>';
            echo '<tr><td><img src="'. $item['iconLink'] .'"/><a href="'. $item['alternateLink'] .'"> '. $item['title'] .' id = '. $item['id'] .'.</a></td></tr><button>try</button><br>';

        }

        /*$fileId = '1fSyA3r6Qo6UPadeJDQbwGDWDCqNRYGum';
        $response = $service->files->get($fileId, array(
            'alt' => 'media'));
        $content = $response->getBody()->getContents();*/
       
    }

    
}


