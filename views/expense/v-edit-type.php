<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Edit Expense Type</h4>
            <?php
            if (isset($error)) {
                $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
     <div class="row">
        <div class="col-lg-12">
    <div class="panel panel-primary">
        <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
            <h3 class="panel-title toggle_custom">Edit Expense Type
                <span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>  

        <div class="panel-body collapse" id="collapseExample">
            <?php
            echo form_open(base_url() . "expense/c_ex_type/update_type/$type_data->ex_type_id", "id='expense_type_mst'");
            ?>
            
            <div class="row bottom_gap">
                <div class="col-lg-2">Expense Type</div>
                <div class="col-lg-4"><?php echo form_input('ex_type_code',$type_data->ex_type_code,"class='form-control'")  ?></div>
                
            </div>   
            
            <div class="row bottom_gap">
                <div class="col-lg-2">Remarks</div>
                <div class="col-lg-4"><?php echo form_textarea('Remarks',$type_data->Remarks,"class='form-control' Placeholder='Remarks'")  ?></div>     
            </div>
            
            <div class="row bottom_gap">
                <div class="col-lg-12">
                    <button type="submit" value="Update" class="btn btn-success btn-md">
                        <span class="glyphicon glyphicon-floppy-disk"></span> Update
                    </button>
                </div>
            </div>
            
        </div>
        <?php
// closing the form
        echo form_close();
        ?> 
    </div>
        </div>
     </div>
    
  <div class="row">
        <div class="col-lg-12">
        <?php
        $Curr_Obj = & get_instance();
        $Curr_Obj->display_all_types();
        ?>
    </div> 
  </div>
</div>
<?php 
   $this->load->view("expense/expense_type_validation");
?>
