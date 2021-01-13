<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

if (!function_exists('encryptor')) {

    function encryptor($string) {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        //pls set your unique hashing key
        $secret_key = 'e@c@l@i@c@k';
        $secret_iv = 'S3cur3';

        // hash
        $key = hash('sha512', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha512', $secret_iv), 0, 16);

        //do the encyption given text/string/number

        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }

} 
if (!function_exists('decryptor')) {

    function decryptor($string) {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        //pls set your unique hashing key
        $secret_key = 'e@c@l@i@c@k';
        $secret_iv = 'S3cur3';

        // hash
        $key = hash('sha512', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha512', $secret_iv), 0, 16);
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);


        return $output;
    }

}  
if (!function_exists('GetPageTitle')) { 
//    function GetPageTitle($page_id) {
//        $ci = & get_instance();
//        $ci->load->database(); 
//        $sql = "select page_title from nexgen_page_mst WHERE page_id=" . $page_id . " ";
//        $query = $ci->db->query($sql);
//        $row = $query->row_array();
//        if (!empty($row)) {
//            return $row['page_title'];
//        } else {
//            return "NA";
//        }
//    }
}
