<!DOCTYPE html>
<html lang="en" ng-app="nexgen.ibms.app">
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
                background: white;
                z-index: 10000;
                text-align: center;
                padding-top: 150px;
                top: 0px;
                opacity: 1;
            }
        </style>
    <div class="pre_loader">
        <img src="<?= base_url() . PRELOADER128 ?>"/>
        Wait While Loading ....
    </div>
    <?php include_once 'Common_Css_Js_Others_files.php'; ?>
</head>
<body ng-controller="DatepickerCtrl">
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
                <a class="navbar-brand" href="<?= base_url() ?>"><span class="title_text_color"><?= SITE_NAME ?></samp></a>
            </div>
            <!-- /.navbar-header -->    
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li>Your Branch:<?php echo $Branch_obj->Bname; ?></li>
                <li class="dropdown"><?php
                    echo date(DTF, time());
                    ?></li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-tasks fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-tasks">
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 1</strong>
                                        <span class="pull-right text-muted">40% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                                            <span class="sr-only">40% Complete (success)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 2</strong>
                                        <span class="pull-right text-muted">20% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%">
                                            <span class="sr-only">20% Complete</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 3</strong>
                                        <span class="pull-right text-muted">60% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                                            <span class="sr-only">60% Complete (warning)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <p>
                                        <strong>Task 4</strong>
                                        <span class="pull-right text-muted">80% Complete</span>
                                    </p>
                                    <div class="progress progress-striped active">
                                        <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                                            <span class="sr-only">80% Complete (danger)</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Tasks</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-tasks -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-comment fa-fw"></i> New Comment
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                    <span class="pull-right text-muted small">12 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-envelope fa-fw"></i> Message Sent
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-tasks fa-fw"></i> New Task
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="pull-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?= base_url() ?>employee/user_profile/<?= $Session_Data['IBMS_USER_ID'] ?>"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="<?= base_url() ?>employee/change_password"><i class="fa fa-gear fa-fw"></i> Change Password</a></li>        
<!--                            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>-->
                </li>
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
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a class="active" href="<?= base_url() ?>dashboard"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>admission"><span class="glyphicon glyphicon-user"></span>  Admission</a>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>Fee_Master"><span class="glyphicon glyphicon-stats"></span>   Fee Collect</a>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>batch_master/Fetch_Student_List"><span class="glyphicon glyphicon-refresh"></span> Batch update</a>
                        </li>
                        <li>
                            <a href="#"><span class="glyphicon glyphicon-th-list"></span> Batch Master<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li>
                                    <a href="<?= base_url() ?>batch_master"><span class="glyphicon glyphicon-edit"></span> Add New Batch</a>
                                </li>
                                <li>
                                    <a href="<?= base_url() ?>batch_master/Fetch_Student_List"><span class="glyphicon glyphicon-fast-forward"></span> Batch update</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><span class="glyphicon glyphicon-th-list"></span> Fee Collect Master<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li>
                                    <a href="<?= base_url() ?>Fee_Master"><span class="glyphicon glyphicon-edit"></span> Fee Collect</a>
                                </li>
                                <li>
                                    <a href="<?= base_url() ?>Fee_Master/all_Fees_record"><span class="glyphicon glyphicon-list-alt"></span> All Fees Record</a>
                                </li>
                            </ul>
                        </li>
                          <li>
                            <a href="#"><span class="glyphicon glyphicon-th-list"></span>Enquiry<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li>
                                    <a href="<?= base_url()."enquiry/AddEnquiry" ?>"><span class="glyphicon glyphicon-edit"></span> Add Enquiry</a>
                                </li>
                                
                            </ul>
                        </li>
                        <li>
                            <a href="#"><span class="glyphicon glyphicon-th-list"></span> Other Master <span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li>
                                    <a href="<?= base_url() ?>courses"><span class="glyphicon glyphicon-edit"></span> Course Master</a>
                                </li>
                                <li>
                                    <a href="<?= base_url() ?>designation_controller"><span class="glyphicon glyphicon-edit"></span> Designation Master</a>
                                </li>
                                <li>
                                    <a href="<?= base_url() ?>fee_type"><span class="glyphicon glyphicon-edit"></span> Fees Type Master</a>
                                </li>
                                <li>
                                    <a href="<?= base_url() ?>qualification_controller"><span class="glyphicon glyphicon-edit"></span> Qualification Master</a>
                                </li>
                                <li>
                                    <a href="<?= base_url() ?>employee"><span class="glyphicon glyphicon-edit"></span> Employee Master</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><span class="glyphicon glyphicon-th-list"></span> Reports<span class="fa arrow"></span></a>
                            <ul class="nav nav-third-level">
                                <li>
                                    <a href="<?= base_url() ?>reports/bal_report"><span class="glyphicon glyphicon-file"></span> Balance Report</a>
                                </li>
                                <li>
                                    <a href="<?= base_url() ?>reports/db_backup"><span class="glyphicon glyphicon-hdd"></span> DataBase BackUp</a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="#"><span class="glyphicon glyphicon-th-list"></span> Super-Admin<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href=""><span class="glyphicon glyphicon-th-list"></span> Authentications <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="<?= base_url() ?>sp-admin/m/menu_auth"><span class="glyphicon glyphicon-edit"></span> Menu Auth</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href=""><span class="glyphicon glyphicon-th-list"></span> Branch Master <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="<?= base_url() ?>sp-admin/bm/create_branch"><span class="glyphicon glyphicon-edit"></span> Modules Master</a>
                                        </li>
                                        <li>
                                            <a href="<?= base_url() ?>sp-admin/m/menus"><span class="glyphicon glyphicon-edit"></span> Menu Master</a>
                                        </li>
                                        <li>
                                            <a href="<?= base_url() ?>sp-admin/a/usertypes"><span class="glyphicon glyphicon-edit"></span> USertype Master</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>sp-admin/m/menu_auth"><span class="glyphicon glyphicon-edit"></span> Menu Auth</a>
                        </li>
                        <li>
                            <a href="<?= base_url() ?>sp-admin/m/menus"><span class="glyphicon glyphicon-edit"></span> Menu Master</a>
                        </li>
                        <li>
                                <a href="<?= base_url() ?>sp-admin/m/show_all_userTypeForAuth"><span class="glyphicon glyphicon-edit"></span> USertype Master</a>
                        </li>
                         <li>
                                <a href="<?= base_url() ?>source/AddSource"><span class="glyphicon glyphicon-edit"></span> Add Source</a>
                        </li>


                        <!-- /.nav-second-level -->
                        <!--</li>-->
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>

            <!-- /.navbar-static-side -->
        </nav>

    </div>
    <!-- /#wrapper -->

    <!-- jQuery Version 1.11.0 -->


    <!--             Bootstrap Core JavaScript 
                <script src="<?= base_url() ?>js/bootstrap.js"></script>-->
    <link href="<?= base_url() ?>css/custome.css" rel="stylesheet" type="text/css"/>
