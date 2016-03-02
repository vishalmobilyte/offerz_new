<div class="container-fluid">
    <div class="container"> 
		<div class="col-md-12">
			<div class="col-md-5 col-sm-5">
			    <h1>Users</h1>
			</div>
			<div class="col-md-2 col-sm-2">
			    <div class="influnce_300">
					<img alt="influencer" src="<?= SITE_URL; ?>/img/influence_img.png">
					<h3> <?php echo $Clientcount; ?>
					  <p> Corporations </p>
					</h3>
			    </div>
			</div>
			<div class="col-md-2 col-sm-2">
			    <div class="influnce_300">
					<img alt="influencer" src="<?= SITE_URL; ?>/img/influence_img.png">
					<h3> <?php echo $Userscount; ?>
					  <p> INFLUENCERS </p>
					</h3>
			    </div>
			</div>
			<div class="col-md-3 col-sm-3">
			    <div class="connects_277">
					<img alt="influncer" src="<?= SITE_URL; ?>/img/influence_img_2.png">
					<h3>2,773,873
					  <p> CONNECTIONS </p>
					</h3>
			    </div>
			</div>
        </div>
        <div class="col-md-12 add_filter_blck">
			<div class="col-md-6 col-sm-6 add_influncer_text">
			    <ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#dashboard">Dashboard</a></li>
					<li><a  href="<?php echo SITE_URL; ?>admin/influencers">Mobile</a></li>
			    </ul>
			</div>
			<div class="col-md-6 col-sm-6 filter_name">
			    <div class="input-group">
				   <input type="text" aria-describedby="basic-addon2" placeholder="Filter by Name, Followers, Share %" class="form-control" id="searchbox">
				</div>
			</div>
        </div>
        <div class="tab-content">
			<div id="dashboard" class="row my_social_terms tab-pane fade in active">
				<div class="col-md-12">
					<div class="table-responsive influence_table">
						<table class="table table-striped datatable">
							<thead>
								<tr class="influencer_th">
									<th width="21%">INFLUENCER</th>
									<th width="30%">CONTACT / MEMBER SINCE</th>
									<th width="17%">FOLLOWERS</th>
									<th width="11%">SHARE %</th>
									<th width="15%">LAST OFFER</th>
									<th width="6%"></th>
								</tr>
							</thead>
						    <tbody>
								<?php foreach($Clientlisting as $displayClient) { ?>
								<tr id="tr_<?=$displayClient['id'];?>">
									<td>
									    <div class="influence_col">
										    <img alt="image" src="<?=$displayClient['twt_pic'];?>" style="border-radius:30px;">
											<p><?=$displayClient['name'];?><br>
											  <?=$displayClient['screen_name'];?></p>
										</div>
									</td>
									<td>
									     <?=$displayClient['email'];?><br>
										  <span><?=date("m/d/Y",strtotime($displayClient['created_at'])); ?></span>
									</td>
									<td>
									   <?=$displayClient['twt_followers'];?>
									</td>
									<td>
									</td>
									<td>
									    10/12/2106
									</td>
									<td>
									     <a href="javascript:void(0);" onclick="del_users('<?=$displayClient['id'];?>')" >
										  <img alt="delt" src="<?= SITE_URL; ?>/img/delete_btn.png" title="Delete">
										  </a>
									</td>	
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>		
            </div>
			<div id="" class="row my_social_terms tab-pane fade">
			  
			</div>
	    </div>
	</div>
</div>
