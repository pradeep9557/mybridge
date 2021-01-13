<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Add New Expense</h4>
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
            <h3 class="panel-title toggle_custom">Add Expense
                <span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>  

        <div class="panel-body collapse" id="collapseExample">
            <?php
            
            echo form_open(base_url() . "expense/c_expense/insert_data", "id='expense_mst'");
            ?>
            <div class="row bottom_gap">
                
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Date of Expense</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class='input-group date bdatetimepicker' >
                        <input type='text' class="form-control" name="ex_date" value="<?= date(DTF) ?>"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>

                </div>
                
                <div class="col-lg-2">Expense Type</div>
                <div class="col-lg-4"> <?php echo form_dropdown('ex_type_id',$ex_type,1,"class='form-control chosen-select'")  ?></div>
            
            </div>   
 
            <div class="row bottom_gap">
                <div class="col-lg-2">Expense Amount (Rs.)</div>
                <div class="col-lg-4"><?php echo form_input('ex_amt','',"class='form-control' Placeholder='Amount'")  ?></div>
                <div class="col-lg-2">Expense By</div>
                <div class="col-lg-4"> <?php echo form_dropdown('ex_by',$emp_list,1,"class='form-control chosen-select'")  ?></div>     
            </div>
            
            <div class="row bottom_gap">
                <div class="col-lg-2">Description</div>
                <div class="col-lg-4"><?php echo form_textarea('ex_des','',"class='form-control' Placeholder='Description'")  ?></div>     
            </div>
            
            <div class="row bottom_gap">
                <div class="col-lg-12">
                    <button type="submit" value="Save" class="btn btn-success btn-md">
                        <span class="glyphicon glyphicon-floppy-disk"></span> Save
                    </button>
                    <button type="reset" value="reset" class="btn btn-success btn-md">
                        <span class="glyphicon glyphicon-refresh"></span> Reset
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
        $Curr_Obj->list_all_expenses();
        ?>  
    </div> 
  </div>
</div>
<?php 
   $this->load->view("expense/expense_validation");
 ?>