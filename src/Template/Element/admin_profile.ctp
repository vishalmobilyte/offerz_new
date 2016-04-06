<!----content----->
<div class="container">
  <div class="row Under_Armour">
    <div class="col-md-12">
      <div class="col-md-5 col-sm-5">
	  <?php
	  if($admin_data->twt_pic != ''){ ?>
	    <img  class="img-responsive f_l x_img" src="<?= str_replace("_normal","",$admin_data->twt_pic); ?>" alt="twt_pic" style="height:120px;width:120px;" >
	  <?php } else{ ?>
        <img alt="" class="img-responsive f_l x_img" src="<?= SITE_URL; ?>/img/img_x.png">
		<?php } ?>
        <p class="under_armr_text"><?= $admin_data->name; ?></p>
        <p class="under_armr_text_btm"><?= $admin_data->screen_name?'@'.$admin_data->screen_name:''; ?></p>
        <p class="text_btm"><?= $admin_data->description; ?></p>
      </div>
	  <?php if($admin_data->twitter_id !=''){ ?>
	  
	  
      <div class="col-md-7 col-sm-7">
        <div class="col-md-3 col-sm-3">
          <p class="nmbr"><?=$admin_data->twt_tweets?$admin_data->twt_tweets:'0';?><br>
            <span class="scl_text">Tweets</span></p>
        </div>
        <div class="col-md-3 col-sm-3">
          <p class="nmbr"><?=$admin_data->twt_followers?$admin_data->twt_followers:'0';;?><br>
            <span class="scl_text">Followers</span></p>
        </div>
        <div class="col-md-3 col-sm-3">
          <p class="nmbr"><?=$admin_data->twt_retweets?$admin_data->twt_retweets:'0';;?><br>
            <span class="scl_text">Retweets</span></p>
        </div>
        <div class="col-md-3 col-sm-3">
          <p class="nmbr_2"><?=$admin_data->twt_favorites?$admin_data->twt_favorites:'0';;?><br>
            <span class="scl_text">Favorites</span></p>
        </div>
      </div>
	  <?php } else { ?>
		<div class="col-md-7 col-sm-7"> 
		You have not connected to Twitter yet. <a href="connect_twitter" target="blank" >Connect Now</a>
		</div>
	  <?php } ?>
	
    </div>
    
<div class="col-md-12">
  <div class="col-md-6 edit_prof_div"  onclick="toggle_profile_div();">
            <img src="<?= SITE_URL; ?>/img/setting.png" class="img-responsive f_l x_img" alt=""  />
    <p class="edit_prfile" >EDIT PROFILE<a href=""> </a></p><a href="">
  </a></div>
         <div class="flash_msg" style="position: absolute;
    right: 5%;
	
    width: 300px;
    "><?=$this->Flash->render();?></div>        
        </div>
		
  </div>
  
  
  
  <div class="row Under_Armour" id="profile_div"><img src="<?= SITE_URL; ?>/img/cross.png" class="img-responsive f_r close_prof_div" alt=""  onclick="toggle_profile_div();">
    <form class="form-horizontal" id="register_form" action="update_profile" method="POST">
    <div class="col-md-12">
      <div class="col-md-3 col-sm-4 cell_pad">
        <div class="input-group">
            <div class="form-group">
              <label for="inputEmail" class="control-label col-xs-5">Enter Name</label>
              <div class="col-xs-7">
                <input type="text" class="form-control" value='<?= $admin_data->name; ?>' id="inputName" name="name" placeholder="Under Armour">
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword" class="control-label col-xs-5">Password</label>
              <div class="col-xs-7">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
              </div>
            </div>
         
        </div>
      </div>
      <div class="col-md-4 col-sm-4 twitter_pan_1">
        <div class="input-group">
        
            <div class="form-group">
              <label for="inputPassword" class="control-label col-xs-5">Phone Number</label>
              <div class="col-xs-7">
                <input type="text" class="form-control" value="<?= $admin_data->phone; ?>" name="phone" id="phone" placeholder="Phone">
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword" class="control-label col-xs-5">Verify Password</label>
              <div class="col-xs-7">
                <input type="password" class="form-control" id="vpassword" name="vpassword"  placeholder="Password">
              </div>
            </div>
         
        </div>
      </div>
      <div class="col-md-3 col-sm-4 twitter_pan">
        <div class="input-group">
          
            <div class="form-group">
              <label for="inputEmail" class="control-label col-xs-5">Email</label>
              <div class="col-xs-7">
                <input type="email" class="form-control" value="<?= $admin_data->email; ?>" name="email" id="email"  >
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail" class="control-label col-xs-5">Twitter</label>
              <div class="col-xs-7 twitter_form">
                <img alt="" class="img-responsive f_l x_img" src="<?= SITE_URL; ?>/img/twitter.png">
                <p class="twitter">
								<?php
								if($admin_data->twitter_id != ''){   ?>
								<a href="unlink_twitter" >UNLINK TWITTER</a>
								
								<?php } else {?>
								<a href="connect_twitter" target="blank" >LINK TWITTER</a>
								<?php } ?>
								</p>
              </div>
            </div>
         
        </div>
      </div>
      <div class="col-md-2 col-sm-4 cell_pad">
	  <input type="submit" class="save_profile" value="SAVE PROFILE" />
     
      </div>
	    
    </div>
	</form>
  </div>
</div>