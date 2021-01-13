<div id="page-wrapper" style="min-height: 345px;">
<div class="row">
    <div class="col-lg-12">
        <h4 class="page-header">All Enquiry List</h4>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
               <?php 
                 echo $enq_search_template;
               ?>

    </div>
     <!--/.col-lg-12--> 
</div>
<?php 
//    $this->load->view('Ajax/v-enquiry-search');
?>                                       
 
</div>
<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
        $('#data_div').collapse('toogle');
    });
</script>
