
<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">All Voucher Report</h4>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading"  data-toggle="collapse" data-target="#allemployee">
                <h3 class="panel-title toggle_custom">Vouchers <span class="glyphicon  glyphicon-chevron-up pull-right" ></span></h3>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body" id="allemployee">
                <div class="table-responsive">
                    <table class="responsive table table-striped table-bordered table-hover capitalized_word" id="table_data">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>vDate</th>
                                <th>Client Name</th>
                                <th>Task Name</th>
                                <th>Sub task Name</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Amt/<br>AmtStatus</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
//                            $this->util_model->printr($voucherList);
                            foreach ($voucherList as $voucher) {
                                ?>
                                <?php ?>
                                <tr class="odd gradeX">
                                    <td><?= ++$i ?></td>
                                    <td>
                                        <?= date(DTF, strtotime($voucher['vDate'])); ?>
                                    </td>
                                    <td><?= $voucher['Emp_Name'] ?></td>
                                    <td>
                                        <?= $voucher['tm_name'] ?>
                                    </td> 
                                    <td><?php echo $voucher['tstm_name'] ?></td>
                                    <td><?php echo $voucher['from_place'] ?></td>
                                    <td><?php echo $voucher['to_place'] ?></td>
                                    <td><?php echo $voucher['v_amt']."/".($voucher['paid']?"Paid":"UnPaid") ?></td>
                                    
                                    <td>
                                        <a target="_blank" href="<?php echo base_url() . "tms/manage_voucher/index/" . $voucher['v_id'] ?>" title="Edit " class="btn btn-primary btn-xs">
                                            <span class="glyphicon glyphicon-edit"></span> 
                                        </a>
                                        <a target="_blank" href="<?php echo base_url() . "tms/manage_voucher/index/" . $voucher['v_id'] . "/del" ?>" onclick="delete_me(this, event);" title="Delete Task" class="btn btn-danger btn-xs">
                                            <span class="glyphicon glyphicon-remove"></span> 
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
<script src="<?= CDN1 ?>js/plugins/dataTables/jquery.dataTables.js"></script>
<script src="<?= CDN1 ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
<script>
                                        $(document).ready(function () {
                                            $('#table_data').DataTable({
                                                responsive: true
                                            });




                                        });

                                        function delete_me(that, e)
                                        {
                                            e.preventDefault();
                                            swal({
                                                title: "Are you sure?",
                                                text: "Are You Sure Want to Delete",
                                                type: "warning",
                                                showCancelButton: true,
                                                confirmButtonColor: '#DD6B55',
                                                confirmButtonText: 'Yes, Delete',
                                                cancelButtonText: "No, Cancel Please!",
                                                closeOnConfirm: false,
                                                closeOnCancel: false
                                            }, function (isConfirm) {
                                                if (isConfirm) {
                                                    preloader.on();
                                                    var url = $(that).attr("href");
                                                    $.ajax({
                                                        url: url,
                                                        type: 'POST',
                                                        dataType: 'json',
                                                        success: function (data, textStatus, jqXHR) {
                                                            if (data['success'])
                                                            {
                                                                swal({
                                                                    title: "Thanks!",
                                                                    type: "success",
                                                                    text: "Entry Deleted Successfully", 
                                                                    timer: 1000});
                                                                $(that).parent("td").parent("tr").remove();
                                                            } else {
                                                                swal("Cancelled", "Sorry Error Occurred !! >_<", "error");
                                                            }
                                                            preloader.off();

                                                        }
                                                    });
                                                } else {
                                                    swal({
                                                        title: "Thanks !!",
                                                        type: "success",
                                                        text: "Entry is safe !!",
                                                        timer: 10});
                                                }

                                            });
                                        }

</script>
