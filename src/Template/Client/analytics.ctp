<?php

?>

<div class="social_teams">
  <div class="container"> 
    <!------accordian--------->
    <div class="row my_social_terms">
      <div class="col-md-12 crt_scl">
        <div class="col-md-12 col-sm-12">
          <h1>ANALYTICS</h1>
        </div>
      </div>
      <div class="col-md-12">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 analytic_bg_whi"> 
          
          <!-- Nav tabs -->
          
          <div class="row">
            <div class="col-md-6 col-sm-6">
              <p>TOP PERFORMERS</p>
            </div>
            <div class="col-md-6 col-sm-6 cell_pad">
              <div class="dropdown">
                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> FOLLOWERS <span class="caret"></span> </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
				<li><a href="javascript:void(0)">Followers</a></li>
                  <li><a href="javascript:void(0)">Share%</a></li>
                  <li><a href="javascript:void(0)">Engagements</a></li>
                  <li><a href="javascript:void(0)">Connections</a></li>
                  <li role="separator" class="divider"></li>
                  <li><a href="javascript:void(0)">Most Declines</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="row border_t_performanec">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
              <img src="<?= SITE_URL; ?>/img/analytica_pizza.png" alt="img"/>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
              <h3> Pizza Hut </h3>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
              <h4> 128 </h4>
            </div>
          </div>
          <div class="row border_t_performanec">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
              <img src="<?= SITE_URL; ?>/img/analytica_home_depot.png" alt="img"/>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
              <h3> Pizza Hut </h3>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
              <h4> 110 </h4>
            </div>
          </div>
          <div class="row border_t_performanec">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
              <img src="<?= SITE_URL; ?>/img/analytica_be.png" alt="img"/>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
              <h3> Pizza Hut </h3>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
              <h4> 90 </h4>
            </div>
          </div>
          <div class="row border_t_performanec">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
              <img src="<?= SITE_URL; ?>/img/lego_icon.png" alt="img"/>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
              <h3> Pizza Hut </h3>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
              <h4> 88 </h4>
            </div>
          </div>
          <div class="row border_t_performanec">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
              <img src="<?= SITE_URL; ?>/img/microsoft_icon.png" alt="img"/>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
              <h3>Pizza Hut </h3>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
              <h4> 80 </h4>
            </div>
          </div>
        </div>
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 cell_pad_recnt">
          <div class="analytic_bg_whi_1">
            <div class="row">
              <div class="col-md-12">
                <p>RECENT ACTIVITY</p>
              </div>
            </div>
			
            <div class="row border_t_performanec">
			<?php foreach($results as $result) { ?>
              <div class="col-md-1 col-sm-1">
                <img src="<?= SITE_URL; ?>/img/rcent_img_1.jpg" alt="img_rect1"/>
              </div>
              <div class="col-md-9 col-sm-9">
                <p><?php echo $result['log_client']; ?></p>
              </div>
              <div class="col-md-2 col-sm-2"> 
			  <?php 
			  
			  $created_at = $result['created_at']; 
			  $dt = new DateTime();
               $today = $dt->format('n/j/y H:i');
			   
			   $ts1 = strtotime($created_at);
			// echo   $ts1 = strtotime(str_replace('/', '-', $created_at));
               $ts2 = strtotime($today);
			   $ext_diff = $ts2 - $ts1;
			  if($ext_diff < 3600){
				  
				$diff = abs($ts2 - $ts1) /60 ;
				echo '<span title="'.$created_at.'" class="display_time">'.$exacttime = round($diff).'Mins ago</span> ';  
				
			  }
			  elseif($ext_diff < 86400){
				$diff = abs($ts2 - $ts1) /3600 ;
				echo '<span title="'.$created_at.'" class="display_time">'.$exacttime = round($diff).' Hrs ago</span>';
				
			  }
			  else{
				 $diff = abs($ts2 - $ts1) /86400 ;
				echo '<span title="'.$created_at.'" class="display_time">'.$exacttime = round($diff).' Days ago</span>';
				
			  }
			 
			 
			  ?></div>
			  <?php } ?>
            </div>
			
           <!-- <div class="row border_t_performanec">
              <div class="col-md-1 col-sm-1">
                <img src="<?= SITE_URL; ?>/img/rcent_img_2.jpg" alt="img_rect1"/>
              </div>
              <div class="col-md-9 col-sm-9">
                <p><span> Mike Angeleno </span> Accepted a request from Lego </p>
              </div>
              <div class="col-md-2 col-sm-2">4d </div>
            </div>
            <div class="row border_t_performanec">
              <div class="col-md-1 col-sm-1">
                <img src="<?= SITE_URL; ?>/img/rcent_img_3.jpg" alt="img_rect1"/>
              </div>
              <div class="col-md-9 col-sm-9">
                <p><span> Jessica Monfredo </span> Shared <span> TEAM DINNER AT MONTYS from Montys </span></p>
              </div>
              <div class="col-md-2 col-sm-2"> 6d </div>
            </div>
            <div class="row border_t_performanec">
              <div class="col-md-1 col-sm-1">
                <img src="<?= SITE_URL; ?>/img/rcent_img_4.jpg" alt="img_rect1"/>
              </div>
              <div class="col-md-9 col-sm-9">
                <p><span>Jason McNeil </span>Declined <span>Toonie Tuesday Breakfasts from Microsoft </span> </p>
              </div>
              <div class="col-md-2 col-sm-2"> 7d </div>
            </div>
            <div class="row border_t_performanec">
              <div class="col-md-1 col-sm-1">
                <img src="<?= SITE_URL; ?>/img/rcent_img_5.jpg" alt="img_rect1"/>
              </div>
              <div class="col-md-9 col-sm-9">
                <p><span> Bill Micheals Shared </span> <span>TEAM DINNER AT MONTYS from  Montys </span></p>
              </div>
              <div class="col-md-2 col-sm-2"> 6d</div>
            </div>
            <div class="row border_t_performanec">
              <div class="col-md-1 col-sm-1">
                <img src="<?= SITE_URL; ?>/img/rcent_img_5.jpg" alt="img_rect1"/>
              </div>
              <div class="col-md-9 col-sm-9">
                <p>Bill Micheals Shared  TEAM DINNER AT MONTYS from  Montys</p>
              </div>
              <div class="col-md-2 col-sm-2"> 6d</div>
            </div>
            <div class="row border_t_performanec">
              <div class="col-md-1 col-sm-1">
                <img src="<?= SITE_URL; ?>/img/rcent_img_5.jpg" alt="img_rect1"/>
              </div>
              <div class="col-md-9 col-sm-9">
                <p>Bill Micheals Shared  TEAM DINNER AT MONTYS from  Montys</p>
              </div>
              <div class="col-md-2 col-sm-2"> 6d</div>
            </div>-->
          </div>
        </div>
      </div>
      
      <!-----end-accordian---------> 
      
    </div>
  </div>
  
</div>