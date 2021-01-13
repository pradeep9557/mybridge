<!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title><?= $title ?></title>
        <!-- Bootstrap Core CSS -->
        <style>
            .pre_loader{
                width: 100%;
                height: 2000px;
                position: fixed;
                background: rgba(0, 0, 0, 0.71);
                z-index: 10000;
                text-align: center;
                padding-top: 10%;
                top: 0px;
                opacity: 1;
                color: white;
            }
        </style>
    <div class="pre_loader">
<!--        <img src="<?= base_url() . PRELOADER128 ?>"/>-->
        <div class="progress progress-striped active" style="  width: 60%;  margin: 120px auto;">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" data-transitiongoal="60" style="width: 60%">
                <span class="sr-only-focusable">60% Complete (success)</span>
            </div>
        </div>
        <span class="blink">Wait While Loading ....</span>
    </div>

    <?php include_once 'Common_Css_Js_Others_files.php'; ?>
</head>
<body>
    <div id="wrapper">
        <input type="hidden" name="base_url"  id="base_url" value="<?= base_url() ?>"/>
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0" tabindex="-1">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <span class="navbar-brand">
                    <span title="Toggle SideBar" class="hide_icon hidden-sm hidden-xs cursor_pointer glyphicon glyphicon-indent-right"></span>
                    <span title="Toggle SideBar" class="show_icon hidden-sm hidden-xs cursor_pointer glyphicon glyphicon-indent-left"></span>
                    <img src="<?= base_url() . LOGO ?>" style="height: 25px;padding-left: 5px;"/>
                    <a href="<?= base_url() ?>">
                        <span class="title_text_color">
                            <?= SITE_NAME ?>
                        </span>
                    </a>
                </span>
            </div>
            <script>
                $(".hide_icon").click(function(){
                hide_left();
                });
                        function hide_left(){
                        $(".show_icon").show();
                                $(".hide_icon").hide();
                                document.cookie = "hide=1";
                                $("#page-wrapper").removeClass("before_toggle_sidebar");
                                $("#page-wrapper").addClass("after_toggle_sidebar");
                                $(".sidebar").hide();
                        }
                $(".show_icon").click(function(){
                show_left();
                });
                        function show_left(){
                        $(".show_icon").hide();
                                $(".hide_icon").show();
                                document.cookie = "hide=0";
                                $("#page-wrapper").removeClass("after_toggle_sidebar");
                                $("#page-wrapper").addClass("before_toggle_sidebar");
//                                $("#page-wrapper").switchClass("after_toggle_sidebar", "before_toggle_sidebar", 200);
                                $(".sidebar").show();
                        }
                $("document").ready(function(){
                var x = getCookie("hide");
                console.log(x);
                        if (x == 1){
                $("#page-wrapper").addClass("after_toggle_sidebar");
                        hide_left();
                } else{
                $("#page-wrapper").addClass("before_toggle_sidebar");
                        show_left();
                }
                });
                        function getCookie(cname) {
                        var name = cname + "=";
                                var ca = document.cookie.split(';');
                                for (var i = 0; i < ca.length; i++) {
                        var c = ca[i];
                                while (c.charAt(0) == ' ') {
                        c = c.substring(1);
                        }
                        if (c.indexOf(name) == 0) {
                        return c.substring(name.length, c.length);
                        }
                        }
                        return "";
                        }
            </script>
            <!-- /.navbar-header -->    
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
<!--                <li>Your Branch:<?php echo $Branch_obj->Bname; ?></li>
                <li class="dropdown"><?php
                echo date(DTF, time());
                ?>
                </li>-->
                <!--End message toogle -->
                <li class="dropdown">
<!--                    <p>
                        Anup Kumar 
                        <img src="<?= base_url() . LOGO ?>" class="img-circle" alt="Cinque Terre" style="float: left"> 
                        <a class="cursor_pointer dropdown-toggle" data-toggle="dropdown"><i class="fa fa-cog" aria-hidden="true"></i></a>
                    </p>-->
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <span class="user_name">
                            Anup Kumar<br>Users bracnch 
                        </span>
                        <img src="<?= base_url() . 'img/login/profile.jpg' ?>" class="circle_img" alt="Cinque Terre" style="float: left"> 
                        <i class="setting_icon fa fa-1x fa-cog" aria-hidden="true"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?= base_url() ?>employee/user_profile"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="<?= base_url() ?>employee/change_password"><i class="fa fa-gear fa-fw"></i> Change Password</a></li>        
<!--                            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>-->

                        <li class="divider"></li>
                        <li><a href="javascript:void()" class="logout_confirm"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <!-- /.navbar-top-links -->
            <div class="navbar-default sidebar" role="navigation">
                <div ng-app="mainApp" ng-controller="MenuCtrl" class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input ng-model="search"  type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>


                        <?php
                        $base_url = base_url();
                        ?>
                        <li ng-repeat="data in menu" ng-show="!search || ([data.Parent.menu_title]|filter:search).length || ([child_one.Parent.menu_title] | filter:search).length">
                            <a href="<?= $base_url ?>{{data.Parent.menu_link}}" target="{{data.Parent.tab}}">
                                <span class="{{data.Parent.menu_icon}}"></span>&nbsp;
                                {{data.Parent.menu_title}}

                                <span ng-if="!!data.Child.length" class='fa arrow'></span>
                            </a>
                            <ul ng-if="!!data.Child.length" class='nav nav-second-level collapse'>
                                <li ng-repeat="child_one in data.Child" ng-show="!search || ([child_one.Parent.menu_title]|filter:search).length">
                                    <a href="<?= $base_url ?>{{child_one.Parent.menu_link}}" target="{{child_one.Parent.tab}}">
                                        <span class="{{child_one.Parent.menu_icon}}"></span>&nbsp;
                                        {{child_one.Parent.menu_title}}
                                        <span ng-if="!!child_one.Child.length" class='fa arrow'></span>
                                    </a>
                                    <ul ng-if="!!child_one.Child.length" class='nav nav-third-level collapse'>
                                        <li ng-repeat="child_two in child_one.Child" ng-show="!search || ([child_two.Parent.menu_title]|filter:search).length">
                                            <a href="<?= $base_url ?>{{child_two.Parent.menu_link}}" target="{{child_two.Parent.tab}}">
                                                <span class="{{child_two.Parent.menu_icon}}"></span>&nbsp;
                                                {{child_two.Parent.menu_title}}
                                                <span ng-if="!!child_two.Child.length" class='fa arrow'></span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                        <script>
//                                    $(document).on("ready", function () {
                            var app = angular.module('mainApp', []);
                                    app.controller('MenuCtrl', function ($scope) {
//                                        $http.get('http://nexgen/nexibms/dashboard/get_menu')
//                                                .success(function (response) {
                                    $scope.menu = <?php echo json_encode($MenuList) ?>
//                                                });
//                                        $scope.$watch('nameFilter', function () {
//                                            $scope.reset = function () {
//                                                $scope.menu = [{"Parent": {"MID": "19", "module_id": "1", "controller": "dashboard", "function": "view", "is_menu": "1", "menu_title": "Dashboard", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-calendar", "menu_link": "dashboard", "tab": "_self", "parent_id": "0", "sort_order": "0", "Meta_keywords": "dashboard", "Status": "1", "Add_User": "15", "Mode_User": "0", "Add_DateTime": "2015-04-11 11:23:04", "Mode_DateTime": "2015-04-11 20:52:32", "UTID": "10", "Allowed": "1"}, "Child": []}, {"Parent": {"MID": "14", "module_id": "2", "controller": "", "function": "", "is_menu": "1", "menu_title": "Manage Enquiry", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "", "tab": "_self", "parent_id": "0", "sort_order": "1", "Meta_keywords": "", "Status": "1", "Add_User": "15", "Mode_User": "0", "Add_DateTime": "2015-04-11 10:26:45", "Mode_DateTime": "2016-03-12 11:08:52", "UTID": "10", "Allowed": "1"}, "Child": [{"Parent": {"MID": "15", "module_id": "2", "controller": "enquiry", "function": "AddEnquiry", "is_menu": "1", "menu_title": "Add Enquiry", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "Enquiry\/enquiry\/index", "tab": "_self", "parent_id": "14", "sort_order": "2", "Meta_keywords": "Add Enquiry, Enquiry", "Status": "1", "Add_User": "15", "Mode_User": "0", "Add_DateTime": "2015-04-11 11:05:11", "Mode_DateTime": "2016-03-12 11:08:52", "UTID": "10", "Allowed": "1"}, "Child": []}, {"Parent": {"MID": "25", "module_id": "2", "controller": "enquiry", "function": "all_enq_list", "is_menu": "1", "menu_title": "All Enquiry List", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-list", "menu_link": "Enquiry\/enquiry\/all_enq_list", "tab": "_self", "parent_id": "14", "sort_order": "3", "Meta_keywords": "all enquiry", "Status": "1", "Add_User": "15", "Mode_User": "0", "Add_DateTime": "2015-04-13 14:53:45", "Mode_DateTime": "2016-03-12 11:08:52", "UTID": "10", "Allowed": "1"}, "Child": []}, {"Parent": {"MID": "28", "module_id": "3", "controller": "followups", "function": "follow_up_list", "is_menu": "1", "menu_title": "Manage Follow ups", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-earphone", "menu_link": "Enquiry\/followups\/follow_up_list", "tab": "_self", "parent_id": "14", "sort_order": "4", "Meta_keywords": "Manage Follow ups", "Status": "1", "Add_User": "33", "Mode_User": "0", "Add_DateTime": "2015-04-23 15:27:05", "Mode_DateTime": "2016-03-12 11:08:52", "UTID": "10", "Allowed": "1"}, "Child": []}]}, {"Parent": {"MID": "38", "module_id": "4", "controller": "", "function": "", "is_menu": "1", "menu_title": "Manage Admission", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-list", "menu_link": "", "tab": "_self", "parent_id": "0", "sort_order": "5", "Meta_keywords": "", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-05-07 12:46:47", "Mode_DateTime": "2016-03-12 11:08:52", "UTID": "10", "Allowed": "1"}, "Child": [{"Parent": {"MID": "39", "module_id": "4", "controller": "cadm", "function": "index", "is_menu": "1", "menu_title": "New Admission", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "adm\/cadm\/", "tab": "_self", "parent_id": "38", "sort_order": "6", "Meta_keywords": "Admssion", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-05-07 13:43:51", "Mode_DateTime": "2016-03-12 11:08:52", "UTID": "10", "Allowed": "1"}, "Child": []}, {"Parent": {"MID": "52", "module_id": "4", "controller": "cadm", "function": "all_adm", "is_menu": "1", "menu_title": "Admissions List", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-list", "menu_link": "adm\/cadm\/all_adm", "tab": "_self", "parent_id": "38", "sort_order": "7", "Meta_keywords": "Admissions List", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-05-27 19:45:42", "Mode_DateTime": "2016-03-12 11:08:52", "UTID": "10", "Allowed": "1"}, "Child": []}]}, {"Parent": {"MID": "51", "module_id": "5", "controller": "fee_master", "function": "index", "is_menu": "1", "menu_title": "Manage Fee", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "fees\/fee_master", "tab": "_self", "parent_id": "0", "sort_order": "8", "Meta_keywords": "", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-05-26 20:35:33", "Mode_DateTime": "2016-03-12 11:10:38", "UTID": "10", "Allowed": "1"}, "Child": [{"Parent": {"MID": "74", "module_id": "5", "controller": "Fee_Master_1", "function": "index", "is_menu": "1", "menu_title": "Manage Fees Vidya", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "fees\/Fee_Master_1", "tab": "_self", "parent_id": "51", "sort_order": "9", "Meta_keywords": "Manage Fees", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-08-26 16:55:03", "Mode_DateTime": "2016-03-12 11:10:38", "UTID": "10", "Allowed": "1"}, "Child": []}, {"Parent": {"MID": "50", "module_id": "5", "controller": "", "function": "", "is_menu": "1", "menu_title": "Manage Fees", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-list", "menu_link": "fees\/Fee_Master", "tab": "_self", "parent_id": "51", "sort_order": "10", "Meta_keywords": "", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-05-26 20:34:41", "Mode_DateTime": "2016-03-12 11:10:38", "UTID": "10", "Allowed": "1"}, "Child": []}, {"Parent": {"MID": "55", "module_id": "5", "controller": "Fee_Master", "function": "all_fee_records", "is_menu": "1", "menu_title": "All Fee Records", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-credit-card", "menu_link": "fees\/Fee_Master_1\/all_fee_records", "tab": "_self", "parent_id": "51", "sort_order": "11", "Meta_keywords": "All Fee Records", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-07-16 14:30:33", "Mode_DateTime": "2016-03-12 11:10:38", "UTID": "10", "Allowed": "1"}, "Child": []}]}, {"Parent": {"MID": "42", "module_id": "11", "controller": "", "function": "", "is_menu": "1", "menu_title": "Manage Reports", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-list", "menu_link": "", "tab": "_self", "parent_id": "0", "sort_order": "12", "Meta_keywords": "", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-05-10 11:44:26", "Mode_DateTime": "2016-03-12 11:10:38", "UTID": "10", "Allowed": "1"}, "Child": [{"Parent": {"MID": "75", "module_id": "11", "controller": "c_share", "function": "index", "is_menu": "1", "menu_title": "Manage Shares", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-list", "menu_link": "fee_share\/c_share", "tab": "_self", "parent_id": "42", "sort_order": "13", "Meta_keywords": "fee_share, c_share", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-09-19 14:05:11", "Mode_DateTime": "2016-03-12 11:10:38", "UTID": "10", "Allowed": "1"}, "Child": []}]}, {"Parent": {"MID": "71", "module_id": "20", "controller": "", "function": "", "is_menu": "1", "menu_title": "Manage Expense", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-list", "menu_link": "", "tab": "_self", "parent_id": "0", "sort_order": "14", "Meta_keywords": "Manage Expense", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-08-14 16:38:50", "Mode_DateTime": "2016-03-12 11:10:38", "UTID": "10", "Allowed": "1"}, "Child": [{"Parent": {"MID": "66", "module_id": "20", "controller": "c_expense", "function": "index", "is_menu": "1", "menu_title": "Manage Expense", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "expense\/c_expense", "tab": "_self", "parent_id": "71", "sort_order": "15", "Meta_keywords": "Manage Expense", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-08-14 15:54:21", "Mode_DateTime": "2016-03-12 11:10:38", "UTID": "10", "Allowed": "1"}, "Child": []}, {"Parent": {"MID": "67", "module_id": "20", "controller": "c_ex_type", "function": "index", "is_menu": "1", "menu_title": "Mange Expense Type", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "expense\/c_ex_type", "tab": "_self", "parent_id": "71", "sort_order": "16", "Meta_keywords": "Mange Expense Type", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-08-14 16:08:20", "Mode_DateTime": "2016-03-12 11:10:38", "UTID": "10", "Allowed": "1"}, "Child": []}]}, {"Parent": {"MID": "69", "module_id": "21", "controller": "", "function": "", "is_menu": "1", "menu_title": "Job Tracker", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-list", "menu_link": "", "tab": "_self", "parent_id": "0", "sort_order": "17", "Meta_keywords": "", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-08-14 16:26:42", "Mode_DateTime": "2016-03-12 11:10:38", "UTID": "10", "Allowed": "1"}, "Child": [{"Parent": {"MID": "70", "module_id": "21", "controller": "c_job_mst", "function": "index", "is_menu": "1", "menu_title": "Manage Job", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "job_trkr\/c_job_mst", "tab": "_self", "parent_id": "69", "sort_order": "18", "Meta_keywords": "Manage Job", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-08-14 16:29:00", "Mode_DateTime": "2016-03-12 11:10:38", "UTID": "10", "Allowed": "1"}, "Child": []}, {"Parent": {"MID": "68", "module_id": "21", "controller": "c_job_status_mst", "function": "index", "is_menu": "1", "menu_title": "Manage Job Status", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "job_trkr\/c_job_status_mst", "tab": "_self", "parent_id": "69", "sort_order": "19", "Meta_keywords": "Manage Job Status", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-08-14 16:25:46", "Mode_DateTime": "2016-03-12 11:10:38", "UTID": "10", "Allowed": "1"}, "Child": []}, {"Parent": {"MID": "73", "module_id": "21", "controller": "c_job_mst", "function": "assigned_jobs", "is_menu": "1", "menu_title": "Assigned Jobs", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-eye-open", "menu_link": "job_trkr\/c_job_mst\/assigned_jobs", "tab": "_self", "parent_id": "69", "sort_order": "20", "Meta_keywords": "Assigned Jobs", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-08-20 10:42:12", "Mode_DateTime": "2016-03-12 11:10:38", "UTID": "10", "Allowed": "1"}, "Child": []}]}, {"Parent": {"MID": "34", "module_id": "10", "controller": "", "function": "", "is_menu": "1", "menu_title": "Manage Batches", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-list", "menu_link": "", "tab": "_self", "parent_id": "0", "sort_order": "21", "Meta_keywords": "Manage Batches", "Status": "1", "Add_User": "33", "Mode_User": "0", "Add_DateTime": "2015-04-28 11:01:04", "Mode_DateTime": "2016-03-12 11:10:38", "UTID": "10", "Allowed": "1"}, "Child": [{"Parent": {"MID": "49", "module_id": "10", "controller": "batch_master", "function": "b_update", "is_menu": "1", "menu_title": "Stu Batch Update", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "batch\/batch_master\/b_update", "tab": "_self", "parent_id": "34", "sort_order": "22", "Meta_keywords": "student batch update", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-05-26 20:28:14", "Mode_DateTime": "2016-03-12 11:10:38", "UTID": "10", "Allowed": "1"}, "Child": []}]}, {"Parent": {"MID": "56", "module_id": "1", "controller": "", "function": "", "is_menu": "1", "menu_title": " All Masters", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-list", "menu_link": "", "tab": "_self", "parent_id": "0", "sort_order": "23", "Meta_keywords": "", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-07-22 18:54:54", "Mode_DateTime": "2016-03-12 11:08:52", "UTID": "10", "Allowed": "1"}, "Child": [{"Parent": {"MID": "59", "module_id": "1", "controller": "", "function": "", "is_menu": "1", "menu_title": "Batches", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "", "tab": "_self", "parent_id": "56", "sort_order": "24", "Meta_keywords": "", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-07-22 19:06:25", "Mode_DateTime": "2016-03-12 11:08:52", "UTID": "10", "Allowed": "1"}, "Child": [{"Parent": {"MID": "48", "module_id": "10", "controller": "batch_master", "function": "index", "is_menu": "1", "menu_title": "Create batch", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "batch\/batch_master\/", "tab": "_self", "parent_id": "59", "sort_order": "25", "Meta_keywords": "create batch", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-05-26 20:23:23", "Mode_DateTime": "2016-03-12 11:08:52", "UTID": "10", "Allowed": "1"}, "Child": []}, {"Parent": {"MID": "35", "module_id": "10", "controller": "c_batch", "function": "index", "is_menu": "1", "menu_title": "Manage Batch Status", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "batch\/c_bstatus", "tab": "_self", "parent_id": "59", "sort_order": "26", "Meta_keywords": "Manage Batch Status", "Status": "1", "Add_User": "33", "Mode_User": "0", "Add_DateTime": "2015-04-28 11:04:22", "Mode_DateTime": "2016-03-12 11:08:52", "UTID": "10", "Allowed": "1"}, "Child": []}]}, {"Parent": {"MID": "65", "module_id": "19", "controller": "c_room", "function": "index", "is_menu": "1", "menu_title": "Manage rooms", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "rooms\/c_room", "tab": "_self", "parent_id": "56", "sort_order": "27", "Meta_keywords": "manage rooms", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-08-14 11:46:41", "Mode_DateTime": "2016-01-05 10:50:23", "UTID": "10", "Allowed": "1"}, "Child": []}, {"Parent": {"MID": "57", "module_id": "1", "controller": "", "function": "", "is_menu": "1", "menu_title": "Enquiry Followup", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "", "tab": "_self", "parent_id": "56", "sort_order": "28", "Meta_keywords": "", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-07-22 18:58:34", "Mode_DateTime": "2016-01-05 10:50:23", "UTID": "10", "Allowed": "1"}, "Child": [{"Parent": {"MID": "16", "module_id": "2", "controller": "source", "function": "AddSource", "is_menu": "1", "menu_title": "Manage Source", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "Enquiry\/source", "tab": "_self", "parent_id": "57", "sort_order": "29", "Meta_keywords": "source master, manage source", "Status": "1", "Add_User": "15", "Mode_User": "0", "Add_DateTime": "2015-04-11 11:07:58", "Mode_DateTime": "2016-01-05 10:50:23", "UTID": "10", "Allowed": "1"}, "Child": []}, {"Parent": {"MID": "29", "module_id": "2", "controller": "c_response", "function": "index", "is_menu": "1", "menu_title": "Manage Response", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-cloud-download", "menu_link": "Enquiry\/c_response\/", "tab": "_self", "parent_id": "57", "sort_order": "30", "Meta_keywords": "Manage Response", "Status": "1", "Add_User": "33", "Mode_User": "0", "Add_DateTime": "2015-04-25 14:11:21", "Mode_DateTime": "2016-01-05 10:50:23", "UTID": "10", "Allowed": "1"}, "Child": []}, {"Parent": {"MID": "37", "module_id": "2", "controller": "c_cdoing", "function": "index", "is_menu": "1", "menu_title": "Manage CDoing", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "Enquiry\/c_cdoing", "tab": "_self", "parent_id": "57", "sort_order": "31", "Meta_keywords": "current doing", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-05-07 10:28:52", "Mode_DateTime": "2016-01-05 10:50:23", "UTID": "10", "Allowed": "1"}, "Child": []}]}, {"Parent": {"MID": "58", "module_id": "1", "controller": "", "function": "", "is_menu": "1", "menu_title": "Fee and Courses", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "", "tab": "_self", "parent_id": "56", "sort_order": "32", "Meta_keywords": "", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-07-22 19:01:41", "Mode_DateTime": "2016-01-05 10:50:23", "UTID": "10", "Allowed": "1"}, "Child": [{"Parent": {"MID": "72", "module_id": "9", "controller": "faculty_share", "function": "index", "is_menu": "1", "menu_title": "Faculty Share", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "fees\/faculty_share", "tab": "_self", "parent_id": "58", "sort_order": "33", "Meta_keywords": "Faculty Share", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-08-17 17:07:37", "Mode_DateTime": "2016-01-05 10:50:23", "UTID": "10", "Allowed": "1"}, "Child": []}, {"Parent": {"MID": "54", "module_id": "9", "controller": "fee_type", "function": "index", "is_menu": "1", "menu_title": "Mange Fee Type", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "fees\/fee_type", "tab": "_self", "parent_id": "58", "sort_order": "34", "Meta_keywords": "Mange Fee Type", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-07-03 12:00:20", "Mode_DateTime": "2016-01-05 10:50:23", "UTID": "10", "Allowed": "1"}, "Child": []}, {"Parent": {"MID": "18", "module_id": "6", "controller": "courses", "function": "Add_Course_form", "is_menu": "1", "menu_title": "Add Courses", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "courses", "tab": "_self", "parent_id": "58", "sort_order": "35", "Meta_keywords": "courses, All Courses", "Status": "1", "Add_User": "15", "Mode_User": "0", "Add_DateTime": "2015-04-11 11:21:06", "Mode_DateTime": "2016-01-06 08:19:53", "UTID": "10", "Allowed": "1"}, "Child": []}, {"Parent": {"MID": "53", "module_id": "5", "controller": "Fee_Master", "function": "scfp", "is_menu": "1", "menu_title": "Mange Course Fee Plan", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "fees\/Fee_Master\/scfp", "tab": "_self", "parent_id": "58", "sort_order": "36", "Meta_keywords": "Mange Course Fee Plan", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-06-22 11:02:16", "Mode_DateTime": "2016-01-06 08:19:53", "UTID": "10", "Allowed": "1"}, "Child": []}, {"Parent": {"MID": "21", "module_id": "6", "controller": "courses", "function": "add_course_cat", "is_menu": "1", "menu_title": "Manage Course Category", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "courses\/add_course_cat", "tab": "_self", "parent_id": "58", "sort_order": "37", "Meta_keywords": "courses Category", "Status": "1", "Add_User": "15", "Mode_User": "0", "Add_DateTime": "2015-04-11 18:14:24", "Mode_DateTime": "2016-01-06 08:19:53", "UTID": "10", "Allowed": "1"}, "Child": []}]}, {"Parent": {"MID": "43", "module_id": "15", "controller": "", "function": "", "is_menu": "1", "menu_title": "Manage LocalityArea", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-list", "menu_link": "", "tab": "_self", "parent_id": "56", "sort_order": "38", "Meta_keywords": "", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-05-10 11:47:05", "Mode_DateTime": "2016-01-06 08:19:53", "UTID": "10", "Allowed": "1"}, "Child": [{"Parent": {"MID": "30", "module_id": "15", "controller": "c_country", "function": "index", "is_menu": "1", "menu_title": "Manage Country", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-download", "menu_link": "Enquiry\/c_country\/", "tab": "_self", "parent_id": "43", "sort_order": "39", "Meta_keywords": "Manage Country", "Status": "1", "Add_User": "33", "Mode_User": "0", "Add_DateTime": "2015-04-25 14:16:41", "Mode_DateTime": "2016-01-06 08:19:53", "UTID": "10", "Allowed": "1"}, "Child": []}, {"Parent": {"MID": "31", "module_id": "15", "controller": "c_state", "function": "index", "is_menu": "1", "menu_title": "Manage States", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "Enquiry\/c_state\/", "tab": "_self", "parent_id": "43", "sort_order": "40", "Meta_keywords": "Manage States", "Status": "1", "Add_User": "33", "Mode_User": "0", "Add_DateTime": "2015-04-25 14:18:24", "Mode_DateTime": "2016-01-06 08:19:53", "UTID": "10", "Allowed": "1"}, "Child": []}, {"Parent": {"MID": "32", "module_id": "15", "controller": "c_city", "function": "index", "is_menu": "1", "menu_title": "Manage Cities", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "Enquiry\/c_city\/", "tab": "_self", "parent_id": "43", "sort_order": "41", "Meta_keywords": "Manage Cities", "Status": "1", "Add_User": "33", "Mode_User": "0", "Add_DateTime": "2015-04-25 14:22:08", "Mode_DateTime": "2016-01-06 08:19:53", "UTID": "10", "Allowed": "1"}, "Child": []}, {"Parent": {"MID": "33", "module_id": "15", "controller": "c_locality", "function": "index", "is_menu": "1", "menu_title": "Manage Locality", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "Enquiry\/c_locality\/", "tab": "_self", "parent_id": "43", "sort_order": "42", "Meta_keywords": "Manage Locality", "Status": "1", "Add_User": "33", "Mode_User": "0", "Add_DateTime": "2015-04-25 14:23:40", "Mode_DateTime": "2016-01-06 08:19:53", "UTID": "10", "Allowed": "1"}, "Child": []}]}, {"Parent": {"MID": "17", "module_id": "6", "controller": "", "function": "", "is_menu": "1", "menu_title": "Manage Courses", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-list", "menu_link": "", "tab": "_self", "parent_id": "56", "sort_order": "43", "Meta_keywords": "", "Status": "1", "Add_User": "15", "Mode_User": "0", "Add_DateTime": "2015-04-11 11:19:57", "Mode_DateTime": "2016-01-06 08:19:53", "UTID": "10", "Allowed": "1"}, "Child": []}, {"Parent": {"MID": "23", "module_id": "12", "controller": "", "function": "", "is_menu": "1", "menu_title": "Manage Employee", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-list", "menu_link": "", "tab": "_self", "parent_id": "56", "sort_order": "44", "Meta_keywords": "", "Status": "1", "Add_User": "15", "Mode_User": "0", "Add_DateTime": "2015-04-11 20:52:13", "Mode_DateTime": "2016-01-05 10:50:23", "UTID": "10", "Allowed": "1"}, "Child": [{"Parent": {"MID": "22", "module_id": "12", "controller": "employee", "function": "add_employee", "is_menu": "1", "menu_title": "Add Employee", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "employee", "tab": "_self", "parent_id": "23", "sort_order": "45", "Meta_keywords": "employee, add Employee", "Status": "1", "Add_User": "15", "Mode_User": "0", "Add_DateTime": "2015-04-11 20:51:35", "Mode_DateTime": "2016-01-05 10:50:23", "UTID": "10", "Allowed": "1"}, "Child": []}]}]}, {"Parent": {"MID": "12", "module_id": "13", "controller": "", "function": "", "is_menu": "1", "menu_title": "Super-Admin", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-list", "menu_link": "", "tab": "_self", "parent_id": "0", "sort_order": "46", "Meta_keywords": "super-admin, superadmin", "Status": "1", "Add_User": "15", "Mode_User": "0", "Add_DateTime": "2015-04-11 10:20:13", "Mode_DateTime": "2016-01-05 10:50:23", "UTID": "10", "Allowed": "1"}, "Child": [{"Parent": {"MID": "45", "module_id": "14", "controller": "", "function": "", "is_menu": "1", "menu_title": "Manage Branch", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-list", "menu_link": "", "tab": "_self", "parent_id": "12", "sort_order": "47", "Meta_keywords": "", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-05-19 16:39:50", "Mode_DateTime": "2016-01-05 10:50:23", "UTID": "10", "Allowed": "1"}, "Child": [{"Parent": {"MID": "20", "module_id": "14", "controller": "branch_master", "function": "index", "is_menu": "1", "menu_title": "New Branch", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "sp-admin\/bm\/index", "tab": "_self", "parent_id": "45", "sort_order": "48", "Meta_keywords": "Manage Branch", "Status": "1", "Add_User": "15", "Mode_User": "0", "Add_DateTime": "2015-04-11 12:47:39", "Mode_DateTime": "2016-01-05 10:50:23", "UTID": "10", "Allowed": "1"}, "Child": []}, {"Parent": {"MID": "47", "module_id": "14", "controller": "branch_master", "function": "update_branch", "is_menu": "1", "menu_title": "Update Branch", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "sp-admin\/bm\/vedit_branch", "tab": "_self", "parent_id": "45", "sort_order": "49", "Meta_keywords": "", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-05-19 16:43:35", "Mode_DateTime": "2016-01-05 10:50:23", "UTID": "10", "Allowed": "1"}, "Child": []}, {"Parent": {"MID": "44", "module_id": "14", "controller": "branch_master", "function": "bra_noti_setting", "is_menu": "1", "menu_title": "Notification Setting", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "sp-admin\/bm\/bra_noti_setting", "tab": "_self", "parent_id": "45", "sort_order": "50", "Meta_keywords": "notification setting ", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-05-19 14:34:56", "Mode_DateTime": "2016-01-05 10:50:23", "UTID": "10", "Allowed": "1"}, "Child": []}]}, {"Parent": {"MID": "61", "module_id": "18", "controller": "", "function": "", "is_menu": "1", "menu_title": "Manage Faq", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-list", "menu_link": "", "tab": "_self", "parent_id": "12", "sort_order": "51", "Meta_keywords": "", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-08-10 15:51:40", "Mode_DateTime": "2016-01-05 10:50:23", "UTID": "10", "Allowed": "1"}, "Child": [{"Parent": {"MID": "62", "module_id": "18", "controller": "c_faqs", "function": "manage_manu", "is_menu": "1", "menu_title": "Manage Menu", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "faqs\/manage_manu", "tab": "_self", "parent_id": "61", "sort_order": "52", "Meta_keywords": "faq", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-08-10 15:53:05", "Mode_DateTime": "2016-01-05 10:50:23", "UTID": "10", "Allowed": "1"}, "Child": []}, {"Parent": {"MID": "63", "module_id": "18", "controller": "c_faqs", "function": "manage_faq_qus", "is_menu": "1", "menu_title": "Manage Question", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "faqs\/manage_faq_qus", "tab": "_self", "parent_id": "61", "sort_order": "53", "Meta_keywords": "Manage Question", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-08-10 15:54:00", "Mode_DateTime": "2016-01-05 10:50:23", "UTID": "10", "Allowed": "1"}, "Child": []}]}, {"Parent": {"MID": "46", "module_id": "13", "controller": "", "function": "", "is_menu": "1", "menu_title": "Manage Menus", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-list", "menu_link": "", "tab": "_self", "parent_id": "12", "sort_order": "54", "Meta_keywords": "", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-05-19 16:40:56", "Mode_DateTime": "2016-01-05 10:50:23", "UTID": "10", "Allowed": "1"}, "Child": [{"Parent": {"MID": "11", "module_id": "13", "controller": "menus", "function": "index", "is_menu": "1", "menu_title": "Menu Master", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-eye-close", "menu_link": "sp-admin\/m\/menus", "tab": "_self", "parent_id": "46", "sort_order": "55", "Meta_keywords": "Menu Master", "Status": "1", "Add_User": "15", "Mode_User": "0", "Add_DateTime": "2015-04-11 10:13:50", "Mode_DateTime": "2016-01-05 10:50:23", "UTID": "10", "Allowed": "1"}, "Child": []}, {"Parent": {"MID": "13", "module_id": "13", "controller": "menus", "function": "menu_auth", "is_menu": "1", "menu_title": "Menu Auth", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "sp-admin\/m\/menu_auth", "tab": "_self", "parent_id": "46", "sort_order": "56", "Meta_keywords": "Menu Auth", "Status": "1", "Add_User": "15", "Mode_User": "0", "Add_DateTime": "2015-04-11 10:23:11", "Mode_DateTime": "2016-01-05 10:50:23", "UTID": "10", "Allowed": "1"}, "Child": []}]}, {"Parent": {"MID": "36", "module_id": "16", "controller": "c_err_mst", "function": "index", "is_menu": "1", "menu_title": "Manage Error Errors", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "sp-admin\/em\/index", "tab": "_self", "parent_id": "12", "sort_order": "57", "Meta_keywords": "Manage Error Errors", "Status": "1", "Add_User": "33", "Mode_User": "0", "Add_DateTime": "2015-04-28 11:12:44", "Mode_DateTime": "2016-01-05 10:50:23", "UTID": "10", "Allowed": "1"}, "Child": []}, {"Parent": {"MID": "26", "module_id": "13", "controller": "usertypes", "function": "index", "is_menu": "1", "menu_title": "UserType Master", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "sp-admin\/a\/usertypes", "tab": "_self", "parent_id": "12", "sort_order": "58", "Meta_keywords": "usertype master", "Status": "1", "Add_User": "32", "Mode_User": "0", "Add_DateTime": "2015-04-16 12:04:51", "Mode_DateTime": "2016-01-05 10:50:23", "UTID": "10", "Allowed": "1"}, "Child": []}]}, {"Parent": {"MID": "40", "module_id": "17", "controller": "", "function": "", "is_menu": "1", "menu_title": "Manage Tokens", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-list", "menu_link": "", "tab": "_self", "parent_id": "0", "sort_order": "59", "Meta_keywords": "", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-05-07 13:47:39", "Mode_DateTime": "2016-01-05 10:50:23", "UTID": "10", "Allowed": "1"}, "Child": [{"Parent": {"MID": "41", "module_id": "17", "controller": "ct", "function": "index", "is_menu": "1", "menu_title": "Generate token", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-edit", "menu_link": "tokensys\/ct", "tab": "_self", "parent_id": "40", "sort_order": "60", "Meta_keywords": "Generate token", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-05-07 13:49:03", "Mode_DateTime": "2016-01-05 10:50:23", "UTID": "10", "Allowed": "1"}, "Child": []}]}, {"Parent": {"MID": "64", "module_id": "18", "controller": "c_faq_template", "function": "index", "is_menu": "1", "menu_title": "Help", "menulocation_id": "1", "menu_icon": "glyphicon glyphicon-file", "menu_link": "nexibms-faq.html", "tab": "_self", "parent_id": "0", "sort_order": "61", "Meta_keywords": "help, how to use this soft", "Status": "1", "Add_User": "34", "Mode_User": "0", "Add_DateTime": "2015-08-13 16:56:13", "Mode_DateTime": "2015-09-19 14:05:33", "UTID": "10", "Allowed": "1"}, "Child": []}];
//                                            }
//                                        });
                                    });
//                                    });
                        </script>


                        <!-- /.nav-second-level -->
                        <!--</li>-->
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>

            <!-- /.navbar-static-side -->
        </nav>

    


 <div id="bread_crum"> 
        <div class="row">
             <div class="col-lg-12"> 
                <h4>
                    <ol class="breadcrumb">
                        <?php 
//                        $this->util_model->printr($bread_crum);
                        $total_element = count($bread_crum) - 1;
                        if($bread_crum[$total_element]['controller']!="dashboard" && $bread_crum[$total_element]['function']!="view")
                        echo "<li><a href='".base_url()."'>" . "Dashboard" . "</a>";
                        echo "<li><a href='".base_url().$bread_crum[$total_element]['menu_link']."'>" . $bread_crum[$total_element]['menu_title'] . "</a>";
                        unset($bread_crum[$total_element]);
                        foreach ($bread_crum as $each_menu) {
                                      echo "<li><a href='".base_url().$each_menu['menu_link']."'>" . $each_menu['menu_title'] . "</a>";
                        }
                        ?>
                    </ol>
                </h4>
             </div>
        </div>
    </div>
    
