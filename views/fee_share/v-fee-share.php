
<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">Fee Share Details</h4>

    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading"  data-toggle="collapse" data-target="#allexpense">
                <h3 class="panel-title toggle_custom">Fee Share Details<span class="glyphicon  glyphicon-chevron-up pull-right" ></span></h3>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body" id="allexpenses">

                <div class="table-responsive">
                    <table class="responsive table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Receipt No.</th>
                                <th>Receipt Date</th>
                                <th>Student Name</th>
                                <th>Amount(Rs.)</th>
                                <th>Faculty</th>
                                <th>Faculty Share</th>

<!--<th>Last Modified</th>-->
                            </tr>
                        </thead>
                        <tbody>
<?php
$i = 0;
foreach ($share_data as $list) {
    ?>
                                <tr class="odd gradeX">
                                    <td><?= ++$i ?></td>
                                    <td><?= $list->ex_type_code ?></td>
                                    <td><?= date(DF, strtotime($list->ex_date)); ?></td>
                                    <td><?= $list->ex_amt ?></td>
                                    <td><?= $list->Emp_Code ?></td>
                                    <td><?= $list->faculty_code ?></td>
                                    <td><?= $list->Mode_User ?></td>
                                    
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
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>
