<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
// if someone put this url == then right side should be come
$route['nexibms-faq'] = "faq/c_faq_template";
$route['faqs/(.*)'] = "faq/c_faqs/$1";
$route['sp-admin/em/(.*)'] = "superadmin/c_err_mst/$1";
$route['sp-admin/a/(.*)'] = "superadmin/usertypes/$1";
$route['sp-admin/m/(.*)'] = "superadmin/menus/$1";
$route['sp-admin/bm/(.*)'] = "superadmin/branch_master/$1";
$route['sp-admin/cf/(.*)'] = "superadmin/cnf/$1";
$route['student_dashboard'] = 'student_dashboard/view';
$route['batch_master'] = 'batch_master/create_batch';
$route['Fee_Master']='Fee_Master/Fee_collect_form';
$route['fee_type'] = "fee_type/Add_Fee_Type_Form";
$route['qualification_controller'] = 'qualification_controller/add_qualification';
$route['designation_controller']='designation_controller/add_designation';
$route['auth'] = 'auth/login';
$route['employee'] = 'employee/add_employee';
$route['admission'] = 'admission/all_admission_form';
$route['courses'] = 'courses/Add_Course_form';
$route['dashboard'] = 'dashboard/view';

//$route['image_library/upload_image'] = 'tms/loginimg_library/upload_image';

$route['my_sub_tasks'] = 'tms/manage_sub_task/subTaskDashboard'; 

//$route['(:any)']= 'dashboard/view/$1';
$route['default_controller'] = 'dashboard/view';//"auth/Login";
$route['404_override'] = 'auth/access_forbidden';
//$route['rooms/v-manage-rooms'] = 'rooms/v-manage-rooms';


/* End of file routes.php */
/* Location: ./application/config/routes.php */