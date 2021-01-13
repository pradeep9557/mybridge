<?php 
class cdesign extends CI_Controller{
    function __construct() {
        parent::__construct();
        $this->load->model('desgination/designation');
    }
    public function add_designation($error = '', $show_error = 0){
        if ($show_error == 1) {
            if ($error == 1)
                $data['error'] = TRUE;
            else
                $data['error'] = FALSE;
        }
        $data['Session_Data'] = $this->session->all_userdata();
        if (!$this->session->userdata('LOGIN_STATUS')) {
            redirect(base_url() . 'auth/login/1/1');
        }
        $this->load->helper('form'); // Loading Form helper which helps to make form elements
             $attributes = array('class' => 'new_designation_form', 'id' => 'new_designation_form'); // extra attributes for form
             $data['attributes'] = $attributes;
            
             $data['active_deactive'] = active_deactive();
              $data['All_Designation_List'] = $this->designation->all_designation_list_from_db();
          if ( ! file_exists(APPPATH.'/views/Designation/Add_New_designation.php'))
			{
				show_404();
			}
                    $data['title'] = ucfirst("Add New Designation |".  SITE_NAME); //capitalizing the first character of string for header.
                    $this->load->view('templates/header.php',$data);
                     $this->load->view('templates/common_window_pop_up.php');
                    $this->load->view('templates/form_validation_css_js.php',$data);   
                    $this->load->view("Designation/Add_New_designation.php",$data);
                    $this->load->view('templates/footer.php');
             
    }
     public function Designation_save_update() {
        $path = "";
        $query_result = array();
        if (isset($_REQUEST['Add_Designation']) && $_REQUEST['Add_Designation'] == "Save") {
            $query_result = $this->designation->Designations_save_update();
            $saved_or_updated = $query_result[0];
            $path = $saved_or_updated ? "cdesign/add_designation/0/1" : "cdesign/add_designation/1/1";
        } else if (isset($_REQUEST['Add_Designation']) && $_REQUEST['Add_Designation'] == "Update") {
            $query_result = $this->designation->Designations_save_update();
            $saved_or_updated = $query_result[0];
            $path = $saved_or_updated ? "cdesign/Edit_Designation/0/1/$query_result[1]" : "cdesign/Edit_Designation/1/1/$query_result[1]";
        } else {
            $path = "cdesign/add_designation/1/1";
        }
        redirect(base_url() . $path); // passing error alert 0 means no error, 1 means Error
    }
    public function All_Designation_List($error='',$show_error=0)
	{
         
         if($show_error==1){
           if($error==1)
             $data['error']=TRUE;
           else
               $data['error']=FALSE;
            }
              $data['Session_Data'] = $this->session->all_userdata();
               if(!$this->session->userdata('LOGIN_STATUS')){
                  redirect(base_url().'auth/login/1/1');
                } 
           $data['title'] = ucfirst("All Designation List |".  SITE_NAME); 
           $data['All_Designation_List'] = $this->designation->all_designation_list_from_db();
            if ( ! file_exists(APPPATH.'/views/Designation/All_Designation_List.php'))
			{
				show_404();
			}
                   // $data['title'] = ucfirst(Add_New_designation); //capitalizing the first character of string for header.
                   // $this->load->view('templates/header.php',$data);
                    
                    $this->load->view("Designation/All_Designation_List.php",$data);
                   // $this->load->view('templates/footer.php');
      }
       public function Edit_Designation($error = '', $show_error = 0, $Encoded_DesignationCode) {

        if ($show_error == 1) {
            if ($error == 1)
                $data['error'] = TRUE;
            else
                $data['error'] = FALSE;
        }
        $data['Session_Data'] = $this->session->all_userdata();
        if (!$this->session->userdata('LOGIN_STATUS')) {
            redirect(base_url() . 'auth/login/1/1');
        }
        $data['active_deactive'] = active_deactive();
        $data['Designation_Data'] = $this->designation->get_details_from_database($this->util_model->url_decode($Encoded_DesignationCode));
        $this->load->helper('form'); // Loading Form helper which helps to make form elements
        $attributes = array('role' => 'form', 'class' => 'new_Designation_form', 'id' => 'Designation_validation_form'); // extra attributes for form
        $data['attributes'] = $attributes;
       
        if (!file_exists(APPPATH . '/views/Designation/Edit_Designation.php')) {
            show_404();
        }
        $data['title'] = ucfirst("Edit Designation |" . SITE_NAME);
        //capitalizing the first character of string for header.
        $this->load->view('templates/Common_Css_Js_Others_files.php', $data);
        
        $this->load->view("Designation/Edit_Designation.php", $data);
        $this->load->view('templates/footer.php');
    }

    public function Del_Designation($Encoded_DesignationCode) {
        if ($this->designation->Del_Designation($this->util_model->url_decode($Encoded_DesignationCode))) {
            redirect(base_url() . "cdesign/All_Designation_List/0/1");
            // passing error alert 0 means no error, 1 means Error
        } else {
            redirect(base_url() . "cdesign/All_Designation_List/1/1");
            // passing error alert 0 means no error, 1 means Error
        }
    }
      
}