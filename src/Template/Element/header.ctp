
	<div class="container-fluid top_bg">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-5 col-sm-4">
					<a href="#"><img alt="" class="img-responsive f_l" src="<?php echo SITE_URL; ?>/img/logo.png"></a>
				</div>
				<div class="col-md-7 col-sm-8 main_menu ">
				
				<nav class="navbar navbar-inverse">  
    <div class="navbar-header">
      <button data-target="#myNavbar" data-toggle="collapse" class="navbar-toggle" type="button">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      
    </div>
    <div id="myNavbar" class="collapse navbar-collapse pull-right-c">
      <ul class="nav navbar-nav">
					<?php 
					if($this->request->session()->check('Client.id')){ 
					//$get_user_data = get_user_data($_SESSION['user_id']);
					
					?>
						
					
							<li><a class="r_brdr" href="<?php echo SITE_URL.'client/analytics'; ?>">ANALYTICS</a></li>
							<!-- <li><a class="r_brdr" href="profile.php">PROFILE</a></li> -->
							 <li><a class="r_brdr" href="javascript:void(0);" onclick="toggle_profile_div();">PROFILE</a></li>
							
							
							<li><a class="r_brdr" href="<?php echo SITE_URL.'client/influencer'; ?>">INFLUENCERS</a></li>
							<li><a class="r_brdr" href="<?php echo SITE_URL.'client/offers'; ?>">OFFERZ</a></li>
							<li><a class="r_brdr" href="<?php echo SITE_URL.'client/push'; ?>">PUSH</a></li>
							<?php if(!$this->request->session()->check('Admin.id')){ ?>
							<li><a href="logout">LOG OUT</a></li>
							<?php } ?>
						
					<?php } else{ ?>
						<li><a class="r_brdr" href="<?php echo SITE_URL.'client/login'; ?>">LOGIN</a></li>
						<li><a  href="<?php echo FRONT_SITE_LINK;?>"  target="_blank">SIGN UP</a></li>
					<?php }?>
					</ul>     
    </div> 
</nav>

				</div>
			</div>
		</div>
	</div>
</div>