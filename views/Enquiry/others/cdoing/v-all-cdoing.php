
<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">All Current Doing List</h4>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                Current Doing List With Advance Filter
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>CD ID</th>
                                <th>Code</th>
                                <th>Sort</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th>Add_User</th>
                                <th>Mode_User</th>
                                <th>Mode_DateTime</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            // $this->util_model->printr($city_list);
                            foreach ($cdoing_list as $List) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><?= ++$i ?></td>
                                    <td><?= $List->Code ?></td>
                                    <td><?= $List->Sort ?></td>
                                    <td><?= $List->Name ?></td>
                                    <td><?= ($List->Status) ? "Actived" : "Deactived" ?></td>
                                    <td><?= $List->Remarks ?></td>
                                    <td><?= $List->AddEmpCode ?></td>
                                    <td><?= $List->ModeEmpCode ?></td>
                                    <td><?= $List->LastModified == "0000-00-00 00:00:00" ? '' : date(DTF, strtotime($List->LastModified)); ?></td>
                                    <td>
                                        <form>
                                            <button type="button"   class="btn-xs btn btn-success" onclick="open_page('<?= base_url() ?>Enquiry/c_cdoing/vedit_cdoing/<?= ($List->ID) ?>', '')" title="Edit <?= mysql_real_escape_string($List->Code) ?>">
                                                <span class="glyphicon glyphicon-edit"></span>
                                            </button>
                                            <input type="hidden" name="_key" value="del_cdoing"/>
                                            <input type="hidden" name="_title" value="<?= mysql_real_escape_string($List->Code) ?>"/>
                                            <input  type="hidden" value="You want to delete <?= mysql_real_escape_string($List->Code) ?> Code !!" name="_msg"/>
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