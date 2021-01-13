<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/>
<div id="page-wrapper" style="min-height: 345px;">


    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
    <script src="//cdn.ckeditor.com/4.11.3/standard/ckeditor.js"></script>


    <div class="row"  ng-app="myapp" ng-controller="myctrl" ng-cloak="">
        <div class="col-md-8">
            <div class="panel  panel-primary form">
                <div class="panel-heading">
                    <h4 class="panel-title">Email Template</h4>
                </div>
                <div class="panel-body">

                    <form class="form-horizontal" role="form" id="add_form" ng-submit="data_submit()">
                        <div class="form-body">
                            <div class="form-group bottom_gap">
                                <label class="col-md-2 control-label">Title</label>
                                <div class="col-md-10">
                                    <input type="hidden" id="template_id"  name="template_id" value="{{editdata.template_id}}">
                                    <input type="text" class="form-control" name="title"  ng-model="editdata.title" placeholder="Enter title" required>
                                </div>
                            </div>
                            <div class="form-group bottom_gap">
                                <label class="col-md-2 control-label">Subject template</label>
                                <div class="col-md-10">
<!--                                    <input type="hidden" id="template_id"  name="template_id" value="">-->
                                    <input type="text" class="form-control" name="subject_temp" value="{{editdata.subject_temp}}"  placeholder="Enter Subject Template" required>
                                </div>
                            </div>
                            <div class="form-group bottom_gap">
                                <label class="col-md-2 control-label">Email Template</label>
                                <div class="col-md-10">
                                    <div class="well">
                                        Use :  VAR.CLIENT_NAME ,VAR.MONTH ,VAR.YEAR ,VAR.STATE ,VAR.TASKTYPE ,VAR.SUBTASK ,VAR.TASKNAME ,VAR.TASKCODE ,VAR.INCHARGE ,VAR.SKILLDEVACTIVITY ,VAR.EXPENDITURE ,VAR.REPEAT ,VAR.SHOWTOCLIENT ,VAR.TASKPERIOD ,VAR.STARTDATE ,VAR.ENDDATE ,VAR.NOTES
                                    </div>
                                    <textarea  class="form-control" id="template" rows="5" name="template" required></textarea>
                                </div>
                            </div>
                            <div class="form-group bottom_gap">

                                <label class="col-md-2 control-label">
                                    SMS Template
                                </label>
                                <div class="col-lg-10 col-md-6 col-sm-4 col-xs-4 col-sm-8">
                                    <textarea class="form-control editor" rows="3" name="sms_template" ng-model="editdata.sms_template" id="sms_template"></textarea>
                                    <span class="wordcount">Word Count 0</span>

                                </div>
                            </div>
                            <div class="form-group bottom_gap">
                                <label class="col-md-2 control-label">Email Template Module</label>
                                <div class="col-md-10"> 
                                    <select class="form-control" ng-model="editdata.module_id" name="module_id">
                                        <option value="-1">---Select---</option>
                                        <?php foreach ($email_template as $key => $value) {
                                            if($value['controller']!=''){
                                            ?>
                                            <option value="<?php echo $value['MID'];?>"><?php echo $value['controller'].' ('.$value['menu_title'].')';?></option>
                                            <?php 
                                            }else{
                                                ?>
                                                <option value="<?php echo $value['MID'];?>"><?php echo $value['menu_title'];?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row bottom_gap"> 
                                <div class="row bottom_gap">
                                    <div class="notify_box">
                                        <div class="col-lg-2 col-md-2 col-sm-4 padding_top_label"> 
                                            <div class="col-lg-12">Notify Via-Email</div>
                                        </div>
                                        <div class="col-lg-10 col-md-10 col-sm-10"> 
                                            <div class="col-lg-12">
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="checkbox" name="email_users[]" ng-model="editdata.email_users"  value="0" style="cursor:pointer;" class="mail_to_all">
                                                    <span class="user_name" title="">All</span>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="checkbox" name="email_users[]" ng-checked="editdata.email_users"  value="3" style="cursor:pointer;" class="chk_fl">
                                                    <span class="user_name" title="DIRECTOR">DIRECTOR</span>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="checkbox" name="email_users[]" ng-checked="editdata.email_users"  value="2" style="cursor:pointer;" class="chk_fl">
                                                    <span class="user_name" title="PARTNER">PARTNER</span>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="checkbox" name="email_users[]" ng-checked="editdata.email_users"  value="4" style="cursor:pointer;" class="chk_fl">
                                                    <span class="user_name" title="DEVELOPER">DEVELOPER</span>
                                                </div>
                                                <div class="col-lg-8 col-md-8 col-sm-8">
                                                    <input type="checkbox" name="email_users[]" ng-checked="editdata.email_users"  value="1" style="cursor:pointer;" class="chk_fl">
                                                    <span class="user_name" title="INCHARGE">INCHARGE</span>
                                                </div>
                                            </div> 
                                            <div class="tbl_check_name col-lg-12"> 
                                            </div> 
                                        </div><!-- /input-group -->      
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="form-actions">
                            <div class="row bottom_gap">
                                <div class="col-md-2"></div>
                                <div class="col-md-10">
                                    <button type="submit" class="btn btn-primary">
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
        <div class="col-md-3">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h4 class="panel-title ">All Templates</h4>
                </div>
                <div class="panel-body">
                    <div class="table-scrollable">
                        <table class="table table-bordered table-hover" id="fee_type_list">
                            <thead>
                                <tr>
                                    <th>Title </th>
                                    <th>Action</th>                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="data in alldata">
                                    <td> {{data.title}} </td>
                                    <td>
                                        <span class="label label-sm label-success"><a href="" ng-click="edit_data(data.template_id)">edit</a> </span>|<span class="label label-sm label-success"><a href="" ng-click="delete_data(data.template_id)">Delete</a> </span>
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

        //
        CKEDITOR.replace('template', {
            toolbar:[
                { name: 'document', groups: [ 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'ExportPdf', 'Preview', 'Print', '-', 'Templates' ] },
                { name: 'clipboard', items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
                { name: 'editing', items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
                { name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
                '/',
                { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat' ] },
                { name: 'paragraph', items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language' ] },
                { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
                { name: 'insert', items: [ 'Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe' ] },
                '/',
                { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
                { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                { name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
                { name: 'about', items: [ 'About' ] }
            ]
});                  

    </script>
    <script>

        var app = angular.module('myapp', []);
        app.controller('myctrl', function ($scope, $http) {
            // DataTables configurable options
            //$scope.dtOptions = DTOptionsBuilder.newOptions()
            //.withDisplayLength(10)
            //.withOption(‘bLengthChange’, false);
            //         

            $scope.data_fatch = function () {

                $.ajax({
                    url: "<?php echo base_url() ?>/tms/email_template/adddata",
                    type: 'POST',
                    data: {'_action': 'get_data'},
                    dataType: 'json',
                    success: function (data, textStatus, jqXHR) {
                        $scope.alldata = data['alldata'];
                        console.log(data.alldata);
                        $scope.$apply();
                    }
                });
            };


            $scope.data_fatch();

            $scope.data_submit = function () {
                var form = $("#add_form");
//                var data = CKEDITOR.instances.template.getData();
                //            console.log(data);
                for (instance in CKEDITOR.instances) {
                    CKEDITOR.instances[instance].updateElement();
                }
                $.ajax({
                    type: "post",
                    url: '<?php echo base_url() ?>/tms/email_template/adddata',
                    data: form.serialize(),
                    dataType: "json",
                    success: function (data, textStatus, jqXHR) {
                        console.log(data);
                        if (data['success'])
                        {
                            swal('Thanks ', 'Congts you just created a awesome template', 'success');
                            $("#add_form")[0].reset();
                            $('#add_form input[type="hidden"]').val('');
                            //                        $('#add_form').find('input:text, input:password, input:file, select, textarea').val('');

                            CKEDITOR.instances.template.setData('');
                            //                         $("#add_form").find('template_id').val();
                            //                         $('form[name="contact-form"]').submit();
                            //  $('input[type="text"], textarea').val('');
                            //                         location.reload(true);



                            $scope.data_fatch();
                        } else
                        {
                            swal('Opps Error', '>__< Sorry unable to save your template', 'error');
                        }
                        $scope.Save = "Save";
                        $scope.$apply();
                    }
                });
            }


            $scope.delete_data = function (template_id) {

                $.ajax({
                    type: "post",
                    url: '<?php echo base_url() ?>/tms/email_template/adddata',
                    data: {
                        template_id: template_id, _action: 'del_data'},
                    dataType: "json",
                    success: function (data, textStatus, jqXHR) {
                        console.log(data);
                        if (data['success'])
                        {
                            swal('Deleted', 'Congts you just deleted a template', 'success');
                            $scope.data_fatch();
                        } else
                        {
                            swal('Opps Error', '>__< Sorry unable to delete your template', 'error');
                        }
                        $scope.$apply();
                    }
                });
            };
            $scope.edit_data = function (template_id) {
                console.log(template_id);
                $scope.editdata = {};
                $.ajax({
                    type: "post",
                    url: '<?php echo base_url() ?>/tms/email_template/adddata',
                    data: {template_id: template_id, _action: 'get_data'},
                    dataType: "json",
                    success: function (data, response) {
                        console.log(data);
                        $scope.editdata = data['alldata'];
                        $scope.template = data.alldata.template;
                        CKEDITOR.instances['template'].setData($scope.template);

                                          console.log($scope.editdata);
                        $scope.$apply();
                    }
                });
            }
        });

        $(".editor").keyup(function () {
            var textArea = $(this).val();
//        console.log(textArea);
            if (textArea == "") {
                $(this).siblings(".wordcount").text("Word Count 0");
            } else {
                var words = textArea;
                //= textArea.split(' ');


                $(this).siblings(".wordcount").text("Word Count " + words.length);
            }

        });
    </script>
</div>

