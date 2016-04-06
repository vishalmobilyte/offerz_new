<div class="container-fluid top_bg">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-5 col-sm-4">
					<a href="#"><img alt="" class="img-responsive f_l" src="<?php echo SITE_URL; ?>/img/logo.png"></a>
				</div>
				<div class="col-md-7 col-sm-8 main_menu">
					<button class="navbar-toggle collapsed" data-target=".bs-navbar-collapse" data-toggle="collapse" type="button">
						<span id="t-button" class="glyphicon glyphicon-align-justify"></span>
					</button>
					<nav class="navbar-collapse bs-navbar-collapse collapse right_menu" role="navigation" style="height: 1px;">
						<ul class="nav navbar-nav">
					<?php 
					if($this->request->session()->check('Admin.id')){ 
					//$get_user_data = get_user_data($_SESSION['user_id']);
					
					?>
					
					
							<li><a class="r_brdr" href="<?php echo SITE_URL.'admin/analytics'; ?>">ANALYTICS</a></li>
							<li><a class="r_brdr" href="<?php echo SITE_URL.'admin/users'; ?>">USERS</a></li>
							<!-- <li><a class="r_brdr" href="profile.php">PROFILE</a></li> -->
							 <li><a class="r_brdr" href="javascript:void(0);" onclick="toggle_profile_div();">PROFILE</a></li>
							 <li><a class="r_brdr" href="<?php echo SITE_URL.'admin/influencers'; ?>">INFLUENCERS</a></li>
							<li><a class="r_brdr" href="<?php echo SITE_URL.'admin/offers'; ?>">OFFERS</a></li>
							
							
							<li><a href="logout">LOG OUT</a></li>
						
					<?php } else{ ?>
						<li><a class="r_brdr" href="<?php echo SITE_URL.'admin/login'; ?>">LOGIN</a></li>
						<li><a  href="<?php echo FRONT_SITE_LINK;?>"  target="_blank">SIGN UP</a></li>
					<?php }?>
					</ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
</div>