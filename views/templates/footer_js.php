<!--<script src="<?= base_url() ?>js/custom_js/ajax/check_aready_exits.js" type="text/javascript"></script>-->
<script src="<?= base_url() ?>js/bootstrap.min.js" type="text/javascript"></script>




<!-- Metis Menu Plugin JavaScript --> 

<script src="<?= base_url() ?>js/plugins/metisMenu/metisMenu.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/sb-admin-2.js" type="text/javascript"></script>
<!--<script src="<?= base_url() ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script src="<?= base_url() ?>js/plugins/dataTables/dataTables.responsive.min.js" type="text/javascript"></script>-->
<!--<script src="<?= base_url() ?>js/smooth_scroll/agency.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/smooth_scroll/jquery.easing.min.js" type="text/javascript"></script>-->

<script>
    
    // $(".taginput").tagsInput();
    $(".succ_msg .btn").click(function () {
        var _this = $(this);
        $(this).animate({"opacity": "0"}, 1000, function () {
            $(this).css({"display": "none"});
        });
    });
    /** Uses
     * 1. Every Drop-Down Input Button after clicking to Plus Button
     **/
    function show_this(id) {
        $("#" + id).removeClass('hidden');
    }
    // not using yet !!
    function hide_this(id) {
        $("#" + id).addClass('hidden');
    }
    // To disable enter key to submit form !!
//    $('form').bind("keypress", function(e) {
//        if (e.keyCode === 13) {
//            e.preventDefault();
//            return false;
//        }
//    });
    $("#Go_to_top").click(function () {
        $("body").animate({scrollTop: 0}, 500);
    });
    $(".del_confirm").click(function () {
        var perform = confirm("Are You Sure Want to Delete ??");
        if (perform)
            return true;
        else
            return false;
    });


    var form_data;
    $(function () {
        $(".logout_confirm").click(function () {
            swal({
                title: "Are you sure?",
                text: "Are You Sure Want to Logout",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, Log me Out!',
                cancelButtonText: "No, Cancel Please!",
                closeOnConfirm: false,
                closeOnCancel: false
            }, function (isConfirm) {
                if (isConfirm) {
                    swal({
                        title: "Thanks!",
                        type: "success",
                        text: "Wait !!",
                        imageUrl: '<?= base_url() . PRELOADER128 ?>',
                        timer: 100});
                    window.location = '<?= base_url() ?>auth/Logout'
                } else {
                    swal({
                        title: "Thanks !!",
                        type: "success",
                        text: "Happy surfing !!",
                        timer: 10});
                }
            });
        });

        rebind();
    });

    function rebind()
    {
        $(".ajax_submit").click(function () {
            var action = $(this).val();//Delete
            form_data = $(this).parent();
            var _msg = form_data.find('input[name="_msg"]').val();
            var title = form_data.find('input[name="_title"]').val();
            //var del_id = element.attr("id");
            //var info = 'faqid=' + del_id;
            swal({
                title: "Are you sure?",
                text: _msg,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, ' + action + ' it!',
                cancelButtonText: "No, cancel Please!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function (isConfirm) {
                if (isConfirm) {
                    preloader.on();
                    $.ajax({
                        type: "POST",
                        url: "<?php echo base_url() ?>Ajax/delete",
                        data: form_data.serialize(),
                        dataType: "json",
                        success: function (result) {
                            console.log(result);
                            preloader.off();
                            if (result['success']) {
                                swal("Deleted!", "Your " + title + " has been deleted!", "success");
                                form_data.parents().parents('tr').animate({backgroundColor: "#fbc7c7"}, "slow", function () {
                                    $(this).remove();
                                });

                            } else {
                                var _err_msg = result['_err_msg'];
                                if (_err_msg != "")
                                    swal("Cancelled", _err_msg, "error");
                                else
                                    swal("Cancelled", "Sorry Error Occurred !! :)", "error");
                            }
                            //                            .animate({opacity: "hide"}, "slow").remove();
                        }
                    });
                } else {
                    swal("Cancelled", "Your " + title + " is safe :)", "error");
                }
            });
        });

    }

//    $(window).load(function () {
//        $('.pre_loader').fadeOut(500);
//    });


    // pop over
    //  $('.popover_element').popover('hide');
//    var showPopover = function () {
//        $(this).popover('show');
//    }, hidePopover = function () {
//        $(this).popover('hide');
//    };

    /* default Only A-Z and a-z  are allowed.  */
//    $('.popover_element1').popover({
//        content: 'Only A-Z and a-z  are allowed.',
//        trigger: 'manual',
//        title: 'Remember',
//        placement: 'top'
//    })
//            .focus(showPopover)
//            .blur(hidePopover)
//            .hover(showPopover, hidePopover);
//    // End of Only A-Z, a-z  are allowed
//    /* default Only A-Z, a-z and space are allowed.  */
//    $('.popover_branch').popover({
//        content: 'Branch Code, Remember a user can access only its branch data.',
//        trigger: 'manual',
//        title: 'Branch Code',
//        placement: 'left'
//    })
//            .focus(showPopover)
//            .blur(hidePopover)
//            .hover(showPopover, hidePopover);
//
//    $('.popover_under').popover({
//        content: 'Parent - Task Category, Choose Parent Category, If It\'s top one in hierarchy',
//        trigger: 'manual',
//        title: 'Branch Code',
//        placement: 'left'
//    }).focus(showPopover)
//            .blur(hidePopover)
//            .hover(showPopover, hidePopover);
//    // End of Only A-Z, a-z and space are allowed
//    /* default Only A-Z, a-z and space are allowed.  */
//    $('.popover_element2').popover({
//        content: 'Only A-Z, a-z and space are allowed.',
//        trigger: 'manual',
//        title: 'Remember',
//        placement: 'top'
//    })
//            .focus(showPopover)
//            .blur(hidePopover)
//            .hover(showPopover, hidePopover);
//    // End of Only A-Z, a-z and space are allowed
//    // default
//    $('.popover_element').popover({
//        content: 'Popover content',
//        trigger: 'manual'
//    })
//            .focus(showPopover)
//            .blur(hidePopover)
//            .hover(showPopover, hidePopover);

// end of popover


    $(".toggle_custom").click(function () {
        $(this).find(".glyphicon-chevron-up").toggleClass('glyphicon-chevron-down', 1000);
    });
    $('#collapseExample').collapse('show');


//    $(function () {
//        $('.bdatetimepicker').datetimepicker({
//            format: 'DD-MM-YYYY hh:mm A',
//            icons: {
//                time: "fa fa-clock-o",
//                date: "fa fa-calendar",
//                up: "fa fa-arrow-up",
//                down: "fa fa-arrow-down"
//            }
//        });
//        $('.bdatepicker').datetimepicker({
//            format: 'DD-MM-YYYY'
//        });
//        $('.btimepicker').datetimepicker({
//            format: 'hh:mm A',
//            icons: {
//                up: "fa fa-arrow-up",
//                down: "fa fa-arrow-down"
//            }
//        });
//
//    });
    
    
//boot radio switches   
//    $(".bootswitches").bootstrapSwitch();
//    $('.bootswitches').on('switchChange.bootstrapSwitch', function (event, state) {
//        var toggle_yes = $(this).attr('toggle');
//        var toggle_id = $(this).attr('toggleid');
//        //alert(toggle_yes);
//        if (toggle_yes) {
//            $("#" + toggle_id).slideToggle(500);
//        }
//    });


    $('body').click(function () {
        rebind();
    });

    /*
     * @param {String} sid source id
     * @param {String} did destination id
     * @returns {nothing}
     * copy one text to another text id
     * called by add_employee form
     */
    function copy_text(sid, did) {
        $("#" + did).val($("#" + sid).val());
    }
    
    $(document).ready(function(){
//        myStopFunction();
    });
</script>    
<!-- multi select -->

<!--<script src="<?= base_url() ?>js/multi_select/chosen.jquery.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/multi_select/prism.js" type="text/javascript"></script>
<script type="text/javascript">
    var config = {
        '.chosen-select': {},
        '.chosen-select-deselect': {allow_single_deselect: true},
        '.chosen-select-no-single': {disable_search_threshold: 10},
        '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
        '.chosen-select-width': {width: "95%"}
    }
    for (var selector in config) {
        $(selector).chosen(config[selector]);
    }

</script>-->

<!--angular js datepicker-->
<!--<script src="<?= base_url() ?>js/angular_js/angular_datapicker.js" type="text/javascript"></script>-->

<!--<script src="<?= base_url() ?>js/model/bootstrap-modalmanager.js" type="text/javascript"></script>
<script src="<?= base_url() ?>js/model/bootstrap-modal.js" type="text/javascript"></script>-->

</body>
</html>


<!-- blinking effect -->
<!--<script src="<?= base_url() ?>js/custom_js/blink/blinking_effect.js" type="text/javascript"></script>-->



