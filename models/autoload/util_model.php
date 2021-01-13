<?php
/*

 * @model util_model
 * @auther : Anup kumar
 * @Created : 10 March 2015 */

class util_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function all_month_list() {
        $c_month = date("F", time());
        $month_list = array();
        $month_list[date("m", strtotime($c_month))] = $c_month;
        for ($i = 1; $i < 13; $i++) {
            $value = date("F", strtotime("+$i months"));
            $month_list[date("m", strtotime($value))] = $value;
        }

        return array($month_list, $c_month);
    }
    

    public function yes_no() {
        return array(0 => 'No', 1 => 'Yes');
    }

    public function _set_encrypt_cookie($cookie_data) {
        $this->load->helper('cookie');
        $cookie = array();
        foreach ($cookie_data as $cookie_raw) {
            $cookie[] = array(
                'name' => $cookie_raw['cname'],
                'value' => $this->encrypt_string($cookie_raw['cvalue']),
                'expire' => time() + 86500,
                'path' => '/',
            );
        }
        $this->input->multi_set_cookie($cookie);
    }

    public function trimmer($POST) {
        $user_data = array();
        foreach ($POST as $key => $value) {
            $user_data["$key"] = trim($value);
        }
        return $user_data;
    }

    public function _get_decrypted_cookie($cname) {
        $this->load->helper('cookie');
        return $this->decrypt_string($this->input->cookie($cname));
    }

    public function encrypt_string($string) {
        $this->load->library('encrypt');
        return $this->encrypt->encode($string);
    }

    public function decrypt_string($string) {
        $this->load->library('encrypt');
        return $this->encrypt->decode($string);
    }

    public function login_page_alt() {
        $id = 1;
        $this->db->select('login_page');
        $query = $this->db->get(DB_PREFIX . 'company', array('company_id' => $id));
        $result_data = $query->row_array();
        return $result_data;
    }

    public function printr($data) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

    function url_encode($CourseCode) {
        $CourseCode = str_replace('+', "plus", $CourseCode);
        $CourseCode = str_replace('&', "and_opertor", $CourseCode);
        $CourseCode = str_replace('/', "slash_opertor", $CourseCode);
        $CourseCode = str_replace('(', "open_pren", $CourseCode);
        $CourseCode = str_replace(')', "close_pren", $CourseCode);
        return $CourseCode;
    }

    function url_decode($CourseCode) {
        $CourseCode = str_replace('plus', "+", $CourseCode);
        $CourseCode = str_replace('and_opertor', "&", $CourseCode);
        $CourseCode = str_replace('%20', " ", $CourseCode);
        $CourseCode = str_replace('slash_opertor', "/", $CourseCode);
        $CourseCode = str_replace('open_pren', "(", $CourseCode);
        $CourseCode = str_replace('close_pren', ")", $CourseCode);
        return $CourseCode;
    }

    function set_error($data, $error, $_err_codes) {
        if ($error != '') {
            $data['error'] = $error == 1 ? TRUE : FALSE;
            $data['err_codes'] = $_err_codes;
        }
        return $data;
    }

    function result_e_code($error, $true_msg = '', $_err_string) {
        if (isset($error)) {
            if (!$error) {  // if error is not occurred
                ?>
                <script>
                    swal({
                        title: "Nice Job !!",
                        type: "success",
                        text: "<?= $this->get_err_msg($_err_string) ?>",
                        timer: 2000});
                </script>
                <!--                    <h6 id="succ_msg">
                                        <button type="button" class="btn btn-success btn-md"><?= $true_msg ?>
                                            <span class="glyphicon glyphicon-remove"></span> 
                                        </button></h6>-->
                <?php
            } else {
                $err_array = explode("404IBMS", $_err_string);
                array_pop($err_array);
                // die($this->util_model->printr($err_array))  ;
                echo "<h6 class='succ_msg'>";
                foreach ($err_array as $_err_code) {
                    ?>
                    <button type="button" class="btn btn-danger btn-md">
                        <?php echo $this->get_err_msg($_err_code) ?>
                        <span class="glyphicon glyphicon-remove"></span> 
                    </button>
                    <?php
                }
                echo "</h6>";
            }
        }
        //print_r($pre_filled_data);
    }

    function get_err_msg($_err_code) {
        $result = $this->db->get_where("nexgen_global_error", array("ErrCode" => $_err_code));
        $result_data = $result->result();
        //    die($this->util_model->printr($result_data));
        if (!empty($result_data))
            return $result_data[0]->ErrCodeDes;
    }

    function show_result_error($error, $true_msg = SUCCESS_MSG, $false_msg = ERROR_MSG) {
        if (isset($error)) {
            if (!$error) {  // if error is not occurred
                ?>
                <script>
                    swal({
                        title: "Nice Job !!",
                        type: "success",
                        text: "<?= $true_msg ?>",
                        timer: 2000});
                </script>
                <!--                    <h6 id="succ_msg">
                                        <button type="button" class="btn btn-success btn-md"><?= $true_msg ?>
                                            <span class="glyphicon glyphicon-remove"></span> 
                                        </button></h6>-->
            <?php } else {
                ?> 
                <script>
                    swal({
                        title: "Error Occured",
                        type: "error",
                        text: "<?= $false_msg ?>",
                        timer: 2000});
                </script>
                <!--                    <h6 id="succ_msg">
                                        <button type="button" class="btn btn-danger btn-md"><? // $false_msg ?>
                                            <span class="glyphicon glyphicon-remove"></span> 
                </button></h6>-->
                <?php
            }
        }
        //print_r($pre_filled_data);
    }

    function active_deactive() {
        return array("1" => "Activate", "0" => "De-Activate");
    }

    function check_if_exits_then_delete($file_path) {
        $base_url = base_url();
        if (file_exists($file_path) && ($file_path != $base_url . "img/default_pic_and_sign/default.png" || $file_path != $base_url . "img/default_pic_and_sign/signature_scan.gif")) {
            unlink($file_path);
        }
    }

    function get_branch_details($BranchID) {
        $result = $this->db->get_where(DB_PREFIX . 'branch_mst', array("BranchID" => $BranchID));
        $result_data = $result->result();
        if (!empty($result_data))
            return $result_data[0];
    }

    function days_list() {
        $timestamp = strtotime('next Sunday');
        $days = array();
        for ($i = 0; $i < 7; $i++) {
            $day = strftime('%A', $timestamp);
            $days[$day] = $day;
            $timestamp = strtotime('+1 day', $timestamp);
        }
        return $days;
    }

    /*
      used to show the all branch
     *  branch_list_with_branch_Cat
     *  @access public    
     * @param $UserType here for controlling the number of branch user can see 
     * like admin can see all branch in dropdown
     * PRO can see current branch under which it has been registered. etc or 
     * custome as per user_types tables will defined the access of user
     * @param	$head_branch  TRUE for head branches
     */

    public function branch_list_with_branch_Cat($Session_Data, $head_branch = 0) {
        $UserTypeID = $Session_Data['IBMS_USER_TYPE'];
        $BranchID = $Session_Data['IBMS_BRANCHID'];
        //echo $UserTypeID; 
        if ($UserTypeID != 2 && $UserTypeID != 10) {
            $this->db->where("t2.BranchID", $BranchID);
        }




        //  print_r($Session_Data);
        if ($head_branch) {
            $this->db->where("t2.HeadB", 1);
        }

        $this->db->select('t2.BranchID,t2.BranchCode')->from(DB_PREFIX . 'branch_mst t2');
//                            $this->db->join(DB_PREFIX . "branch_mst t2", "t1.AccessBranchID=t2.BranchID");
        $this->db->where(array("t2.Status" => 1))->order_by('t2.BranchCode,t2.Bname');
        $result = $this->db->get()->result();
//                            echo $this->db->last_query();
        $return_list = array();
        foreach ($result as $value) {
            $return_list[$value->BranchID] = $value->BranchCode;
        }

        //die(print_r($return_list));
        return $return_list;
    }

//    public function add_common_field($action,$FormData,$Session_Data){
//        if($action=="add"){
//        $FormData['Add_User']=  $Session_Data['IBMS_USER_ID'];
//        $FormData['Add_DateTime'] = date(DB_DTF, strtotime(TIMEZONE));
//        }else{
//         $FormData['Mode_User']=  $Session_Data['IBMS_USER_ID'];   
//        }
//        
//    }
//    public function data_filter($data) {
//        foreach ($data as $key => $value) {
//            $data[$key] = $this->db->escape_str($value);
//        }
//        return $data;
//    }

    public function get_list($vkey, $skey, $table, $branchid = 0, $sort_col = 'Sort', $for_selection = TRUE, $status = 1, $whr = "") {
        if ($branchid != 0) {
            $this->db->where(array("BranchID" => $branchid));
        }

        if ($status) {
            $this->db->where(array("Status" => $status));
        }
        if ($whr != "") {
            $this->db->where($whr, NULL, FALSE);
        }
        $query = $this->db->select()->from($table)->order_by($sort_col);
        $result = $query->get()->result();
        if (!$for_selection) {
            return $result;
        } else {
            $return_list = array();
            foreach ($result as $value) {
                $return_list[$value->$vkey] = $value->$skey;
            }
            return $return_list;
        }
    }

    public function add_common_fields($FormData) {
        global $data;
        $FormData['Add_User'] = $data['Session_Data']['IBMS_USER_ID'];
        $FormData['Add_DateTime'] = date(ADD_DTF, time());
        return $FormData;
    }

    public function add_mode_user($FormData) {
        global $data;
        $FormData['Mode_User'] = $data['Session_Data']['IBMS_USER_ID'];
        return $FormData;
    }

    public function unset_array($main_array, $key_to_unset) {
        foreach ($key_to_unset as $key) {
            if (isset($main_array[$key]) || $main_array[$key] == "") {
                unset($main_array[$key]);
            }
        }
        return $main_array;
    }

    public function is_auth_for_this($con = "", $fun = "") {
        global $data;
//        echo $con . $fun;
        if ($con == "" || $fun == "") {
            $con = $data['cnf'][0];
            $fun = $data['cnf'][1];
        }
//        $BranchID = $data['Session_Data']['IBMS_BRANCHID'];
        $UTID = $data['Session_Data']['IBMS_USER_TYPE'];
        $this->db->select("mcnf.MID,m.menu_title")->from(DB_PREFIX . "menu_cnfs mcnf");
        $this->db->join(DB_PREFIX . "menus m", "mcnf.MID=m.MID and m.Status=1", "inner");
        $this->db->where(array(
            "mcnf.function" => $fun,
            "mcnf.controller" => $con,
            "m.status" => 1
        ));
        $this->db->where("(select count(*) FROM " . DB_PREFIX . "menu_access ma WHERE ma.MID=mcnf.MID and ma.BranchID=" . $this->get_ubid() . " and ma.UTID=$UTID and ma.Allowed=1)", NULL, FALSE);
        //ma.MID = (select MID from " . DB_PREFIX . "menus nm where ='$con' and ='$fun' order by MID DESC limit 1) and ma.BranchID=$BranchID and ma.UTID=$UTID 
//        $sql = "select mcnf.MID,m.menu_title from nexgen_menu_cnfs mcnf inner join nexgen_menus m on (mcnf.MID=m.MID and m.Status=1) where mcnf.controller='manage_users' and mcnf.function='index1' and (select count(*) FROM nexgen_menu_access ma WHERE ma.MID=mcnf.MID and ma.BranchID=1 and ma.UTID=8 and ma.Allowed=1) order by mcnf.MID DESC limit 1";
//        $sql = "SELECT ma.MID,(select menu.menu_title from " . DB_PREFIX . "menus menu where menu.MID=ma.MID order by menu.menu_title DESC limit 1) as menu_title FROM " . DB_PREFIX . "menu_access ma WHERE ma.MID = (select MID from " . DB_PREFIX . "menus nm where controller='$con' and function='$fun' order by MID DESC limit 1) and ma.BranchID=$BranchID and ma.UTID=$UTID and ma.Allowed=1";
//        $query = $this->db->query($sql);
        $this->db->order_by("mcnf.MID");
        $this->db->limit(1, 0);
        $result = $this->db->get()->result();
//        print_r($result);
//      echo  $this->db->last_query();
        if (empty($result)) {
            return array("auth" => 0);
        } else {
            return array("auth" => 1, "title" => $result[0]->menu_title);
        }
    }

    public function ShowMenus($PID = 0, $BranchID = '', $UTID = '', $only_Allowed = 0, $only_menu = 0) {
        $List = array();
        $this->db->select('m.*,ma.UTID,ma.Allowed');
        $this->db->from(DB_PREFIX . 'menus m');
        $this->db->join(DB_PREFIX . "modules mdl", "m.module_id=mdl.module_id and mdl.Status=1", "inner");
        $this->db->join(DB_PREFIX . "menu_access ma", "m.MID = ma.MID", "right");

        $this->db->where(array("ma.BranchID" => $BranchID, "m.Status" => 1, "m.parent_id" => $PID, 'ma.UTID' => $UTID));
        if ($only_Allowed) {
            $this->db->where(array('ma.Allowed' => $only_Allowed));
        }
        if ($only_menu) {
            $this->db->where(array('m.is_menu' => 1));
        }
        $this->db->order_by('m.sort_order', 'ASC');
        $result = $this->db->get();
//        echo $this->db->last_query()."hi";
        foreach ($result->result_array() as $mrow) {

            $List[] = array('Parent' => $mrow, 'Child' => $this->ShowMenus($mrow['MID'], $BranchID, $UTID, $only_Allowed, $only_menu));
        }

        return $List;
    }

    /*

     * check already exits     */

    public function check_aready_exits($table, $where_array, $result_set = FALSE) {
        $result = $this->db->get_where($table, $where_array);
        if ($result_set)
            return $result->result();
        return $result->num_rows;
    }

    /*

     * this function help ful if you wnat to get a single column value,
     * like you want to get coursecode from courseid   
     * 
     * where is an array  */

    public function get_a_column_value($get_column, $table, $where) {
        $query = $this->db->get_where($table, $where);
        $result = $query->result();
        return isset($result[0]->$get_column) ? $result[0]->$get_column : '';
    }

    public function get_column_value($column_name, $table, $whr) {
        $this->db->select($column_name)->from($table)->where($whr);
        $result = $this->db->get()->row_array();
        return isset($result[$column_name]) ? $result[$column_name] : '';
    }

    public function format_file_name($full_name) {
        
    }

    /*

     * update the data */

    public function update_data($table, $data, $where_array) {
        $this->db->where($where_array);
        $this->db->update($table, $data);
        return $this->db->affected_rows();
    }

    public function insert_data($table, $data, $batch_insert = FALSE, $aff_row = TRUE, $insert_id = FALSE) {
        if ($batch_insert) {
            $this->db->insert_batch($table, $data);
        } else {
            $this->db->insert($table, $data);
        }

        if ($aff_row && $insert_id) {
            return array($this->db->insert_id(), $this->db->affected_rows());
        } elseif ($aff_row) {
            return $this->db->affected_rows();
        } else {
            return $this->db->insert_id();
        }
    }

    public function set_db_date_formate($FormData, $field_array) {
        foreach ($field_array as $field) {
            $FormData[$field] = date(DB_DF, strtotime($FormData[$field]));
        }
        return $FormData;
    }

    public function get_breadcrum() {
        global $data;
        $controller = $data['cnf'][0];
        $function = $data['cnf'][1];
        $bread_crum = array();
        $each_menu = $this->db->get_where(DB_PREFIX . "menus", array("controller" => $controller, "function" => $function, "status" => 1))->row_array();
//        echo $this->db->last_query();
//                            $this->util_model->printr($each_menu);
//                            die();
        $bread_crum[] = $each_menu;
        $parent_id = isset($each_menu['parent_id']) ? $each_menu['parent_id'] : 0;
        while ($parent_id) {
            $each_menu = $this->get_parent_details($parent_id);
            $parent_id = $each_menu['parent_id'];
            $bread_crum[] = $each_menu;
        }
        krsort($bread_crum);
        return $bread_crum;
    }

    public function get_parent_details($parent_id) {
        return $this->db->get_where(DB_PREFIX . "menus", array("MID" => $parent_id, "status" => 1))->row_array();
    }

    public function get_utype() {
        global $data;
        return $data['Session_Data']['IBMS_USER_TYPE'];
    }

    public function get_uname() {
        global $data;
        return $data['Session_Data']['IBMS_USER_ID_NAME'];
    }

    public function get_uid() {
        global $data;
        return $data['Session_Data']['IBMS_USER_ID'];
    }

    public function get_ubid() {
        global $data;
        return $data['Session_Data']['IBMS_BRANCHID'];
    }

    public function formatted_time($Add_DateTime = "") {
        if ((time() > strtotime('+1 day', strtotime($Add_DateTime))) && (time() < strtotime('+2 day', strtotime($Add_DateTime)))) {
            //yesterday
            return "Yesterday at " . date("h:i A", strtotime($Add_DateTime));
        } else if (time() > strtotime('+2 day', strtotime($Add_DateTime))) {
            //date and time of post
            return date("F j, Y, g:i a", strtotime($Add_DateTime));
        } else {
            $totaldelay = time() - strtotime($Add_DateTime);
            if ($totaldelay <= 0) {
                return 'Just now';
            } else {
                //in hrs
                if ($hours = floor($totaldelay / 3600)) {
                    $totaldelay = $totaldelay % 3600;
                    return $hours . ' hrs';
                }
                //in minutes
                if ($minutes = floor($totaldelay / 60)) {
                    $totaldelay = $totaldelay % 60;
                    return $minutes . ' Min';
                }
                //in seconds
                if ($seconds = floor($totaldelay / 1)) {
                    $totaldelay = $totaldelay % 1;
                    return $seconds . ' Sec';
                }
            }
        }
    }

    /*

     * this function will kill if user is not allowed to access the module     */

    function is_auth() {
        global $data;
        $auth = $this->is_auth_for_this();
        if ($auth['auth']) {
            redirect("Not Autherised to access");
        }
    }

    public function get_progress_flag_string($progress_flag) {
        switch ($progress_flag) {
            case 2:
                return "In Progress";
            case 3:
                return "Completed Request raised";
            case 4:
                return "Close & Completed";
            default:
                return "Un-defined";
        }
    }

    public function get_authStatus($con = '', $fun = '') {
        $res = $this->is_auth_for_this($con, $fun);
        return $res['auth'];
    }

    public function getUtypeString($utid = '') {
        if ($utid == INCHARGE) {
            return "INCHARGE";
        } else if ($utid == PARTNER) {
            return "PARTNER";
        } else if ($utid == DIRECTOR) {
            return "DIRECTOR";
        }
    }

    public function get_lower_utids() {
        $sql = "SELECT UTID FROM nexgen_usertypes WHERE level >= (select level from nexgen_usertypes where UTID = " . $this->util_model->get_utype() . ")";
        $ids = $this->db->query($sql)->result_array();
        $id_list = array();
        foreach ($ids as $eachID) {
            $id_list[] = $eachID['UTID'];
        }
        return $id_list;
    }

    public function day() {

        $list = array();
        for ($i = 1; $i <= 28; $i++) {
            $list[$i] = $i;
        }
        return $list;
    }

    public function time() {

        $list = array(
            "6" => "6 am",
            "7" => "7 am",
            "8" => "8 am",
            "9" => "9 am",
            "10" => "10 am",
            "11" => "11 am",
            "12" => "12 pm",
            "13" => "1 pm",
            "14" => "2 pm",
            "15" => "3 pm",
            "16" => "4 pm",
            "17" => "5 pm",
            "18" => "6 pm",
           
        );

        return $list;
    }

 public function get_state($data){
           $this->db->where('state_id',$data);
           $r3=  $this->db->get('nexgen_cstates')->row();
           if($r3){
               return $r3->name;
           }else{
             return '';  
           }
    }
    
}
