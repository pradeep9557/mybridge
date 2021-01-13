
<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Add Course Category
                <a href="<?php echo base_url(); ?>courses" class="pull-right">
                    <button type="button" name="Add_CourseCat" value="Save" class="btn btn-success btn-md margin_top-10px">
                        <span class="glyphicon glyphicon-plus"></span> Manage Course
                    </button></a>
            </h4>
            <?php
            if (isset($error)) {
                          $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample">
            <h3 class="panel-title toggle_custom">New Course Category From<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
        <!-- /.col-lg-12 -->
        <div class="panel-body" id="collapseExample">
            <?php
            //for normal form
            //  echo form_open('/dashboard/new_admission',$attributes);
            echo form_open_multipart(base_url() . 'courses/save_course_cat', "id='CourseCategory_form'");
            ?>
            <!--String of Row-->
            <div class="row bottom_gap">
                <div class="col-lg-2 padding_top_label">Branch</div>
                <div class="col-lg-4">
                    <div class="form-group">	
                        <?php echo form_dropdown("BranchID", array($Branch_obj->BranchID => $Branch_obj->BranchCode), "", "class='form-control chosen-select'") ?>
                    </div>
                </div><!-- /input-group -->               
                <div class="col-lg-2 padding_top_label">Course Category Code</div>
                <div class="col-lg-4">
                    <div class='input-group'>
                        <div class="form-group">
                            <?php echo form_input("C_CatCode", set_value("C_CatCode", ""), array("id" => "C_CatCode", "checking_id" => "'5'", "class" => "'form-control check_already_exits popover_element1'", "data-content" => "'Course Category Code required,  space is not allowed and max 3 characters'", "placeholder" => "'Course Category Code'", "maxlength" => "3")) ?>
                        </div>
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-md search_already_exits" tabindex="-1" search_for="C_CatCode">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                </div><!-- /input-group -->               
                <!-- end of col-lg-4 -->
            </div>
            <!--String of Row-->
            <div class="row bottom_gap">
                <div class="col-lg-2 padding_top_label">Course Category Name</div>
                <div class="col-lg-4">
                    <div class="input-group">
                        <div class="form-group">
                            <?php echo form_input("C_CatName", "", array("id" => "C_CatName", "checking_id" => "'6'", "class" => "'form-control check_already_exits  popover_element1'", "data-content" => "'Course Category Name required,   max 50 characters'", "placeholder" => "'Course Category Name'", "maxlength" => "50")) ?>
                        </div>
                        <span class="input-group-btn">
                            <button type="button" class="btn btn-default btn-md search_already_exits" tabindex="-1" search_for="C_CatName">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="col-lg-2 padding_top_label">Status</div>
                <div class="col-lg-4">
<!--                    <input class="bootswitches"  name="Status" type="checkbox" value="1" checked="">-->
                    <?php
                    echo form_checkbox("Status", 1, TRUE, "class='bootswitches'");
                    ?>
                </div>

            </div> <!--End of row-->
            <!--String of Row-->

            <!--End of row-->
            <div class="row bottom_gap">

                <div class="col-lg-2 padding_top_label">Add User</div>
                <div class="col-lg-4">
                    <?php
                    echo form_input("Add_User", "{$Session_Data['IBMS_USER_ID_NAME']}", array("class" => "'form-control'", "readonly" => "True", "id" => "add_user"));
                    ?>
                </div>
            </div>
            <div class="row bottom_gap">
                <div class="col-lg-2 padding_top_label">Remarks</div>
                <div class="col-lg-4">
                    <div class="form-group">
                        <?php echo form_textarea("Remarks", "", array("class" => "'form-control'", "placeholder" => "'Remarks'", "id" => "remarks"), 3, 3) ?>                               
                    </div>
                </div>
            </div>

            <!--<div class="panel-footer">-->
            <div class="row">
                <div class="col-lg-12">
                    <button type="submit" name="Add_CourseCat" value="Save" class="btn btn-success btn-md">
                        <span class="glyphicon glyphicon-floppy-disk"></span> Save
                    </button>
                    <button type="reset" name="Add_CourseCat" value="Save" class="btn btn-success btn-md">
                        <span class="glyphicon glyphicon-refresh"></span> Reset
                    </button>
                </div>
            </div>
            <!--</div>-->
            <?php echo form_close(); ?>
        </div>
    </div>
    <div class="panel panel-primary">
        <div class="panel-heading" data-toggle="collapse" data-target="#collapseExample1">
            <h3 class="panel-title toggle_custom">All Category List<span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
        </div>
        <!-- /.col-lg-12 -->
        <div class="panel-body" id="collapseExample1">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Course Category List With Advance Filter
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>S.No</th>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Sort</th>
                                            <th>Status</th>
                                            <th>Add User</th>
                                            <th>Add Date</th>
                                            <th>Modified</th>
                                            <th>Edit</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 0;

                                        foreach ($CourseCatList as $CourseCat_List) {
                                                      ?>
                                                      <tr class="odd gradeX">
                                                          <td><?= ++$i ?></td>
                                                          <td><?= $CourseCat_List->C_CatCode ?></td>
                                                          <td><?= $CourseCat_List->C_CatName ?></td>
                                                          <td><?= $CourseCat_List->Sort ?></td>
                                                          <td><?= ($CourseCat_List->Status) ? "Actived" : "Deactived" ?></td>
                                                          <td><?= $CourseCat_List->Add_User ?></td>
                                                          <td><?php echo date(DF, strtotime($CourseCat_List->Add_DateTime)); ?></td>
                                                          <td><?php echo $CourseCat_List->Mode_DateTime != "" ? date(DF, strtotime($CourseCat_List->Mode_DateTime)) : ""; ?></td>
                                                          <td>
                                                              <form>
                                                                  <button type="button"   class="btn-xs btn btn-success" onclick="open_page('<?= base_url() ?>courses/Edit_CourseCat/<?= ($CourseCat_List->C_CID) ?>', '')" title="Edit <?= mysql_real_escape_string($CourseCat_List->C_CatName) ?>">
                                                                      <span class="glyphicon glyphicon-edit"></span>
                                                                  </button>
                                                                  <input type="hidden" name="_key" value="del_course_cat"/>
                                                                  <input  type="hidden" value="You want to delete <?= mysql_real_escape_string($CourseCat_List->C_CatName) ?> Course Category !!" name="_msg"/>
                                                                  <input type="hidden" value="<?= $this->util_model->url_encode($CourseCat_List->C_CID) ?>" name="C_CID"/>
                                                                  <button type="button" value="Del"  class="btn btn-xs btn-danger ajax_submit">
                                                                      <span class="glyphicon glyphicon-trash"></span> 
                                                                  </button>
                                                              </form>

                                                          </td>
                                                      </tr>
                                                      <?php
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
        </div>
    </div>
    <?php
      $this->load->view("Courses/CourseCategory_valid");
    ?>


</div>
<link href="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>css/bdt/moment.js" type="text/javascript"></script>
<script src="<?= base_url() ?>css/bdt/bootstrap-datetimepicker.min.js" type="text/javascript"></script>




<!--for form validation-->
<link href="<?= base_url() ?>css/validator/bootstrapValidator.min.css" rel="stylesheet" type="text/css"/>
<script src="<?= base_url() ?>js/validator/bootstrapValidator.min.js" type="text/javascript"></script>