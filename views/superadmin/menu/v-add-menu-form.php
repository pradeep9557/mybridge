    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header ">Menu Management</h4>
            <?php
            if (isset($error)) {
                $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
           
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
<div class="col-lg-12">

    <div class="">
        <?php
        //Error msg show
        //$this->load->view('admin/showmsg'); 
        ?>
    </div>
    <?php echo form_open(base_url() . "sp-admin/m/AddMenu", array("id" => "AddMenu", "class" => "AddMenu")); ?> 
    <table class="col-lg-6 table tableNoborder">
        <tr>
            <td>Module (<span class="Compulsory">*</span>)</td>
            <td>
                <?php
                echo form_dropdown("module_id", $all_modules, "", "class='form-control chosen-select'");
                ?>

            </td>
        </tr>
        <tr>
            <td>Controller</td>
            <td>
                 <div class="form-group">                
                       <?php echo form_input("controller", "", array("id" => "controller", "class" => "'form-control popover_element'", "placeholder" => "'Controller name'", "maxlength" => "50", "data-toggle" => "'popover'", "data-placement" => "'top'", "data-content" => "'Only A-Z, a-z and space are allowed, and cant be more than 50 characters'", "data-original-title" => "'Remember'")) ?>                  
                 </div>
            </td>
        </tr>
        <tr>
            <td>Function</td>
            <td>
                 <div class="form-group">                
                       <?php echo form_input("function", "", array("id" => "function", "class" => "'form-control popover_element'", "placeholder" => "'Function Name'", "maxlength" => "50", "data-toggle" => "'popover'", "data-placement" => "'top'", "data-content" => "'Only A-Z, a-z and space are allowed, and cant be more than 50 characters'", "data-original-title" => "'Remember'")) ?>                  
                 </div>
            </td>
        </tr>
        <tr>
            <td>Is Menu</td>
            <td>
                <div class="form-group">
                     <?php
                    echo form_dropdown("is_menu", $yes_no_list,'', "class='form-control chosen-select'");
                    ?>
                </div>
            </td></tr>
        <tr>
            <td>Menu Title</td>
            <td>
                 <div class="form-group">                
                       <?php echo form_input("menu_title", "", array("id" => "menu_title", "class" => "'form-control popover_element'", "placeholder" => "'Menu title'", "maxlength" => "25", "data-toggle" => "'popover'", "data-placement" => "'top'", "data-content" => "'Only A-Z, a-z and space are allowed, and cant be more than 25 characters'", "data-original-title" => "'Remember'")) ?>                  
                 </div>
            </td>
        </tr>
         <tr>
            <td>Menu Link</td>
            <td>
                 <div class="form-group"> 
                     <?php echo form_input("menu_link", "", array("id" => "menu_link", "class" => "'form-control popover_element'", "placeholder" => "'Menu link'", "maxlength" => "150", "data-toggle" => "'popover'", "data-placement" => "'top'", "data-content" => "'Used to Link, and cant be more than 150 characters'", "data-original-title" => "'Remember'")) ?>
                 </div>
            </td>

        </tr>
        <tr>
            <td>Meta Keyword</td>
            <td>
                <div class="form-group"> 
                    <?php echo form_input("Meta_keywords", "", array("id" => "Meta_keywords", "class" => "'form-control popover_element'", "placeholder" => "'Meta keywords'", "maxlength" => "150", "data-toggle" => "'popover'", "data-placement" => "'top'", "data-content" => "'Only A-Z, a-z and space are allowed, and cant be more than 150 characters, It would help in Searching Menu.'", "data-original-title" => "'Remember'")) ?>
                </div>
            </td>
        </tr>
        <tr>
            <td>Open In </td>
            <td>
                <div class="form-group"> 
                    <?php
                    echo form_dropdown("tab", array("_self" => "Same Tab", "_blank" => "New Tab"), '_self', "class='form-control chosen-select'");
                    ?>
                </div>
            </td>
        </tr>
       
        <tr>
            <td>Sort Order </td>
            <td>
                <div class="form-group"> 
                    <?php echo form_input("sort_order", "", array("id" => "Sort Order Ex 0,2,3", "class" => "'form-control popover_element'", "placeholder" => "'Sorting of Menu'", "maxlength" => "2", "data-toggle" => "'popover'", "data-placement" => "'top'", "data-content" => "'Only 0-99 are allowed, It will help to sort the menu.'", "data-original-title" => "'Remember'")) ?>
                </div>
            </td>
        </tr>

        <tr>
            <td>Location</td>
            <td>
                <div class="form-group">
                     <?php
                    echo form_dropdown("menulocation_id", $menu_location_list,'', "class='form-control chosen-select'");
                    ?>
                </div>
            </td></tr>
        <tr><td>Menu Icon</td>
            <td>
                  <?php
                   // echo form_dropdown("menu_icon", $icon_list,'', "class='form-control chosen-select'");
                    ?>
                <div class="col-lg-5">
                    <label class="icon_choose popover_element"  data-toggle="popover"  data-content="Click here to select Icon for menu" data-original-title="Menu Icon" data-placement="right">
                        <input name="menu_icon" value="" id="" class="icon_id" type="hidden">
                        <span style="background: rgb(227, 228, 229);  padding: 11px;  margin-left: -14px;" class="glyphicon glyphicon-chevron-right ">
                        </span>
                        </label>   
                </div>
            </td>
        </tr>
<tr>
            <td>Status</td>
            <td>
                <div class="form-group">
                     <input class="bootswitches"  name="Status" type="checkbox" value="1" checked="">
                </div>
            </td></tr>
        <tr>
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-sm btn-success">
                    <span class="glyphicon glyphicon-floppy-disk"></span>
                    Save
                </button>
                <button type="reset" class="btn btn-sm btn-danger">
                    <span class="glyphicon glyphicon-refresh"></span>
                    Reset
                </button>
            </td>
        </tr>

    </table>
    <?php echo form_close(); ?>
</div> 

<script type="text/javascript">
//
//  $(function() {
//      $('.typeheadinput').typeahead({
//          ajax: '<?= base_url() . "admin/menus/MenuList/" ?>'+$(this).val(),
//          displayField: 'MenuName',
//          valueField:'MID',
//          onSelect:function (Item){
//                $(this).parent('td').children('.pids').val(Item.value);
//          }        
//          
//          });
//  
//  });
//  

    function close_data_div()
    {
        $(".ajax-data-collector").css({"display": "none"});
    }
    $(function() {





// this function is use to chose the icon for the menus .
        $(".icon_choose").click(function() {

            var icon_chooser = $(this);
            var ID = $(this).children('input').attr('id');
            $.ajax({
                url: "<?= base_url() . "sp-admin/m/icon_choose" ?>",
                type: 'POST',
                data: 'ID=' + ID,
                dataType: 'html',
                beforeSend: function(xhr) {

                },
                success: function(data, textStatus, jqXHR) {
                    $(".ajax-data-collector").css({"display": "block"});
                    $(".data-panel").html(data);


                    $(".icon_div").bind('click', function() {

                        var icon = $(this).children('span').attr('class');
                        icon_chooser.children('.icon_id').val(icon);

                        icon_chooser.children('span').removeClass();
                        icon_chooser.children('span').addClass(icon);
                        $(".ajax-data-collector").css({"display": "none"});


                    });

                },
                error: function(jqXHR, textStatus, errorThrown) {

                }
            });

        });







    });
    
        //      Form Validation           
    $(document).ready(function() {
        $('#AddMenu').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                module_id: { // field name
                    validators: {
                        notEmpty: {
                            message: 'Module Name is required and can\'t be empty'
                        }
                    }
                }
//                , controller: {
//                    message: 'Controller Name is not valid',
//                    validators: {
//                        notEmpty: {
//                           message: 'Controller Name is required and can\'t be empty'
//                        },
//                        regexp: {
//                            regexp: /^[a-zA-Z0-9_]+$/,
//                            message: 'Controller Name can only consist alphabets and numbers'
//                        }
//                    }
//                }, function: {
//                    message: 'Function Name is not valid',
//                    validators: {
//                        notEmpty: {
//                           message: 'Function  Name is required and can\'t be empty'
//                        },
//                        regexp: {
//                            regexp: /^[a-zA-Z0-9_]+$/,
//                            message: 'Function  Name can only consist alphabets and numbers'
//                        }
//                    }
//                }
                , menu_title: {
                    message: 'Menu Title Name is not valid',
                    validators: {
                        notEmpty: {
                           message: 'Menu Title Name is required and can\'t be empty'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9\s]+$/,
                            message: 'Menu Title Name can only consist alphabets and numbers'
                        }
                    }
                }
//                , menu_link: {
//                    validators: {
//                        notEmpty: {
//                            message: 'Menu Link is required and can\'t be empty'
//                        }
//                    }
//                }
                
//                , Meta_keywords: {
//                    validators: {
//                        notEmpty: {
//                            message: 'Keywords is required and can\'t be empty'
//                        }
//                    }
//                }
            }

        });
    });

</script>
<script src="<?= base_url() ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>





<!--for form validation-->
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>
