<div id="page-wrapper" style="min-height: 345px;">
    <div class="col-lg-12">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">New Branch Form</h4>
            <?php
            if (isset($error)) {
                          $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <?php // $this->util_model->printr($Branch_obj); ?>

    <?php
    echo form_open(base_url() . "sp-admin/bm/save_branch", "id='branch_form'");
    ?>

    <div class="row bottom_gap">
        <div class="col-lg-2 padding_top_label">Branch Code</div>
        <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("BranchCode", "", array("class" => "'form-control'", "placeholder" => "'Branch Code'", "maxlength" => "20")) ?>
            </div>
        </div>

        <div class="col-lg-2 padding_top_label">Branch Name</div>  

        <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("Bname", "", array("class" => "'form-control'", "placeholder" => "'Branch Name'", "maxlength" => "20")) ?>
            </div>
        </div>  


    </div>

    <script>
                  function get_enroll()
                  {
                      var branch_code = $("#Enroll_Code").val();
                      var page = "<?= base_url() ?>adm/cadm/next_enroll/" + branch_code;
                      $.ajax({
                          type: "POST",
                          url: page,
                          success: function (result) {
                              $("#Enrollno").val(result);
                          }});
                  }
                  function check_blank() {
                      if ($("#Enrollno").val() == "") {
                          get_enroll();
                      }
                  }
                  setInterval(check_blank, 1000);
                  $(document).ready(function () {
                      get_enroll();
                  });
    </script>


    <!--    <div class="row bottom_gap">
            <div class="col-lg-2 padding_top_label">Pro User Type</div>  
            <div class="col-lg-4">
                <div class="form-group">	
    <?php // echo form_dropdown("procode", $user_types,  isset($Branch_obj->procode) ? $Branch_obj->procode : "", "class='form-control chosen-select'") ?>
                </div> /input-group                
            </div>
    
    
         
    
        </div>-->


    <div class="row bottom_gap">
        <div class="col-lg-2 padding_top_label">Head Branch ID</div>  
        <div class="col-lg-4">
            <div class="form-group">	
                <?php echo form_dropdown("HeadBID", $a_branches, $Branch_obj->HeadBID, "class='form-control chosen-select'") ?>
            </div><!-- /input-group -->               
        </div>

        <div class="col-lg-2">Head Branch</div> 
        <div class="col-lg-4">
            <input name="HeadB" type="checkbox" disabled="" class="form-control bootswitches">
        </div>
        <!--        <div class="col-lg-2 padding_top_label">Max Student in Batch</div>  
        
                <div class="col-lg-4">
                    <div class="form-group">
        <?php //echo form_hidden("Max_Std_In_Batch", "") ?>
                    </div>
                </div>  -->

    </div>    


    <!--    <div class="row bottom_gap">
    
             <div class="col-lg-2 padding_top_label">Min Emp age</div>  
    
            <div class="col-lg-4">
                <div class="form-group">
    <?php //echo form_input("Min_Emp_Age", "", array("class" => "'form-control'", "placeholder" => "'Max Emp age'", "maxlength" => "20")) ?>
                </div>
            </div> 
    
            <div class="col-lg-2 padding_top_label">Min Stu age</div>  
    
            <div class="col-lg-4">
                <div class="form-group">
    <?php //echo form_input("Min_Std_Age", "", array("class" => "'form-control'", "placeholder" => "'Min Stu age'", "maxlength" => "20")) ?>
                </div>
            </div> 
    
    
    
        </div>-->

    <!--    <div class="row bottom_gap">
    
            <div class="col-lg-2 padding_top_label">Branch Site</div>  
    
            <div class="col-lg-4">
                <div class="form-group">
    <?php // echo form_input("Bsite", $Branch_obj->Bsite, array("class" => "'form-control'", "placeholder" => "'Branch Site'", "maxlength" => "20")) ?>
                </div>
            </div> 
    
    
    
            <div class="col-lg-2">Status</div> 
            <div class="col-lg-4">
                <input name="Status" type="checkbox" checked="true" value="1" class="form-control bootswitches">
            </div>
        </div>-->

    <div class="row bottom_gap"> 
        <div class="col-lg-2 padding_top_label">Email1</div>  
        <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("Email1", $Branch_obj->Email1, array("class" => "'form-control'", "placeholder" => "'Email1'", "maxlength" => "20")) ?>
            </div>
        </div>  
        <div class="col-lg-2 padding_top_label">Email2</div>  

        <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("Email2", "", array("class" => "'form-control'", "placeholder" => "'Email2'", "maxlength" => "20")) ?>
            </div>
        </div>  
    </div>

    <div class="row bottom_gap">

        <div class="col-lg-2 padding_top_label">Phone1</div>  

        <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("Phone1", "", array("class" => "'form-control'", "placeholder" => "'Phone1'", "maxlength" => "20")) ?>
            </div>
        </div> 

        <div class="col-lg-2 padding_top_label">Phone2</div>  

        <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("Phone2", "", array("class" => "'form-control'", "placeholder" => "'Phone2'", "maxlength" => "20")) ?>
            </div>
        </div> 




    </div>

    <div class="row bottom_gap">
        <div class="col-lg-2 padding_top_label">Mob1</div>  

        <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("Mob1", "", array("class" => "'form-control'", "placeholder" => "'Mob1'", "maxlength" => "20")) ?>
            </div>
        </div> 

        <div class="col-lg-2 padding_top_label">Mob2</div>  

        <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("Mob2", "", array("class" => "'form-control'", "placeholder" => "'Mob2'", "maxlength" => "20")) ?>
            </div>
        </div> 





    </div>


    <div class="row bottom_gap">
        <div class="col-lg-2 padding_top_label">Address1</div>  

        <div class="col-lg-4">
            <div class="form-group">
                <textarea rows="5" placeholder="Address1" name="Add1" class="form-control"></textarea>

            </div>
        </div>

        <div class="col-lg-2 padding_top_label">Address2</div>  

        <div class="col-lg-4">
            <div class="form-group">
                <textarea rows="5" placeholder="Address2" name="Add2" class="form-control"></textarea>

            </div>
        </div>



    </div>



    <div class="row bottom_gap">
        <div class="col-lg-2 padding_top_label">Country</div>  
        <div class="col-lg-4">
            <div class="form-group">	
                <?php echo form_dropdown("Country", $country_list, $Branch_obj->Country, "class='form-control chosen-select'") ?>
            </div><!-- /input-group -->               
        </div>

        <div class="col-lg-2 padding_top_label">State</div>  
        <div class="col-lg-4">
            <div class="form-group">	
                <?php echo form_dropdown("state_id", $state_list, $Branch_obj->state_id, "class='form-control chosen-select'") ?>
            </div><!-- /input-group -->               
        </div>





    </div>



    <div class="row bottom_gap">
<!--        <div class="col-lg-2 padding_top_label">City</div>  
        <div class="col-lg-4">
            <div class="form-group">	
                <?php //echo form_dropdown("cityid", $City_list, "", "class='form-control chosen-select'") ?>
            </div> /input-group                
        </div>-->

        <div class="col-lg-2 padding_top_label">District</div>  
        <div class="col-lg-4">
            <div class="form-group">	
                <?php echo form_dropdown("District", $City_list, $Branch_obj->District, "class='form-control chosen-select'") ?>
            </div><!-- /input-group -->               
        </div>

    

<!--        <div class="col-lg-2 padding_top_label">Locality</div>  
        <div class="col-lg-4">
            <div class="form-group">	
                <?php //echo form_dropdown("Locality", $locality_list, "", "class='form-control chosen-select'") ?>
            </div> /input-group                
        </div>-->

        <div class="col-lg-2 padding_top_label">Pincode</div>  
        <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("Pincode", "", array("class" => "'form-control'", "placeholder" => "'Pincode'", "maxlength" => "20")) ?>
            </div>
        </div>


    </div>


    <div class="row bottom_gap">

        <div class="col-lg-2 padding_top_label">Login Panel Url</div>  

        <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("login_panel_url", base_url(), array("class" => "'form-control'", "placeholder" => "'Login Panel Url'")) ?>
            </div>
        </div>  
    </div> 
    <!--    <div class="row bottom_gap">
            <div class="col-lg-2 padding_top_label">Emp Pass Templete</div>  
    
            <div class="col-lg-4">
                <div class="form-group">
                    <textarea rows="5" placeholder="Emp Pass Templete" name="emp_pass_template" class="form-control"></textarea>
    
                </div>
            </div>
    
    
    
    
            <div class="col-lg-2 padding_top_label">Remarks</div>  
    
            <div class="col-lg-4">
                <div class="form-group">
                    <textarea rows="5" placeholder="Remarks" name="Remarks" class="form-control"></textarea>
    
                </div>
            </div>
    
        </div>-->





    <div class="row bottom_gap">
        <button type="submit"  name="sbt_btn" value="Save" class="btn btn-success btn-md">
            <span class="glyphicon glyphicon-floppy-disk"></span> Create Branch
        </button>
        <button type="reset"  value="Save" class="btn btn-success btn-md">
            <span class="glyphicon glyphicon-refresh"></span> Reset
        </button>
    </div>




</div>
<?php echo form_close(); ?>
<script>
              /* 
               * To change this license header, choose License Headers in Project Properties.
               * To change this template file, choose Tools | Templates
               * and open the template in the editor.
               */
              //      Form Validation           
              $(document).ready(function () {
                  $('#branch_form').bootstrapValidator({
                      feedbackIcons: {
                          valid: 'glyphicon glyphicon-ok',
                          invalid: 'glyphicon glyphicon-remove',
                          validating: 'glyphicon glyphicon-refresh'
                      },
                      fields: {
                          BranchCode: {// field name
                              validators: {
                                  notEmpty: {
                                      message: 'Branch Code is required and can\'t be empty'
                                  },
                                  regexp: {
                                      regexp: /^[a-zA-Z0-9_]+$/,
                                      message: 'Branch Code can only consist alphabets and numbers'
                                  },
                                  stringLength: {
                                      min: 4,
                                      max: 10,
                                      message: 'Branch Code must be 4 characters long and maximum 10 characters long'
                                  }
                              }
                          }, Bname: {// field name
                              validators: {
                                  notEmpty: {
                                      message: 'Branch Name is required and can\'t be empty'
                                  },
                                  regexp: {
                                      regexp: /^[a-z\s]+$/i,
                                      message: 'Branch Name can only consist alphabets and numbers'
                                  },
                                  stringLength: {
                                      min: 4,
                                      max: 10,
                                      message: 'Branch Name must be 4 characters long and maximum 10 characters long'
                                  }
                              }
                          }, Max_Std_In_Batch: {// field name
                              validators: {
                                  notEmpty: {
                                      message: 'Field is required and can\'t be empty'
                                  },
                                  regexp: {
                                      regexp: /^[0-9_]+$/,
                                      message: 'Field can only consist of numbers'
                                  },
                                  stringLength: {
                                      min: 1,
                                      max: 5,
                                      message: 'Field must be 1 characters long and maximum 5 characters long'
                                  }
                              }
                          }, Min_Emp_Age: {// field name
                              validators: {
                                  notEmpty: {
                                      message: 'Field is required and can\'t be empty'
                                  },
                                  regexp: {
                                      regexp: /^[0-9_]+$/,
                                      message: 'Field can only consist of numbers'
                                  },
                                  stringLength: {
                                      min: 1,
                                      max: 5,
                                      message: 'Field must be 1 characters long and maximum 3 characters long'
                                  }
                              }
                          }, Min_Std_Age: {// field name
                              validators: {
                                  notEmpty: {
                                      message: 'Field is required and can\'t be empty'
                                  },
                                  regexp: {
                                      regexp: /^[0-9_]+$/,
                                      message: 'Field can only consist of numbers'
                                  },
                                  stringLength: {
                                      min: 1,
                                      max: 5,
                                      message: 'Field must be 1 characters long and maximum 3 characters long'
                                  }
                              }
                          }, Mob1: {// field name
                              validators: {
                                  notEmpty: {
                                      message: 'Field is required and can\'t be empty'
                                  },
                                  regexp: {
                                      regexp: /^[0-9_]+$/,
                                      message: 'Field can only consist of numbers'
                                  },
                                  stringLength: {
                                      min: 10,
                                      max: 12,
                                      message: 'Field must be 10 characters long'
                                  }
                              }
                          }
//                          , Pincode: {// field name
//                              validators: {
//                                  notEmpty: {
//                                      message: 'Field is required and can\'t be empty'
//                                  },
//                                  regexp: {
//                                      regexp: /^[0-9_]+$/,
//                                      message: 'Field can only consist of numbers'
//                                  },
//                                  stringLength: {
//                                      min: 6,
//                                      max: 6,
//                                      message: 'Field must be of 6 characters long'
//                                  }
//                              }
//                          }
                          
                           , Email1: {// field name
                              validators: {
                                  notEmpty: {
                                      message: 'Field is required and can\'t be empty'
                                  },
                                  emailAddress: {
                                      message: 'The value is not a valid email address'
                                  }
                              }
                          }
                      }

                  });
              });



</script>
<div class="row">
              <?php echo $branch_list_view; ?>
</div>
</div>
<link href="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>




<!--for form validation-->
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>