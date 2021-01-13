<link href="<?php echo base_url(); ?>css/tms_module_css.css" rel="stylesheet" type="text/css"/>
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">All Replicate Tasks</h4>
        </div>
         <div class="col-lg-12">
           <?php
           echo $task_search_view;
// $this->util_model->printr($task_list);
         ?>
        </div>
        
        <!-- /.col-lg-12 -->
        
    </div>
    <!-- /.row -->
    <script>
       $(document).ready(function () {
        search_task_data();
    });
    </script>
</div>
 
