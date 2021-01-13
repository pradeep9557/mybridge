<?php
    if($multi_select){
    echo form_multiselect($field_name."[]", $list,$selected,"class='form-control chosen-select'");
    }else{
       $faculty_show_filter = $faculty_show_filter?"onchange='load_getFacultyByCourse(this.value)'":"";           
       echo form_dropdown($field_name, $list,$selected,"class='form-control chosen-select' $faculty_show_filter id = 'course_id'");              
    }
?>