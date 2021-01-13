<div class="col-lg-12" style="margin: 5px 0px;">
     <span class="add-on input-group-addon" onclick="hide_this('Searching_Result')"><i class="glyphicon glyphicon-minus fa fa-minus"></i></span>
     <table class="table table-striped table-hover table-bordered table-responsive" id="record_searched">
        <?php 
         if(isset($Query_Result)){
        ?>
         <thead>
        <tr>
            <th>Enroll No</th>
            <th>Name</th>
            <th>Father's Name</th>
            <th>Course</th>
            <th>Mobile</th>           
            <th>Add User</th>
            <th>Action</th>
        </tr>
        </thead>
        <?php
        foreach ($Query_Result as $row) {
            
        ?>
        <tr>
            <td><?= $row->EnrollNo ?></td>
            <td><?= $row->StudentName ?></td>
            <td><?= $row->FatherName ?></td>
            <td><?= $row->CourseCode ?></td>
            <td><?= $row->Mobile1 ?></td>
            <td><?= $row->Add_User ?></td>
            <td>
                <span onclick="open_page('<?= base_url() ?>admission/admission_edit/0/0/<?= $row->EnrollNo ?>', '')">
                <button class="btn-xs btn btn-success" title="Edit Details of EnrollNo <?= $row->EnrollNo ?>" type="button"><span class="glyphicon glyphicon-edit"></span></button></span>
                <a href="<?= base_url() ?>Fee_Master/Fee_collect_form/0/0/<?= $row->EnrollNo ?>">
                <button type="button" class="btn btn-info btn-xs" id="all_fee_record">
                    <span class="glyphicon glyphicon-send">  </span>
                </button>
                </a>
                
            </td>
        </tr>
        <?php
         }
        }else{
             echo "<tr><td colspan='9'>Sorry No Record Found !!</td></tr>";
         }
        ?>
    </table>
</div>
<script>
    $(document).ready(function() {
        $('#record_searched').dataTable();
    });

</script>