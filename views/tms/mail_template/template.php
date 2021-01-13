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
                  
            </div>
        </div>
        <div style="font-family: verdana;overflow: hidden;height: 50px;line-height: 50px;color: rgba(255,255,255,0.8);background-color: rgba(238, 110, 115, 0.85);">
            <div style="font-family: verdana;width: 95%;margin: 0 auto;color:white">&copy;<?php echo date('Y')?> <?php echo SITE_NAME ?><br>
                You can manage notification via click here <a href="<?php echo base_url(isset($sender_email)?$sender_email:"") ?>">Unsubscribe</a>
            </div>
        </div>
        </div>
    </div>