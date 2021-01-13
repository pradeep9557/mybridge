<!-- for charts --> 
<link href="<?= base_url() ?>css/plugins/morris.css" rel="stylesheet">
<script src="<?= base_url() ?>js/plugins/morris/raphael.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/plugins/morris/morris.min.js" type="text/javascript"></script>
<div id="page-wrapper" style="min-height: 345px;padding:0px 0px 0px 10px">
    <div class="row">
        <div class="col-lg-12">
            &nbsp;
            <!--<h1 class="page-header ">Dashboard</h1>-->
        </div>

    </div>

    <div class="row">
        <div class="col-lg-6  col-md-6 col-sm-6">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-bell fa-fw"></i> 
                        System Status
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
                                    <span class="pull-right text-muted small"><?= $box['link_title'] ?></span>
                                    </span>
                                </div> 
                            <?php endforeach; ?>
                        </div>
                        <!-- /.list-group -->

                    </div>
                    <!-- /.panel-body -->
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">

            <?php
//        $this->util_model->printr($all_box);
            $i = 0;
            foreach ($all_box as $box):
                ?>
                <div class="col-lg-12 col-md-12 col-sm-12">
                     <!--<a href="<?= $box['link'] ?>">-->
                    <div class="panel <?php echo $box['extra_cls']; ?>">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="<?= $box['icon'] ?>"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <div class="huge"><?= $box['value'] ?></div>
                                    <div><?= $box['title'] ?></div>
                                </div>
                            </div> 
                        </div>

                        <div class="panel-footer">
                            <span class="pull-left"><a href="<?= $box['link'] ?>"><?= $box['link_title'] ?></a></span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>

                    </div>
                    <!--</a>-->
                </div>
                <?php
                $i++;
                if ($i % 3 == 0) {
                    echo "<div class='col-lg-12 col-md-12 col-sm-12'></div>";
                }
            endforeach;
            ?>
        </div>
        <div class='col-lg-4 col-md-6'>
<?php if ($dashboard_weigets['this_month_follow_donut']) { ?>  
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