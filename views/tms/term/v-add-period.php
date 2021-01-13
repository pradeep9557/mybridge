<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/> 
<script src="<?php echo base_url("js/angular_js/angular.js"); ?>" type="text/javascript"></script>

<div id="page-wrapper" style="min-height: 345px;" ng-app="accountManage" ng-controller="accountManager">
    <div class="row">

        <div class="col-lg-12">
            <h4 class="page-header ">Create Task Period Master</h4>
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
                    <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label">Period name<span class="Compulsory">*</span></div>
                    <div class="col-lg-4 col-md-4 col-sm-8"> 
                        <div class="form-group">

                            <input type="hidden"  name="term_id" value="{{term_id}}" />

                            <input type="text" class="form-control" name="term_name" ng-model="term_name"/>
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
                    <th>Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <tr ng-repeat="account in allAccounts">
                    <td>{{account.term_id}}</td>
                    <td>{{account.term_name}}</td>
                    <td>{{account.status}}</td>
                    <td>
                        <button type="button" ng-click="getUpdateData(account)" class="btn btn-success btn-sm" >Edit</button>
                        <button type="button" ng-click="deleteaccount(account.term_id)" class="btn btn-danger btn-sm">Del</button>
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

                                $scope.term_name = "";
                                $scope.term_type = "";
                                $scope.term_id = "";
                                $scope.status = true;
                                $scope.message = "";
                                $scope.mtype = "text-success";

                                $scope.allAccounts;
                                $scope.submitstatus = "";
                                $scope.updatestatus = "hidden";

                                $scope.addNewform = function () {
                                    $scope.term_type = "";
                                    $scope.term_name = "";
                                    $scope.term_id = "";
                                    $scope.status = true;
                                    $scope.message = "";
                                    $scope.submitstatus = "";
                                    $scope.updatestatus = "hidden";
                                };
                                $scope.addAccount = function () {
                                    var form = $("#billForm");
                                    var url = "<?php echo base_url() . "tms/terms/addPeriods" ?>";

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
                                    var url = "<?php echo base_url() . "tms/terms/addPeriods" ?>";
                                    $.ajax({
                                        url: url,
                                        type: 'POST',
                                        data: form.serialize()+"&_action=update",
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

                                $scope.deleteaccount = function (term_id)
                                {

                                    var url = "<?php echo base_url() . "tms/terms/addPeriods" ?>";

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
                                            data: 'term_id=' + term_id+"&_action=delete",
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
                                    var url = "<?php echo base_url() . "tms/terms/addPeriods" ?>";
                                    $.ajax({
                                        url: url,
                                        type: 'POST',
                                        data: "_action=getAll",
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
