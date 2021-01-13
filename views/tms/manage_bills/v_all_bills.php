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
                                 <th>Bill Number</th>
                                <th>Task Name</th>
                                <th>Client Name</th>
                                <th>Bill Amount</th>
                                <th>From A/C</th>
                                <th>Remarks</th>
                                <th>Due Date</th>
                                <th>Total Paid</th>
                               
                                <th >Edit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0; 
                            foreach ($all_bill_details as $bill_List) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><?= ++$i ?></td>    
                                    <td><?php echo $bill_List['bill_no']; ?></td>
                                    <td><?= $bill_List['tm_name'] ?></td>
                                    <td><?= $bill_List['Emp_Name'] ?></td>
                                    
                                    
                                    <td><?php echo number_format($bill_List['bill_amt']+$bill_List['ser_tax']+$bill_List['etax']+$bill_List['ktax'],2); ?></td>
                                    <td><?php echo isset($bill_List['from_acc'])?$bill_List['from_acc']:"NA";  ?></td>
                                    <td><?php echo $bill_List['remarks']; ?></td>
                                    <td><?= date(DF,  strtotime($bill_List['bill_due_date'])) ?></td>
                                    <td><?php echo $bill_List['Paid_amt']; ?></td>
                                    
                                    <td style="width: 150px;">
                                        <a href="<?= base_url() ?>tms/manage_bills/index/<?= $bill_List['bill_mst_id'] ?>">
                                            <button type="button" title="Edit Bill Details" value="Edit" class="btn btn-success btn-xs">
                                                <span class="glyphicon glyphicon-edit"></span> 
                                            </button>
                                        </a>
                                        
                                         
                                            <button  type="button" title="Delete" class="delete_bill btn btn-danger btn-xs" action_url='<?= base_url() ?>tms/manage_bills/index/?delete_bill_id=<?= $bill_List['bill_mst_id'] ?>'>
                                                <span class="glyphicon glyphicon-trash"></span> 
                                            </button>
                                         <a href="<?= base_url() ?>tms/manage_bills/print_bill/<?= $bill_List['bill_mst_id'] ?>">
                                            <button type="button" title="Print Bills" class="btn btn-info btn-xs">
                                                <span class="glyphicon glyphicon-print"></span> 
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
    
    $(".delete_bill").click(function(){
        preloader.on();
        var _this = $(this);
            $.ajax({
                url: $(this).attr('action_url'),
                method: "GET",
                dataType: "json",
                success: function (result) {
                    if (result.succ) {
                        
                          swal({
                                        title: "Done!",
                                        text: result._err_codes,
                                        type: "success",
                                        timer: 1000
                                    });
                        _this.parents("tr").remove();
                    } else {
                        swal("Cancelled", "Sorry Error Occurred !! >__<", "error");
                    }
                     preloader.off();
                }
            });
    });
</script>
