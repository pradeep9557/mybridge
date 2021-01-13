<div class="row">
    <div class="col-lg-12">
        <?php 
        if(empty($task_history)){
            echo "<p class='well well-sm log_well'> No logs found for this task ...  </p>";
        }
        foreach ($task_history as $eachTask) {
            echo "<div class='well well-sm log_well'>LogID: #{$eachTask->t_log_id}<br> Log Desc: {$eachTask->remarks} <br>Time: ".date(DTF,  strtotime($eachTask->modified_datetime))." <br>By: ".ucfirst($eachTask->UserName)."</div>";
        }
        //$this->util_model->printr($task_history); ?>
    </div>
</div> 