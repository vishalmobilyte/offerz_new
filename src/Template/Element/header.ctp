<div class="container-fluid top_bg">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="col-md-5 col-sm-4">
					<a href="#"><img alt="" class="img-responsive f_l" src="img/logo.png"></a>
				</div>
				<div class="col-md-7 col-sm-8 main_menu">
					<button class="navbar-toggle collapsed" data-target=".bs-navbar-collapse" data-toggle="collapse" type="button">
						<span id="t-button" class="glyphicon glyphicon-align-justify"></span>
					</button>
					<nav class="navbar-collapse bs-navbar-collapse collapse right_menu" role="navigation" style="height: 1px;">
						<ul class="nav navbar-nav">
					<?php 
					if($this->request->session()->check('User.user_id')){ 
					//$get_user_data = get_user_data($_SESSION['user_id']);
					
					?>
					
					
							<li><a class="r_brdr" href="<?php echo ROOT; ?>">HOME</a></li>
							<!-- <li><a class="r_brdr" href="profile.php">PROFILE</a></li> -->
							 <li><a class="r_brdr" href="javascript:void(0);" onclick="toggle_profile_div();">PROFILE</a></li>
							
							
							<li><a class="r_brdr" href="#teams">TEAMS</a></li>
							<li><a class="r_brdr" href="#offers">OFFERZ</a></li>
							<li><a class="r_brdr" href="#support">SUPPORT</a></li>
							<li><a href="process/logout.php">LOG OUT</a></li>
						
					<?php } else{ ?>
						<li><a class="r_brdr" href="login.php">LOGIN</a></li>
						<li><a  href="">SIGN UP</a></li>
					<?php }?>
					</ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
</div>