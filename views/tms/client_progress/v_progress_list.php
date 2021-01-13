<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/js/bootstrapValidator.min.js" type="text/javascript"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.3/css/bootstrapValidator.min.css"  rel="stylesheet" type="text/css"/>
<script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.12.1.min.js"></script>
<script src="//cdn.ckeditor.com/4.7.2/basic/ckeditor.js"></script>
<div id="page-wrapper" style="min-height: 345px;">

<div class="row"  ng-app="myapp" ng-controller="myctrl" ng-cloak="">
    <div class="col-md-6">
        <div class="panel  panel-primary form">
            <div class="panel-heading">
                <h4 class="panel-title">Progress list form</h4>
            </div>
            <div class="panel-body">
            <form class="form-horizontal" role="form" id="add_form" ng-submit="data_submit()">
                <div class="form-group bottom_gap">
                    <label class="col-md-2 control-label">Name</label>
                    <div class="col-md-10">
                        <input type="hidden" id="p_id"  name="p_id" value="{{editdata.p_id}}">
                        <input type="text" class="form-control" name="p_name"  ng-model="editdata.p_name" placeholder="Enter Progress Name" required>
                    </div>
                </div>
                <div class="form-group bottom_gap">
                    <label class="col-md-2 control-label">Description</label>
                    <div class="col-md-10">
                        <input type="text" class="form-control" name="p_desc"  ng-model="editdata.p_desc" placeholder="Enter Progress description" required>
                    </div>
                </div>
                
                <div class="form-group bottom_gap">
                    <label class="col-md-2 control-label">Email Template</label>
                    <div class="col-md-10"> 
                        <select class="form-control" ng-model="editdata.template_id" name="template_id">
                            <option value="-1">---Select---</option>
                            <option ng-repeat="data in alltempdata" value="{{data.template_id}}">{{data.title}}</option>
                        </select>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-2"></div>
                            
                        <div class="col-md-10">
                            <button type="submit" class="btn btn-primary green" >
                                <span class="glyphicon glyphicon-floppy-save"></span>
                                Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        </div>
        <!-- END SAMPLE TABLE PORTLET-->
    </div>
    <div class="col-md-6">
        <!-- BEGIN BORDERED TABLE PORTLET-->
        <div class="panel  panel-primary form">
            <div class="panel-heading">
                <h4 class="panel-title">Progress list form</h4>
            </div>
            <div class="panel-body">
            <div class="table-scrollable">
                <table class="table table-bordered table-hover" id="fee_type_list">
                    <thead>
                        <tr>
                            <th> Name </th>
                            <th> Description </th>
                            
                            <th> Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="data in alldata">
                            <td> {{data.p_name}} </td>
                            <td> {{data.p_desc}} </td>
                            <td>
                                <span class="label label-sm label-success"><a href="" ng-click="edit_data(data.p_id)">edit</a> </span>|<span class="label label-sm label-success"><a href="" ng-click="delete_data(data.p_id)">Delete</a> </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            </div>
        </div>
        <!-- END BORDERED TABLE PORTLET-->
    </div>
</div>
<script>

    $(function () {

        $('#add_form').bootstrapValidator({
            message: false,
            //container: 'tooltip',
            trigger: 'blur',
            live: 'enabled',
            feedbackIcons: {
                // valid: 'glyphicon glyphicon-ok',
                // invalid: 'glyphicon glyphicon-remove',
                // validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                p_name: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Field cannot be empty'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z\s]+$/,
                            message: 'Invalid first name'
                        },
                        stringLength: {
                            min: 4,
                            max: 25,
                            message: 'Only 4 - 25 characters'
                        }
                    }
                },
                p_desc: {// field name
                    validators: {
                        notEmpty: {
                            message: 'Field cannot be empty'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z\s]+$/,
                            message: 'Invalid first name'
                        },
                        stringLength: {
                            min: 4,
                            max: 25,
                            message: 'Only 4 - 25 characters'
                        }
                    }
                }
            }
        }).on('success.form.bv', function (e) {
            e.preventDefault();
        });
    });</script>


<script>

    var app = angular.module('myapp', ['ui.bootstrap']);
    app.controller('myctrl', function ($scope, $http) {
        // DataTables configurable options
//$scope.dtOptions = DTOptionsBuilder.newOptions()
//.withDisplayLength(10)
//.withOption(‘bLengthChange’, false);
//         

        $scope.getall_data = function () {

//            var form = $("#searchForm").serialize();
            $.ajax({
                url: "<?php echo base_url('tms/progress_list/index') ?>",
                type: 'POST',
                data: {'_action': 'get_data'},
                dataType: 'json',
                success: function (data, textStatus, jqXHR) {
                    $scope.alldata = data['alldata'];
                    $scope.alltempdata = data['alltempdata'];
                    console.log(data.alldata);
                    $scope.$apply();
                }
            });
        };


        $scope.getall_data();

        $scope.data_submit = function () {
            if (!$("#add_form").data('bootstrapValidator').validate().isValid()) {
                return false;
            }
            var form = $("#add_form");
//            console.log(data);
            $.ajax({
                type: "post",
                url: '<?php echo base_url('tms/progress_list/index') ?>',
                data: form.serialize(),
                dataType: "json",
                success: function (data, textStatus, jqXHR) {
                    console.log(data);
                    if (data['success'])
                    {
                        swal('Thanks ', 'Data saved successfully', 'success');
                            
                        $("#add_form")[0].reset();
                        $('#add_form input[type="hidden"]').val('');
                        $('#add_form').find('input:text, input:password, input:file, select, textarea').val('');
//                         location.reload(true);
                        $scope.editdata['template_id'] = "-1";
                        $scope.getall_data();
                    } else
                    {
                        swal('Opps Error', '>__< Sorry unable to perform desire action', 'error');
                    }
                    $scope.Save = "Save";
                    $scope.$apply();
                }
            });
        }


        $scope.delete_data = function (p_id) {

            $.ajax({
                type: "post",
                url: '<?php echo base_url('tms/progress_list/index') ?>',
                data: {p_id: p_id,_action:'del_data'},
                dataType: "json",
                success: function (data, textStatus, jqXHR) {
                    console.log(data);
                    if (data['success'])
                    {
                        swal('Deleted', 'Deleted record successfully !', 'success');
                            
                        $scope.getall_data();
                    } else
                    {
                        swal('Opps Error', '>__< Sorry unable to perform desire action', 'error');
                    }
                    $scope.$apply();
                }
            });
        };
        $scope.edit_data = function (p_id) {
            console.log(p_id);
            $scope.editdata = {};
            $.ajax({
                type: "post",
                url: '<?php echo base_url('tms/progress_list/index') ?>',
                data: {p_id: p_id, _action: 'get_data'},
                dataType: "json",
                success: function (data, response) {
                    $scope.editdata = data['alldata'];
                    console.log($scope.editdata);
                    $scope.$apply();
                }
            });
        }
        angular.element(document).ready(function () {
            $scope.editdata = {};
            $scope.editdata['template_id'] = "-1";
            $scope.$apply();
        });
    });
</script>
</div>