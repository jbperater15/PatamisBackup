<?php
   require_once (APPPATH.'libraries/google-api-php-client/src/Google_Client.php');
   require_once (APPPATH.'libraries/google-api-php-client/src/contrib/Google_DriveService.php');
   require_once (APPPATH.'libraries/google-api-php-client/src/contrib/Google_CalendarService.php');
   class Upload extends CI_Controller {
  
      public function __construct() { 
         parent::__construct(); 
         $this->load->helper("file");
      }
    
      public function index() { 
        $this->load->view('layout/header');
        //$this->load->view('upload/upload_form', array('error' => ' ' ));
        $this->load->view('upload/form_upload.php', array('error' => ' ' )); 
        $this->load->view('layout/footer');
        //$this->load->view('upload/g_drive.php', array('error' => ' ' )); 
        //$this->calendar();
        
      } 
      
    
      public function do_upload() { 
         $config['upload_path']   = '././file/'; 
         $config['allowed_types'] = '*'; //'gif|jpg|png'; 
         $config['max_size']      = 204800; 
         $config['max_width']     = 1024; 
         $config['max_height']    = 768;  
         $this->load->library('upload', $config);
      
         if ( ! $this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors()); 
            $this->load->view('upload/upload_form', $error); 
         }
      
         else { 
            //$data = array('upload_data' => $this->upload->data()); 
            $data['upload_data'] =  $this->upload->data(); 
            $name =  $this->upload->data(); 
            $file_name = $name['file_name'];
            var_dump($file_name);
            //$this->g_upload();

            $url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            $url = $url_array[0];

           
            $client = new Google_Client();
            $client->setClientId('863284018800-kt6vu2rsmolcgri8a8f6fsjaj3a0tq68.apps.googleusercontent.com');
            $client->setClientSecret('8sJoFcVoDyEDKjm0P8H8Jq9s');
            $client->setRedirectUri($url);
            $client->setScopes(array('https://www.googleapis.com/auth/drive'));
            $service = new Google_DriveService($client);
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $files= array();
            $dir = dir('./file');
            while ($file = $dir->read()) {
                if ($file != '.' && $file != '..') {
                    $files[] = $file;
                }
            }
            $dir->close();

            if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $_SESSION['token'] = $client->getAccessToken();
            header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
            }

            if (isset($_SESSION['token'])) {
              $client->setAccessToken($_SESSION['token']);
            }

            if ($client->getAccessToken()) {
              $file = new Google_DriveFile();
                foreach ($files as $file_name) {
                    $file_path = './file/'.$file_name;
                    $mime_type = finfo_file($finfo, $file_path);
                    $file->setTitle($file_name);
                    $file->setDescription('This is a '.$mime_type.' document');
                    $file->setMimeType($mime_type);
                    $parent = new Google_ParentReference();
                    $parent->setId('1_j-tnQY_7rFGVuv4QvlLu9-VzktuM7sC');
                    $file->setParents(array($parent));
                    echo $mime_type.'1 <br>';
                    $service->files->insert(
                        $file,
                        array(
                            'data' => file_get_contents($file_path),
                            'mimeType' => $mime_type
                        )
                    );
                }
                finfo_close($finfo);

                   //header('location:'.$url);exit;
                foreach ($files as $file_name) {
                   echo $file_name;
                   
                   $path = '././file/';
                   delete_files($path);
                 }
                $this->load->view('upload/upload_success', $data); 
              $_SESSION['token'] = $client->getAccessToken();
            } else {
              var_dump($client->getAccessToken());
              $authUrl = $client->createAuthUrl();
              print "<a class='login' href='$authUrl'>Connect Me!</a>";
            }   
         } 
      }

      public function do_upload_bak() { 
         $config['upload_path']   = '././file/'; 
         $config['allowed_types'] = '*'; //'gif|jpg|png'; 
         $config['max_size']      = 204800; 
         $config['max_width']     = 1024; 
         $config['max_height']    = 768;  
         $this->load->library('upload', $config);
      
         if ( ! $this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors()); 
            $this->load->view('upload/upload_form', $error); 
         }
      
         else { 
            //$data = array('upload_data' => $this->upload->data()); 
            $data['upload_data'] =  $this->upload->data(); 
            $name =  $this->upload->data(); 
            $file_name = $name['file_name'];
            var_dump($file_name);
            //$this->g_upload();

            $url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            $url = $url_array[0];

           
            $client = new Google_Client();
            $client->setClientId('863284018800-kt6vu2rsmolcgri8a8f6fsjaj3a0tq68.apps.googleusercontent.com');
            $client->setClientSecret('8sJoFcVoDyEDKjm0P8H8Jq9s');
            $client->setRedirectUri($url);
            $client->setScopes(array('https://www.googleapis.com/auth/drive'));
            if (isset($_GET['code'])) {
                $_SESSION['accessToken'] = $client->authenticate($_GET['code']);
                header('location:'.$url);exit;
            } elseif (!isset($_SESSION['accessToken'])) {
                $client->authenticate();
            }
            var_dump(isset($_GET['code']));
            var_dump(!isset($_SESSION['accessToken']));
            var_dump($_SESSION['accessToken']);
            var_dump($client->authenticate($_POST['code']));
            $files= array();
            $dir = dir('./file');
            while ($file = $dir->read()) {
                if ($file != '.' && $file != '..') {
                    $files[] = $file;
                }
            }
            $dir->close();
            
                $client->setAccessToken($_SESSION['accessToken']);
                $service = new Google_DriveService($client);
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $file = new Google_DriveFile();
                foreach ($files as $file_name) {
                    $file_path = './file/'.$file_name;
                    $mime_type = finfo_file($finfo, $file_path);
                    $file->setTitle($file_name);
                    $file->setDescription('This is a '.$mime_type.' document');
                    $file->setMimeType($mime_type);
                    $parent = new Google_ParentReference();
                    $parent->setId('1_j-tnQY_7rFGVuv4QvlLu9-VzktuM7sC');
                    $file->setParents(array($parent));
                    echo $mime_type.'1 <br>';
                    $service->files->insert(
                        $file,
                        array(
                            'data' => file_get_contents($file_path),
                            'mimeType' => $mime_type
                        )
                    );
                }
                finfo_close($finfo);
            
                //header('location:'.$url);exit;
             foreach ($files as $file_name) {
               echo $file_name;
               
               $path = '././file/';
               delete_files($path);
             }
            $this->load->view('upload/upload_success', $data); 
         } 
      } 

      public function g_upload(){
         
            $url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            $url = $url_array[0];

           
            $client = new Google_Client();
            $client->setClientId('863284018800-kt6vu2rsmolcgri8a8f6fsjaj3a0tq68.apps.googleusercontent.com');
            $client->setClientSecret('8sJoFcVoDyEDKjm0P8H8Jq9s');
            $client->setRedirectUri($url);
            $client->setScopes(array('https://www.googleapis.com/auth/drive'));
            if (isset($_GET['code'])) {
                $_SESSION['accessToken'] = $client->authenticate($_GET['code']);
                header('location:'.$url);exit;
            } elseif (!isset($_SESSION['accessToken'])) {
                $client->authenticate();
            }
            $files= array();
            $dir = dir('./file');
            while ($file = $dir->read()) {
                if ($file != '.' && $file != '..') {
                    $files[] = $file;
                }
            }
            $dir->close();
            
                $client->setAccessToken($_SESSION['accessToken']);
                $service = new Google_DriveService($client);
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $file = new Google_DriveFile();
                foreach ($files as $file_name) {
                    $file_path = './file/'.$file_name;
                    $mime_type = finfo_file($finfo, $file_path);
                    $file->setTitle($file_name);
                    $file->setDescription('This is a '.$mime_type.' document');
                    $file->setMimeType($mime_type);
                    $parent = new Google_ParentReference();
                    $parent->setId('1_j-tnQY_7rFGVuv4QvlLu9-VzktuM7sC');
                    $file->setParents(array($parent));
                    echo $mime_type.'1 <br>';
                    $service->files->insert(
                        $file,
                        array(
                            'data' => file_get_contents($file_path),
                            'mimeType' => $mime_type
                        )
                    );
                }
                finfo_close($finfo);
            
                //header('location:'.$url);exit;
             foreach ($files as $file_name) {
               echo $file_name;
               
               $path = '././file/';
               delete_files($path);
             }
        }

        function calendar(){
          $jobname = "TEST";
          $joblocation = "Your mums house";
          $jobdescription = "An interview with a dog.";
          $startofjob = "2020-08-19T08:00:00.000+08:00"; //datetimes must be in this format
          $endofjob = "2020-08-19T09:00:00.000+08:00"; // YYYY-MM-DDTHH:MM:SS.MMM+HH:MM
          //So that's year, month, day, the letter T, hours, minutes, seconds, miliseconds, + or -, timezoneoffset in hours and minutes

          $url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
          $url = $url_array[0];
          $client = new Google_Client();
          $client->setApplicationName('patamis');
          $client->setClientId('863284018800-kt6vu2rsmolcgri8a8f6fsjaj3a0tq68.apps.googleusercontent.com');
          $client->setClientSecret('8sJoFcVoDyEDKjm0P8H8Jq9s');
          $client->setRedirectUri($url);
          //$client->setDeveloperKey('yourdeveloperkey');
          $cal = new Google_CalendarService($client);

          if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $_SESSION['token'] = $client->getAccessToken();
            header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
          }

          if (isset($_SESSION['token'])) {
            $client->setAccessToken($_SESSION['token']);
          }

          if ($client->getAccessToken()) {
            $event = new Google_Event();
          $event->setSummary($jobname);
          $event->setDescription($jobdescription);
          $event->setLocation($joblocation);
          $start = new Google_EventDateTime();
          $start->setDateTime($startofjob);
          $event->setStart($start);
          $end = new Google_EventDateTime();
          $end->setDateTime($endofjob);
          $event->setEnd($end);

          $createdEvent = $cal->events->insert('mis@region10.dost.gov.ph', $event);
          var_dump($createdEvent);


          $_SESSION['token'] = $client->getAccessToken();
          } else {
            $authUrl = $client->createAuthUrl();
            print "<a class='login' href='$authUrl'>Connect Me!</a>";
          }
        }

        function up_calendar(){
          $title = $this->input->post('title');
          $location = $this->input->post('location');
          $description = $this->input->post('description');
          $time_start = $this->input->post('date')."T".$this->input->post('time_start').":00.000+08:00"; //"2020-08-19T08:00:00.000+08:00"; datetimes must be in this format
          echo $this->input->post('date');
          echo $time_start;
          $time_end =$this->input->post('date')."T".$this->input->post('time_end').":00.000+08:00"; 
          echo $time_end;
          //"2020-08-19T09:00:00.000+08:00";YYYY-MM-DDTHH:MM:SS.MMM+HH:MM
          //So that's year, month, day, the letter T, hours, minutes, seconds, miliseconds, + or -, timezoneoffset in hours and minutes

          $url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
          $url = $url_array[0];

          $client = new Google_Client();
          $client->setApplicationName('patamis');
          $client->setClientId('863284018800-kt6vu2rsmolcgri8a8f6fsjaj3a0tq68.apps.googleusercontent.com');
          $client->setClientSecret('8sJoFcVoDyEDKjm0P8H8Jq9s');
          $client->setScopes(array('https://www.googleapis.com/auth/drive','https://www.googleapis.com/auth/calendar'));



          $client->setRedirectUri($url);
          //$client->setDeveloperKey('yourdeveloperkey');
          $cal = new Google_CalendarService($client);
          $client->createAuthUrl();
          if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $_SESSION['token'] = $client->getAccessToken();
            header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
          }

          if (isset($_SESSION['token'])) {
            $client->setAccessToken($_SESSION['token']);
          }

          if ($client->getAccessToken()) {
            $event = new Google_Event();
          $event->setSummary($title);
          $event->setDescription($description);
          $event->setLocation($location);
          $start = new Google_EventDateTime();
          $start->setDateTime($time_start);
          $event->setStart($start);
          $end = new Google_EventDateTime();
          $end->setDateTime($time_end);
          $event->setEnd($end);

          $createdEvent = $cal->events->insert('mis@region10.dost.gov.ph', $event);
          var_dump($createdEvent);


          $_SESSION['token'] = $client->getAccessToken();
          } else {
            $authUrl = $client->createAuthUrl();
            print "<a class='login' href='$authUrl'>Connect Me!</a>";
          }
        }


        function files_to(){
          $url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
          $url = $url_array[0];

          $data_ni = $_FILES['userfile']['tmp_name'];//$this->input->post('userfile');

          var_dump($data_ni);
          $client = new Google_Client();
          $client->setClientId('863284018800-kt6vu2rsmolcgri8a8f6fsjaj3a0tq68.apps.googleusercontent.com');
          $client->setClientSecret('8sJoFcVoDyEDKjm0P8H8Jq9s');
          $client->setRedirectUri($url);
          $client->setScopes(array('https://www.googleapis.com/auth/drive','https://www.googleapis.com/auth/calendar'));

          $file = new Google_DriveFile();

          if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $_SESSION['token'] = $client->getAccessToken();
            header('Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']);
          }
            echo( $_SERVER['HTTP_HOST'] . ' this' . $_SERVER['PHP_SELF'] . ' ');
          if (isset($_SESSION['token'])) {
            $client->setAccessToken($_SESSION['token']);
          }

          //var_dump($client->authenticate($_GET['code']));
          if ($client->getAccessToken()) {
         $mime_type = $_FILES['userfile']['type'];
         $file_name = explode('.', $_FILES['userfile']['name']) ;
         var_dump($file_name);
          
              $client->setAccessToken($_SESSION['token']);
              $service = new Google_DriveService($client);
              $finfo = finfo_open(FILEINFO_MIME_TYPE);
              $file = new Google_DriveFile();
              
                  //$file_path = './file/'.$file_name;
                  //$mime_type = finfo_file($finfo, $file_path);
                  $file->setTitle($file_name);
                  $file->setDescription('This is a '.$mime_type.' document');
                  $file->setMimeType($mime_type);
                  $parent = new Google_ParentReference();
                  $parent->setId('1_j-tnQY_7rFGVuv4QvlLu9-VzktuM7sC');
                  $file->setParents(array($parent));
                  echo $mime_type.'1 <br>';
                  $service->files->insert(
                      $file,
                      array(
                          'data' => file_get_contents($data_ni),
                          'mimeType' => $mime_type
                      )
                  );
              finfo_close($finfo);
              //header('location:'.$url);exit;
              redirect('/filelist');
          }else {
            $authUrl = $client->createAuthUrl();
            print "<a class='login' href='$authUrl'>Connect Me!</a>";
          }
        }

        function getMimeType() {
          $file = $this->input->post('userfile');
          $contentType = $_FILES['userfile']['type'];
          echo $contentType;
         $mtype = false;
          if (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mtype = finfo_file($finfo, $file);
            finfo_close($finfo);
          } elseif (function_exists('mime_content_type')) {
            $mtype = mime_content_type($file);
          } 
          return $mtype;
}
     
     
   }
?>