<?php 
  if($index_no!=1){
?>
<div class="padding_left_0px col-lg-6 bottom_gap">
                            <div class="col-lg-4">
                                 <label>From</label>
                                <div class="form-group">
                                    <div class='input-group date' id="Trang1<?=$index_no?>">
                                        <input type='text' class="form-control" name="Str_Time[]" value="<?=date(DT)?>"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label>To</label>
                                <div class="form-group">
                                    <div class='input-group date' id="Trang2<?=$index_no?>">
                                        <input type='text' class="form-control" name="End_Time[]" value="<?=date(DT)?>"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <script type="text/javascript">
                                          $(function () {
                                              $('#Trang1<?=$index_no?>').datetimepicker({
                                                  format: 'hh:mm A',
                                                  icons: {
                                                      up: "fa fa-arrow-up",
                                                      down: "fa fa-arrow-down"
                                                  }
                                              });
                                              $('#Trang2<?=$index_no?>').datetimepicker({
                                                  format: 'hh:mm A',
                                                  icons: {
                                                      up: "fa fa-arrow-up",
                                                      down: "fa fa-arrow-down"
                                                  }
                                              });
                                              $("#Trang1<?=$index_no?>").on("dp.change", function (e) {
                                                  $('#Trang2<?=$index_no?>').data("DateTimePicker").minDate(e.date);
                                              });
                                              $("#Trang2<?=$index_no?>").on("dp.change", function (e) {
                                                  $('#Trang1<?=$index_no?>').data("DateTimePicker").maxDate(e.date);
                                              });
                                          });
                            </script>
                            
                            <div class="padding_left_0px col-lg-4 padding_top_label text-center" >
                                <label>More</label>
                                <div class="row">
                                <button class="btn btn-success add_prefer_time" onclick="add_tr_picker(this)" id="<?=$index_no?>" type="button" style="padding: 8px 12px;margin-top: -7px;">
                                    <span class="glyphicon glyphicon-plus"></span>           
                                </button>
                                <button class="btn btn-danger remove_prefer_time"  onclick="removetrp(this)" id="<?=$index_no?>" type="button" style="padding: 8px 12px;margin-top: -7px;">
                                    <span class="glyphicon glyphicon-minus"></span>           
                                </button>
                                </div>
                            </div>
                        </div>   
  <?php  }else{ ?>
<div class="padding_left_0px bottom_gap col-lg-12">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class='input-group date' id="Trang1">
                                        <input type='text' class="form-control" name="Str_Time[]"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="padding_left_0px col-lg-1 padding_top_label text-center">To</div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <div class='input-group date' id="Trang2">
                                        <input type='text' class="form-control" name="End_Time[]"/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <script type="text/javascript">
                                          $(function () {
                                              $('#Trang1').datetimepicker({
                                                  format: 'hh:mm A',
                                                  icons: {
                                                      up: "fa fa-arrow-up",
                                                      down: "fa fa-arrow-down"
                                                  }
                                              });
                                              $('#Trang2').datetimepicker({
                                                  format: 'hh:mm A',
                                                  icons: {
                                                      up: "fa fa-arrow-up",
                                                      down: "fa fa-arrow-down"
                                                  }
                                              });
                                              $("#Trang1").on("dp.change", function (e) {
                                                  $('#Trang2').data("DateTimePicker").minDate(e.date);
                                              });
                                              $("#Trang2").on("dp.change", function (e) {
                                                  $('#Trang1').data("DateTimePicker").maxDate(e.date);
                                              });
                                          });
                            </script>
                            <div class="padding_left_0px col-lg-3 padding_top_label text-center">
                                <button class="btn btn-success add_prefer_time" onclick="add_tr_picker(this)" type="button" id="1" style="padding: 8px 12px;margin-top: -7px;">
                                    <span class="glyphicon glyphicon-plus"></span>           
                                </button>
<!--                                <button class="btn btn-danger remove_prefer_time"  onclick="removetrp(this)"  onclick="removetrp(this)" id="1" type="button" style="padding: 8px 12px;margin-top: -7px;">
                                    <span class="glyphicon glyphicon-minus"></span>           
                                </button>-->
                            </div>
                        </div>   

  <?php  }  ?>

