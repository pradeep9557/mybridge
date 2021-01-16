

<!-- 

<div class="row">

    <div class="col-lg-12">

        <h4 class="page-header">All Locality List</h4>

    </div>

</div>-->
<?php
$selected = isset($_GET['status'])?$_GET['status']:0;
?>
<link href="<?php echo base_url() ?>js/multi_select/chosen.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url() ?>js/multi_select/chosen.jquery.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>js/multi_select/prism.js" type="text/javascript"></script>
<!-- /.row -->
<style>
.container1 {
                                                    width: 100%;
                                                    height: 100%;
                                                    position: absolute;
                                                    visibility:hidden;
                                                    display:none;
                                                    /*background-color: rgba(22,22,22,0.5);*/
                                                }

                                                .container1:target {
                                                    visibility: visible;
                                                    display: block;
                                                }

                                                .reveal-modal select {
    max-width: 900px;
    margin-bottom: 23px;
} 

    .reveal-modal {
        background:#fff; 
        margin: 0 auto;
        width:1000px; 
        position:relative; 
        z-index:41;
        top: 25%;
        padding:30px; 
        -webkit-box-shadow:0 0 10px rgba(0,0,0,0.4);
        -moz-box-shadow:0 0 10px rgba(0,0,0,0.4); 
        box-shadow:0 0 10px rgba(0,0,0,0.4);
    }
</style>
<?php 
    //foreach ($locality_list as $List) {
        ?>
        <form name="form">
            <div id="container" class="container1">
                <div id="exampleModal" class="reveal-modal">
                    <h2>Change Task</h2>
                    <input type="hidden" id="attachid" name="attachid" value="">
                    <select id="clientlist" name="clientlist">
                        <?php 
                        foreach ($clientlist as $key1 => $value1) {
                            ?>
                            <option value="<?php echo $value1['tstm_id'];?>"><?php echo $value1['tstm_name'];?>(<?php echo $value1['tm_name'];?>)</option>
                            <?php
                        }
                        ?>
                    </select>
                    <button name="submit1" class="changeattach" value="">Submit</button>
                    <a href="#" class="close-reveal-modal" style="
                        position: absolute;
                        top: 6px;
                        right: 10px;">×</a>
                </div>
            </div>
        </form>
        <?php
   // }
?>
<div class="row">

    <div class="col-md-2"></div>

    <div class="col-lg-10">

        <div class="panel panel-primary">

            <div class="panel-heading" data-toggle="collapse" data-target="#allcountry">

                <h3 class="panel-title toggle_custom">My AttaCHMENT FILE
                    <span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right"></span>
                </h3>
            </div>
            
            <!-- /.panel-heading -->

            <div class="panel-body" id="allcountry">
                <div class="row bottom_gap">
                    <div class="col-lg-12">
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 col-sm-4 padding_top_label">
                            Send Mail
                        </div>
                        <div class="col-lg-4 col-md-4  col-sm-4 col-xs-4 col-sm-8">
                        <div class="form-group">
                            <input type="hidden" name="_action" value="notify_action">
                            <button class="btn btn-primary" id="notify_email" type='button'>
                                <span class="glyphicon glyphicon-floppy-save"></span>
                                Email
                            </button>
                        </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-6 col-sm-4 padding_top_label">
                            Select Status
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 col-sm-8">
                            <div class="form-group">
                                <?php
                                    echo form_dropdown("astatus", $astatus, $selected, "class='form-control chosen-select attach_status'");
                                ?>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="table-responsive">
                    <!-- <select class="form-control col-md-6">
                        <option value="1">Approved</option>
                        <option value="0">Unapproved</option>
                    </select> -->

                    <table class="table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">

                        <thead>

                            <tr>
                                <th>Select</th>
                                <th>S.No</th>

                                <th>username</th>

                                <th>Task Name</th>
                                <th>date</th>
                                <th>file name</th>

                                <!-- <th>State</th> -->
                                <th>year</th>
                                <th>Month</th>
                                <th>view File</th>
                                <th>Approve</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // print_r($locality_list); exit;
                            $i = 0;
                        if (is_array($locality_list))
                            {                               
                            foreach ($locality_list as $List) {
                                //  print_r (explode(" ",$List['date'])); exit;
                                // die($this->util_model->printr($List));
                                //  $date=explode(" ",$List['date']);
                                ?>
                            <tr class="odd gradeX">
                                <td><input type="checkbox" name="selectattach[]" value="<?php echo $List['id'];?>"></td>
                                <td><?= ++$i ?></td>
                                <td><?= $List['Emp_Name'] ?></td>
                                <td><?= $List['Task']['ttm_name'] ?></td>

                                <td><?= $List['date'] ?></td>
                                <!-- <td><?= $date[0] ?></td> -->
                                <td><a href="<?php echo base_url($List['link']); ?>"><?= $List['file'] ?></a>
                                <a class="updatekey" href="#container" data-reveal-id="exampleModal" key="<?php echo $List['id'] ?>"><span class='glyphicon glyphicon-pencil del_attachment  text-danger' key="<?php echo $List['id'] ?>" doc_link="<?php echo $List['link'] ?>"></span></a>
                                </td>
                                <td><?= $List['Task']['year'] ?></td>
                                <td><?= $List['Task']['month'] ?></td>
                                <td><button class="btn btn-info editfile" data-id="<?= $List['id'] ?>" data-tm="<?= $List['tm_id'] ?>">Edit</button></td>
                                <td><button class="btn btn-default approve" data-id="<?= $List['id'] ?>">
                                        <?php if ($List['status'] == 1) {
                                                echo 'Approved' ?>

                                        <?php } else {
                                                echo 'Unapproved' ?>
                                        <?php } ?>

                                    </button></td>
                            </tr>
                            <?php
                            }
                        }
                            ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="modal" tabindex="-1" role="dialog" id="myattach" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="input-group m-b">
                        <label>Attach New File</label>
                        <input type="file" class="form-control is_require" id="exampleInputFile" name="Upload_file" />
                    </div>
                </div>
                <div class="loading" style="display: none;">
                    <i class="fa fa-spinner fa-spin fa-3x fa-fw"></i>
                    <span class="sr-only">Loading...</span>
                </div>
            </div>


            <div class="row link">
                <div class="col-md-6">
                    <ul class="list-group linkItem">


                    </ul>
                </div>
            </div>
            <!--            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary upload">Save changes</button>
                        </div>-->
        </div>
    </div>
</div>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
$(document).ready(function() {
    $('#dataTables-example').dataTable();
    $('.attach_status').on('change',function(){
        var val1 = $(this).val();
        window.location='<?php echo base_url('tms/manage_tasks/view_file?status=');?>'+val1;
    });
    $('#notify_email').click(function(){
        var sattachment=$('input[name="selectattach[]"]:checked').serialize();
        $.ajax({
            type: "post",
            url: '<?php echo base_url('tms/manage_tasks/send_attachment_mails') ?>',
            data: sattachment,
            dataType: "json",
            success: function(data) {
                console.log(data);
                /*$('.link').show();
                $('.linkItem').html(" ");
                for (i in data) {
                    $('<li class="list-group-item active " style="margin-top:10px">' +
                        '<a href="' + data[i].link + '" style="color:#fff;">' + data[i].file_name +
                        '</a>' +
                        '<button type="button" class="close" data-id="4" >' +
                        '<span aria-hidden="true">&times;</span>' +
                        '</button></li>').appendTo('.linkItem');
                }*/
            }
        });
    });
});

$('.approve').on("click", function() {
    var id = $(this).data().id;
    $(this).html("ApproveD");
    $.ajax({
        type: "post",
        url: '<?php echo base_url('auth/approve') ?>',
        data: {"id": id,"status": 1},
        dataType: "json",
        success: function(data) {
            $('.link').show();
            $('.linkItem').html(" ");
            for (i in data) {
                $('<li class="list-group-item active " style="margin-top:10px">' +
                    '<a href="' + data[i].link + '" style="color:#fff;">' + data[i].file_name +'</a>' +
                    '<button type="button" class="close" data-id="4" >' +
                    '<span aria-hidden="true">&times;</span>' +
                    '</button></li>').appendTo('.linkItem');
            }
        }
    });
});

var id;
var tmid;
$('.editfile').on("click", function() {
    id = $(this).data().id;
    tmid = $(this).data().tm;
    $('#myattach').modal('show');
});
$('.updatekey').click(function(){
    $('#attachid').val($(this).attr('key'));
});
$('.changeattach').click(function(e){
    e.preventDefault();
    var id=$(this).val();
    var clientlist=$('#clientlist'+id).val();
    var attachid=$('#attachid'+id).val();
    console.log("clientid=" + clientlist + "&attachid=" + attachid);
    $.ajax({
        type: "POST",
        url: get_base_url() + "tms/daily_task/update_attachment_main",
        data: "clientid=" + clientlist + "&attachid=" + attachid,
        dataType: "json",
        success: function (result) {
            if (result['success']) {
                swal("Updated!", result['_err_msg'], "success");
            } else {
                swal("Cancelled", result['_err_msg'], "error");

            }
            $('.container1').hide();
        }
    });
});
$("#exampleInputFile").on("change", function() {
    show_loading();
    var file = document.getElementById("exampleInputFile").files[0];
    var formData = new FormData();
    formData.append('myFile', file);
    formData.append('id', id);
    formData.append('tmid', tmid);
    console.log(formData);
    $.ajax({
        type: "post",
        url: '<?php echo base_url('auth/update_file') ?>',
        data: formData,
        dataType: "json",
        async: false,
        processData: false,
        contentType: false,
        success: function(data) {
            if (data.status == 200) {
                $('.link').show();
                //                    $('<a href="' + data.link + '" class="list-group-item list-group-item-action active">View</a>').appendTo('.linkItem');
                $('<li class="list-group-item active " style="margin-top:10px">' +
                    '<a href="' + data.link + '" style="color:#fff;">' + data.upload_data.file_name + '</a>' +
                    '<button type="button" class="close" data-id="' + data.lid + '" >' +
                    '<span aria-hidden="true">&times;</span>' +
                    '</button></li>').appendTo('.linkItem');
                hide_loading();
            } else if (data.status == 500) {
                hide_loading();
                alert(data.error);
            }
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            hide_loading();
            alert("Status: " + textStatus);
            alert("Error: " + errorThrown);
            //  window.location.href="";
        }

    });

});

function show_loading() {
    $('.loading').show();
}

function hide_loading() {
    $('.loading').hide();
}

$('.close').on("click", function(d) {
    window.location.href = "";
});
</script>

<script src="<?= base_url() ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>