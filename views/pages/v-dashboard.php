<!-- for charts --> 

<link href="<?= base_url() ?>css/plugins/morris.css" rel="stylesheet">

<script src="<?= base_url() ?>js/plugins/morris/raphael.min.js" type="text/javascript"></script>

<script src="<?= base_url() ?>js/plugins/morris/morris.min.js" type="text/javascript"></script>  

 

 

 

 

<script type="text/javascript">

    
    /*$(document).ready(function () { 
        $(".duration").change(function(){
               var durationVal = $('.duration').val();
               preloader.on();
                $.ajax({
                    url: "<?php echo base_url() . 'dashboard/view' ?>",
                    method: "POST",
                    data: {durationVal: durationVal},
                    dataType: "json",

                    success: function (result) {
                        alert(result);
                        if (result.succ) {
                            sweetAlert("Good Job!!", result._err_codes, "success",3000, false);
                            
                        } else {
                            sweetAlert("Oops...", result._err_codes, "error");
                        }
                        preloader.off();
                    }
                });
        }); 
    });*/
     
</script>
<div id="page-wrapper" style="min-height: 345px;padding:0px 0px 0px 10px">
    <div class="row">
        <div class="col-lg-12">
            &nbsp;
            <!--<h1 class="page-header ">Dashboard</h1>-->
        </div>

    </div>
    <?php
      if(isset($noti_boxes)){
    ?>
    <div class="row">
        <?php
        foreach($noti_boxes as $eachBox){ ?>
        <a href="<?php echo $eachBox['link'] ?>">
        <div class="col-lg-3  col-md-3 col-sm-3">
            <!--<div class="col-md-12">
                <div class="panel panel-primary">
                    
                    <div class="panel-heading">
                        <?php //echo "<i class='{$eachBox['icon']}'></i> {$eachBox['title']} ({$eachBox['value']})" ?>
                    </div>
                    
                </div>
            </div>-->
        </div></a>
        <?php } ?>
    </div>
      <?php } ?>
    <div class="row">
        <div class="col-lg-6  col-md-6 col-sm-6">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bell fa-fw"></i> 
                        Overall Summary 
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="list-group">
                            <?php
//        $this->util_model->printr($all_box);
                            $i = 0;
                            foreach ($all_box as $box):
                                $box['icon'] = str_replace("fa-4x", "", $box['icon']);
                                ?>
                                <div  class="list-group-item">
                                    <i class="<?= $box['icon'] ?>"></i> &nbsp;<span class="value_text"><?= $box['value'] ?></span> <?= $box['title'] ?>
                                    <span class="pull-right text-muted small a_text_decoration"><?= $box['link_title'] ?></span>
                                    </span>
                                </div> 
                            <?php endforeach; ?>
                            <div  class="list-group-item">
                                    <i class="fa fa-calendar "></i> &nbsp;<span class="value_text"></span> Send Daily Task Reminder
                                    <span id="senddailytaskreminder" class="pull-right text-muted small a_text_decoration">Send</span>
                                    </span>
                                </div> 
                                <div  class="list-group-item">
                                    <i class="fa fa-calendar "></i> &nbsp;<span class="value_text"></span> Ten Days Period Email
                                    <span id="tendaysperiodemail" class="pull-right text-muted small a_text_decoration">Send</span>
                                    </span>
                                </div> 
                                <div  class="list-group-item">
                                    <i class="fa fa-calendar "></i> &nbsp;<span class="value_text"></span> Daily Email for the overdue pending tasks
                                    <span id="overduetaskemail" class="pull-right text-muted small a_text_decoration">Send</span>
                                    </span>
                                </div> 
                        </div>
                        <!-- /.list-group -->

                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
            <?php
            if (isset($client_working_status) && !empty($client_working_status['clientTaskData'])) {
                ?>
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Client Wise Task Status

                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <td>S.No.</td>
                                        <td>Client Name</td>
                                        <td>Pending Sub task(Task)</td>
                                        <td>Total Required Time<br>/ Total Spent</td>
                                        <td>OverDue</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $s_no = 1;
                                    $total['subTask'] = 0;
                                    $total['given'] = 0;
                                    $total['spent'] = 0;
                                    $total['overDue'] = 0;
                                    $total['total_pending_task'] = 0;
                                    foreach ($client_working_status['clientTaskData'] as $row) {
                                        ?>
                                        <tr>
                                            <td><?php echo $s_no++; ?></td>
                                            <td><?php echo "<a href='".  base_url("my_sub_tasks?progress_flag=".IN_PROGRESS."&client_id={$row['client_id']}")."'>".$row['client_name']."</a>"; ?></td>
                                            <td><?php echo "{$row['total_pending_sub_task']}(<a title='list pending task' href=".  base_url("tms/manage_tasks/my_tasks?client_id={$row["client_id"]}&replica=0").">{$row['pending_task']})</a>"; ?></td>
                                            <td><?php echo round($row['time_given'])."/".round($row['time_spent']); ?></td>
                                            <td><?php 
                                             $overDue = round($row['time_given'])<round($row['time_spent'])?round($row['time_spent']-$row['time_given'],2):0;
                                             echo $overDue!=0 ? $overDue." Hrs":"No";
                                            ?></td>
                                        </tr>
                                    <?php  $total['subTask']+=$row['total_pending_sub_task'];
                                    $total['given']+=round($row['time_given'], 2);
                                    $total['spent']+=round($row['time_spent'], 2);
                                            $total['overDue'] +=$overDue;
                                         $total['total_pending_task']+= $row['pending_task'];   }
                                         
                                    echo "<tr><td colspan='2'>Total</td><td>{$total['subTask']}({$total['total_pending_task']})</td><td>".round($total['given']/PER_DAY_HOURS,0)."/".round($total['spent']/PER_DAY_HOURS,0)." Days</td><td>".round($total['overDue']/PER_DAY_HOURS,0)." Days</td></tr>"; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>
            
        </div> 
        <div class='col-lg-6 col-md-6'>
            <?php
            if (isset($task_monitering) && !empty($task_monitering['AllTaskASPErCat'])) {
                ?>
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Performance Chart

                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <table class="table table-bordered table-striped table-hover">
                                <thead>

                            <form action="" method="get">
                              <div class="form-row">
                                <div class="col-md-9">
                                  <input type="text" class="form-control date bdatetimepicker" name="duration" placeholder="Select Year"> 
                                </div>
                                <div class="col-md-3">
                                  <input type="submit" class="form-control btn btn-primary" name="submit" value="Search">  
                                </div>
                              </div>
                            </form><br> 
                                    <tr>
                                        <td>S.No.</td>
                                        <td>Entry By</td>
                                        <td>Total No of Hrs</td>
                                        <!-- <td>Completed</td>  -->
                                    </tr>
                                </thead>
                                  <tbody>
                                    <?php
                                    $i=1;
                                  foreach($performance_chart['AllPerformanceChart'] as $row){
                                    ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>

                                            <td><?php echo $row['entryBy'];?></td> 
                                            <td><?php echo $row['count_hours'].' Hrs';?></td> 
                                            <!-- <td><?php //echo $row['completed'].' %';?> </td> -->
                                        </tr>
                                    <?php $i++;} ?>    
                                     
                                          </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>


            <?php
            if (isset($task_monitering) && !empty($task_monitering['AllTaskASPErCat'])) {
                ?>
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Task Category 

                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <td>S.No.</td>
                                        <td>Task Category</td>
                                        <td>Main Task</td>
                                        <td>Sub-Tasks</td> 
                                    </tr>
                                </thead>
                                  <tbody>
                                    <?php
                                    $s_no = 1;
                                    $total['subTask'] = 0;
                                    $total['pendTask'] = 0; 
                                    foreach ($task_monitering['AllTaskASPErCat'] as $row) { if($row['pending_task']==0){}else { ?>
                                        <tr>
                                            <td><?php echo $s_no++; ?></td>

                                            <td><?php echo "<a href='".base_url("my_sub_tasks?progress_flag=".IN_PROGRESS."&ttm_name={$row['ttm_name']}")."'>".$row['ttm_name']."</a>"; ?></td>

                                            <td><a href="<?php echo base_url("tms/manage_tasks/my_tasks?ttm_id=".$row['ttm_id']);?>"><?php echo $row['pending_task'];?></a></td>

                                            <td><?php echo $row['pending_sub_task'];?></td>
                                        </tr>
                                        
                                    <?php }
                                         $total['pendTask']+=$row['pending_task'];
                                     $total['subTask']+=$row['pending_sub_task'];
                                       
                                    }
                                    echo "<tr><td colspan='2'>Total</td><td>{$total['pendTask']}</td><td>{$total['subTask']}</td></tr>";
                                  ?>
                                          </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>
            
            <?php
//            $this->util_model->printr($team_monitering);
            if (isset($team_monitering)) {
                ?>
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Team Monitoring

                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <td>S.No.</td>
                                        <td>Team Member</td>
                                        <td>Pending Sub task(Task)</td>
                                        <td>Total Required Time<br>/ Total Spent</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $s_no = 1;
                                    $total['subTask'] = 0;
                                    $total['pendTask'] = 0;
                                    $total['given'] = 0;
                                    $total['spent'] = 0;
                                    //print_r($team_monitering['team_data']);
                                    foreach ($team_monitering['team_data'] as $value) {
//                                        $this->util_model->printr($value);
                                        if ($value['assignedPer'] == "")
                                            continue;
                                        ?>
                                        <tr>
                                            <td><?php echo $s_no++; ?></td>
                                            <td><?php echo "<a href='" . base_url("my_sub_tasks?progress_flag=".IN_PROGRESS."&assignTo={$value['assignedTo']}") . "'>" . ucfirst($value['assignedPer']) . "</a>"; ?></td>
                                            <td><?php echo "<a href='" . base_url("my_sub_tasks?progress_flag=".IN_PROGRESS."&assignTo={$value['assignedTo']}") . "'>" . $value['pending_task']. "</a>";?>(<?php echo "<a href='" . base_url("tms/manage_tasks/my_tasks?replica=0&user_id={$value['assignedTo']}") . "'>" . $value['total_subTask']. "</a>"; ?>)</td>
                                            <td><?php echo round($value['time_given'], 2) ?>/ <?php echo round($value['time_spent'], 2) ?></td>


                                           <!--  <td><a href="<?php //echo base_url("tms/manage_tasks/my_tasks?ttm_id=".$value['ttm_id']);?>"><?php //echo $value['pending_task'];?></a></td>
 -->

                                        </tr>    
                                    <?php $total['subTask']+=$value['total_subTask'];
                                    $total['pendTask']+=$value['pending_task'];
                                    $total['given']+=round($value['time_given'], 2);
                                    $total['spent']+=round($value['time_spent'], 2);
                                            }
                                    echo "<tr><td colspan='2'>Total</td><td>{$total['pendTask']}({$total['subTask']})</td><td>".round($total['given']/PER_DAY_HOURS,0)."/".round($total['spent']/PER_DAY_HOURS,0)." Days</td></tr>";
                                    ?>
                                        
                                </tbody>
                            </table> 
                        </div>
                    </div>
                </div>
            <?php } ?>
                 <?php
            if (isset($task_monitering) && !empty($task_monitering['TaskData'])) {
                ?>
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Task Category Wise

                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <td>S.No.</td>
                                        <td>Task Category</td>
                                        <td>Pending Sub task(Task)</td>
                                        <td>Total Required Time<br>/ Total Spent</td>
                                        <td>Overdue Tasks/Overspent</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $s_no = 1;
                                     $total['subTask'] = 0;
                                    $total['given'] = 0;
                                    $total['spent'] = 0;
                                    $total['overDue'] = 0;
                                    $sumOverDueTask =0;
                                    $sumOverSpentTask =0;
                                    $total['total_pending_task'] = 0;
                                    foreach ($task_monitering['TaskData'] as $row) {
                                        ?>
                                        <tr>
                                            <td><?php echo $s_no++; ?></td>
                                            <td><?php echo "<a href='".  base_url("my_sub_tasks?progress_flag=".IN_PROGRESS."&ttm_id={$row['ttm_id']}")."'>".$row['cat_name']."</a>"; ?></td>
                                            <td><?php echo "{$row['total_pending_sub_task']}(<a title='list pending task' href=".  base_url("tms/manage_tasks/my_tasks?ttm_id={$row["ttm_id"]}&replica=0").">{$row['pending_task']})</a>"; ?></td>
                                            <td><?php echo round($row['time_given'])."/".round($row['time_spent']); ?></td>
                                            <td><?php 
                                                $overDueTask = $row['total_pending_sub_task'] - $row['pending_task'];
                                                $sumOverDueTask+=$overDueTask;
                                                $overSpentTask = round($row['time_spent'])-round($row['time_given']); 
                                                echo "(".($overDueTask).")/"; 
                                               if($row['time_spent'] ==0){
                                                echo 0;
                                               }else if($row['time_given']>=$row['time_spent']){ 
                                                echo 0;
                                               }else{
                                                 $sumOverSpentTask+=$overSpentTask;
                                                echo "(".($overSpentTask).")";
                                               }
                                                
                                             //$overDue = round($row['time_given'])<round($row['time_spent'])?round($row['time_spent']-$row['time_given'],2):0;
                                            // echo $overDue!=0 ? $overDue." Hrs":"No";
                                            ?></td>
                                        </tr>
                                    <?php  $total['subTask']+=$row['total_pending_sub_task'];
                                    $total['given']+=round($row['time_given'], 2);
                                    $total['spent']+=round($row['time_spent'], 2);
                                    $total['overDue'] +=$overDue;
                                    $total['total_pending_task']+= $row['pending_task'];
                                            }
                                    echo "<tr>
				    <td colspan='2'>Total</td>
				    <td>{$total['subTask']}({$total['total_pending_task']})</td>
				    <td>".round($total['given']/PER_DAY_HOURS,0)."/".round($total['spent']/PER_DAY_HOURS,0)." Days</td>
                                            <td> ".$sumOverDueTask."/".$sumOverSpentTask." </td>
				    </tr>"; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } ?>
                
                <?php if (isset($last_7_day_working_hours)): ?>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Last seven days working hours
                            <div class="pull-right">
                                <div class="btn-group">
                                    <a href="<?php echo $last_7_day_working_hours['link'] ?>">
                                        <button type="button" class="btn btn-default btn-xs">
                                            View More 
                                        </button> 
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="last_7_day_working_hours"></div>
                            <script>
                                $(function () {

                                    Morris.Line({
                                        element: 'last_7_day_working_hours',
                                        data: <?php echo json_encode($last_7_day_working_hours['json_data']); ?>,
                                        xkey: 'work_datetime',
                                        ykeys: ['efforts', 'total_working_hours'],
                                        labels: ['WorkTime in hours', 'Total Working Hours'],
                                        lineColors: ['#ff9800', '#673ab7'],
                                        pointSize: 5,
                                        hideHover: 'auto',
                                        resize: true,
                                        fillOpacity: .5,
                                        goals: [0, 300]
                                    });
                                });
                            </script>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
                <?php
            endif;
            if (isset($last_7_days_entry_log)):
                ?>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Last seven days Working Summery
                            <div class="pull-right">
                                <div class="btn-group">
                                    <a href="<?php echo $last_7_day_working_hours['link'] ?>">
                                        <button type="button" class="btn btn-default btn-xs">
                                            View More 
                                        </button> 
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div id="last_7_days_entry_log"></div>
                            <script>
                                $(function () {

                                    Morris.Line({
                                        element: 'last_7_days_entry_log',
                                        data: <?php echo json_encode($last_7_days_entry_log['json_data']); ?>,
                                        xkey: 'work_datetime',
                                        ykeys: ['total_users', 'wrkDonePunched', 'total_entry'],
                                        labels: ['EntryDone', 'TotalUsers', 'Total Entry'],
                                        lineColors: ['#ff9800', '#673ab7', '#009688'],
                                        pointSize: 5,
                                        hideHover: 'auto',
                                        resize: true,
                                        fillOpacity: .5,
                                        goals: [0, 50]
                                    });
                                });
                            </script>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
                <?php
            endif;
            if ($dashboard_weigets['this_month_follow_donut']) {
                ?>  
                <div class="col-md-12">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <i class="fa fa-bar-chart-o fa-fw"></i> Today's Follow ups <?= count($todays_follow_up) ?> (<?= $followed ?>/<?= $unfollowed ?>)
                        </div>

                        <div class="panel-body">


                            <?php
                            // if $todays_follow up is zero then donut will not display !!

                            if (isset($todays_follow_up)) {
                                ?>
                                <div id="morris-donut-chart" style="height: 200px"></div>
                                <script>
                                    Morris.Donut({
                                        element: 'morris-donut-chart',
                                        data: [
        <?php echo $follow_up_details ?>
                                        ],
                                        backgroundColor: '#ccc',
                                        labelColor: '#060',
                                        colors: [
                                            '#0BA462',
                                            '#39B580',
                                            '#67C69D',
                                            '#95D7BB'
                                        ],
                                        formatter: function (x) {
                                            return x + "%";
                                        }

                                    });
                                </script>
                            <?php } ?>

                            <a href="<?= base_url() ?>Enquiry/followups/follow_up_list" class="btn btn-default btn-block">View Details</a>

                        </div>
                        <!-- /.panel-body -->
                    </div>
                </div>
            <?php } ?>
            <?php
            if ($dashboard_weigets['this_month_follow_tabular']) {
                ?> 
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <i class="fa fa-bar-chart-o fa-fw"></i> Today's Follow ups <?= count($todays_follow_up) ?> (<?= $followed ?>/<?= $unfollowed ?>)
                    </div>

                    <div class="panel-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Follow</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sno = 1;
                                if (!empty($todays_follow_up)) {
                                    foreach ($todays_follow_up as $each_row) {
                                        
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $sno++; ?></td>
                                        <td><?php echo $each_row->StudentName ?></td>
                                        <td><?php echo $each_row->Mobile1 ?></td>
                                        <td><a href="<?php echo base_url() ?>Enquiry/followups/index/<?php echo $each_row->E_Code ?>" title="Follow Up" target="_blank">
                                                <button type="button" name="Follow_up" value="Follow Up" class="btn btn-info btn-xs">
                                                    <span class="glyphicon glyphicon-thumbs-up"></span>
                                                </button>
                                            </a></td>
                                    </tr>
                                <?php } else { ?>
                                    <tr>
                                        <td colspan="4">No Enquiry to Follow up</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.panel-body -->
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="col-lg-12">
                <?php
                if ($dashboard_weigets['this_month_fee_pending']) {
                    ?>
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <i class="fa fa-calendar fa-fw"></i> Total Pending Installments <?= count($pending_fees) ?>
                        </div>


                        <div class="panel-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Student Name</th>
                                        <th>Enroll No</th>
                                        <th>Mobile</th>
                                        <th>Due Date</th>
                                        <th>Due Amount</th>
                                        <th>Net Payable</th>
                                        <th>Paid</th>
                                        <th>Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sno = 1;
                                    if (count($pending_fees)) {
                                        foreach ($pending_fees as $each_row) {
                                            ?>
                                            <tr>
                                                <td><?php echo $sno++; ?></td>
                                                <td><?php echo $each_row['StudentName'] ?></td>
                                                <td><?php echo $each_row['EnrollNo'] ?></td>
                                                <td><?php echo $each_row['Mobile1'] ?></td>
                                                <td><?php echo $each_row['due_date'] ?></td>
                                                <td><?php echo $each_row['DueInstAmt'] ?></td>
                                                <td><?php echo $each_row['NetPayableAmt'] ?></td>
                                                <td><?php echo $each_row['PaidAmt'] ?></td>
                                                <td><?php echo $each_row['BalanceAmt'] ?></td>

                                            </tr>
                                            <?php
                                        }
                                        ?>

                                    <?php } else { ?>
                                        <tr>
                                            <td colspan="4">No any pending installment</td> 
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>


</div>

<script src="<?= base_url() ?>js/model/bootstrap-modalmanager.js" type="text/javascript"></script>

<script src="<?= base_url() ?>js/model/bootstrap-modal.js" type="text/javascript"></script>

<link href="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>

<script src="<?= CDN1 ?>css/bdt/moment.js" type="text/javascript"></script>

<script src="<?= CDN1 ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script> 
<script>
     
    $('.date').datetimepicker({ 
            format: 'YYYY', 
            icons: { 
                time: "fa fa-clock-o", 
                date: "fa fa-calendar", 
                up: "fa fa-arrow-up", 
                down: "fa fa-arrow-down" 
            } 
        });
        $(document).ready(function(){
            $('#senddailytaskreminder').click(function(){
                console.log('clicked');
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() ?>dashboard/sendDailyTaskMail",
                    data: {},
                    dataType: "json",
                    success: function(result) {
                        if (result['success']) {
                            swal("Successfully Done!", "Mail Sent Successfully", "success");
                        } else {
                            var _err_msg = result['_err_msg'];
                            if (_err_msg != "")
                                swal("Cancelled", _err_msg, "error");
                            else
                                swal("Cancelled", "Sorry Error Occurred !! :)", "error");
                        }
                    }
                });
            });
            $('#tendaysperiodemail').click(function(){
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() ?>dashboard/tendaysperiodemail",
                    data: {},
                    dataType: "json",
                    success: function(result) {
                        if (result['success']) {
                            swal("Successfully Done!", "Mail Sent Successfully", "success");
                        } else {
                            var _err_msg = result['_err_msg'];
                            if (_err_msg != "")
                                swal("Cancelled", _err_msg, "error");
                            else
                                swal("Cancelled", "Sorry Error Occurred !! :)", "error");
                        }
                    }
                });
            });
            $('#overduetaskemail').click(function(){
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url() ?>dashboard/overduetaskemail",
                    data: {},
                    dataType: "json",
                    success: function(result) {
                        if (result['success']) {
                            swal("Successfully Done!", "Mail Sent Successfully", "success");
                        } else {
                            var _err_msg = result['_err_msg'];
                            if (_err_msg != "")
                                swal("Cancelled", _err_msg, "error");
                            else
                                swal("Cancelled", "Sorry Error Occurred !! :)", "error");
                        }
                    }
                });
            });
        });
</script>
 