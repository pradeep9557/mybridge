<!--Tag input files-->
<link href="<?= base_url() ?>css/taginput/jquery.tagsinput.css" rel="stylesheet" type="text/css"/>
<!--<script src="<?= base_url() ?>js/taginput/jquery.tagsinput.js" type="text/javascript"></script>-->
<script src="<?= base_url() ?>js/taginput/jquery.tagsinput.min.js" type="text/javascript"></script>
<!--End of tag input files-->


<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            
            <h4 class="page-header ">Edit  Detials of <?php echo $employee_data->UserName ?>
                <a href="<?php echo base_url('tms/manage_users'); ?>" class="pull-right">
                    <button type="button" name="link" value="Save" class="btn btn-success btn-md margin_top-10px">
                        <span class="glyphicon glyphicon-backward"></span> Back
                    </button></a>
            </h4>
            <?php
          //  print_r($Emp_ID);
            if (isset($error)) {
                $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
            <h3 class="panel-title toggle_custom">Edit User<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
        <div class="panel-body collapse" id="collapseExample">   
            <?php
            //for normal form
            //  echo form_open('/dashboard/new_admission',$attributes);
            echo form_open_multipart(base_url() . 'tms/manage_users/users_save_update', "id='validation_form'");
            ?>
            <!--String of Row-->
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">UserName<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="input-group">
                <?php
               
                echo form_input("UserName", $employee_data->UserName,"class='form-control'");
//                echo form_dropdown("BranchID", $a_branches, $employee_data->BranchID, "class='form-control form-control chosen-select' tabindex=1")
                ?>
                      

                    </div> 
                </div> 
                <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">User Type<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="input-group">

                        <?php
                        echo form_hidden("Emp_ID", $Emp_ID);
                        echo form_dropdown("UTID", $user_types, $employee_data->UTID, "class='form-control form-control chosen-select' tabindex=1");
                        
                        ?>
                        <span class="input-group-addon popover_branch"  id="basic-addon1" >
                            <span class="glyphicon glyphicon-question-sign"></span>
                        </span>


                    </div><!-- /input-group -->               
                </div> 
            </div>
            <div class="row bottom_gap">

                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">User Full Name<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_input("Emp_Name", $employee_data->Emp_Name, array("class" => "'form-control form-control popover_element1'", "placeholder" => "'Employee Name'")) ?>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">Primary Email<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_input("P_Email", $employee_data->P_Email, array("class" => "'form-control  popover_element1'", "placeholder" => "'Primary Email'")) ?>
                    </div>        
                </div>

            </div> <!--End of row-->


             <div class="row bottom_gap">
                 
                 <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Password<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php echo form_input("Emp_Pass",  $this->util_model->decrypt_string($employee_data->Emp_Pass) , array("class" => "'form-control form-control popover_element1'", "placeholder" => "'Employee Password'")) ?>
                    </div>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4  padding_top_label">Status<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group">
                        <?php  echo form_dropdown("Status",array("1"=>"Enable","0"=>"Disable"), $employee_data->Status,"class='form-control'");?>
                    </div>        
                </div>
                 
                 
                
             </div>



            <div class="row">
                <div class="col-lg-1">
                    <!--<div class="input-group">-->
                    
                    <?php echo form_submit("Add_Employee", "Update", array("class" => "'btn btn-success'")) ?>
                    <!--                   
                                       <button   type="button"  class="btn btn-success  btn-md">   
                                            <span class="glyphicon glyphicon-floppy-disk"></span>
                                        </button>
                    -->
                    <!--</div>-->
                </div>
                <div class="col-lg-1">
                     <a href="<?php  echo base_url("tms/manage_users"); ?>" class="btn btn-danger">Cancel</a>
                </div>

            </div>
        </div>
    </div>


    <?php
    echo form_close();
    $Curr_Obj = & get_instance();
    $Curr_Obj->All_users_List(USER);
    ?>


</div>
<?php
$this->load->view("Employee/emp_form_validation");
?>
<script>
    $(".send_on_mail").change(function () {
        if ($(this).val() == "1") {
            $("#password_box").hide();
        } else {
            $("#password_box").show();
        }
    });
</script> 