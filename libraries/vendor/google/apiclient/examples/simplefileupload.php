<?php
/*
 * Copyright 2011 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
include_once "templates/base.php";
session_start();

require_once realpath(dirname(__FILE__) . '/../src/Google/autoload.php');
include_once  APPPATH."libraries/Curl.php";
echo  APPPATH."libraries/Curl.php";

/* * **********************************************
  We'll setup an empty 1MB file to upload.
 * ********************************************** */
//dirname(__FILE__);
DEFINE("TESTFILE", '/home/nexibms/public_html/tms/img/logo.png');
if (!file_exists(TESTFILE)) {
    $fh = fopen(TESTFILE, 'w');
    fseek($fh, 1024 * 1024);
    fwrite($fh, "!", 1);
    fclose($fh);
}

/* * **********************************************
  ATTENTION: Fill in these values! Make sure
  the redirect URI is to this page, e.g:
  http://localhost:8080/fileupload.php
 * ********************************************** */

//client id  322869322943-49ril63nd0pocoespfhnefa52qcun2t9.apps.googleusercontent.com

$client_id = '322869322943-49ril63nd0pocoespfhnefa52qcun2t9.apps.googleusercontent.com';
$client_secret = 'vjpkA5igLIDF3bVgqVwIlcKC';
$redirect_uri = 'http://tms.nexibms.in/tms/google_drive/';

$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("https://www.googleapis.com/auth/drive");
$service = new Google_Service_Drive($client);

if (isset($_REQUEST['logout'])) {
    unset($_SESSION['upload_token']);
}

if (isset($_GET['code'])) {
    $client->authenticate($_GET['code']);
    $_SESSION['upload_token'] = $client->getAccessToken();
    $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
    //echo 'hello';
    header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['upload_token']) && $_SESSION['upload_token']) {
    $client->setAccessToken($_SESSION['upload_token']);
    if ($client->isAccessTokenExpired()) {
        unset($_SESSION['upload_token']);
    }
} else {
    $authUrl = $client->createAuthUrl();
     $cont = new Curl();
    $cont->create($authUrl);

//  To Temporarily Store Data Received From Server
    $cont->option('buffersize', 10);

//  To support Different Browsers
    $cont->option('useragent', 'Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.8) Gecko/20100722 Firefox/3.6.8 (.NET CLR 3.5.30729)');

//  To Receive Data Returned From Server
    $cont->option('returntransfer', 1);

//  To follow The URL Provided For Website
    $cont->option('followlocation', 1);

//  To Retrieve Server Related Data
    $cont->option('HEADER', true);

//  To Set Time For Process Timeout
    $cont->option('connecttimeout', 600);

//  To Execute 'option' Array Into cURL Library & Store Returned Data Into $data
    $data = $cont->execute();

//  To Display Returned Data
    echo $data;
    die();
    //curl
    //echo file_get_contents($authUrl);
}

/* * **********************************************
  If we're signed in then lets try to upload our
  file. For larger files, see fileupload.php.
 * ********************************************** */
if ($client->getAccessToken()) {
    // This is uploading a file directly, with no metadata associated.
    $file = new Google_Service_Drive_DriveFile();
    $result = $service->files->insert(
            $file, array(
        'data' => file_get_contents(TESTFILE),
        'mimeType' => 'application/octet-stream',
        'uploadType' => 'media'
            )
    );

    // Now lets try and send the metadata as well using multipart!
    $file = new Google_Service_Drive_DriveFile();
    $file->setTitle("Hello World!");
    $result2 = $service->files->insert(
            $file, array(
        'data' => file_get_contents(TESTFILE),
        'mimeType' => 'application/octet-stream',
        'uploadType' => 'multipart'
            )
    );
}

echo pageHeader("File Upload - Uploading a small file");
if (strpos($client_id, "googleusercontent") == false) {
    echo missingClientSecretsWarning();
    exit;
}
?>
<div class="box">
    <div class="request">
        <?php
        if (isset($authUrl)) {
            header('Location: ' . $authUrl);
            echo "<a class='login' href='" . $authUrl . "'>Connect Me!</a>";
        }
        ?>
    </div>

    <div class="shortened">
        <?php
        if (isset($result) && $result) {

            print_r($result);

            print_r($result2);

            var_dump($result->title);
            var_dump($result2->title);
        }
        ?>
    </div>
</div>
<?php
//echo pageFooter(__FILE__);
