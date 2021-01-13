<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | User defined Constents
  |--------------------------------------------------------------------------
 */
define("CLIENT_FILE_PENDING_STATUS",19);
define("COMMENT_ATT_TYPE", 0);
define("TASK_ATT_TYPE", 3);

define('FILE_UPLOAD_DEFAULT', 19);
define('FILE_REJECTED', 20);
define('FILE_APROVED', 21);

define("INCHARGE", 1);
define("PARTNER", 2); // UTID
define("DIRECTOR", 3); // UTID
define("DEVELOPER", 1); // UTID

define("CLIENT", 9);
define("CLIENT_GROUP", 2);
define("USER", 'user');

define("HOLD", 1);
define("IN_PROGRESS", 2);
define("COMPLETED_REQUEST", 3);
define("COMPLETED_APPROVAL", 4);

define("PER_DAY_HOURS", 7);

define("TASK_CATEGORY_MASTER", 1);
define("TT_DOC_REQ", 2);
define("TT_SUB_TASK_MASTER", 3);
define("TASK_MASTER", 4);
define("T_DOC_REQ", 5);
define("T_SUB_TASK", 6);
define("COMMENT_ID", 7);
define("SUB_TASK_REASSIGNED", 8);

define("NOTIFY_BEFORE_DATE", 7);
define("EMAIL_FROM", "Kachhal & Co Team");
define("NOTIFY_EMAIL", "dont_reply@kachhal.in");
define("CC_MAILS", "sanjeev@kachhal.com"); 
define("DEV_MAILS", "anup@nexgi.com");

define("SITE_ROOT_PATH", $_SERVER['DOCUMENT_ROOT'] . ""); // if your file in public_html leave it blank
//define("CDN1", "http://mybridge.kachhal.in/");
define("CDN1", "http://mybridge.local/");
define("CLIENT_URL", "http://client.kachhal.in/");
//define("CDN1", "http://knctest.nexibms.in/");
//define("CDN1", "http://anup/tms_nexibms/");
define('STU_UPLOAD_PATH', 'img/Students_Data/student_pic_and_sign/');
define('EMP_UPLOAD_PATH', 'img/Employee_Data/Employee_pic_and_sign/');
define('EMP_DOCUMENT_UPLOAD_PATH', 'img/Employee_Data/Documents/');
define("TIMEZONE", "+3 hours 30 minute");
define('DF', 'd-m-Y'); //showing default date formate
define('DTF', 'd-m-Y @ h:i a'); //showing default date formate
define('DB_DTF', 'Y-m-d H:i:s'); //insering default date formate
define("DT", 'G:i a'); // showing default time formate 
define("DB_DT", 'G:ia'); // inserting default time formate
define("H24DB_DT", "H:i");
define('ADD_DTF', 'Y-m-d H:i:s');
define('DB_DF', 'Y-m-d');
define("Month", date('m', time()));
define("Year", date('Y', time()));
define("DB_PREFIX", "nexgen_");
//define("First_Day_Of_Month", date(DB_DF,  strtotime(Year."-".Month."-01")));
define("ERR_DELIMETER", "404IBMS");
define('DEFAULT_STU_SIGN', 'img/default_pic_and_sign/signature_scan.gif'); //Default Sign
define('DEFAULT_STU_PIC', 'img/default_pic_and_sign/default.png'); //Default Picture
define('DEFAULT_EMP_SIGN', 'img/default_pic_and_sign/signature_scan.gif'); //Default Sign
define('DEFAULT_EMP_PIC', 'img/default_pic_and_sign/default.png'); //Default Picture
define('SITE_NAME', 'My Bridge'); //Site Name
define('TAGLINE', 'A Way Towards Goal'); //Site Name
define('LOGO', ''); // blank if you dont wnat to show logo
define('ERROR_MSG', 'Internal Server Error !!');
define('SUCCESS_MSG', 'Saved Successfully !!');
define('UPDATE_SUCCESS_MSG', 'Updated Successfully !!');
define('UPDATE_ERROR_MSG', 'Internal Server Error In Updation !!');
define('DEL_SUCCESS_MSG', 'Deleted Successfully !!');
define('DEL_ERROR_MSG', 'Error In Deleting Record Successfully !!');
define('DEFAULT_STARTING_TIME', '9:00 am');
define('DEFAULT_ENDING_TIME', '5:00 pm');
define('FEE_COLLECT_TYPE1_URL', 'fees/Fee_Master');
define('FEE_COLLECT_TYPE2_URL', 'fees/Fee_Master_1');
define('FEE_COLLECT_TYPE', '1');
define("STATUS_TRUE", 1);
define("STATUS_FALSE", 0);

$day = date('d', time());
$pre_loader = "";
if ($day <= 10) {
    $pre_loader = "Preloader_1";
} else if ($day <= 20 && $day > 10) {
    $pre_loader = "Preloader_3";
} else {
    $pre_loader = "Preloader_7";
}
$pre_loader.=".gif";
define("PRELOADER32", "img/pre_loaders/32x32/" . $pre_loader);
define("PRELOADER64", "img/pre_loaders/64x64/" . $pre_loader);
define("PRELOADER128", "img/pre_loaders/128x128/" . $pre_loader);
// "<img src='"base_url()img/pre_loaders/loader.gif'/>"
define("MAX_FEE_AMT", "100000");
define("MAX_DIS_AMT", "5000");
define("AJAXPRELOADER", '<div class="progress progress-striped active"><div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"><span class="sr-only">40% Complete (success)</span></div></div>');
$GLOBALS['data'] = array();
global $data;
$data['form_common_cls'] = "form-control"; //common class for all form element of bootstrap


/*
  |--------------------------------------------------------------------------
  | End of User Defined constents
  |--------------------------------------------------------------------------
 */


/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */