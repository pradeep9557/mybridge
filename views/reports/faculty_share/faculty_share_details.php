<div id="page-wrapper" style="min-height: 345px;">
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover capitalized_word fee_record_table">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Receipt No</th>
                    <th>Faculty</th>
                    <th>Course</th>
                    <th>Faculty Share</th>
                    <th>Weightage</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($fees_record as $fee) {
                              ?>
                              <tr class="odd gradeX">
                                  <td><?= ++$i ?>.</td>
                                  <td><?= $fee->ReceiptNo ?></td>
                                  <td><?= $fee->FacultyID ?></td>
                                  <td><?= $fee->CourseID ?></td>
                                  <td><?= $fee->FacultyShare ?></td>
                                  <td><?= $fee->Weightage ?></td>
                              </tr>
                              <?php
                }
                ?>


            </tbody>
        </table>
    </div>

    <script>
                  $(document).ready(function () {
                      $('.fee_record_table').DataTable();
                  });
    </script>

</div>