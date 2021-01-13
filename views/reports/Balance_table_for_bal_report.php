<div class="col-lg-12">
    <div class="panel panel-primary">
        <div class="panel-heading">
            Students List With Advance Filter
        </div>
        <!-- /.panel-heading -->
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>EnrollNo</th>
                            <th>DOR</th>
                            <th>CourseCode</th>
                            <th>Faculty Code</th>
                            <th>Batch Code</th>
                            <th>Receipt Date</th>
                            <th>Balance</th>
                            <th>Due Date</th>
                            <th>Add/Mode User</th>
                            <td>Fee Collect</td>
                         <!--<th>Last Modified</th>-->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;

                        foreach ($All_Fee_report as $Bal_List) {
                            ?>
                            <tr class="odd gradeX">
                                <td><?= ++$i ?></td>
                                <td><?= $Bal_List->EnrollNo ?></td>
                                <td><?= date(DF, strtotime($Bal_List->DOR)) ?></td>
                                <td><?= $Bal_List->CourseCode ?></td>
                                <td><?= $Bal_List->FacultyCode ?></td>
                                <td><?= $Bal_List->BatchCode ?></td>
                                <td><?= date(DF, strtotime($Bal_List->ReceiptDate)) ?></td>
                                <td><?= $Bal_List->BalanceAmt ?></td>
                                <td><?= date(DF, strtotime($Bal_List->BalDueDate)) ?></td>
                                <td><?= $Bal_List->Add_User . "/" . $Bal_List->Mode_User ?></td>
                                <td>
                                    <a href="<?= base_url() ?>Fee_Master/Fee_collect_form/0/0/<?= $Bal_List->EnrollNo ?>/<?= $this->util_model->url_encode($Bal_List->CourseCode) ?>">
                                        <button class="btn-xs btn btn-info" title="Fee Collect For <?= $Bal_List->EnrollNo ?>" type="button"><span class="glyphicon glyphicon-send"></span> Fee Collect</button>
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
<script>
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });

</script>
