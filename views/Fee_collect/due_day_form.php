 
<div class="col-md-2 padding_top_label">
    Due Date
</div>
<div class="col-md-2">
              <?php
            echo form_dropdown('due_day', $due_days, $due_day, "class = 'form-control chosen-select' onchange='copy_due_day(this)'");
        ?>
</div>
<div class="col-lg-4">    
    
    <form> 
        <input type="hidden" name="due_day" value="<?php echo $due_day ?>" id="due_day"/>
        <input type="hidden" name="_key" value="due_day_update"/>
        <input type="hidden" name="_title" value="Due Day"/>
        <input  type="hidden" value="Do you want to update Due Date" name="_msg"/>
        <input type="hidden" value="<?= $Stu_ID ?>" name="Stu_ID"/>
        <input type="hidden" value="<?= $CourseID ?>" name="CourseID"/>
        <button type="button" value="Update"  class="btn btn-md btn-danger ajax_submit">
            <span class="glyphicon glyphicon-refresh"></span>  Update Due Date
        </button>
    </form>
</div>
<script>
              function copy_due_day(that){
                  $("#due_day").val(that.value);          
              }
</script>