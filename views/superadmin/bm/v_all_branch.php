<!--<div id="page-wrapper" style="min-height: 345px;">-->
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="page-header">All Branch</h4>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-primary">
                    <div class="panel-heading"  data-toggle="collapse" data-target="#allemployee">
                        <h3 class="panel-title toggle_custom">Branch List With Advance Filter <span class="glyphicon  glyphicon-chevron-up pull-right" ></span></h3>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body" id="allemployee">
                        <div class="table-responsive">
                            <table class="responsive table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Branch ID</th>
                                        <th>B Name</th>
                                        <!--<th>Agent Code</th>-->
                                        <th>Mobile</th>
                                        <th>Email</th>
                                        <th>Branch Site</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 0;
                                    foreach ($branch_list as $row) {
                                        ?>
                                        <tr class="odd gradeX">
                                            <td><?= ++$i ?></td>
                                            <td><?= $row['BranchID'] ?></td>
                                            <td><?= $row['Bname']?></td>
                                            <!--<td><?= $row['agent_code'] ?></td>-->
                                            <td><?= $row['Mob1'] ?></td>
                                            <td><?= $row['Email1'] ?></td>
                                            <td><?= $row['Bsite'] ?></td>

                                            <td>
                                                <a target="_blank" href="<?= base_url("sp-admin/bm/vedit_branch") . "/" . $row['BranchID'] ?>">
                                                    <button type="button" class="btn btn-xs btn-primary">
                                                        <span class="glyphicon glyphicon-edit"></span>
                                                    </button>
                                                </a>
                                                <a target="_blank" href="<?= base_url("sp-admin/bm/bra_noti_setting") . "/" . $row['BranchID'] ?>">
                                                    <button type="button" class="btn btn-xs btn-primary">
                                                        <span class="glyphicon glyphicon-edit">Setting</span>
                                                    </button>
                                                </a>
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
<!--</div>

 Page-Level Demo Scripts - Tables - Use for reference 
<script>
    $(document).ready(function () {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>-->

<script src="<?= base_url() ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>