
		  <?php 
		  
		  foreach($invites_data_followers as $dis) {?>
          <div class="row border_t_performanec followers">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
              <img src="<?php if($dis['u']['twt_pic']){
				
				      echo $dis['u']['twt_pic'];

				} 
				else {
					
					echo SITE_URL."/img/table_3.png";
				} ?>" alt="img"/>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
              <h3> <?php echo $dis['u']['name'];?> <br/><?php echo $dis['u']['email'];?></h3>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
              <h4 > <?php echo $dis['u']['twt_followers']; ?> </h4>
              
            </div>
          </div>
		  <?php } ?>

		  