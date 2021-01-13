<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/>
<link href="<?php echo base_url() ?>css/dummy_du.css" rel="stylesheet" type="text/css"/>
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">  
            <?php
            if (isset($error)) {
                $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 slide_rht_con">
            <table cellpadding="0" cellspacing="0" width="96%" class="task_section dashbod_tbl_m10 fixed_layout" style="display: table;">
        <tbody>
            <tr>
                <td id="topaction" class="compactview_action">
                    <!--Tabs section starts -->
                    <div style="display:block;border:0px solid #FF0000;" class="tab" id="topactions">
                        <ul id="myTab4" class="nav-tabs">
                            <li class="active">
                                <a class="cattab active_tab" id="cases_id" data-toggle="tab">
                                    <div class="fl">All Tasks<span id="tskTabAllCnt"> (8)</span>
                                    </div>
                                    <div class="cbt"></div>
                                </a>
                            </li>
                            <li class="">
                                <a class="cattab" id="assigntome_id"  data-toggle="tab">
                                    <div class="fl">My Tasks<span id="tskTabMyCnt"> (4)</span>
                                    </div>
                                    <div class="cbt"></div>
                                </a>
                            </li>
                            <li class="">
                                <a class="cattab" id="overdue_id" data-toggle="tab">
                                    <div class="fl">Overdue<span id="tskTabOverdueCnt"> (2)</span>
                                    </div>
                                    <div class="cbt"></div>
                                </a>
                            </li>
                            <div style="clear:both"></div>
                        </ul>
                    </div>
                    <!--Tabs section ends -->
                </td>
            </tr>
            <tr>
                <td>
                    <!--Task listing section starts here-->
                    <div id="caseViewSpanUnclick" style="display: block;">
                        <div id="caseViewDetails" style="display:none"></div>
                        <div id="caseViewSpan" style="display:block">
                            <style type="text/css">
                                .pr_low {
                                    background: none !important;
                                }
                                .pr_medium {
                                    background: none !important;
                                }
                                .pr_high {
                                    background: none !important;
                                }
                                .label {
                                    font-weight: normal;
                                }
                                .tsk_tbl td {
                                    border-right: 0px solid #FFF !important;
                                    border-bottom: 0px solid #FFF !important;
                                }
                            </style>
                            <table width="100%" class="tsk_tbl compactview_tbl">
                                <tbody>
                                    <tr style="" class="tab_tr">
                                        <td width="18%" class="all_td">
                                            <div class="dropdown fl">
                                                S.No
                                            </div>
                                        </td>
                                        <td class="task_cn">
                                            <a href="javascript:void(0);" title="Task#" onclick="ajaxSorting('caseno', 6, this);" class="sortcaseno">
                                                <div class="fl">Task#</div>
                                                <div class="tsk_sort fl "></div>
                                            </a>
                                        </td>
                                        <td class="task_wd">
                                            <a class="sorttitle" href="javascript:void(0);" title="Title" onclick="ajaxSorting('title', 6, this);">
                                                <div class="fl">Title</div>
                                                <div class="tsk_sort fl "></div>
                                            </a>
                                        </td>
                                        <td class="assign_wd_td">
                                            <a class="sortcaseAt" href="javascript:void(0);" title="Assigned to" onclick="ajaxSorting('caseAt', 6, this);">
                                                <div class="fl">Assigned to</div>
                                                <div class="tsk_sort fl "></div>
                                            </a>
                                        </td>
                                        <td class="tsk_due_dt">
                                            <a class="sortduedate" href="javascript:void(0);" title="Due Date" onclick="ajaxSorting('duedate', 6, this);">
                                                <div class="fl">Due Date</div>
                                                <div class="tsk_sort fl "></div>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" align="left" class="curr_day">
                                            <div class="">Y'day</div>
                                        </td>
                                    </tr>
                                    <tr class="tr_all" id="curRow26">
                                        <td class="pr_medium" valign="top">
                                            <input type="checkbox" id="actionChk1" checked="checked" value="26|8|closed" disabled="disabled" class="fl mglt chkOneTsk">
                                            <input type="hidden" id="actionCls1" value="3" disabled="disabled" size="2">
                                            <div class="dropdown fl">
                                                <div class="sett" data-toggle="dropdown"></div>
                                                <ul class="dropdown-menu sett_dropdown-caret">
                                                    <li class="pop_arrow_new"></li>
                                                    <li onclick="startCase('26', '8', '34f95bbda46386087c258c2518f68777');" id="start26" style=" display:none">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon act_start_task fl" title="Start"></div>Start</a>
                                                    </li>
                                                    <li onclick="caseResolve('26', '8', '34f95bbda46386087c258c2518f68777');" id="resolve26" style="  display:none ">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon act_resolve_task fl" title="Resolve"></div>Resolve</a>
                                                    </li>
                                                    <li id="act_reply1" data-task="34f95bbda46386087c258c2518f68777">
                                                        <a href="javascript:void(0);" id="reopen26" style="display:block ">
                                                            <div class="act_icon act_reply_task fl" title="Re-open"></div>Re-open</a>
                                                        <a href="javascript:void(0);" id="reply26" style="display:none">
                                                            <div class="act_icon act_reply_task fl" title="Reply"></div>Reply</a>
                                                    </li>
                                                    <li onclick="moveTask('26', '8', '', '1');" id="moveTask26" style="  display:none ">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon task_move_mlst fl" title="Move Task To Milestone"></div>Move to Milestone</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li onclick="archiveCase('26', '8', '1', 't_34f95bbda46386087c258c2518f68777');" id="arch26" style="display:none">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon act_arcv_task fl" title="Archive"></div>Archive</a>
                                                    </li>
                                                    <li onclick="deleteCase('26', '8', '1', 't_34f95bbda46386087c258c2518f68777');" id="arch26" style="display:none">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon act_del_task fl" title="Delete"></div>Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="dropdown fl" style="width:32px;">
                                                <div id="showUpdStatus26" class="type_dev  " title="Development" data-toggle="dropdown"></div> <span id="typlod26" class="type_loader">                     <img src="http://task.nexgi.biz/img/images/del.gif" alt="Loading..." title="Loading...">                 </span> </div>
                                            <div id="csStsRep1" class="fl tsk_sts">
                                                <div class="label closed">Closed</div>
                                            </div>
                                        </td>
                                        <td valign="top" style="padding-right:20px;text-align:right">8</td>
                                        <td class="title_det_wd">
                                            <div class="fl title_wd">
                                                <div id="titlehtml1" data-task="34f95bbda46386087c258c2518f68777" class="fl case-title closed_tsk">
                                                    <div class="case_title wrapword task_title_ipad  " title="Display login page content dynmically  ">Display login page content dynmically</div>
                                                </div>
                                            </div>
                                            <div class="att_fl fr" style="display:none;" id="fileattch1"></div>
                                            <div class="cb rcb"></div>
                                            <div class="fnt999 fl">
                                                <div class="fl"> <span id="stsdisp26" class="cview_hide">updated</span> by <span></span> <span class="cview_hide">                                              </span> <span id="timedis1" class="cview_hide">                         Y'day 5:11 pm.                     </span> <span id="timedis1" class="cview_show" title="Y'day 5:11 pm">                         21 hours ago.                     </span> </div>
                                                <div class="fl" style="">
                                                    <div id="repno1" class="fl bblecnt"></div> (2) </div>
                                            </div>
                                            <div class="cb"></div>
                                        </td>
                                        <td valign="top">
                                            <div class="dropdown fl"> <span id="showUpdAssign26" style="cursor:text;text-decoration:none;color:#666666;">Anup</span>
                                                <ul class="dropdown-menu asgn_dropdown-caret" id="showAsgnToMem26">
                                                    <li class="pop_arrow_new"></li>
                                                    <li class="text-centre"><img src="http://task.nexgi.biz/img/images/del.gif" id="assgnload26">
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="fnt12" valign="top">
                                            <div class="dropdown fl">
                                                <div class="fl"> <span id="showUpdDueDate26" title="Tuesday, May 31, 2016">                         Y'day                                              </span> <span id="datelod26" class="asgn_loader">                         <img src="http://task.nexgi.biz/img/images/del.gif" alt="Loading..." title="Loading...">                     </span> </div>
                                                <ul class="dropdown-menu dudt_dropdown-caret">
                                                    <li class="pop_arrow_new"></li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('26', '8');
                                                        changeDueDate('26', '00/00/0000', 'No Due Date', '34f95bbda46386087c258c2518f68777')">No Due Date</a>
                                                    </li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('26', '8');
                                                        changeDueDate('26', '06/01/2016', 'Today', '34f95bbda46386087c258c2518f68777')">Today</a>
                                                    </li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('26', '8');
                                                        changeDueDate('26', '06/02/2016', 'Tomorrow', '34f95bbda46386087c258c2518f68777')">Tomorrow</a>
                                                    </li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('26', '8');
                                                        changeDueDate('26', '06/06/2016', 'Next Monday', '34f95bbda46386087c258c2518f68777')">Next Monday</a>
                                                    </li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('26', '8');
                                                        changeDueDate('26', '06/03/2016', 'This Friday', '34f95bbda46386087c258c2518f68777')">This Friday</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="cstm-dt-option" data-csatid="26">
                                                            <input value="" type="hidden" id="set_due_date_26" class="set_due_date hasDatepicker" title="Custom Date" style="">
                                                            <button type="button" class="ui-datepicker-trigger"><img src="http://task.nexgi.biz/img/images/calendar.png" alt="..." title="...">
                                                            </button> <span style="position:relative;top:2px;cursor:text;">Custom&nbsp;Date</span> </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="tr_all" id="curRow25">
                                        <td class="pr_medium" valign="top">
                                            <input type="checkbox" id="actionChk2" checked="checked" value="25|7|closed" disabled="disabled" class="fl mglt chkOneTsk">
                                            <input type="hidden" id="actionCls2" value="3" disabled="disabled" size="2">
                                            <div class="dropdown fl">
                                                <div class="sett" data-toggle="dropdown"></div>
                                                <ul class="dropdown-menu sett_dropdown-caret">
                                                    <li class="pop_arrow_new"></li>
                                                    <li onclick="startCase('25', '7', '78777aeaae3c47b83b8c166c06dd733d');" id="start25" style=" display:none">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon act_start_task fl" title="Start"></div>Start</a>
                                                    </li>
                                                    <li onclick="caseResolve('25', '7', '78777aeaae3c47b83b8c166c06dd733d');" id="resolve25" style="  display:none ">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon act_resolve_task fl" title="Resolve"></div>Resolve</a>
                                                    </li>
                                                    <li id="act_reply2" data-task="78777aeaae3c47b83b8c166c06dd733d">
                                                        <a href="javascript:void(0);" id="reopen25" style="display:block ">
                                                            <div class="act_icon act_reply_task fl" title="Re-open"></div>Re-open</a>
                                                        <a href="javascript:void(0);" id="reply25" style="display:none">
                                                            <div class="act_icon act_reply_task fl" title="Reply"></div>Reply</a>
                                                    </li>
                                                    <li onclick="moveTask('25', '7', '', '1');" id="moveTask25" style="  display:none ">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon task_move_mlst fl" title="Move Task To Milestone"></div>Move to Milestone</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li onclick="archiveCase('25', '7', '1', 't_78777aeaae3c47b83b8c166c06dd733d');" id="arch25" style="display:none">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon act_arcv_task fl" title="Archive"></div>Archive</a>
                                                    </li>
                                                    <li onclick="deleteCase('25', '7', '1', 't_78777aeaae3c47b83b8c166c06dd733d');" id="arch25" style="display:none">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon act_del_task fl" title="Delete"></div>Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="dropdown fl" style="width:32px;">
                                                <div id="showUpdStatus25" class="type_bug  " title="Bug" data-toggle="dropdown"></div> <span id="typlod25" class="type_loader">                     <img src="http://task.nexgi.biz/img/images/del.gif" alt="Loading..." title="Loading...">                 </span> </div>
                                            <div id="csStsRep2" class="fl tsk_sts">
                                                <div class="label closed">Closed</div>
                                            </div>
                                        </td>
                                        <td valign="top" style="padding-right:20px;text-align:right">7</td>
                                        <td class="title_det_wd">
                                            <div class="fl title_wd">
                                                <div id="titlehtml2" data-task="78777aeaae3c47b83b8c166c06dd733d" class="fl case-title closed_tsk">
                                                    <div class="case_title wrapword task_title_ipad overme " title="Footer.css is not being loading on login page | ankit  ">Footer.css is not being loading on login page | ankit</div>
                                                </div>
                                            </div>
                                            <div class="att_fl fr" style="display:none;" id="fileattch2"></div>
                                            <div class="cb rcb"></div>
                                            <div class="fnt999 fl">
                                                <div class="fl"> <span id="stsdisp25" class="cview_hide">updated</span> by <span></span> <span class="cview_hide">                                              </span> <span id="timedis2" class="cview_hide">                         Y'day 10:57 am.                     </span> <span id="timedis2" class="cview_show" title="Y'day 10:57 am">                         1 day ago.                     </span> </div>
                                                <div class="fl" style="">
                                                    <div id="repno2" class="fl bblecnt"></div> (1) </div>
                                            </div>
                                            <div class="cb"></div>
                                        </td>
                                        <td valign="top">
                                            <div class="dropdown fl"> <span id="showUpdAssign25" style="cursor:text;text-decoration:none;color:#666666;">Anup</span>
                                                <ul class="dropdown-menu asgn_dropdown-caret" id="showAsgnToMem25">
                                                    <li class="pop_arrow_new"></li>
                                                    <li class="text-centre"><img src="http://task.nexgi.biz/img/images/del.gif" id="assgnload25">
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="fnt12" valign="top">
                                            <div class="dropdown fl">
                                                <div class="fl"> <span id="showUpdDueDate25" title="">                                                                       </span> <span id="datelod25" class="asgn_loader">                         <img src="http://task.nexgi.biz/img/images/del.gif" alt="Loading..." title="Loading...">                     </span> </div>
                                                <ul class="dropdown-menu dudt_dropdown-caret">
                                                    <li class="pop_arrow_new"></li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('25', '7');
                                                        changeDueDate('25', '00/00/0000', 'No Due Date', '78777aeaae3c47b83b8c166c06dd733d')">No Due Date</a>
                                                    </li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('25', '7');
                                                        changeDueDate('25', '06/01/2016', 'Today', '78777aeaae3c47b83b8c166c06dd733d')">Today</a>
                                                    </li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('25', '7');
                                                        changeDueDate('25', '06/02/2016', 'Tomorrow', '78777aeaae3c47b83b8c166c06dd733d')">Tomorrow</a>
                                                    </li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('25', '7');
                                                        changeDueDate('25', '06/06/2016', 'Next Monday', '78777aeaae3c47b83b8c166c06dd733d')">Next Monday</a>
                                                    </li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('25', '7');
                                                        changeDueDate('25', '06/03/2016', 'This Friday', '78777aeaae3c47b83b8c166c06dd733d')">This Friday</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="cstm-dt-option" data-csatid="25">
                                                            <input value="" type="hidden" id="set_due_date_25" class="set_due_date hasDatepicker" title="Custom Date" style="">
                                                            <button type="button" class="ui-datepicker-trigger"><img src="http://task.nexgi.biz/img/images/calendar.png" alt="..." title="...">
                                                            </button> <span style="position:relative;top:2px;cursor:text;">Custom&nbsp;Date</span> </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" align="left" class="curr_day">
                                            <div class="">May 28</div>
                                        </td>
                                    </tr>
                                    <tr class="tr_all" id="curRow17">
                                        <td class="pr_high" valign="top">
                                            <input type="checkbox" id="actionChk3" checked="checked" value="17|5|closed" disabled="disabled" class="fl mglt chkOneTsk">
                                            <input type="hidden" id="actionCls3" value="3" disabled="disabled" size="2">
                                            <div class="dropdown fl">
                                                <div class="sett" data-toggle="dropdown"></div>
                                                <ul class="dropdown-menu sett_dropdown-caret">
                                                    <li class="pop_arrow_new"></li>
                                                    <li onclick="startCase('17', '5', 'f916cfe6a1ebdd9dbccaf50c0b911bb5');" id="start17" style=" display:none">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon act_start_task fl" title="Start"></div>Start</a>
                                                    </li>
                                                    <li onclick="caseResolve('17', '5', 'f916cfe6a1ebdd9dbccaf50c0b911bb5');" id="resolve17" style="  display:none ">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon act_resolve_task fl" title="Resolve"></div>Resolve</a>
                                                    </li>
                                                    <li id="act_reply3" data-task="f916cfe6a1ebdd9dbccaf50c0b911bb5">
                                                        <a href="javascript:void(0);" id="reopen17" style="display:block ">
                                                            <div class="act_icon act_reply_task fl" title="Re-open"></div>Re-open</a>
                                                        <a href="javascript:void(0);" id="reply17" style="display:none">
                                                            <div class="act_icon act_reply_task fl" title="Reply"></div>Reply</a>
                                                    </li>
                                                    <li onclick="moveTask('17', '5', '', '1');" id="moveTask17" style="  display:none ">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon task_move_mlst fl" title="Move Task To Milestone"></div>Move to Milestone</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li onclick="archiveCase('17', '5', '1', 't_f916cfe6a1ebdd9dbccaf50c0b911bb5');" id="arch17" style="display:none">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon act_arcv_task fl" title="Archive"></div>Archive</a>
                                                    </li>
                                                    <li onclick="deleteCase('17', '5', '1', 't_f916cfe6a1ebdd9dbccaf50c0b911bb5');" id="arch17" style="display:none">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon act_del_task fl" title="Delete"></div>Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="dropdown fl" style="width:32px;">
                                                <div id="showUpdStatus17" class="type_dev  " title="Development" data-toggle="dropdown"></div> <span id="typlod17" class="type_loader">                     <img src="http://task.nexgi.biz/img/images/del.gif" alt="Loading..." title="Loading...">                 </span> </div>
                                            <div id="csStsRep3" class="fl tsk_sts">
                                                <div class="label closed">Closed</div>
                                            </div>
                                        </td>
                                        <td valign="top" style="padding-right:20px;text-align:right">5</td>
                                        <td class="title_det_wd">
                                            <div class="fl title_wd">
                                                <div id="titlehtml3" data-task="f916cfe6a1ebdd9dbccaf50c0b911bb5" class="fl case-title closed_tsk">
                                                    <div class="case_title wrapword task_title_ipad overme " title="Manage Task Category and log model creation | Ankit  ">Manage Task Category and log model creation | Ankit</div>
                                                </div>
                                            </div>
                                            <div class="att_fl fr" style="display:none;" id="fileattch3"></div>
                                            <div class="cb rcb"></div>
                                            <div class="fnt999 fl">
                                                <div class="fl"> <span id="stsdisp17" class="cview_hide">updated</span> by <span></span> <span class="cview_hide">                         on                     </span> <span id="timedis3" class="cview_hide">                         May 28, Sat 3:40 pm.                     </span> <span id="timedis3" class="cview_show" title="May 28, Sat 3:40 pm">                         4 days ago.                     </span> </div>
                                                <div class="fl" style="">
                                                    <div id="repno3" class="fl bblecnt"></div> (2) </div>
                                            </div>
                                            <div class="cb"></div>
                                        </td>
                                        <td valign="top">
                                            <div class="dropdown fl"> <span id="showUpdAssign17" style="cursor:text;text-decoration:none;color:#666666;">Anup</span>
                                                <ul class="dropdown-menu asgn_dropdown-caret" id="showAsgnToMem17">
                                                    <li class="pop_arrow_new"></li>
                                                    <li class="text-centre"><img src="http://task.nexgi.biz/img/images/del.gif" id="assgnload17">
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="fnt12" valign="top">
                                            <div class="dropdown fl">
                                                <div class="fl"> <span id="showUpdDueDate17" title="Saturday, May 28, 2016">                         May 28, Sat                                              </span> <span id="datelod17" class="asgn_loader">                         <img src="http://task.nexgi.biz/img/images/del.gif" alt="Loading..." title="Loading...">                     </span> </div>
                                                <ul class="dropdown-menu dudt_dropdown-caret">
                                                    <li class="pop_arrow_new"></li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('17', '5');
                                                        changeDueDate('17', '00/00/0000', 'No Due Date', 'f916cfe6a1ebdd9dbccaf50c0b911bb5')">No Due Date</a>
                                                    </li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('17', '5');
                                                        changeDueDate('17', '06/01/2016', 'Today', 'f916cfe6a1ebdd9dbccaf50c0b911bb5')">Today</a>
                                                    </li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('17', '5');
                                                        changeDueDate('17', '06/02/2016', 'Tomorrow', 'f916cfe6a1ebdd9dbccaf50c0b911bb5')">Tomorrow</a>
                                                    </li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('17', '5');
                                                        changeDueDate('17', '06/06/2016', 'Next Monday', 'f916cfe6a1ebdd9dbccaf50c0b911bb5')">Next Monday</a>
                                                    </li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('17', '5');
                                                        changeDueDate('17', '06/03/2016', 'This Friday', 'f916cfe6a1ebdd9dbccaf50c0b911bb5')">This Friday</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="cstm-dt-option" data-csatid="17">
                                                            <input value="" type="hidden" id="set_due_date_17" class="set_due_date hasDatepicker" title="Custom Date" style="">
                                                            <button type="button" class="ui-datepicker-trigger"><img src="http://task.nexgi.biz/img/images/calendar.png" alt="..." title="...">
                                                            </button> <span style="position:relative;top:2px;cursor:text;">Custom&nbsp;Date</span> </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="tr_all" id="curRow1">
                                        <td class="pr_medium" valign="top">
                                            <input type="checkbox" id="actionChk4" checked="checked" value="1|1|closed" disabled="disabled" class="fl mglt chkOneTsk">
                                            <input type="hidden" id="actionCls4" value="3" disabled="disabled" size="2">
                                            <div class="dropdown fl">
                                                <div class="sett" data-toggle="dropdown"></div>
                                                <ul class="dropdown-menu sett_dropdown-caret">
                                                    <li class="pop_arrow_new"></li>
                                                    <li onclick="startCase('1', '1', '247f44d958751eabcc0395446e8365d2');" id="start1" style=" display:none">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon act_start_task fl" title="Start"></div>Start</a>
                                                    </li>
                                                    <li onclick="caseResolve('1', '1', '247f44d958751eabcc0395446e8365d2');" id="resolve1" style="  display:none ">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon act_resolve_task fl" title="Resolve"></div>Resolve</a>
                                                    </li>
                                                    <li id="act_reply4" data-task="247f44d958751eabcc0395446e8365d2">
                                                        <a href="javascript:void(0);" id="reopen1" style="display:block ">
                                                            <div class="act_icon act_reply_task fl" title="Re-open"></div>Re-open</a>
                                                        <a href="javascript:void(0);" id="reply1" style="display:none">
                                                            <div class="act_icon act_reply_task fl" title="Reply"></div>Reply</a>
                                                    </li>
                                                    <li onclick="moveTask('1', '1', '', '1');" id="moveTask1" style="  display:none ">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon task_move_mlst fl" title="Move Task To Milestone"></div>Move to Milestone</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li onclick="archiveCase('1', '1', '1', 't_247f44d958751eabcc0395446e8365d2');" id="arch1" style="display:none">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon act_arcv_task fl" title="Archive"></div>Archive</a>
                                                    </li>
                                                    <li onclick="deleteCase('1', '1', '1', 't_247f44d958751eabcc0395446e8365d2');" id="arch1" style="display:none">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon act_del_task fl" title="Delete"></div>Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="dropdown fl" style="width:32px;">
                                                <div id="showUpdStatus1" class="type_dev  " title="Development" data-toggle="dropdown"></div> <span id="typlod1" class="type_loader">                     <img src="http://task.nexgi.biz/img/images/del.gif" alt="Loading..." title="Loading...">                 </span> </div>
                                            <div id="csStsRep4" class="fl tsk_sts">
                                                <div class="label closed">Closed</div>
                                            </div>
                                        </td>
                                        <td valign="top" style="padding-right:20px;text-align:right">1</td>
                                        <td class="title_det_wd">
                                            <div class="fl title_wd">
                                                <div id="titlehtml4" data-task="247f44d958751eabcc0395446e8365d2" class="fl case-title closed_tsk">
                                                    <div class="case_title wrapword task_title_ipad  " title="Create Task Type category  ">Create Task Type category</div>
                                                </div>
                                            </div>
                                            <div class="att_fl fr" style="display:none;" id="fileattch4"></div>
                                            <div class="cb rcb"></div>
                                            <div class="fnt999 fl">
                                                <div class="fl"> <span id="stsdisp1" class="cview_hide">updated</span> by <span>me</span> <span class="cview_hide">                         on                     </span> <span id="timedis4" class="cview_hide">                         May 28, Sat 3:33 pm.                     </span> <span id="timedis4" class="cview_show" title="May 28, Sat 3:33 pm">                         4 days ago.                     </span> </div>
                                                <div class="fl" style="">
                                                    <div id="repno4" class="fl bblecnt"></div> (11) </div>
                                            </div>
                                            <div class="cb"></div>
                                        </td>
                                        <td valign="top">
                                            <div class="dropdown fl"> <span id="showUpdAssign1" style="cursor:text;text-decoration:none;color:#666666;"><span style="color:#E0814E">me</span></span>
                                                <ul class="dropdown-menu asgn_dropdown-caret" id="showAsgnToMem1">
                                                    <li class="pop_arrow_new"></li>
                                                    <li class="text-centre"><img src="http://task.nexgi.biz/img/images/del.gif" id="assgnload1">
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="fnt12" valign="top">
                                            <div class="dropdown fl">
                                                <div class="fl"> <span id="showUpdDueDate1" title="Wednesday, May 25, 2016">                         May 25, Wed                                              </span> <span id="datelod1" class="asgn_loader">                         <img src="http://task.nexgi.biz/img/images/del.gif" alt="Loading..." title="Loading...">                     </span> </div>
                                                <ul class="dropdown-menu dudt_dropdown-caret">
                                                    <li class="pop_arrow_new"></li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('1', '1');
                                                        changeDueDate('1', '00/00/0000', 'No Due Date', '247f44d958751eabcc0395446e8365d2')">No Due Date</a>
                                                    </li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('1', '1');
                                                        changeDueDate('1', '06/01/2016', 'Today', '247f44d958751eabcc0395446e8365d2')">Today</a>
                                                    </li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('1', '1');
                                                        changeDueDate('1', '06/02/2016', 'Tomorrow', '247f44d958751eabcc0395446e8365d2')">Tomorrow</a>
                                                    </li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('1', '1');
                                                        changeDueDate('1', '06/06/2016', 'Next Monday', '247f44d958751eabcc0395446e8365d2')">Next Monday</a>
                                                    </li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('1', '1');
                                                        changeDueDate('1', '06/03/2016', 'This Friday', '247f44d958751eabcc0395446e8365d2')">This Friday</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="cstm-dt-option" data-csatid="1">
                                                            <input value="" type="hidden" id="set_due_date_1" class="set_due_date hasDatepicker" title="Custom Date" style="">
                                                            <button type="button" class="ui-datepicker-trigger"><img src="http://task.nexgi.biz/img/images/calendar.png" alt="..." title="...">
                                                            </button> <span style="position:relative;top:2px;cursor:text;">Custom&nbsp;Date</span> </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="tr_all" id="curRow15">
                                        <td class="pr_high" valign="top">
                                            <input type="checkbox" id="actionChk5" checked="checked" value="15|4|closed" disabled="disabled" class="fl mglt chkOneTsk">
                                            <input type="hidden" id="actionCls5" value="3" disabled="disabled" size="2">
                                            <div class="dropdown fl">
                                                <div class="sett" data-toggle="dropdown"></div>
                                                <ul class="dropdown-menu sett_dropdown-caret">
                                                    <li class="pop_arrow_new"></li>
                                                    <li onclick="startCase('15', '4', '5cc9d908459f2a42414a920f296246f2');" id="start15" style=" display:none">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon act_start_task fl" title="Start"></div>Start</a>
                                                    </li>
                                                    <li onclick="caseResolve('15', '4', '5cc9d908459f2a42414a920f296246f2');" id="resolve15" style="  display:none ">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon act_resolve_task fl" title="Resolve"></div>Resolve</a>
                                                    </li>
                                                    <li id="act_reply5" data-task="5cc9d908459f2a42414a920f296246f2">
                                                        <a href="javascript:void(0);" id="reopen15" style="display:block ">
                                                            <div class="act_icon act_reply_task fl" title="Re-open"></div>Re-open</a>
                                                        <a href="javascript:void(0);" id="reply15" style="display:none">
                                                            <div class="act_icon act_reply_task fl" title="Reply"></div>Reply</a>
                                                    </li>
                                                    <li onclick="moveTask('15', '4', '', '1');" id="moveTask15" style="  display:none ">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon task_move_mlst fl" title="Move Task To Milestone"></div>Move to Milestone</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li onclick="archiveCase('15', '4', '1', 't_5cc9d908459f2a42414a920f296246f2');" id="arch15" style="display:none">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon act_arcv_task fl" title="Archive"></div>Archive</a>
                                                    </li>
                                                    <li onclick="deleteCase('15', '4', '1', 't_5cc9d908459f2a42414a920f296246f2');" id="arch15" style="display:none">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon act_del_task fl" title="Delete"></div>Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="dropdown fl" style="width:32px;">
                                                <div id="showUpdStatus15" class="type_dev  " title="Development" data-toggle="dropdown"></div> <span id="typlod15" class="type_loader">                     <img src="http://task.nexgi.biz/img/images/del.gif" alt="Loading..." title="Loading...">                 </span> </div>
                                            <div id="csStsRep5" class="fl tsk_sts">
                                                <div class="label closed">Closed</div>
                                            </div>
                                        </td>
                                        <td valign="top" style="padding-right:20px;text-align:right">4</td>
                                        <td class="title_det_wd">
                                            <div class="fl title_wd">
                                                <div id="titlehtml5" data-task="5cc9d908459f2a42414a920f296246f2" class="fl case-title closed_tsk">
                                                    <div class="case_title wrapword task_title_ipad  " title="Manage User Type authentication | deepak  ">Manage User Type authentication | deepak</div>
                                                </div>
                                            </div>
                                            <div class="att_fl fr" style="display:none;" id="fileattch5"></div>
                                            <div class="cb rcb"></div>
                                            <div class="fnt999 fl">
                                                <div class="fl"> <span id="stsdisp15" class="cview_hide">updated</span> by <span>me</span> <span class="cview_hide">                         on                     </span> <span id="timedis5" class="cview_hide">                         May 28, Sat 3:32 pm.                     </span> <span id="timedis5" class="cview_show" title="May 28, Sat 3:32 pm">                         4 days ago.                     </span> </div>
                                                <div class="fl" style="">
                                                    <div id="repno5" class="fl bblecnt"></div> (2) </div>
                                            </div>
                                            <div class="cb"></div>
                                        </td>
                                        <td valign="top">
                                            <div class="dropdown fl"> <span id="showUpdAssign15" style="cursor:text;text-decoration:none;color:#666666;"><span style="color:#E0814E">me</span></span>
                                                <ul class="dropdown-menu asgn_dropdown-caret" id="showAsgnToMem15">
                                                    <li class="pop_arrow_new"></li>
                                                    <li class="text-centre"><img src="http://task.nexgi.biz/img/images/del.gif" id="assgnload15">
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="fnt12" valign="top">
                                            <div class="dropdown fl">
                                                <div class="fl"> <span id="showUpdDueDate15" title="Saturday, May 28, 2016">                         May 28, Sat                                              </span> <span id="datelod15" class="asgn_loader">                         <img src="http://task.nexgi.biz/img/images/del.gif" alt="Loading..." title="Loading...">                     </span> </div>
                                                <ul class="dropdown-menu dudt_dropdown-caret">
                                                    <li class="pop_arrow_new"></li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('15', '4');
                                                        changeDueDate('15', '00/00/0000', 'No Due Date', '5cc9d908459f2a42414a920f296246f2')">No Due Date</a>
                                                    </li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('15', '4');
                                                        changeDueDate('15', '06/01/2016', 'Today', '5cc9d908459f2a42414a920f296246f2')">Today</a>
                                                    </li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('15', '4');
                                                        changeDueDate('15', '06/02/2016', 'Tomorrow', '5cc9d908459f2a42414a920f296246f2')">Tomorrow</a>
                                                    </li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('15', '4');
                                                        changeDueDate('15', '06/06/2016', 'Next Monday', '5cc9d908459f2a42414a920f296246f2')">Next Monday</a>
                                                    </li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('15', '4');
                                                        changeDueDate('15', '06/03/2016', 'This Friday', '5cc9d908459f2a42414a920f296246f2')">This Friday</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="cstm-dt-option" data-csatid="15">
                                                            <input value="" type="hidden" id="set_due_date_15" class="set_due_date hasDatepicker" title="Custom Date" style="">
                                                            <button type="button" class="ui-datepicker-trigger"><img src="http://task.nexgi.biz/img/images/calendar.png" alt="..." title="...">
                                                            </button> <span style="position:relative;top:2px;cursor:text;">Custom&nbsp;Date</span> </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5" align="left" class="curr_day">
                                            <div class="">May 26</div>
                                        </td>
                                    </tr>
                                    <tr class="tr_all" id="curRow11">
                                        <td class="pr_medium" valign="top">
                                            <input type="checkbox" id="actionChk6" checked="checked" value="11|3|closed" disabled="disabled" class="fl mglt chkOneTsk">
                                            <input type="hidden" id="actionCls6" value="3" disabled="disabled" size="2">
                                            <div class="dropdown fl">
                                                <div class="sett" data-toggle="dropdown"></div>
                                                <ul class="dropdown-menu sett_dropdown-caret">
                                                    <li class="pop_arrow_new"></li>
                                                    <li onclick="startCase('11', '3', 'bf02e2573f0b780fbbaab2c7ef0acc26');" id="start11" style=" display:none">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon act_start_task fl" title="Start"></div>Start</a>
                                                    </li>
                                                    <li onclick="caseResolve('11', '3', 'bf02e2573f0b780fbbaab2c7ef0acc26');" id="resolve11" style="  display:none ">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon act_resolve_task fl" title="Resolve"></div>Resolve</a>
                                                    </li>
                                                    <li id="act_reply6" data-task="bf02e2573f0b780fbbaab2c7ef0acc26">
                                                        <a href="javascript:void(0);" id="reopen11" style="display:block ">
                                                            <div class="act_icon act_reply_task fl" title="Re-open"></div>Re-open</a>
                                                        <a href="javascript:void(0);" id="reply11" style="display:none">
                                                            <div class="act_icon act_reply_task fl" title="Reply"></div>Reply</a>
                                                    </li>
                                                    <li onclick="moveTask('11', '3', '', '1');" id="moveTask11" style="  display:none ">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon task_move_mlst fl" title="Move Task To Milestone"></div>Move to Milestone</a>
                                                    </li>
                                                    <li class="divider"></li>
                                                    <li onclick="archiveCase('11', '3', '1', 't_bf02e2573f0b780fbbaab2c7ef0acc26');" id="arch11" style="display:none">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon act_arcv_task fl" title="Archive"></div>Archive</a>
                                                    </li>
                                                    <li onclick="deleteCase('11', '3', '1', 't_bf02e2573f0b780fbbaab2c7ef0acc26');" id="arch11" style="display:none">
                                                        <a href="javascript:void(0);">
                                                            <div class="act_icon act_del_task fl" title="Delete"></div>Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="dropdown fl" style="width:32px;">
                                                <div id="showUpdStatus11" class="type_dev  " title="Development" data-toggle="dropdown"></div> <span id="typlod11" class="type_loader">                     <img src="http://task.nexgi.biz/img/images/del.gif" alt="Loading..." title="Loading...">                 </span> </div>
                                            <div id="csStsRep6" class="fl tsk_sts">
                                                <div class="label closed">Closed</div>
                                            </div>
                                        </td>
                                        <td valign="top" style="padding-right:20px;text-align:right">3</td>
                                        <td class="title_det_wd">
                                            <div class="fl title_wd">
                                                <div id="titlehtml6" data-task="bf02e2573f0b780fbbaab2c7ef0acc26" class="fl case-title closed_tsk">
                                                    <div class="case_title wrapword task_title_ipad overme " title="Make same left menu in every page | Ankit  ">Make same left menu in every page | Ankit</div>
                                                </div>
                                            </div>
                                            <div class="att_fl fr" style="display:none;" id="fileattch6"></div>
                                            <div class="cb rcb"></div>
                                            <div class="fnt999 fl">
                                                <div class="fl"> <span id="stsdisp11" class="cview_hide">updated</span> by <span></span> <span class="cview_hide">                         on                     </span> <span id="timedis6" class="cview_hide">                         May 26, Thu 11:18 am.                     </span> <span id="timedis6" class="cview_show" title="May 26, Thu 11:18 am">                         6 days ago.                     </span> </div>
                                                <div class="fl" style="">
                                                    <div id="repno6" class="fl bblecnt"></div> (1) </div>
                                            </div>
                                            <div class="cb"></div>
                                        </td>
                                        <td valign="top">
                                            <div class="dropdown fl"> <span id="showUpdAssign11" style="cursor:text;text-decoration:none;color:#666666;">Anup</span>
                                                <ul class="dropdown-menu asgn_dropdown-caret" id="showAsgnToMem11">
                                                    <li class="pop_arrow_new"></li>
                                                    <li class="text-centre"><img src="http://task.nexgi.biz/img/images/del.gif" id="assgnload11">
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="fnt12" valign="top">
                                            <div class="dropdown fl">
                                                <div class="fl"> <span id="showUpdDueDate11" title="Thursday, May 26, 2016">                         May 26, Thu                                              </span> <span id="datelod11" class="asgn_loader">                         <img src="http://task.nexgi.biz/img/images/del.gif" alt="Loading..." title="Loading...">                     </span> </div>
                                                <ul class="dropdown-menu dudt_dropdown-caret">
                                                    <li class="pop_arrow_new"></li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('11', '3');
                                                        changeDueDate('11', '00/00/0000', 'No Due Date', 'bf02e2573f0b780fbbaab2c7ef0acc26')">No Due Date</a>
                                                    </li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('11', '3');
                                                        changeDueDate('11', '06/01/2016', 'Today', 'bf02e2573f0b780fbbaab2c7ef0acc26')">Today</a>
                                                    </li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('11', '3');
                                                        changeDueDate('11', '06/02/2016', 'Tomorrow', 'bf02e2573f0b780fbbaab2c7ef0acc26')">Tomorrow</a>
                                                    </li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('11', '3');
                                                        changeDueDate('11', '06/06/2016', 'Next Monday', 'bf02e2573f0b780fbbaab2c7ef0acc26')">Next Monday</a>
                                                    </li>
                                                    <li><a href="javascript:void(0);" onclick="changeCaseDuedate('11', '3');
                                                        changeDueDate('11', '06/03/2016', 'This Friday', 'bf02e2573f0b780fbbaab2c7ef0acc26')">This Friday</a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0);" class="cstm-dt-option" data-csatid="11">
                                                            <input value="" type="hidden" id="set_due_date_11" class="set_due_date hasDatepicker" title="Custom Date" style="">
                                                            <button type="button" class="ui-datepicker-trigger"><img src="http://task.nexgi.biz/img/images/calendar.png" alt="..." title="...">
                                                            </button> <span style="position:relative;top:2px;cursor:text;">Custom&nbsp;Date</span> </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <input type="hidden" name="hid_cs" id="hid_cs" value="6">
                            <input type="hidden" name="totid" id="totid" value="26|25|17|1|15|11|">
                            <input type="hidden" name="chkID" id="chkID" value="">
                            <input type="hidden" name="slctcaseid" id="slctcaseid" value="">
                            <input type="hidden" id="getcasecount" value="6" readonly="true">
                            <input type="hidden" id="openId" value="">
                            <input type="hidden" id="email_arr" value="[object HTMLInputElement]">
                            <input type="hidden" id="curr_sel_project_id" value="1 ">
                        </div>
                        <div id="task_paginate" style="display: block;">
                            <table cellpadding="0" cellspacing="0" border="0" align="right">
                                <tbody>
                                    <tr>
                                        <td align="center" style="padding-top:5px;">
                                            <div class="show_total_case" style="font-weight:normal;color:#000;font-size:12px;">1 - 6 of 6</div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="padding-top:5px">
                                            <ul class="pagination"> </ul>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--Task listing section ends here-->
                </td>
            </tr>
        </tbody>
    </table>
        </div>
    </div>