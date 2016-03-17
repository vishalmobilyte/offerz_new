
		  <?php 
		  
		  foreach($invites_data_followers as $dis) {
			  print_r($dis);die;
			  ?>
          <div class="row border_t_performanec followers">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
              <img src="<?php if($dis['twt_pic']){
				
				      echo $dis['twt_pic'];

				} 
				else {
					
					echo SITE_URL."/img/table_3.png";
				} ?>" alt="img"/>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
			<?php 
									$total_offer_accepted=0;
									$total_offer_received=0;
									if($dis['offers_stat'])
									{
										// if($displayUsers['offers_stat'][0]['offer_accepted']!=0)
										// {
									foreach ($dis['offers_stat'] as $k) 
									{
										$total_offer_accepted+=$k['offer_accepted'];
										$total_offer_received+=$k['total_offer_received'];
										//$total_share_perc=intval(($total_offer_accepted/$total_offer_received)*100);
										//print_r($k['offer_accepted']);
																			
									}
									$total_share_perc=round(($total_offer_accepted/$total_offer_received)*100);
									echo $total_share_perc.	 '%';
										
										
									}
									
									else
									{
										echo '0%';
									}
									
									?>
              <h3> <?php echo $dis['name'];?> <br/><?php echo $dis['email'];?></h3>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
              <h4 > <?php //echo $dis['offers_count']	 ?> </h4>
              
            </div>
          </div>
		  <?php } ?>

		  