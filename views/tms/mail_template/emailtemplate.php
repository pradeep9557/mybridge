<link href="http://mybridge.local/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<script src="http://mybridge.local/js/jquery-1.11.0.js" type="text/javascript"></script>    
<link href="<?= base_url() ?>js/sweetalert/lib/sweet-alert.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/sweetalert/lib/sweet-alert.js" type="text/javascript"></script>
    <div style="font-family: verdana;margin: 0px;padding:0px;font-size: 13px;">
        <div id="page-wrapper" style="min-height: 0px;">

        <div style='background-color: rgb(95, 156, 201) !important;'>
            <div style="font-family: verdana;padding: 20px; border-radius: 0 0 2px 2px;">
                <?php
                 if(isset($heading)){
                ?>
                <span style="font-family: verdana;color: #fff;font-size: 24px;font-weight: 300;line-height: 48px;">
                   <?php echo $heading ?>
                </span>
                 <?php } ?>
                <p style='margin: 0;color: white;'><?php echo $msg;  ?></p>
                <form action="http://mybridge.local/tms/manage_tasks/upload_files" id="daily_task_form" enctype="multipart/form-data" method="post" accept-charset="utf-8">  
                    <div class="row bottom_gap">
                        <div class="col-lg-12 col-md-12 col-sm-12"> 
                            <div class="row">
                            <input type="hidden" name="tm_code" value="<?php echo $tm_id;  ?>">
                                <div class="col-lg-4 col-md-4 col-sm-8 attachmentdiv">
                                    <div class="form-group" id="attachment" style="width: 100%;float: left;">
                                        <div style="width:33%; float:left;">
                                            <input type="file" multiple="" name="attach_name[]">
                                        </div>
                                        <div style="width:33%; float:left;">
                                            <select name="fileType[]">
                                                <option value="">Select FileType</option>
                                                <option value="Input file">Input file</option>
                                                <option value="Working file">Working file</option>
                                                <option value="File  Report">Final Report</option>
                                            </select>
                                            
                                        </div>
                                        <div style="width:33%; float:left;">
                                            <input type="text" name="attach_desc[]">
                                            <i class="fa fa-plus addattachment" aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                                <br />
                                <br />
                                <button type="submit" class="btn btn-success btn-md action" id="action_sub">
                                    <span class="glyphicon glyphicon-oppy-disk"></span> Save Work Description
                                </button>
                                <?php echo "<br><br><br><br>\n\n\nThanks NexIBMS Team";?>
                            </div>
                        </div>
                    </div>
                </form> 
            </div>
        </div>
        <script>
        $(document).ready(function(){
            $('.addattachment').click(function(){
                console.log($('#attachment').length);
                var i=$('#attachment').length+1;
                var html='<div class="form-group" id="attachment" style="width: 100%;float: left;"><div style="width:33%; float:left;"><input type="file" multiple name="attach_name[]"/></div><div style="width:33%; float:left;"><select name="fileType[]"><option value="">Select FileType</option><option value="input file">Input file</option><option value="working file">Working file</option><option value="File  Report">File  Report</option></select></div><div style="width:33%; float:left;"><input type="text" name="attach_desc[]"></div></div>';
                $('.attachmentdiv').append(html);
            });
        });
        $(document).on("ready", function () {
            $("#daily_task_form").on("submit", function (e) {
                e.preventDefault();
                $.ajax({
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    url: $(this).attr("action"),
                    method: "POST",
                    success: function (result) {
                        console.log(result);
                        if (result.succ) {
                            swal({
                                title: "Done!",
                                text: result._err_codes,
                                type: "success",
                                timer: 1000
                            });  
                        } else {
                            sweetAlert("Oops...", result._err_codes, "error");
                        }
                    }
                });
            });
        });
        </script>
        <div style="font-family: verdana;overflow: hidden;height: 50px;line-height: 50px;color: rgba(255,255,255,0.8);background-color: rgba(238, 110, 115, 0.85);">
            <div style="font-family: verdana;width: 95%;margin: 0 auto;color:white">&copy;<?php echo date('Y')?> <?php echo SITE_NAME ?><br>
                You can manage notification via click here <a href="<?php echo base_url(isset($sender_email)?$sender_email:"") ?>">Unsubscribe</a>
            </div>
        </div>
        </div>
    </div>