<!----content----->
<div class="container">
  <div class="row Under_Armour">
    <div class="col-md-12">
      <div class="col-md-5 col-sm-5">
        <img alt="" class="img-responsive f_l x_img" src="<?= SITE_URL; ?>/img/img_x.png">
        <p class="under_armr_text"><?= $client_data->name; ?></p>
        <p class="under_armr_text_btm"><?= $client_data->screen_name?'@'.$client_data->screen_name:''; ?></p>
        <p class="text_btm"><?= $client_data->description; ?></p>
      </div>
      <div class="col-md-7 col-sm-7">
        <div class="col-md-3 col-sm-3">
          <p class="nmbr">8,682<br>
            <span class="scl_text">Tweets</span></p>
        </div>
        <div class="col-md-3 col-sm-3">
          <p class="nmbr">10.5K<br>
            <span class="scl_text">Followers</span></p>
        </div>
        <div class="col-md-3 col-sm-3">
          <p class="nmbr">1192<br>
            <span class="scl_text">Retweets</span></p>
        </div>
        <div class="col-md-3 col-sm-3">
          <p class="nmbr_2">852<br>
            <span class="scl_text">Favorites</span></p>
        </div>
      </div>
    </div>
    
<div class="col-md-12">
  <div class="col-md-6 edit_prof_div"  onclick="toggle_profile_div();">
            <img src="<?= SITE_URL; ?>/img/setting.png" class="img-responsive f_l x_img" alt=""  />
    <p class="edit_prfile" >EDIT PROFILE<a href=""> </a></p><a href="">
  </a></div>
            
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
                <input type="text" class="form-control" value='<?= $client_data->name; ?>' id="inputName" name="name" placeholder="Under Armour">
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
                <input type="text" class="form-control" value="<?= $client_data->phone; ?>" name="phone" id="phone" placeholder="Phone">
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
                <input type="email" class="form-control" value="<?= $client_data->email; ?>" name="email" id="inputEmail"  placeholder="Under Armour">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail" class="control-label col-xs-5">Twitter</label>
              <div class="col-xs-7 twitter_form">
                <img alt="" class="img-responsive f_l x_img" src="<?= SITE_URL; ?>/img/twitter.png">
                <p class="twitter">
								<?php
								if($client_data->twitter_id != ''){   ?>
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
        <button class="save_profile">SAVE PROFILE</button>
      </div>
    </div>
	</form>
  </div>
</div>