 <div class="col-lg-12">
                                    <div class="admin_menu col-lg-12" >
                                    <?php 
                                   
                                   function show_menu($Menu,$PageID,$DivID)
                                   {
                                       echo "<ul class='admin_menuul'>";
                                       if($Menu!=NULL)
                                       {
                                           foreach ($Menu as $mrow) {
                                              echo "<li class='col-lg-12'>";
                                              
                                           ?>
                                        <div class='menu_item col-lg-12'>
                                                        <div class="col-lg-9">
                                                           
                                                            <div class="col-lg-4"> 
                                                       <div>
                                              <?= $mrow['Parent']['MenuName'] ?>
                                                           
                                                            (<?= $mrow['Parent']['PageTitle'] ?>)
                                                       </div>
                     
                                                            </div>
                                                            <a style="" href="javascript:;" onclick="get_menu('<?=$mrow['Parent']['MID']?>','<?=$PageID?>','<?=$DivID?>','<?=$mrow['Parent']['MenuName']?>');" class=" col-lg-1">
                                                                  <span class='glyphicon glyphicon-edit'></span>
                                                                  OK
                                                            </a>
                                                            
                                                            
                                                        </div>
                                                        <div class='col-lg-3' style="text-align: right;font-size: 11px;font-weight: normal;">
                                                           
                                                       
                                                          
                                                            
                                                             </div> 
                                                    </div> 
                                             <?php
                                                            
                                              show_menu($mrow['Child'],$PageID,$DivID);
                                              echo "</li>"; 
                                           }
                                       }
                                       echo "</ul>";
                                   }
                                   
                                   show_menu($MenuTable,$PageID,$DivID);
                                   
                                   
                                    ?>
                                    </div>
                                    
                    </div>
<script>
    
</script>