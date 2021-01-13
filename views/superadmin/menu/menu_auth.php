<link href="<?= base_url() ?>css/model/bootstrap-modal.css" rel="stylesheet" type="text/css"/>
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Menu Authentication

            </h4>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <?php
    //   $this->util_model->printr($usertype_list);
    ?>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading"  data-toggle="collapse" data-target="#allemployee">
                    <h3 class="panel-title toggle_custom">Select UserType To Edit<span class="glyphicon  glyphicon-chevron-up pull-right" ></span></h3>
                </div>
                <!-- .panel-heading -->
                <div class="panel-body" id="allemployee">
                    <?php
                    foreach ($all_branches as $BranchID => $BranchCode) {
                        ?>
                        <div class="col-lg-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading"  data-toggle="collapse" data-target="#allemployee<?= $BranchCode ?>">
                                    <h3 class="panel-title toggle_custom">UserType Of Branch <?= $BranchCode ?><span class="glyphicon  glyphicon-chevron-up pull-right" ></span></h3>
                                </div>
                                <!-- .panel-heading -->
                                <div class="panel-body" id="allemployee<?= $BranchCode ?>">
                                    <?php foreach ($usertype_list as $UTID => $UsertypeName) { ?>
                                        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6"> 
                                            <button type="button" class="btn btn-primary btn-sm ajax" UTID="<?= $UTID ?>" BranchID="<?= $BranchID ?>" data-toggle="modal" data-target="#myModal">
                                                <span class="glyphicon glyphicon-edit"></span>  <?= $UsertypeName ?>
                                            </button></div>   
                                    <?php } ?>
                                </div> 
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>

            </div>
        </div>
    </div>

    <!-- Button trigger modal -->

    <!-- Modal -->
    <div class="form-feed modal fade" id="ajax-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">All Module List</h4>
                </div>
                <div class="modal-body" id="body_cls">
                    <div class="col-lg-12">
                        <form id="MenuAccessForm" method="post" action="<?= base_url() . "sp-admin/m/UpdateMenuAccess/" ?>">

                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="SaveChanges();">Save changes</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>js/model/bootstrap-modalmanager.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/model/bootstrap-modal.js" type="text/javascript"></script>
<script>
    var $modal = $('#ajax-modal');

    $('.ajax').on('click', function () {
        // create the backdrop and wait for next modal to be triggered
//        $('body').modalmanager('loading');
        var UTID = $(this).attr('utid');
        preloader.on();
        var BranchID = $(this).attr('branchid');


        setTimeout(function () {

            $.ajax({
                url: "<?= base_url() . "sp-admin/m/displayMenuForAuth/" ?>" + BranchID + "/" + UTID,
                dataType: 'html',
                data: '',
                type: 'POST',
                success: function (data, textStatus, jqXHR) {
                    $("#body_cls").children('div').children('form').html(data);
                },
                error: function (jqXHR, textStatus, errorThrown) {

                },
                complete: function (jqXHR, textStatus) {

                }

            });

            $modal.modal();
            preloader.off();

        }, 1500);
    });


    function SaveChanges()
    {
        var postData = $("#MenuAccessForm").serializeArray();
            var formURL = $("#MenuAccessForm").attr("action");
            $.ajax(
                    {
                            url: formURL,
                            type: "POST",
                            data: postData,
                            success: function (data, textStatus, jqXHR)
                            {
                        swal({
                            title: "Nice Job !!",
                            type: "success",
                            text: data,
                            timer: 52000
                        });
                            },
                            error: function (data, textStatus, errorThrown)
                            {
                                    swal({
                            title: "Error Occured",
                            type: "error",
                            text: data,
                            timer: 52000
                        });
                            }
                    });
    }

//$modal.on('click', '.update', function(){
//  $modal.modal('loading');
//  setTimeout(function(){
//    $modal
//      .modal('loading')
//      .find('.modal-body')
//        .prepend('<div class="alert alert-info fade in">' +
//          'Updated!<button type="button" class="close" data-dismiss="alert">&times;</button>' +
//        '</div>');
//  }, 1000);
//});


    function checkMyChild(that) {
        //alert("click");

console.log($(that).parent("div").parent("li").children("ol.dd-list").find("input.checkbox"));
        if ($(that).is(':checked'))
        {
            console.log("checked");
           // console.log($(that).parent("li").children().find(".checkbox_inp"));
            $.each($(that).parent("div").parent("div").parent("li").children("ol.dd-list").find("input.checkbox"), function (index, item) {
                $(item).prop('checked', true);


                //console.log(item);
            });

            ///.children(":checkbox").attr('checked', true);
        }
        else
        {
            console.log("un checked");
            $.each($(that).parent("div").parent("div").parent("li").children("ol.dd-list").find("input.checkbox"), function (index, item) {
                $(item).removeAttr("checked");
                //$(item).attr("checked",false);
                //console.log(item);
            });
        }




    }
</script>
