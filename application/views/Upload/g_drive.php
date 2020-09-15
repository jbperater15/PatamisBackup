<?php
$url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$url = $url_array[0];

require_once (APPPATH.'libraries/google-api-php-client/src/Google_Client.php');
require_once (APPPATH.'libraries/google-api-php-client/src/contrib/Google_DriveService.php');
require_once (APPPATH.'libraries/google-api-php-client/src/contrib/Google_Oauth2Service.php');
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

//var_dump($client->authenticate($_GET['code']));

$files= array();
$dir = dir('./file');
while ($file = $dir->read()) {
    if ($file != '.' && $file != '..') {
        $files[] = $file;
    }
}
$dir->close();
if (!empty($_POST)) {
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
}
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Google Drive Example App</title>
    </head>
    <body>
        <ul>
        <?php foreach ($files as $file) { ?>
            <li><?php echo $file; ?></li>
        <?php } ?>
        </ul>
        <form method="post" action="<?php echo $url; ?>">
            <input type="submit" value="enviar" name="submit">
        </form>
    </body>
</html>
