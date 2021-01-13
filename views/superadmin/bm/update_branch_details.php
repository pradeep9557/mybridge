<div id="page-wrapper" style="min-height: 345px;">
<div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Update Branch Details</h4>
             <?php
            if (isset($error)) {
                          $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <?php // $this->util_model->printr($branch_details); ?>
    
     <?php
    echo form_open(base_url() . "sp-admin/bm/update_branch","id='branch_form'");
    ?>
    
        <div class="row bottom_gap">
         <div class="col-lg-2 padding_top_label">Branch Code</div>
        <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_hidden("id",$branch_details->BranchID);?>
                <?php echo form_input("BranchCode", $branch_details->BranchCode, array("class" => "'form-control'", "placeholder" => "'Branch Code'", "maxlength" => "20")) ?>
            </div>
        </div>
        
    <div class="col-lg-2 padding_top_label">Branch Name</div>  
    
    <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("Bname", $branch_details->Bname, array("class" => "'form-control'", "placeholder" => "'Branch Name'", "maxlength" => "20")) ?>
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
    

 <div class="row bottom_gap">
     <div class="col-lg-2 padding_top_label">Head Branch ID</div>  
     <div class="col-lg-4">
            <div class="form-group">	
                <?php echo form_dropdown("HeadBID", $a_branches, $Branch_obj->HeadBID, "class='form-control chosen-select'") ?>
            </div><!-- /input-group -->               
        </div>
        
        
         <div class="col-lg-2">Head Branch</div> 
<div class="col-lg-4">
            <input name="HeadB" type="checkbox" checked="true" value="1" class="form-control bootswitches">
        </div>

</div>
    
    
 <div class="row bottom_gap">
 
  <div class="col-lg-2 padding_top_label">Email1</div>  
    
    <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("Email1",  $branch_details->Email1, array("class" => "'form-control'", "placeholder" => "'Email1'", "maxlength" => "20")) ?>
            </div>
        </div> 
        
        <div class="col-lg-2 padding_top_label">Email2</div>  
    
    <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("Email2", $branch_details->Email2, array("class" => "'form-control'", "placeholder" => "'Email2'", "maxlength" => "20")) ?>
            </div>
        </div> 
 
 
 
 
 
 
 
</div>

<div class="row bottom_gap">

<div class="col-lg-2 padding_top_label">Phone1</div>  
    
    <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("Phone1", $branch_details->Phone1, array("class" => "'form-control'", "placeholder" => "'Phone1'", "maxlength" => "20")) ?>
            </div>
        </div> 
        
        <div class="col-lg-2 padding_top_label">Phone2</div>  
    
    <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("Phone2", $branch_details->Phone2, array("class" => "'form-control'", "placeholder" => "'Phone2'", "maxlength" => "20")) ?>
            </div>
        </div> 




</div>

<div class="row bottom_gap">
<div class="col-lg-2 padding_top_label">Mob1</div>  
    
    <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("Mob1", $branch_details->Mob1, array("class" => "'form-control'", "placeholder" => "'Mob1'", "maxlength" => "20")) ?>
            </div>
        </div> 
        
        <div class="col-lg-2 padding_top_label">Mob2</div>  
    
    <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("Mob2", $branch_details->Mob2, array("class" => "'form-control'", "placeholder" => "'Mob2'", "maxlength" => "20")) ?>
            </div>
        </div> 





</div>


<div class="row bottom_gap">
        <div class="col-lg-2 padding_top_label">Address1</div>  

<div class="col-lg-4">
            <div class="form-group">
<textarea rows="5" placeholder="Address1" name="Add1" class="form-control"><?php echo $branch_details->Add1?></textarea>

            </div>
        </div>
        
        <div class="col-lg-2 padding_top_label">Address2</div>  

<div class="col-lg-4">
            <div class="form-group">
<textarea rows="5" placeholder="Address2" name="Add2" class="form-control"><?php echo $branch_details->Add2?></textarea>

            </div>
        </div>



</div>



<div class="row bottom_gap">
 <div class="col-lg-2 padding_top_label">Country</div>  
     <div class="col-lg-4">
            <div class="form-group">	
                <?php echo form_dropdown("Country", $country_list, $branch_details->Country, "class='form-control chosen-select'") ?>
            </div><!-- /input-group -->               
        </div>
        
         <div class="col-lg-2 padding_top_label">State</div>  
     <div class="col-lg-4">
            <div class="form-group">	
                <?php echo form_dropdown("state_id", $state_list, $branch_details->state_id, "class='form-control chosen-select'") ?>
            </div><!-- /input-group -->               
        </div>
        




</div>



<div class="row bottom_gap">
     
         <div class="col-lg-2 padding_top_label">District</div>  
     <div class="col-lg-4">
            <div class="form-group">	
                <?php echo form_dropdown("District", $City_list, $branch_details->District, "class='form-control chosen-select'") ?>
            </div><!-- /input-group -->               
        </div>
         <div class="col-lg-2 padding_top_label">Pincode</div>  
     <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("Pincode",$branch_details->Pincode, array("class" => "'form-control'", "placeholder" => "'Pincode'", "maxlength" => "20")) ?>
            </div>
        </div>

</div>

<div class="row bottom_gap">

 <div class="col-lg-2 padding_top_label">Login Panel Url</div>  
    
    <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("login_panel_url", $branch_details->login_panel_url, array("class" => "'form-control'", "placeholder" => "'Login Panel Url'")) ?>
            </div>
        </div> 

</div>





<div class="row bottom_gap">
 <button type="submit"  value="Save" class="btn btn-success btn-md">
            <span class="glyphicon glyphicon-floppy-disk"></span> Update
        </button>
        <button type="reset"  value="Save" class="btn btn-success btn-md">
            <span class="glyphicon glyphicon-refresh"></span> Reset
        </button>
</div>



    
</div>
<?php form_close(); ?>
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
                          StudentName: {// field name
                              validators: {
                                  notEmpty: {
                                      message: 'Student Name is required and can\'t be empty'
                                  },
                                  regexp: {
                                      regexp: /^[a-zA-Z\s]+$/,
                                      message: 'Student Name can only consist alphabets'
                                  },
                                  stringLength: {
                                      min: 3,
                                      max: 25,
                                      message: 'Student Name must be more 3 characters long'
                                  }
                              }
                          }, FatherName: {
                              message: 'Father Name is not valid',
                              validators: {
                                  notEmpty: {
                                      message: 'Father Name is required and can\'t be empty'
                                  },
                                  regexp: {
                                      regexp: /^[a-zA-Z\s]+$/,
                                      message: 'Father Name can only consist alphabets'
                                  }
                              }
                          }, MotherName: {
                              message: 'Mother Name is not valid',
                              validators: {
                                  regexp: {
                                      regexp: /^[a-zA-Z\s]+$/,
                                      message: 'Mother Name can only consist alphabets'
                                  }
                              }
                          }, Email1: {
                              validators: {
                                  emailAddress: {
                                      message: 'Invalid Email address'
                                  }
                              }
                          }, Email2: {
                              validators: {
                                  emailAddress: {
                                      message: 'Invalid Email address'
                                  }
                              }
                          }, Mobile1: {
                              validators: {
                                  notEmpty: {
                                      message: 'Mobile is required and can\'t be empty'
                                  },
                                  regexp: {
                                      //regexp: /^[a-zA-Z]+$/,
                                      regexp: /^[0-9\,]+$/,
                                      message: 'Invalid Mobile number'
                                  },
                                  stringLength: {
                                      min: 10,
                                      max: 21,
                                      message: 'Mobile no. should be 10 characters long'
                                  }
                              }
                          }, Phone1: {
                              validators: {
//                         notEmpty: {
//                            message: 'Phone is required and can\'t be empty'
//                        },
                                  regexp: {
                                      //regexp: /^[a-zA-Z]+$/,
                                      regexp: /^[0-9\,]+$/,
                                      message: 'Invalid Phone number'
                                  }
                              }
                          }, C_city: {
                              validators: {
                                  notEmpty: {
                                      message: 'City is required and can\'t be empty'
                                  }
                              }
                          }, C_state: {
                              validators: {
                                  notEmpty: {
                                      message: 'State and is required and can\'t be empty'
                                  }, regexp: {
                                      regexp: /^[a-zA-Z\s]+$/,
                                      message: 'Invalid State name'
                                  }
                              }
                          }, Quali: {
                              validators: {
                                  notEmpty: {
                                      message: 'Qualification is required and can\'t be empty'
                                  }
                              }
                          }, Nationality: {
                              validators: {
                                  notEmpty: {
                                      message: 'Nationality is required and can\'t be empty'
                                  }
                              }
                          }, C_village_and_post: {
                              validators: {
                                  notEmpty: {
                                      message: 'Village and Post is required and can\'t be empty'
                                  }
                              }
                          },
                          DOB: {
                              validators: {
                                  notEmpty: {
                                      message: 'Date is required and can\'t be empty'
                                  },
                                  date: {
                                      format: 'DD-MM-YYYY'
                                  }
                              }
                          }, C_pincode: {
                              validators: {
                                  notEmpty: {
                                      message: 'Pincode is required and can\'t be empty'
                                  },
                                  regexp: {
                                      //regexp: /^[a-zA-Z]+$/,
                                      regexp: /^(\d{6})+$/,
                                      message: 'Invalid PinCode'
                                  }
                              }
                          }, P_pincode: {
                              validators: {
//                         notEmpty: {
//                            message: 'Phone is required and can\'t be empty'
//                        },
                                  regexp: {
                                      //regexp: /^[a-zA-Z]+$/,
                                      regexp: /^(\d{6})+$/,
                                      message: 'Invalid PinCode'
                                  }
                              }
                          }
                      }

                  });
              });



</script>
<link href="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>




<!--for form validation-->
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>