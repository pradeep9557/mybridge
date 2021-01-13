<a href="<?php echo base_url(); ?>" class="go_back_link">Go Back</a>
<header>
    <h1><?php echo $faq_title_text ?></h1>    
</header>
<?php if(empty($faq_data)): ?>
    <h4 class="text-center">>-_-< Sorry there is no any FAQ  </h4>
    <?php endif; ?>
    
<section class="cd-faq">
    
    <!--printing sidebar menu-->
    <ul class="cd-faq-categories"> <?php
        foreach ($faq_data as $row) {
                      ?>
                      <li><a  href="#<?php echo $row['menuid'] ?>">
                                    <?php echo $row['m_heading_text'] ?></a>
                      </li>
                      <?php
        }
        ?>

    </ul>

    <div class="cd-faq-items">
        <!--printing div heading now-->
            <?php
            foreach ($result as $row) {
                          if(!empty($row['ques'])):
                          ?><ul id="<?php echo $row['Menu']['menuid'] ?>" class="cd-faq-group">
                              <li class="cd-faq-title" id="<?php echo $row['Menu']['menuid'] ?>">
                                  <h2><?php echo $row['Menu']['div_heading_text'] ?></h2></li>

                              <!--printing questions inside each div heading-->   
                              <?php
                              foreach ($row['ques'] as $row2) {
                                            ?>
                                            <li> 
                                                <a class="cd-faq-trigger" href="#0">
                                                    <?php echo $row2['question'] ?>
                                                </a>
                                                <div class="cd-faq-content">
                                                    <p><?php echo $row2['ans'] ?></p>
                                                </div>
                                            </li>
                                            <?php
                              }
                              ?></ul>
                          <?php
                              endif;
            }
            ?>  
    </div> <!-- cd-faq-items -->
    <a href="#0" class="cd-close-panel">Close</a>
</section> <!-- cd-faq -->




