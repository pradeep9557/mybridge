<div id="page-wrapper" style="min-height: 345px;">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="page-header">Select User Type</h4>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <?php
 //   $this->util_model->printr($usertype_list);
    ?>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading"  data-toggle="collapse" data-target="#allemployee">
                    <h3 class="panel-title toggle_custom">Users Type List <span class="glyphicon  glyphicon-chevron-up pull-right" ></span></h3>
                </div>
                <!-- .panel-heading -->
                <div class="panel-body" id="allemployee">
                    <ul>
                        <?php 
                            foreach ($UserType as $key => $value) {
                                ?>
                        <li>
                            <a href="<?= base_url() ?>sp-admin/m/menu_auth/?UTID=<?=$key?>">
                                <?=$value?>
                            </a>
                        </li>
                        <?php
                            }
                        ?>
                        
                    </ul>
                    
                   
                </div>

            </div>
        </div>
    </div> 
</div>