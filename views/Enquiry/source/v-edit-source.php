
<div id="page-wrapper" style="min-height: 345px;">
<div class="row">
        <div class="col-lg-12">
            <h4 class="page-header group_title ">Edit Source</h4>
             <?php
            if (isset($error)) {
              $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <?php
    //for normal form
    //  echo form_open('/dashboard/new_admission',$attributes);
    echo form_open_multipart(base_url() . 'Enquiry/source/EditSource',array('id'=>'editsourcefrom'));
    ?>
    <!--String of Row-->
    <div class="row bottom_gap">
         <div class="col-lg-2 padding_top_label">Branch<span class="Compulsory">*</span ></div>
        <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_dropdown("BranchID", array($Branch_obj->BranchID=>$Branch_obj->BranchCode),$SourceData['BranchID'],"class='form-control chosen-select' subid='ParentSelectList' onchange='load_parents(this)'") ?>
            </div>
        </div>
        <div class="col-lg-2 padding_top_label">Source Code</div>
        <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("Src_Code",$SourceData['Src_Code'], array("class" => "'form-control'", "placeholder" => "'Source code'", "maxlength" => "20")) ?>
                
            </div><!-- /input-group -->               
            
        </div> <!-- end of col-lg-4 -->
        
    </div> 
    
    <div class="row bottom_gap">
       
       
    </div>
     <div class="row bottom_gap">
          <div class="col-lg-2 padding_top_label">Source Name</div>
        <div class="col-lg-4">
            <div class="form-group">
                <?php echo form_input("Src_Name",$SourceData['Src_Name'], array("class" => "'form-control'", "placeholder" => "'Source Name'", "maxlength" => "20")) ?>
                <input type="hidden" value="<?=$SourceData['SrcId']?>" name="Src_Id"/>
            </div><!-- /input-group -->               
            
        </div> <!-- end of col-lg-4 -->
        <div class="col-lg-2 padding_top_label">Parent<span class="Compulsory">*</span></div>
        <div class="col-lg-4">
            <div class="form-group" id="ParentSelectList">
                <?php echo form_dropdown("Parent", $Parent,$SourceData['Parent'],"class='form-control chosen-select'") ?>
            </div>
        </div>
    </div>
    <div class="row bottom_gap">
        <div class="col-lg-2 padding_top_label">Status<span class="Compulsory">*</span></div>
        <div class="col-lg-4">
             <div class="form-group">
                     <input class="bootswitches"  name="Status" type="checkbox" value="1" <?=$SourceData['Status'] =='1' ?"checked='true'":""?> >
             </div>
        </div>
    </div>
    
    
    <!--End of row-->
    <!--String of Row-->
  
    <div class="row">
        <button type="submit" name="source_submit" value="Save"  class="btn btn-success btn-md">
            <span class="glyphicon glyphicon-floppy-disk"></span> Save
        </button>
        <button type="reset" name="Reset" value="Save" class="btn btn-success btn-md">
            <span class="glyphicon glyphicon-refresh"></span> Reset
        </button>

    </div>
    <?php echo form_close();
 
    ?>
</div>
    <script>
        /* 
               * To change this license header, choose License Headers in Project Properties.
               * To change this template file, choose Tools | Templates
               * and open the template in the editor.
               */
              //      Form Validation           
              $(document).ready(function () {
                  $('#addSourceForm').bootstrapValidator({
                      feedbackIcons: {
                          valid: 'glyphicon glyphicon-ok',
                          invalid: 'glyphicon glyphicon-remove',
                          validating: 'glyphicon glyphicon-refresh'
                      },
                      fields: {
                          Src_Code: {// field name
                              validators: {
                                  notEmpty: {
                                      message: 'Source Code is required and can\'t be empty'
                                  },
                                  regexp: {
                                      regexp: /^[a-zA-Z_0-9]+$/,
                                      message: 'Source Codee can only consist alphanumeric and underscore'
                                  },
                                  stringLength: {
                                      min: 3,
                                      max: 15,
                                      message: 'Source Code must be more 3-15 characters long'
                                  }
                              }
                          }, Src_Name: {
                              message: 'Source Name is not valid',
                              validators: {
                                  notEmpty: {
                                      message: 'Source Name is required and can\'t be empty'
                                  },
                                  regexp: {
                                      regexp: /^[a-zA-Z\s]+$/,
                                      message: 'Source Name can only consist alphanumeric,space and underscore'
                                  },
                                  stringLength: {
                                      min: 3,
                                      max: 50,
                                      message: 'Source Name must be more 3-50 characters long'
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