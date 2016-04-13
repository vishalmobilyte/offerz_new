
		 <?php foreach($share_perc_data as $dis) {?>
		  <div class="row border_t_performanec share">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
              <img class="performer_pic" src="<?php if($dis['user']['twt_pic']){
				
				      echo $dis['user']['twt_pic'];

				} 
				else {
					
					echo SITE_URL."/img/table_3.png";
				} ?>" alt="img"/>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
              <h3> <?php echo $dis['user']['name'];?></h3>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
                 <h4 class="share" > <?php echo $dis['offer_declined']; ?> </h4>
            </div>
          </div>
		  <?php } ?>

		  