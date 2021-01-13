<script src="<?= CDN1 ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= CDN1 ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">All Bill Details</h4>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading"  data-toggle="collapse" data-target="#allemployee">
                <h3 class="panel-title toggle_custom">Bills List With Advance Filter <span class="glyphicon  glyphicon-chevron-up pull-right" ></span></h3>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body" id="allemployee">
                <div class="table-responsive">
                    <table class="responsive table table-striped table-bordered table-hover capitalized_word" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Task Name</th>
                                <th>Client Name</th>
                                <th>Amount Paid</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            foreach ($all_bill_details as $bill_List) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><?= ++$i ?></td>    
                                    <td><?= $bill_List['tm_name'] ?></td>
                                    <td><?= $bill_List['Emp_Name'] ?></td>
                                    <td><?php echo $bill_List['amt_paid']; ?></td>
                                    <td><?php echo $bill_List['remarks']; ?></td>;
                                    <td><?php if($bill_List['status']==1){
                                        echo "Active";
                                    }else if($bill_List['status']==2){
                                        echo "Cancelled";
                                    }else{
                                        echo "Deleted";
                                    }
                                     ?></td>
                                    <td>
                                        <a href="<?= base_url() ?>tms/manage_bills/finalize_bill/<?= $bill_List['bill_id'] ?>">
                                            <button type="button" title="Edit Bill Details" value="Edit" class="btn btn-success btn-xs">
                                                <span class="glyphicon glyphicon-edit"></span> 
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
<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function () {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>
