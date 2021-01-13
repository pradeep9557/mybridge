<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/>
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row"> 
        <div class="col-lg-12">
            <h4 class="page-header ">Generate Bills</h4>
            <?php
            if (isset($error)) {
                $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?> 
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php
            echo $bill_search_view;
//            $this->util_model->printr($bill_data);
            ?>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
            <h3 class="panel-title toggle_custom"><?php echo (isset($bill_data) && !empty($bill_data)) ? "Edit Bill Form" : "Generate Bill Form" ?><span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
        <div class="panel-body collapse" id="collapseExample">   
            <?php
            //for normal form
            //  echo form_open('/dashboard/new_admission',$attributes);
            echo form_open_multipart(base_url() . 'tms/manage_bills/bill_master_save_update', "id='bill_save_update_form'");
            ?>
            <?php if (isset($bill_data) && !empty($bill_data)) { ?>
                <input type="hidden" name="action_performed" value="update" />
                <input type="hidden" name="bill_mst_id" value="<?= $bill_data['bill_mst_id'] ?>" />
            <?php } else { ?>
                <input type="hidden" name="action_performed" value="save" />
            <?php }
            ?>

            <div class="row bottom_gap"> 
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Billing Type<span class="Compulsory">*</span></div>
                <div class="col-lg-10 col-md-10 col-sm-8"> 
                    <div class="form-group">
                        <?php
                        echo form_dropdown("billtype", $btypelist, (isset($billtype) && $bill_data['billtype'] != "") ? $bill_data['billtype'] : 0, " class='form-control chosen-select' required='required' ")
                        ?>
                    </div> 
                </div>
            </div>
            <div class="row bottom_gap"> 
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Billing Client<span class="Compulsory">*</span></div>
                <div class="col-lg-10 col-md-10 col-sm-8"> 
                    <div class="form-group">
                        <?php
                        echo form_dropdown("client_id", $all_cilents, (isset($bill_data) && $bill_data['client_id'] != "") ? $bill_data['client_id'] : 0, " class='form-control chosen-select client_list' ")
                        ?>
                    </div> 
                </div>
            </div>
            <div class="row bottom_gap"> 
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Client Billing Name<span class="Compulsory">*</span></div>
                <div class="col-lg-10 col-md-10 col-sm-8"> 
                    <div class="form-group">
                        <?php echo form_input("client_billing_name", (isset($bill_data['client_billing_name']) && $bill_data['client_billing_name'] != "") ? $bill_data['client_billing_name'] : "", array("class" => "'form-control client_billing_name'", "placeholder" => "'Client Billing Address'")) ?>
                    </div> 
                </div>
            </div>
            <div class="row bottom_gap"> 
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Client Billing Address 1<span class="Compulsory">*</span></div>
                <div class="col-lg-10 col-md-10 col-sm-8"> 
                    <div class="form-group">
                        <?php echo form_input("client_billing_add1", (isset($bill_data['client_billing_add1']) && $bill_data['client_billing_add1'] != "") ? $bill_data['client_billing_add1'] : "", array("class" => "'form-control client_billing_add1'", "placeholder" => "'Client Billing Address Line 1'")) ?>
                    </div> 
                </div>
            </div>
            <div class="row bottom_gap"> 
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Client Billing Address 2<span class="Compulsory">*</span></div>
                <div class="col-lg-10 col-md-10 col-sm-8"> 
                    <div class="form-group">
                        <?php echo form_input("client_billing_add2", (isset($bill_data['client_billing_add2']) && $bill_data['client_billing_add2'] != "") ? $bill_data['client_billing_add2'] : "", array("class" => "'form-control client_billing_add2'", "placeholder" => "'Client Billing Address Line 2'")) ?>
                    </div> 
                </div>
            </div>
            <div class="row bottom_gap"> 
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Client GST Number<span class="Compulsory">*</span></div>
                <div class="col-lg-10 col-md-10 col-sm-8"> 
                    <div class="form-group">
                        <?php echo form_input("client_gst_no", (isset($bill_data['client_gst_no']) && $bill_data['client_gst_no'] != "") ? $bill_data['client_gst_no'] : "", array("class" => "'form-control client_gst_no'", "placeholder" => "'Client GST No'")) ?>
                    </div> 
                </div>
            </div>
            <div class="row bottom_gap"> 
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Client PO Number<span class="Compulsory">*</span></div>
                <div class="col-lg-10 col-md-10 col-sm-8"> 
                    <div class="form-group">
                        <?php echo form_input("client_po", (isset($bill_data['client_po']) && $bill_data['client_po'] != "") ? $bill_data['client_po'] : "", array("class" => "'form-control client_po'", "placeholder" => "'Client PO number'")) ?>
                    </div> 
                </div>
            </div>
            <div class="row bottom_gap"> 
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Filter Task of Clients<span class="Compulsory">*</span></div>
                <div class="col-lg-10 col-md-10 col-sm-8"> 
                    <div class="form-group">
                        <?php
                        echo form_multiselect("clients[]", $unbilled_client_list, (isset($bill_data) && $bill_data['clients'] != "") ? explode(',', $bill_data['clients']) : array(), " class='form-control chosen-select get_client_task' ");
                        ?>
                    </div> 
                </div>
            </div>
            <div class="row bottom_gap"> 
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Task Name<span class="Compulsory">*</span></div>
                <div class="col-lg-10 col-md-10 col-sm-8"> 
                    <div class="form-group">
                        <?php echo form_multiselect("tm_id[]", $task_list, isset($bill_data['tm_id']) ? $bill_data['tm_id'] : array(), "class='form-control chosen-select task_list' ") ?>   
                    </div> 
                </div>
                <!-- /input-group -->               

            </div> <!--End of row-->
            <div class="row bottom_gap">

                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Bill Date Date</div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class='input-group date bill_date'>
                        <input type='text' class="form-control" name="bill_due_date" value="<?php echo (isset($bill_data['bill_due_date']) && $bill_data['bill_due_date'] != "") ? date(DF, strtotime($bill_data['bill_due_date'])) : date(DF) ?>"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                    <!--                    <div class='input-group date bdatetimepicker' >
                                            <input type='text' class="form-control" name="bill_due_date" value="<?php echo (isset($bill_data['bill_due_date']) && $bill_data['bill_due_date'] != "") ? date(DF, strtotime($bill_data['bill_due_date'])) : date(DF) ?>"/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>-->
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Bill Number<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8">
                    <div class="form-group"> 
                        <?php echo form_input("bill_no", (isset($bill_data['bill_no']) && $bill_data['bill_no'] != "") ? $bill_data['bill_no'] : "", array("class" => "'form-control bill_no'", "placeholder" => "'Bill Number'")) ?>
                    </div> 
                </div>
            </div> <!--End of row-->

            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Service List<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <?php echo form_dropdown("serCatCode", $service_list, (isset($bill_data['serCatCode']) && $bill_data['serCatCode'] != "") ? $bill_data['serCatCode'] : "", " class='form-control services_list'") ?>
                    </div> 
                </div> 
            </div> <!--End of row-->
            <div class="row bottom_gap server_container">
                <div class="single_ser_box"></div>
                <?php
                if (isset($bill_data['ser_data']) && $bill_data['ser_data'] != "") {
                    $i = 1;
                    foreach ($bill_data['ser_data'] as $eachSer) {
                        ?>
                        <div class="single_ser_box">
                            <div class="col-md-12">
                                <h4>
                                    <span class="sub_task_num" id="subtask<?php echo $i; ?>"># Services <?php echo $i; ?></span>
                                </h4>
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">
                                Service Name<span class="Compulsory">*</span>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-8"> 
                                <div class="form-group">
                                    <textarea type="text" class="form-control ser_name" rows="5" name="service_name[]" placeholder="Enter Service"/><?php echo $eachSer['ser_name'] ?></textarea>
                                </div> 
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-4">
                                <div class="form-group">
                                    <input type="text" class="form-control ser_amt" placeholder="service amount" value="<?php echo $eachSer['amt'] ?>" onkeydown ="total_amt()" onblur="total_amt()" onkeypress="total_amt()" name="amt[]"/>
                                </div> 
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2"> 

                                <div class="form-group">
                                    <input type="text" class="form-control ser_sort" placeholder="Sort" name="sort[]" value="<?php echo $eachSer['sort'] ?>"/>
                                </div> 
                            </div>
                            <div class="col-lg-2 col-md-2 col-sm-2"> 
                                <button type="button" class="add_ser  btn btn-danger btn-md">
                                    <span class="glyphicon glyphicon-plus"></span>
                                </button>
                                <button type="button" class="remove_ser  btn btn-success btn-md">
                                    <span class="glyphicon glyphicon-minus"></span>
                                </button>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div> <!--End of row-->

            <!--String of Row-->
            <div class="row bottom_gap">
                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Professional Fee<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <?php echo form_input("bill_amt", (isset($bill_data['bill_amt']) && $bill_data['bill_amt'] != "") ? $bill_data['bill_amt'] : "", array("class" => "'form-control bill_amt'", "placeholder" => "'Bill Amount'", 'onkeydown' => "total_amt()", 'onblur' => "total_amt()", 'onkeypress' => "total_amt()")) ?>
                    </div> 
                </div> 
            </div> <!--End of row--> 
            <div class="row bottom_gap ser_tax"> 
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Service Tax (<?php if($get_tax_rate[0]['name']=='Service Tax'){ echo $get_tax_rate[0]['rate']; }?>)<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <input type="checkbox"   onclick="total_amt()"> Applicable<?php echo form_input("ser_tax", (isset($bill_data['ser_tax']) && $bill_data['ser_tax'] != "") ? $bill_data['ser_tax'] : "", array("class" => "'form-control ser_tax'", "placeholder" => "'Service Tax'", 'onkeydown' => "total_amt()", 'onblur' => "total_amt()", 'onkeypress' => "total_amt()")) ?>
                    </div> 
                </div>
            </div>
            <div class="row bottom_gap etax">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">EduTax (<?php if($get_tax_rate[1]['name']=='EduTax'){ echo $get_tax_rate[1]['rate']; }?>)<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <input type="checkbox" <?php echo (isset($bill_data['etax']) && $bill_data['etax'] != "0") ? 'checked' : "" ?> onclick="total_amt()"> Applicable<?php echo form_input("etax", (isset($bill_data['etax']) && $bill_data['etax'] != "") ? $bill_data['etax'] : "", array("class" => "'form-control etax'", "placeholder" => "'EduTax'", 'onkeydown' => "total_amt()", 'onblur' => "total_amt()", 'onkeypress' => "total_amt()")) ?>
                    </div> 
                </div>
            </div>
            <div class="row bottom_gap ktax">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">KTax (<?php if($get_tax_rate[2]['name']=='KTax'){ echo $get_tax_rate[2]['rate']; }?>)<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <input type="checkbox" <?php echo (isset($bill_data['ktax']) && $bill_data['ktax'] != "0") ? 'checked' : "" ?>  onclick="total_amt()"> Applicable<?php echo form_input("ktax", (isset($bill_data['ktax']) && $bill_data['ktax'] != "") ? $bill_data['ktax'] : "", array("class" => "'form-control ktax'", "placeholder" => "'KTax '", 'onkeydown' => "total_amt()", 'onblur' => "total_amt()", 'onkeypress' => "total_amt()")) ?>
                    </div> 
                </div>
            </div>
            <div class="row bottom_gap CGST">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">CGST (<?php if($get_tax_rate[3]['name']=='CGST'){ echo $get_tax_rate[3]['rate']; }?>)<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <input type="checkbox" <?php echo (isset($bill_data['CGST']) && $bill_data['CGST'] != "0") ? 'checked' : "" ?>  onclick="total_amt()"> Applicable<?php echo form_input("CGST", (isset($bill_data['CGST']) && $bill_data['CGST'] != "") ? $bill_data['CGST'] : "", array("class" => "'form-control CGST'", "placeholder" => "'CGST '", 'onkeydown' => "total_amt()", 'onblur' => "total_amt()", 'onkeypress' => "total_amt()")) ?>
                    </div> 
                </div>
            </div>
            <div class="row bottom_gap IGST">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">IGST (<?php if($get_tax_rate[4]['name']=='IGST'){ echo $get_tax_rate[4]['rate']; }?>)<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <input type="checkbox" <?php echo (isset($bill_data['IGST']) && $bill_data['IGST'] != "0") ? 'checked' : "" ?>  onclick="total_amt()"> Applicable<?php echo form_input("IGST", (isset($bill_data['IGST']) && $bill_data['IGST'] != "") ? $bill_data['IGST'] : "", array("class" => "'form-control IGST'", "placeholder" => "'IGST '", 'onkeydown' => "total_amt()", 'onblur' => "total_amt()", 'onkeypress' => "total_amt()")) ?>
                    </div> 
                </div>
            </div>
            <div class="row bottom_gap SGST">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">SGST (<?php if($get_tax_rate[5]['name']=='SGST'){ echo $get_tax_rate[5]['rate']; }?>)<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <input type="checkbox" <?php echo (isset($bill_data['SGST']) && $bill_data['SGST'] != "0") ? 'checked' : "" ?>  onclick="total_amt()"> Applicable<?php echo form_input("SGST", (isset($bill_data['SGST']) && $bill_data['SGST'] != "") ? $bill_data['SGST'] : "", array("class" => "'form-control SGST'", "placeholder" => "'SGST '", 'onkeydown' => "total_amt()", 'onblur' => "total_amt()", 'onkeypress' => "total_amt()")) ?>
                    </div> 
                </div>
            </div>
            <div class="row bottom_gap UTGST">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">UTGST (<?php if($get_tax_rate[6]['name']=='UTGST'){ echo $get_tax_rate[6]['rate']; }?>)<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <input type="checkbox" <?php echo (isset($bill_data['UTGST']) && $bill_data['UTGST'] != "0") ? 'checked' : "" ?>  onclick="total_amt()"> Applicable<?php echo form_input("UTGST", (isset($bill_data['UTGST']) && $bill_data['UTGST'] != "") ? $bill_data['UTGST'] : "", array("class" => "'form-control UTGST'", "placeholder" => "'UTGST '", 'onkeydown' => "total_amt()", 'onblur' => "total_amt()", 'onkeypress' => "total_amt()")) ?>
                    </div> 
                </div>
            </div>
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Invoice Value<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <?php echo form_input("final_bill", (isset($bill_data['final_bill']) && $bill_data['final_bill'] != "") ? $bill_data['final_bill'] : "", array("class" => "'form-control final_bill'", "placeholder" => "'Final bill'", 'onkeydown' => "total_amt()", 'onblur' => "total_amt()", 'onkeypress' => "total_amt()")) ?>
                    </div> 
                </div>
            </div>

            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Account<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <?php echo form_dropdown("bill_account_id", $accountList, isset($bill_data['bill_account_id']) ? $bill_data['bill_account_id'] : '', " class='form-control chosen-select bill_acount_id' ") ?>   

                    </div> 
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Billing Company Name<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <?php echo form_input("billing_com_name", (isset($bill_data['billing_com_name']) && $bill_data['billing_com_name'] != "") ? $bill_data['billing_com_name'] : "", array("class" => "'form-control billing_com_name'", "placeholder" => "'Billing Company name'")) ?>
                    </div> 
                </div>
            </div>
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Billing Address<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <?php echo form_input("billing_add", (isset($bill_data['billing_add']) && $bill_data['billing_add'] != "") ? $bill_data['billing_add'] : "", array("class" => "'form-control billing_add'", "placeholder" => "'Billing Address'")) ?>
                    </div> 
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Billing Phone No<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <?php echo form_input("bill_phone", (isset($bill_data['bill_phone']) && $bill_data['bill_phone'] != "") ? $bill_data['bill_phone'] : "", array("class" => "'form-control Billing bill_phone'", "placeholder" => "'Billing Company name'")) ?>
                    </div> 
                </div>
            </div>
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Billing Email<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <?php echo form_input("bill_email", (isset($bill_data['bill_email']) && $bill_data['bill_email'] != "") ? $bill_data['bill_email'] : "", array("class" => "'form-control bill_email'", "placeholder" => "'Billing Email'")) ?>
                    </div> 
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Billing Pan No<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <?php echo form_input("pan_no", (isset($bill_data['pan_no']) && $bill_data['pan_no'] != "") ? $bill_data['pan_no'] : "", array("class" => "'form-control pan_no'", "placeholder" => "'Billing Pan number'")) ?>
                    </div> 
                </div>
            </div>
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Service Tax number<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <?php echo form_input("st_reg_no", (isset($bill_data['st_reg_no']) && $bill_data['st_reg_no'] != "") ? $bill_data['st_reg_no'] : "", array("class" => "'form-control st_reg_no'", "placeholder" => "'Service Tax number'")) ?>
                    </div> 
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Bank Name<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <?php echo form_input("bank_name", (isset($bill_data['bank_name']) && $bill_data['bank_name'] != "") ? $bill_data['bank_name'] : "", array("class" => "'form-control bank_name'", "placeholder" => "'Bank name'")) ?>
                    </div> 
                </div>
            </div>
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Bank Account number<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <?php echo form_input("bank_acc_no", (isset($bill_data['bank_acc_no']) && $bill_data['bank_acc_no'] != "") ? $bill_data['bank_acc_no'] : "", array("class" => "'form-control bank_acc_no'", "placeholder" => "'Bank Account number'")) ?>
                    </div> 
                </div>
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Bank IFSC<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <?php echo form_input("bank_ifsc_code", (isset($bill_data['bank_ifsc_code']) && $bill_data['bank_ifsc_code'] != "") ? $bill_data['bank_ifsc_code'] : "", array("class" => "'form-control bank_ifsc_code'", "placeholder" => "'Bank IFSC'")) ?>
                    </div> 
                </div>
            </div>
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Bank Address<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <?php echo form_input("bank_address", (isset($bill_data['bank_address']) && $bill_data['bank_address'] != "") ? $bill_data['bank_address'] : "", array("class" => "'form-control bank_address'", "placeholder" => "'Bank Address'")) ?>
                    </div> 
                </div> 
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">GST No<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <?php echo form_input("gst_no", (isset($bill_data['gst_no']) && $bill_data['gst_no'] != "") ? $bill_data['gst_no'] : "", array("class" => "'form-control gst_no'", "placeholder" => "'GST Number'")) ?>
                    </div> 
                </div> 
            </div>
            
            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Place to supply<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <?php echo form_input("place_supply", (isset($bill_data['place_supply']) && $bill_data['place_supply'] != "") ? $bill_data['place_supply'] : "", array("class" => "'form-control place_supply'", "placeholder" => "'Place to supply'")) ?>
                    </div> 
                </div> 
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">MSME No<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <?php echo form_input("msme_no", (isset($bill_data['msme_no']) && $bill_data['msme_no'] != "") ? $bill_data['msme_no'] : "", array("class" => "'form-control msme_no'", "placeholder" => "'MSME Number'")) ?>
                    </div> 
                </div> 
            </div>


            <div class="row bottom_gap">
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Status<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <?php echo form_dropdown("status", array("1" => "Enable", "0" => "Disable"), (isset($bill_data['status']) && $bill_data['status'] != "") ? $bill_data['status'] : "1", " class='form-control'") ?>
                    </div> 
                </div> 
                <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">HSN/SCN Code<span class="Compulsory">*</span></div>
                <div class="col-lg-4 col-md-4 col-sm-8"> 
                    <div class="form-group"> 
                        <?php echo form_input("hsn_scn", (isset($bill_data['hsn_scn']) && $bill_data['hsn_scn'] != "") ? $bill_data['hsn_scn'] : "", array("class" => "'form-control hsn_scn'", "placeholder" => "'HSN/SCN Code'")) ?>
                    </div> 
                </div> 
            </div>

            <div class="row bottom_gap">
                <div class="col-lg-12 padding_top_label">Remarks</div>
                <div class="col-lg-12">
                    <div class="form-group">
                        <?php echo form_textarea("remarks", (isset($bill_data['remarks']) && $bill_data['remarks'] != "") ? $bill_data['remarks'] : "", array("class" => "'form-control tinymce'", "placeholder" => "'Extra Notes for Bill'", "maxlength" => "500")) ?>
                    </div>
                </div>
            </div> <!--End of row-->
            <div class="row">
                <?php if (isset($bill_data) && !empty($bill_data)) { ?>
                    <div class="col-lg-1">
                        <?php echo form_submit("", "Update", array("class" => "'btn btn-success update'")); ?>
                    </div>
                <?php } else { ?>
                    <div class="col-lg-1">
                        <?php echo form_submit("", "Create", array("class" => "'btn btn-success save'")); ?>
                    </div>
                <?php }
                ?>
                <div class="col-lg-1">
                    <?php echo form_reset("Reset", "Reset", array("class" => "'btn btn-success'")) ?>
                </div>
            </div>
        </div>

    </div>

    <?php
    echo form_close();
    $Curr_Obj = & get_instance();
    $Curr_Obj->All_bill_List();
    ?>
</div>
<script src="<?= base_url() ?>js/chosen.jquery.min.js" type="text/javascript"></script>
<link href="<?= base_url() ?>js/multi_select/chosen.css" rel="stylesheet" type="text/css"/>
<!--<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>-->
<!--<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>-->
<link href="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= CDN1 ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<!--<script src="<?= base_url() ?>js/tinymce/js/tinymce/tinymce.min.js" type="text/javascript"></script>-->
<!--<script src="<?= CDN1 ?>js/moment.min.js" type="text/javascript"></script>-->
<script src="<?= CDN1 ?>js/jquery.form.min.js"></script>
<script>
//                            function init() {
//                                $(document).unbind(".bdatetimepicker .assignedto .remove_sub_task");
//                                $('.bdatetimepicker').datetimepicker({
//                                    format: 'DD-MM-YYYY',
//                                    icons: {
//                                        time: "fa fa-clock-o",
//                                        date: "fa fa-calendar",
//                                        up: "fa fa-arrow-up",
//                                        down: "fa fa-arrow-down"
//                                    }
//                                });
//                            }

                            function t_init(selector) {
//        tinymce.init({
//            selector: selector,
//            setup: function (editor) {
//                editor.on('change', function () {
//                    tinymce.triggerSave();
//                });
//            },
//            height: 150,
//            plugins: [
//                "advlist autolink autosave link  lists charmap  spellchecker",
//                "searchreplace wordcount      media ",
//                " contextmenu directionality emoticons  textcolor paste textcolor colorpicker textpattern"
//            ],
//            toolbar1: "bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | searchreplace | bullist numlist | outdent indent blockquote | media | forecolor backcolor | subscript superscript | charmap emoticons",
//            menubar: false,
//            toolbar_items_size: 'small'
//        });
                            }

                            $(".client_list").change(function () {
                                if ($(this).val() != 0) {
                                    preloader.on();
                                    $.ajax({
                                        url: get_base_url() + "tms/manage_bills/get_client_address",
                                        method: "POST",
                                        data: "client_id=" + $(this).val(),
                                        dataType: "json",
                                        success: function (result) {
//                                            $('.task_list').empty();
                                            if (result.succ) {
//                                                $('.task_list').html($('<option>').text("Select Task").attr('value', 0));
//                                                $.each(result.data, function (i, value) {
//                                                    $('.task_list').append($('<option>').text(value.tm_name).attr('value', value.tm_id));
//                                                });

                                                $(".client_billing_name").val((result.client_details.client_billing_name));
                                                $(".client_billing_add1").val((result.client_details.client_billing_add1));
                                                $(".client_billing_add2").val((result.client_details.client_billing_add2));
                                                $(".client_gst_no").val((result.client_details.gst_no));
                                                $(".client_po").val((result.client_details.po_no));

                                            } else {
//                                                $('.task_list').html($('<option>').text("Select Task").attr('value', 0));
                                            }


//                                            $(".chosen-select").trigger("chosen:updated");
                                            preloader.off();
                                        }
                                    });
                                } else {
//                                    $('.task_list').html($('<option>').text("Select Task").attr('value', 0));
                                }
                            });
                            $(document).on("ready", function () {
                                t_init("textarea.tinymce");
                                init();
                                var config = {
                                    '.chosen-select': {},
                                    '.chosen-select-deselect': {allow_single_deselect: true},
                                    '.chosen-select-no-single': {disable_search_threshold: 10},
                                    '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                                    '.chosen-select-width': {width: "95%"}
                                }
                                for (var selector in config) {
                                    $(selector).chosen(config[selector]);
                                }
                            });
                            function display_msg($_data) {
                                var err_msg = "";
                                $.each($_data, function (i, value) {
                                    err_msg += value + "\n";
                                });
                                return err_msg;
                            }

                            $("#bill_save_update_form").on("submit", function (e) {
                                e.preventDefault();
                                preloader.on();
                                $.ajax({
                                    url: $(this).attr("action"),
                                    type: "POST",
                                    dataType: "JSON",
                                    data: $(this).serialize(),
                                    success: function (result) {
                                        var msg = display_msg(result._err_codes);
                                        if (result.succ) {
                                            
                                              swal({
                                        title: "Done!",
                                        text: msg,
                                        type: "success",
                                        timer: 1000
                                    });
                                            setTimeout(function () {
                                                var win = window.open(get_base_url() + "tms/manage_bills/print_bill/" + result.id, "_blank");
                                                win.focus();

                                                window.location = (get_base_url() + "tms/manage_bills<?php echo isset($bill_data['bill_mst_id']) && $bill_data['bill_mst_id'] != "" ? ("/index/{$bill_data['bill_mst_id']}") : "" ?>");
//                        window.location = (get_base_url() + "tms/manage_bills/print_bill/");
                                            }, 2000);
                                        } else {
                                            sweetAlert({
                                                title: "Oops...",
                                                text: msg,
                                                type: "error",
                                                timer: 2500,
                                                html: true
                                            });
                                        }
                                        preloader.off();
                                    }
                                });
                            });



</script>
<div class="hidden dummy_content">
    <div class="single_ser_box">
        <div class="col-md-12">
            <h4>
                <span class="sub_task_num" id="subtask2"># Services</span>
            </h4>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">
            Service Name<span class="Compulsory">*</span>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-8"> 
            <div class="form-group">
                <textarea type="text" class="form-control ser_name" rows="5" name="service_name[]" placeholder="Enter Service"/></textarea>
            </div> 
        </div>
        <div class="col-lg-2 col-md-2 col-sm-4">
            <div class="form-group">
                <input type="text" class="form-control ser_amt" placeholder="service amount" onkeydown ="total_amt()" onblur="total_amt()" onkeypress="total_amt()" name="amt[]"/>
            </div> 
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2"> 

            <div class="form-group">
                <input type="text" class="form-control ser_sort" placeholder="Sort" name="sort[]"/>
            </div> 
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2"> 
            <button type="button" class="add_ser  btn btn-danger btn-md">
                <span class="glyphicon glyphicon-plus"></span>
            </button>
            <button type="button" class="remove_ser  btn btn-success btn-md">
                <span class="glyphicon glyphicon-minus"></span>
            </button>
        </div>
    </div>
</div>
<script>
    function total_amt() {
        var t = 0;
        $.each($('.server_container').find(".single_ser_box"), function () {
            if (typeof $(this).find(".ser_amt").val() != "undefined") {
                t = eval(t) + eval($(this).find(".ser_amt").val());
                // console.log(t);
            }
        });
        $(".bill_amt").val(t);
        if ($(".ser_tax").find("input[type=checkbox]").is(':checked')) {
            $(".ser_tax").val(t * (<?= str_replace('%','',$get_tax_rate[0]['rate']) ?>) / 100);
        } else {
            $(".ser_tax").val(0);
        }
        if ($(".etax").find("input[type=checkbox]").is(':checked')) {
            $(".etax").val(t * (<?= str_replace('%','',$get_tax_rate[1]['rate']) ?>) / 100);
        } else {
            $(".etax").val(0);
        }
        if ($(".ktax").find("input[type=checkbox]").is(':checked')) {
            $(".ktax").val(t * (<?= str_replace('%','',$get_tax_rate[2]['rate']) ?>) / 100);
        } else {
            $(".ktax").val(0);
        }
        if ($(".CGST").find("input[type=checkbox]").is(':checked')) {

            $(".CGST").val(t * (<?= str_replace('%','',$get_tax_rate[3]['rate']) ?>) / 100);
        } else {
            $(".CGST").val(0);
        }
        if ($(".IGST").find("input[type=checkbox]").is(':checked')) {
            $(".IGST").val(t * (<?= str_replace('%','',$get_tax_rate[4]['rate']) ?>) / 100);
        } else {
            $(".IGST").val(0);
        }
        if ($(".SGST").find("input[type=checkbox]").is(':checked')) {
            $(".SGST").val(t * (<?= str_replace('%','',$get_tax_rate[5]['rate']) ?>) / 100);
        } else {
            $(".SGST").val(0);
        }
        if ($(".UTGST").find("input[type=checkbox]").is(':checked')) {
            $(".UTGST").val(t * (<?= str_replace('%','',$get_tax_rate[6]['rate']) ?>) / 100);
        } else {
            $(".UTGST").val(0);
        }
        $(".final_bill").val(eval($(".bill_amt").val()) + eval($(".ser_tax").val()) + eval($(".etax").val()) + eval($(".ktax").val()) + eval($(".CGST").val()) + eval($(".IGST").val()) + eval($(".SGST").val()) + eval($(".UTGST").val()));
    }



    function init() {
        var count = 0;
        total_amt();
        $.each($('.server_container').find(".single_ser_box"), function () {
            if (typeof $(this).find(".ser_amt").val() != "undefined") {
                $(this).find(".sub_task_num").html("# Services " + ++count);
                $(this).find(".sub_task_num").attr("id", "subtask" + count);
            }
        });

//        $('html, body').animate({
//            scrollTop: $('#subtask' + count).offset().top() - 50
//        }, 500);

        $.each($(document).find(".add_ser"), function () {
            $(this).unbind();
        });
        $.each($(document).find(".remove_ser"), function () {
            $(this).unbind();
        });

        $(".add_ser").on("click", function () {
            $(this).parents(".single_ser_box").after($(".dummy_content").html());
            init();
        });

        $(".remove_ser").on("click", function () {
            console.log($('.server_container').find(".single_ser_box").length);
            if ($('.server_container').find(".single_ser_box").length <= 1) {
                alert("This Can't be deleted!!");
            } else {
                $(this).parents(".single_ser_box").remove();
                init();
            }
        });


    }

<?php
if (!isset($bill_data['bill_amt'])) {
    ?>
        $(document).ready(function () {
            init();
        });
<?php } ?>
    $(".services_list").change(function () {
        var serCatCode = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("tms/manage_bills/get_serCatList") ?>" + "/" + serCatCode,
            data: $("#search_task_form").serialize(),
            dataType: "json",
            success: function (search_data) {
//                console.log(search_data); 
                $(".server_container").html("<div class='single_ser_box'></div>");
                $(search_data.serCatData).each(function (index, eachSer) {
                    $(".dummy_content").find(".single_ser_box").find(".ser_name").text(eachSer.service_name);
                    $(".dummy_content").find(".single_ser_box").find(".ser_amt").attr("value", eachSer.amt);
                    $(".dummy_content").find(".single_ser_box").find(".ser_sort").attr("value", eachSer.sort);
                    $(".server_container").append($(".dummy_content").html());
                });
                init();
                total_amt();
                preloader.off();
            }
        });
    });
    $(".bill_acount_id").change(function () {
        var bill_acount_id = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("tms/manage_bills/get_bill_account") ?>" + "/" + bill_acount_id,
            dataType: "json",
            success: function (search_data) {
//                console.log(search_data); 
//                $(".server_container").html("<div class='single_ser_box'></div>");

                $(search_data).each(function (key, Eachaccount_details) {

                    $.each(Eachaccount_details, function (cls, eachField) {
                        console.log(eachField);
                        $("." + cls).val(eachField);
                    });

                });
//                init();
//                total_amt();
                preloader.off();
            }
        });
    });


    $(".bill_no").blur(function () {
        var billno = $(this).val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("tms/manage_bills/check_bill_no") ?>" + "/" + billno,
            dataType: "json",
            success: function (search_data) {
                if (search_data.succ == false) {
                    swal("Duplicate Bill No", "This Bill No already exist, but you can proceed if you want", "info");
                }
//                init();
//                total_amt();
                preloader.off();
            }
        });
    });
    $(document).on("ready", function () {
        var d = new Date();
//        d.setDate(d.getDate() - 2);
        $('.bill_date').datetimepicker({
//            maxDate: d,
            format: 'DD-MM-YYYY',
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            }
        });
    });
    $(".get_client_task").change(function () {
//                                if ($(this).val() != 0) {
        preloader.on();
        $.ajax({
            url: get_base_url() + "tms/manage_bills/filter_task_by_client",
            method: "POST",
            data: "client_ids=" + $(this).val(),
            dataType: "json",
            success: function (result) {
                $('.task_list').empty();
                if (result.succ) {
                    $('.task_list').html($('<option>').text("Select Task").attr('value', 0));
                    $.each(result.data, function (i, value) {
                        $('.task_list').append($('<option>').text(value.tm_name).attr('value', value.tm_id));
                    });

//                                                $(".client_billing_name").val((result.client_details.client_billing_name));
//                                                $(".client_billing_add1").val((result.client_details.client_billing_add1));
//                                                $(".client_billing_add2").val((result.client_details.client_billing_add2));
//                                                $(".client_gst_no").val((result.client_details.gst_no));
//                                                $(".client_po").val((result.client_details.po_no));

                } else {
                    $('.task_list').html($('<option>').text("Select Task").attr('value', 0));
                }


                $(".chosen-select").trigger("chosen:updated");
                preloader.off();
            }
        });
//                                } else {
//                                    $('.task_list').html($('<option>').text("Select Task").attr('value', 0));
//                                }
    });
 
</script>