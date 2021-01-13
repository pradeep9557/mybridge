<!-- <!doctype html>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
    <script src="<?php //echo base_url()?>js/site.js"></script>
    <script src="<?php //echo base_url()?>js/ajaxfileupload.js"></script> 
     
</head>
<body>
    <h1>Upload File</h1>
    <form method="post" action="" id="upload_file"> 
        <label for="userfile">File</label>
        <input type="file" name="userfile" id="userfile" size="20" />
 
        <input type="submit" name="submit" id="submit" />
    </form>
    <h2>Files</h2>
    <div id="files"></div>
</body>
</html> -->

<!-- <!DOCTYPE html>
<html>
<head>
    <title>Image Upload</title>
</head>
<body>
    <h1><a href="<?= base_url() ?>">Form</a></h1>
    <?php if(!empty(validation_errors())): ?>
        <p><?= validation_errors() ?></p>
    <?php endif; ?>
    <form action="http://mybridgedevelopment.kachhal.in/index.php/tms/loginimg_library/upload_image" method="post" accept-charset="utf-8" enctype="multipart/form-data">
    <label>Name: </label><input type="text" name="name" value="<?= set_value('name') ?>"></label>
    <label>E-mail: </label><input type="email" name="email" value="<?= set_value('email') ?>"></label>
    <input type="file" name="my_image">
    <button type="submit">Submit</button>
   </form>
</body>
</html> -->

<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header ">Image Library</h4>

            
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
            <h3 class="panel-title toggle_custom"><?php  //echo $type?> Image Library<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
         
        <div class="panel-body collapse" id="collapseExample">   
              
            <form action="http://mybridgedevelopment.kachhal.in/tms/loginimg_library/upload" method="post" id="form_img" enctype="multipart/form-data" class="form-inline" accept-charset="utf-8">
         
        <div class="form-group mb-2">
           <input type="file" name="image" class="form-control-plaintext">
            <span class="error image" style="color:red;"></span>
        </div>
        <input type="submit" name="submit" value="submit" class="btn btn-primary mb-2">
        <p class="msg success" style="color:red;"></p>
        </form>
            
        </div>

    </div>
 
   
</div>

 

 <script type="text/javascript">
    $(document).ready(function() {
        $("#form_img").submit(function(e){
            e.preventDefault();
            var formData = new FormData($("#form_img")[0]);

            $.ajax({
                url : $("#form_img").attr('action'),
                dataType : 'json',
                type : 'POST',
                data : formData,
                contentType : false,
                processData : false,
                success: function(resp) {
                    console.log(resp);
                    $('.error').html('');
                    $('.msg').html('');
                    if(resp.status == false) {
                      $.each(resp.message,function(i,m){
                          $('.'+i).text(m);
                      });
                     }else if(resp.status == true) {
                      $.each(resp.message,function(i,m){
                          $('.'+i).text(m);
                      });
                         
                     }
                }
            });
        });
    });

</script>
 

