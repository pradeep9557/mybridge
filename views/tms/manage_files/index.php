<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header ">Un-assigned Client Data</h4>
            <?php
            if (isset($error)) {
                $this->util_model->result_e_code($error, SUCCESS_MSG, $err_codes);
            }
            ?>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Client</th>
                <th>Year - Month</th>
                <th>View Files</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1.</td>
                <td>XYZ</td>
                <td>2017 - Jan</td>
                <td><button>View All Files</button></td>
                <td><button>Assign</button></td>
            </tr>
        </tbody>
    </table>
</div>