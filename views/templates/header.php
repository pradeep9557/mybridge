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
<!--        <style>
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
        </style>-->
<!--    <div class="pre_loader">
        <img src="<?= base_url() . PRELOADER128 ?>"/>
        <div class="progress progress-striped active" style="  width: 60%;  margin: 120px auto;">
            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" data-transitiongoal="60" style="width: 5%">
                <span class="sr-only-focusable"5% Complete (success)</span>
            </div>
        </div>
        <span class="blink">Wait While Loading ....</span>
    </div>-->

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
                    <?php if(LOGO!=""):?><img src="<?= base_url() . LOGO ?>" style="height: 25px;padding-left: 5px;"/><?php endif; ?>
                    <a href="<?= base_url() ?>">
                        <span class="title_text_color">
                            <?= SITE_NAME ?>
                        </span>
                    </a>
                </span>
            </div> 
            
            <div class="myshortCuts">
                
            </div>

            <!-- /.navbar-header -->    
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
<!--                <li>Your Branch:<?php echo $Branch_obj->Bname; ?></li>
                <li class="dropdown"><?php
                echo date(DTF, time());
                ?></li>-->
                <!-- message toogle -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <span class="user_name">
                            <?php
                            echo ucfirst($this->util_model->get_uname());
                            ?>
                            (
                            <?php
                            echo ucfirst($this->session->userdata['IBMS_USER_TYPE_NAME']);
                            ?>
                            )
                        </span>
                        <?php if ($this->session->userdata['IBMS_USER_PRO_PIC'] != "") { ?>
                        <!--http://tms.nexibms.in/img/Employee_Data/Employee_pic_and_sign/SanjeevKachhal_no-image.png-->
                            <img src="<?= base_url() . 'img/Employee_Data/Employee_pic_and_sign/' . $this->session->userdata['IBMS_USER_PRO_PIC'] ?>" class="circle_img" alt="Cinque Terre" style="float: left"> 
                        <?php } else { ?>
                            <img src="<?= base_url() . 'img/Login/profile.jpg' ?>" class="circle_img" alt="Cinque Terre" style="float: left"> 
                        <?php }
                        ?>
                        <i class="setting_icon fa fa-1x fa-cog" aria-hidden="true"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="<?= base_url() ?>employee/user_profile"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="<?= base_url() ?>employee/change_password"><i class="fa fa-gear fa-fw"></i> Change Password</a></li>        
<!--                            <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>-->

                        <li class="divider"></li>
                        <li>
                            <a href="javascript:;" class="logout_confirm">
                                <i class="fa fa-sign-out fa-fw"></i> 
                                Logout
                            </a>
                        </li>
                    </ul>
                    <!--/.dropdown-messages--> 
                </li>
            </ul>
            <!-- / 
            <!-- /.navbar-top-links -->

            <!-- /.navbar-top-links -->
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control srch_class" placeholder="Search...">
<!--                                                        <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>-->
                            </div>
                        </li>
                    </ul>
                    <ul class="nav" id="side-menu">
                        <?php
                        $base_url = base_url();
                        $total_element = count($bread_crum) - 1;
                        $curr_bread_crum = $bread_crum[$total_element];

                        foreach ($MenuList as $Menu) {
                            $Menu_selcted = 0;
//                                       print_r($curr_bread_crum);
                            if (!empty($curr_bread_crum) && $curr_bread_crum['MID'] == $Menu['Parent']['MID']) {
                                $Menu_selcted = 1;
                                $total_element--;
                                $curr_bread_crum = isset($bread_crum[$total_element]) ? $bread_crum[$total_element] : array();
                            }
                            $Menu_selcted = $Menu_selcted ? " class='active' " : "";
                            echo "<li " . $Menu_selcted . " is_shortcut='{$Menu['Parent']['is_shortcut']}' ><a href='$base_url{$Menu['Parent']['menu_link']}' target='{$Menu['Parent']['tab']}'><span class='{$Menu['Parent']['menu_icon']}'></span> {$Menu['Parent']['menu_title']}";
                            $Menu_selcted = 0;
                            if (!empty($Menu['Child'])) {
                                echo "<span class='fa arrow'></span>";
                            }
                            echo "</a>";
                            if (!empty($Menu['Child'])) {
                                echo "<ul class='nav nav-second-level'>";
                                foreach ($Menu['Child'] as $l1_menu) {
                                    $l1_menu_selcted = 0;
                                    if (!empty($curr_bread_crum) && $curr_bread_crum['MID'] == $l1_menu['Parent']['MID']) {
                                        $l1_menu_selcted = 1;
                                        $total_element--;
                                        $curr_bread_crum = isset($bread_crum[$total_element]) ? $bread_crum[$total_element] : array();
                                    }
                                    $l1_menu_selcted = $l1_menu_selcted ? " class='active' " : "";
                                    echo "<li " . $l1_menu_selcted . " is_shortcut='{$l1_menu['Parent']['is_shortcut']}' ><a href='$base_url{$l1_menu['Parent']['menu_link']}' target='{$l1_menu['Parent']['tab']}'><span class='{$l1_menu['Parent']['menu_icon']}'></span> {$l1_menu['Parent']['menu_title']}";
                                    $l1_menu_selcted = 0;
                                    if (!empty($l1_menu['Child'])) {
                                        echo "<span class='fa arrow'></span>";
                                    }
                                    echo "</a>";
                                    if (!empty($l1_menu['Child'])) {
                                        echo "<ul class='nav nav-third-level'>";
                                        foreach ($l1_menu['Child'] as $l2_menu) {
                                            $l2_menu_selcted = 0;
                                            if (!empty($curr_bread_crum) && $curr_bread_crum['MID'] == $l2_menu['Parent']['MID']) {
                                                $l2_menu_selcted = 1;
                                                $total_element--;
                                                $curr_bread_crum = isset($bread_crum[$total_element]) ? $bread_crum[$total_element] : array();
                                            }
                                            $l2_menu_selcted = $l2_menu_selcted ? " class='active' " : "";
                                            echo "<li " . $l2_menu_selcted . " is_shortcut='{$l2_menu['Parent']['is_shortcut']}' ><a href='$base_url{$l2_menu['Parent']['menu_link']}' target='{$l2_menu['Parent']['tab']}'><span class='{$l2_menu['Parent']['menu_icon']}'></span> {$l2_menu['Parent']['menu_title']}";
                                            $l2_menu_selcted = 0;
                                            if (!empty($l2_menu['Child'])) {
                                                echo "<span class='fa arrow'></span>";
                                            }
                                            echo "</a>";
                                        }
                                        echo "</ul>";
                                    }
                                }
                                echo "</ul>";
                            }
                            echo "</li>";
                        }
                        ?>

                        <!-- /.nav-second-level -->
                        <!--</li>-->
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>

            <!-- /.navbar-static-side -->
            <av>

                </div>
                <!-- /#wrapper -->

                <!-- jQuery Version 1.11.0 -->

                <div id="bread_crum"> 
                    <div class="row">
                        <div class="col-lg-12"> 
                            <h4>
                                <ol class="breadcrumb">
                                    <?php
                                    $total_element = count($bread_crum) - 1;
                                    if ($bread_crum[$total_element]['controller'] != "dashboard" && $bread_crum[$total_element]['function'] != "view")
                                        echo "<li><a href='" . base_url() . "'>" . "Dashboard" . "</a>";
                                    echo "<li><a href='" . base_url() . $bread_crum[$total_element]['menu_link'] . "'>" . $bread_crum[$total_element]['menu_title'] . "</a>";
                                    unset($bread_crum[$total_element]);
                                    foreach ($bread_crum as $each_menu) {
                                        echo "<li><a href='" . base_url() . $each_menu['menu_link'] . "'>" . $each_menu['menu_title'] . "</a>";
                                    }
                                    ?>
                                </ol>
                            </h4>
                        </div>
                    </div>
                </div>


                <script>
                    $(document).on("ready", function () {
                        var lastFilter = "";
                        $('.srch_class').change(function () {
                            var filter = $(this).val().toLowerCase();
                            myfun(filter);
                            return false;
                        }).keyup(function () {
                            if ($(this).val() === lastFilter) {
                                return;
                            } else {
                                lastFilter = $(this).val();

                                $(this).change();

                            }
                        });
                        
                        
                   
                   $("#side-menu").find("li[is_shortcut='1']").each(function(index,item){
                     
                     $("div.myshortCuts").append("<div class='myshortLinks'>"+$(item).html()+"</div>" );
                       
                   });
                   
                        
                        
                        
                    });

                    function myfun(filter) {
                        $("#side-menu").find("li").each(function () {
                            console.log(filter);
                            if (filter == "") {
                                $(this).css("visibility", "visible");
                                $(this).removeClass("active");
                                for (var i = 0; i < $(this).children().length; i++) {
                                    var liObject = jQuery($(this).children()[i]);
                                    if (liObject.is('ul')) {
                                        $(this).children("ul").removeClass("in");
                                    }
                                }
                                $(this).fadeIn();
                            } else if ($(this).text().search(new RegExp(filter, "i")) < 0) {
                                $(this).removeClass("active");
                                $(this).css("visibility", "hidden");
                                for (var i = 0; i < $(this).children().length; i++) {
                                    var liObject = jQuery($(this).children()[i]);
                                    if (liObject.is('ul')) {
                                        $(this).children("ul").removeClass("in");
                                    }
                                }
                                $(this).fadeOut();
                            } else {
                                $(this).addClass("active");
                                $(this).css("visibility", "visible");
                                for (var i = 0; i < $(this).children().length; i++) {
                                    var liObject = jQuery($(this).children()[i]);
                                    if (liObject.is('ul')) {
                                        $(this).children("ul").addClass("in");
                                    }
//                                    if(liObject.is('a') && i == $(this).children().length){
//                                        $(this).children("a").css("text-decoration","underline");
//                                    }
                                }
                                $(this).fadeIn();
                            }
                        });
                    }



                </script>