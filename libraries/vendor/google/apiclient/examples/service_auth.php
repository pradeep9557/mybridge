<?php

/*
 * Copyright 2013 Google Inc.
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
session_start();
include_once "templates/base.php";

/* * **********************************************
  Make an API request authenticated with a service
  account.
 * ********************************************** */
require_once realpath(dirname(__FILE__) . '/../src/Google/autoload.php');

/* * **********************************************
  ATTENTION: Fill in these values! You can get
  them by creating a new Service Account in the
  API console. Be sure to store the key file
  somewhere you can get to it - though in real
  operations you'd want to make sure it wasn't
  accessible from the webserver!
  The name is the email address value provided
  as part of the service account (not your
  address!)
  Make sure the Books API is enabled on this
  account as well, or the call will fail.
 * ********************************************** */
//API KEY //AIzaSyAJ6S9EPY49VQT6CAEXFLFZQnxcdknCLCs

$client_id = '101803273545217552042'; //Client ID 107742042059574641188
$service_account_name = 'tmsmanager@smart-pattern-133323.iam.gserviceaccount.com'; //Email Address
$key_file_location = dirname(__FILE__) . "/MyProject-72eec91a3ebb.p12"; //key.p12
//notasecret


DEFINE("TESTFILE", '/home/nexibms/public_html/tms/img/gdrive/bigbasta-bg.jpg');
if (!file_exists(TESTFILE)) {
    $fh = fopen(TESTFILE, 'w');
    fseek($fh, 1024 * 1024);
    fwrite($fh, "!", 1);
    fclose($fh);
}

echo pageHeader("Service Account Access");
//if (strpos($client_id, "googleusercontent") == false
//    || !strlen($service_account_name) 
//    || !strlen($key_file_location)) {
//  echo missingServiceAccountDetailsWarning();
//  exit; 
//} 

$client = new Google_Client();
//$client->addScope("https://www.googleapis.com/auth/drive");
//$client->setApplicationName("Client_Library_Examples");
$client->setApplicationName("tmsmanager");
$client->setClientId($client_id);
$service = new Google_Service_Drive($client);

/* * **********************************************
  If we have an access token, we can carry on.
  Otherwise, we'll get one with the help of an
  assertion credential. In other examples the list
  of scopes was managed by the Client, but here
  we have to list them manually. We also supply
  the service account
 * ********************************************** */
if (isset($_SESSION['service_token'])) {
    $client->setAccessToken($_SESSION['service_token']);
}
$key = file_get_contents($key_file_location);
$cred = new Google_Auth_AssertionCredentials(
        $service_account_name, array('https://www.googleapis.com/auth/drive',
    'https://www.googleapis.com/auth/drive.apps.readonly','https://www.googleapis.com/auth/drive.file'), $key
);
$client->setAssertionCredentials($cred);
if ($client->getAuth()->isAccessTokenExpired()) {
    $client->getAuth()->refreshTokenWithAssertion($cred);
}
//echo "<pre>";
//print_r($client);
//echo '</pre>';
//echo $client->getAccessToken();

$_SESSION['service_token'] = $client->getAccessToken();




if ($client->getAccessToken()) {
    echo "hi";
    // This is uploading a file directly, with no metadata associated.
    $file = new Google_Service_Drive_DriveFile();
    $file->setTitle("Kuldeep File !");
    $result2 = $service->files->insert(
            $file, array(
        'data' => file_get_contents(TESTFILE),
        'mimeType' => 'application/octet-stream',
        'uploadType' => 'multipart'
    ));


    if (isset($result2) && $result2) {
//        echo '<pre>';
//        print_r($result2);
//        echo '</pre>';
//    print_r($result2);
//
//    var_dump($result->title);
//    var_dump($result2->title);
        
        
        $result2 = $service->files->listFiles();
         echo '<pre>';
        print_r($result2);
        echo '</pre>';
        
    }

    die();
    // Now lets try and send the metadata as well using multipart!
    $file = new Google_Service_Drive_DriveFile();
    $file->setTitle("Hello World name!");
    $result2 = $service->files->insert(
            $file, array(
        'data' => file_get_contents(TESTFILE),
        'mimeType' => 'application/octet-stream',
        'uploadType' => 'multipart'
            )
    );
}

/************************************************
  We're just going to make the same call as in the
  simple query as an example.
 ************************************************/
//$optParams = array('filter' => 'free-ebooks');
//$results = $service->volumes->listVolumes('Henry David Thoreau', $optParams);
//echo "<h3>Results Of Call:</h3>";
//foreach ($results as $item) {
//  echo $item['volumeInfo']['title'], "<br /> \n";
//}
//
//echo pageFooter(__FILE__);
