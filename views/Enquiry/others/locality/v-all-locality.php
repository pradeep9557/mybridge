
<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">All Locality List</h4>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading" data-toggle="collapse" data-target="#allcountry">
                <h3 class="panel-title toggle_custom">New Locality Form
                    <span class="glyphicon glyphicon-chevron-down glyphicon-chevron-up pull-right" ></span></h3>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body" id="allcountry">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>City</th>
                                <th>LCode</th>
                                <th>Lfullname</th>
                                <th>Parent</th>
                                <th>Status</th>
                                <th>Sort</th>
                                <th>Add User</th>
                                <th>Mode User</th>
                                <th>Last Modified</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($locality_list as $List) {
                               // die($this->util_model->printr($List));
                                ?>
                                <tr class="odd gradeX">
                                    <td><?= ++$i ?></td>
                                    <td><?= $List->citycode ?></td>
                                    <td><?= $List->localitycode ?></td>
                                    <td><?= $List->localityname ?></td>
                                    <td><?= $List->parentcode ?></td>
                                    <td><?= ($List->Status) ? "Actived" : "Deactived" ?></td>
                                    <td><?= $List->Sort ?></td>
                                    <td><?= $List->Add_User ?></td>
                                    <td><?= $List->Mode_User ?></td>
                                    <td><?= $List->LastModified == NULL ? '' : date(DTF, strtotime($List->LastModified)); ?></td>
                                    <td><?= $List->Remarks ?></td>
                                    <td>
                                        <form>
                                            <a href="<?php echo base_url() ?>Enquiry/c_locality/vedit_locality/<?= ($List->ID) ?>"><button type="button"   class="btn-xs btn btn-success" onclick="" title="Edit <?= mysql_real_escape_string($List->localitycode) ?>">
                                                    <span class="glyphicon glyphicon-edit"></span>
                                                </button>
                                            </a>
                                            <input type="hidden" name="_key" value="del_locality"/>
                                            <input type="hidden" name="_title" value="<?= mysql_real_escape_string($List->localitycode) ?>"/>
                                            <input  type="hidden" value="You want to delete <?= mysql_real_escape_string($List->localitycode) ?> Locality !!" name="_msg"/>
                                            <input type="hidden" value="<?= $this->util_model->url_encode($List->ID) ?>" name="ID"/>
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

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function () {
        $('#dataTables-example').dataTable();
    });
</script>

<script src="<?= base_url() ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>