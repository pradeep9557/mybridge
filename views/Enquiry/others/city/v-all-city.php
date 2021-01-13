
<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">All City List</h4>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                City List With Advance Filter
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>City</th>
                                <th>State</th>
                                <th>City</th>
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
                           // $this->util_model->printr($city_list);
                            foreach ($city_list as $List) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><?= ++$i ?></td>
                                    <td><?= $List->country ?></td>
                                    <td><?= $List->statecode ?></td>
                                    <td><?= $List->citycode ?></td>
                                    <td><?= ($List->Status) ? "Actived" : "Deactived" ?></td>
                                    <td><?=$List->Sort?></td>
                                    <td><?=$List->AddEmpCode?></td>
                                    <td><?=$List->ModeEmpCode?></td>
                                    <td><?= $List->LastModified=="0000-00-00 00:00:00"?'':date(DTF, strtotime($List->LastModified)); ?></td>
                                    <td><?=$List->Remarks?></td>
                                     <td>
                                        <form>
                                            <a href="<?= base_url() ?>Enquiry/c_city/vedit_city/<?= ($List->ID) ?>"> <button type="button"   class="btn-xs btn btn-success" onclick="" title="Edit <?= mysql_real_escape_string($List->citycode) ?>">
                                                <span class="glyphicon glyphicon-edit"></span>
                                            </button>
                                            </a>
                                            <input type="hidden" name="_key" value="del_city"/>
                                            <input type="hidden" name="_title" value="<?= mysql_real_escape_string($List->citycode) ?>"/>
                                            <input  type="hidden" value="You want to delete <?= mysql_real_escape_string($List->citycode) ?> City !!" name="_msg"/>
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