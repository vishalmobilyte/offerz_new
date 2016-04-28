<head>
<meta charset="UTF-8">
<script src="<?php echo SITE_URL;?>/js/admin/jquery.nanoscroller.js"></script>
<script>
$(document).ready(function() {
$(".nano").nanoScroller();
});
</script>
</head>



<div class="social_teams analytics_div">
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
                <button style="background:#139DE2; color:#fff;"class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> FOLLOWERS <span class="caret"></span> </button>
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
		  <div class="display-all" >
		  <div id="most_pop_div">
		  <?php // print_r($invites_data); die; ?>
		  <?php foreach($invites_data_followers as $dis) {?>
          <div class="row border_t_performanec followers">
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
              <img class="performer_pic" src="<?php if($dis['u']['twt_pic']){
				
				      echo $dis['u']['twt_pic'];

				} 
				else {
					
					echo SITE_URL."/img/table_3.png";
				} ?>" alt="img"/>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
              <h3> <?php echo $dis['u']['name'];?> </h3>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-2">
              <h4 > <?php echo $dis['u']['twt_followers']; ?> </h4>
              
            </div>
          </div>
		  <?php } ?>
			</div>
		
		  </div>
	
        </div>
		<!--Right Section-->
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 cell_pad_recnt">
		<div class="row1" style="padding:0px; bottom:0px;">
              <div class="col-md-12" style="padding:0px;">
                <p id="recent">RECENT ACTIVITY</p>
              </div>
            </div>
			  <div id="about" class="nano">
    <div class="nano-content ">
			<?php if($results) { ?>
			<?php foreach($results as $result) { ?>
            <div class="row border_t_performanec">
			
              <div class="col-md-1 col-sm-1">
                <img class="activity_log_img" src="<?php 
				if($result['user']['twt_pic']){
				
				      echo $result['user']['twt_pic'];

				} 
				else {
					
					echo SITE_URL."/img/table_3.png";
				}

				?>" alt="img_rect1" >
				
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
				echo '<span title="'.$created_at.'" class="display_time">'.$exacttime = round($diff).' Mins ago</span> ';  
				
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
			  
            </div>
				<?php } ?>
			<?php } else { ?>
				
				<div class="row border_t_performanec">
				<p id="recent">
				No recent activity</p>
				</div>
			<?php } ?>
			
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
      </div>
      
      <!-----end-accordian---------> 
      
    </div>
  </div>
  
</div>