<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/> 
<script src="<?php echo base_url("js/angular_js/angular.js"); ?>" type="text/javascript"></script>

<div id="page-wrapper" style="min-height: 345px;" ng-app="accountManage" ng-controller="accountManager">
    <div class="row">

        <div class="col-lg-12">
            <h4 class="page-header ">Bills Account Master</h4>
            <?php
            if (isset($error)) {
                $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>

        </div>

        <!-- /.col-lg-12 -->
    </div>
    <div class="row">

    </div>
    <div class="panel panel-primary">
        <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
            <h3 class="panel-title toggle_custom"><?php echo (isset($bill_data) && !empty($bill_data)) ? "Edit Bill Form" : "Generate Bill Form" ?><span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
        <div class="panel-body collapse" id="collapseExample">   

            <form id="billForm">
                <div class="row bottom_gap"> 
                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Account Title<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8"> 
                        <div class="form-group">

                            <input type="hidden"  name="bill_account_id" value="{{bill_account_id}}" />

                            <input type="text" class="form-control" name="account_title" ng-model="account_title"/>
                        </div> 
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Status<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8"> 
                        <div class="form-group">
                            <input type="checkbox" name="status" value="1" ng-checked="{{status}}"/>
                        </div> 
                    </div>
                    <!-- /input-group -->               

                </div> <!--End of row-->


                <div class="row bottom_gap"> 
                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Billing Company Name<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8"> 
                        <div class="form-group">
                            <input type="text" class="form-control" name="billing_com_name" ng-model="billing_com_name"/>
                        </div> 
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Billing address<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8"> 
                        <div class="form-group">
                            <input type="text" class="form-control" name="billing_add" ng-model="billing_add"/>
                        </div> 
                    </div>  
                </div> <!--End of row-->

                <div class="row bottom_gap"> 
                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Billing Phone<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8"> 
                        <div class="form-group">
                            <input type="text" class="form-control" name="bill_phone" ng-model="bill_phone"/>
                        </div> 
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Billing Email<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8"> 
                        <div class="form-group">
                            <input type="text" class="form-control" name="bill_email" ng-model="bill_email"/>
                        </div> 
                    </div>  
                </div> <!--End of row-->

                <div class="row bottom_gap"> 
                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Bank Name<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8"> 
                        <div class="form-group">
                            <input type="text" class="form-control" name="bank_name" ng-model="bank_name"/>
                        </div> 
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Account No<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8"> 
                        <div class="form-group">
                            <input type="text" class="form-control" name="bank_acc_no" ng-model="bank_acc_no"/>
                        </div> 
                    </div>  
                </div> <!--End of row-->

                    

                <div class="row bottom_gap"> 
                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">IFSC Code<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8"> 
                        <div class="form-group">
                            <input type="text" class="form-control" name="bank_ifsc_code" ng-model="bank_ifsc_code"/>
                        </div> 
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Bank Address<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8"> 
                        <div class="form-group">
                            <input type="text" class="form-control" name="bank_address" ng-model="bank_address"/>
                        </div> 
                    </div>  
                </div> <!--End of row-->


                <div class="row bottom_gap"> 
                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">PAN No<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8"> 
                        <div class="form-group">
                            <input type="text" class="form-control" name="pan_no" ng-model="pan_no"/>
                        </div> 
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">ST Reg No<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8"> 
                        <div class="form-group">
                            <input type="text" class="form-control" name="st_reg_no" ng-model="st_reg_no"/>
                        </div> 
                    </div>  
                </div> <!--End of row-->
                
                <div class="row bottom_gap"> 
                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">GST No.<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8"> 
                        <div class="form-group">
                            <input type="text" class="form-control" name="gst_no" ng-model="gst_no"/>
                        </div> 
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">HSN/SCN Code.<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8"> 
                        <div class="form-group">
                            <input type="text" class="form-control" name="hsn_scn" ng-model="hsn_scn"/>
                        </div> 
                    </div>
                </div>
                <div class="row bottom_gap"> 
                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Place To Supply<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8"> 
                        <div class="form-group">
                            <input type="text" class="form-control" name="place_supply" ng-model="place_supply"/>
                        </div> 
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">MSME Number<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8"> 
                        <div class="form-group">
                            <input type="text" class="form-control" name="msme_no" ng-model="msme_no"/>
                        </div> 
                    </div>
                </div>

                <div class="row bottom_gap"> 
                    <div class="col-lg-2 col-md-2 col-sm-4 "> </div>
                    <div class="col-lg-4 col-md-4 col-sm-8 "> 
                        <button class="btn btn-success  btn-sm {{submitstatus}}" type="submit" ng-click="addAccount()" >Submit</button>
                        <button class="btn btn-success  btn-sm {{updatestatus}}" type="submit" ng-click="update()" >Update</button>
                        <button class="btn btn-success  btn-sm {{updatestatus}}" type="submit" ng-click="addNewform()" >Add New</button>
                        <button class="btn btn-danger  btn-sm {{submitstatus}}" type="reset" >Reset</button>
                        <div class="{{mtype}}}">{{message}}</div>
                    </div>
                </div>
            </form>
        </div>

    </div>


    <div class="">
        <table class="table table-responsive">
            <thead>
                <tr>
<!--                    <th>S.No.</th>-->
                    <th>ID</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <tr ng-repeat="account in allAccounts">
                    <td>{{account.bill_account_id}}</td>
                    <td>{{account.account_title}}</td>
                    <td>{{account.status}}</td>
                    <td>
                        <button type="button" ng-click="getUpdateData(account)" class="btn btn-success btn-sm" >Edit</button>
                        <button type="button" ng-click="deleteaccount(account.bill_account_id)" class="btn btn-danger btn-sm">Del</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>


</div>


<script src="<?= base_url() ?>js/chosen.jquery.min.js" type="text/javascript"></script>
<link href="<?= base_url() ?>css/chosen.min.css" rel="stylesheet" type="text/css"/>
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>
<link href="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= CDN1 ?>css/bdt/moment.js" type="text/javascript"></script>
<script sr="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/tinymce/js/tinymce/tinymce.min.js" type="text/javascript"></script>
<script src="<?= CDN1 ?>js/moment.min.js" type="text/javascript"></script>
<script src="<?= CDN1 ?>js/jquery.form.min.js"></script>


<script>
                            var app = angular.module("accountManage", []);
                            app.controller("accountManager", function ($scope,$parse) {

                                $scope.account_title = "";
                                $scope.bill_account_id = "";
                                $scope.status = true;
                                $scope.message = "";
                                $scope.mtype = "text-success";

                                $scope.allAccounts;
                                $scope.submitstatus = "";
                                $scope.updatestatus = "hidden";

                                $scope.addNewform = function () {

                                    $scope.account_title = "";
                                    $scope.bill_account_id = "";
                                    $scope.status = true;
                                    $scope.message = "";
                                    $scope.submitstatus = "";
                                    $scope.updatestatus = "hidden";
                                };
                                $scope.addAccount = function () {
                                    var form = $("#billForm");
                                    var url = "<?php echo base_url() . "tms/manage_bills/bill_account_add" ?>";

                                    $.ajax({
                                        url: url,
                                        type: 'POST',
                                        data: form.serialize(),
                                        dataType: 'json',
                                        success: function (data, textStatus, jqXHR) {

                                            if (data['success'])
                                            {

                                                  swal({
                                        title: "Done!",
                                        text: "Your " + title + " has been deleted!",
                                        type: "success",
                                        timer: 1000
                                    });
                                                form[0].reset();
                                                $scope.getAllAccount();
                                            }
                                            else
                                            {
                                                swal("Not Added!", data['msg'], "error");
                                            }
                                        }
                                    });

                                };

                                $scope.getUpdateData = function (account) {
                                    console.log(account);


                                    $scope.submitstatus = "hidden";
                                    $scope.updatestatus = "";
                                    $.each(account, function (key, value) {
                                        if (key == "status") {
                                            if (account.status)
                                                $parse(key).assign($scope, true);
                                            else
                                                $parse(key).assign($scope, false);
                                        } else {
//                                            $scope.key = account.key;
                                            $parse(key).assign($scope, value);
                                        }
                                    });
//                                     $scope.$apply();
                                };

                                $scope.update = function () {
                                    var form = $("#billForm");
                                    var url = "<?php echo base_url() . "tms/manage_bills/bill_account_update" ?>";
                                    $.ajax({
                                        url: url,
                                        type: 'POST',
                                        data: form.serialize(),
                                        dataType: 'json',
                                        success: function (data, textStatus, jqXHR) {

                                            if (data['success'])
                                            {
                                                
                                                  swal({
                                        title: "Done!",
                                        text: data['msg'],
                                        type: "success",
                                        timer: 1000
                                    });
                                                $scope.getAllAccount();
                                            }
                                            else
                                            {
                                                swal("Update!", data['msg'], "error");
                                            }
                                        }
                                    });

                                };

                                $scope.deleteaccount = function (bill_account_id)
                                {

                                    var url = "<?php echo base_url() . "tms/manage_bills/bill_account_dele" ?>";

                                    swal({
                                        title: "Are you sure?",
                                        text: "Your will not be able to recover  data!",
                                        type: "warning",
                                        showCancelButton: true,
                                        confirmButtonClass: "btn-danger",
                                        confirmButtonText: "Yes, delete it!",
                                        closeOnConfirm: false
                                    },
                                    function () {

                                        $.ajax({
                                            url: url,
                                            type: 'POST',
                                            data: 'bill_account_id=' + bill_account_id,
                                            dataType: 'json',
                                            success: function (data, textStatus, jqXHR) {

                                                if (data['success'])
                                                {
                                                    
                                                      swal({
                                        title: "Done!",
                                        text: data['msg'],
                                        type: "success",
                                        timer: 1000
                                    });
                                                    $scope.mtype = "text-success";
                                                    $scope.getAllAccount();
                                                }
                                                else
                                                {
                                                    swal("Not Deleted!", data['msg'], "error");
                                                }
                                            }
                                        });





                                    });







                                };

                                $scope.getAllAccount = function () {
                                    console.log("called");
                                    var url = "<?php echo base_url() . "tms/manage_bills/get_bill_account" ?>";
                                    $.ajax({
                                        url: url,
                                        type: 'POST',
                                        data: '',
                                        dataType: 'json',
                                        success: function (data, textStatus, jqXHR) {
                                            $scope.allAccounts = data;
                                            $scope.$apply();
                                        }
                                    });
                                };

                                $scope.getAllAccount();


                            });
</script>
