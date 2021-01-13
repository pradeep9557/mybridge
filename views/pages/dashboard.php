<?php
 $this->load->view('templates/chart_files');
?>
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header ">Dashboard</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
        
        <div class="col-lg-3 col-md-6">
        <?php for($i=0;$i<0;$i++):?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-calendar fa-4x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php //$this_month_admission ?>225</div>
                            <div>This month Admission!</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
            <?php endfor; ?>
            
            

        </div>
        <div class="col-lg-5">
                   <?php for($i=0;$i<4;$i++){?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-calendar fa-4x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php //$this_month_admission ?>INR 1,50,000</div>
                            <div>This month Fee collection</div>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
            <?php } ?>    
        </div>
        <div class='col-lg-4'>
          <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Today's Follow ups <?=count($todays_follow_up)?> (<?=$followed?>/<?=$unfollowed?>)
                </div>
                <div class="panel-body">
                    <div id="morris-donut-chart" style="height: 200px"></div>
                    <a href="<?=  base_url()?>Enquiry/followups/follow_up_list" class="btn btn-default btn-block">View Details</a>
                </div>
                <!-- /.panel-body -->
            </div>
            <?php
             // if $todays_follow up is zero then donut will not display !!
              if(count($todays_follow_up)){
            ?>
            <script>
                          Morris.Donut({
                              element: 'morris-donut-chart',
                              data: [
                                  <?php echo $follow_up_details?>
                              ],
                              backgroundColor: '#ccc',
                              labelColor: '#060',
                              colors: [
                                  '#0BA462',
                                  '#39B580',
                                  '#67C69D',
                                  '#95D7BB'
                              ],
                              formatter: function (x) {return x + "%";}

                          });
            </script>
              <?php } ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fa fa-bar-chart-o fa-fw"></i> Courses Wise Fee Collection
                </div>
                <div class="panel-body">
                    <div id="Course-wise-chart"></div>
                    <a href="#" class="btn btn-default btn-block">View Details</a>
                </div>
                <!-- /.panel-body -->
            </div>
            
            <script>
                          Morris.Donut({
                              element: 'Course-wise-chart',
                              data: [
                                  {value: 70, label: 'C++'},
                                  {value: 15, label: 'DAIT'},
                                  {value: 10, label: 'CS'},
                                  {value: 10, label: 'Computer Dimploma'},
                                  {value: 5, label: 'NTT'}
                              ],
                              backgroundColor: '#ccc',
                              labelColor: '#060',
                              colors: [
                                  '#0BA462',
                                  '#39B580',
                                  '#67C69D',
                                  '#95D7BB'
                              ],
                              formatter: function (x) {return x + "%";}

                          });
            </script>

        </div>

        <script>

        </script>
        
        
    </div>
</div>