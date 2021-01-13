<div class="col-lg-12 bottom_gap">
    <h5 class="page-header">Available timings</h5>
    <input type="hidden" name="element_type" value = "<?php echo $element_type ?>">
    <table class="table table-bordered time_mange" id="time_mange">
        <thead>
            <tr>
                <th>S.No.</th>
                <th style="width: 10%;">Room List</th>
                <th style="width: 50%;">Days List</th>
                <th>Str Time</th>
                <th>End Time</th>
                <th>Add/Remove</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($timings_details) && count($timings_details)) {
                          foreach ($timings_details as $each_row) {
                                        ?>
                                        <tr>
                                            <td>1.</td>
                                            <td class="rooms_col">
                                                <?php 
                                                echo form_dropdown("room_id[]", $room_list, $each_row['room_id'], "class='form-control chosen-select'"); ?>                                     
                                             </td>
                                            <td class="days_col">
                                                <?php
                                                echo form_multiselect("day[0][]", $days_list, explode(",", $each_row['days_list']), "class='form-control select_days chosen-select'");
                                                ?>
                                            </td>
                                           
                                            <td class="str_time_col">
                                                <div class="form-group">
                                                    <div class='input-group date str_time' id="Trang2">
                                                        <input type='text' class="form-control" name="str_time[]" value="<?= date("H:00", strtotime($each_row['str_time'])) ?>" id="end_batch_time"/>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time"></span>
                                                        </span>
                                                    </div
                                                </div>
                                                </div>
                                            </td>
                                            <td class="end_time_col">
                                                <div class="form-group">
                                                    <div class='input-group date end_time' id="Trang2">
                                                        <input type='text' class="form-control" name="end_time[]" value="<?= date("H:00", strtotime($each_row['end_time'])) ?>" id="end_batch_time"/>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-time"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            <td> 
                                                <button   type='button' class='btn btn-danger btn-sm' onclick="remove_row(this, 'time_mange', 1);">
                                                    <span class='glyphicon glyphicon-minus'></span>
                                                </button> 
                                            </td> 
                                        </tr>
                                        <?php
                          }
            } else {
                          ?>
                          <tr>
                              <td>1.</td>
                              <td class="rooms_col">
                                                <?php 
                                                echo form_dropdown("room_id[]", $room_list, 0, "class='form-control chosen-select'"); ?>                                     
                                             </td>
                              <td class="days_col">
                                  <?php
                                  echo form_multiselect("day[0][]", $days_list, $selected, "class='form-control select_days chosen-select'");
                                  ?>
                          </td>
                              <td class="str_time_col">
                                  <div class="form-group">
                                      <div class='input-group date str_time' id="Trang2">
                                          <input type='text' class="form-control" name="str_time[]" value="<?= date("H:00", strtotime("+1 hour")) ?>" id="end_batch_time"/>
                                          <span class="input-group-addon">
                                              <span class="glyphicon glyphicon-time"></span>
                                          </span>
                                      </div
                                  </div>
                                  </div>
                              </td>
                              <td class="end_time_col">
                                  <div class="form-group">
                                      <div class='input-group date end_time' id="Trang2">
                                          <input type='text' class="form-control" name="end_time[]" value="<?= date("H:00", strtotime("+1 hour")) ?>" id="end_batch_time"/>
                                          <span class="input-group-addon">
                                              <span class="glyphicon glyphicon-time"></span>
                                          </span>
                                      </div>
                                  </div>
                              <td> 
                                  <button   type='button' class='btn btn-danger btn-sm' onclick="remove_row(this, 'time_mange', 1);">
                                      <span class='glyphicon glyphicon-minus'></span>
                                  </button> 
                              </td> 
                          </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr><td colspan='5'>
                    <h5 class="text-danger">Please don't enter duplicate timings, otherwise entry will be canceled.</h5>
                <td>
                    <button   type='button' class='btn btn-info btn-sm' onclick="clone_row('time_mange', 1, 'total_row')">
                        <span class='glyphicon glyphicon-plus'></span>
                    </button>
                </td>
            </tr>   
        </tfoot>
    </table>

</div>
<script src="<?php echo base_url(); ?>js/custom_js/table_manipulation/mange_time_js.js" type="text/javascript"></script>