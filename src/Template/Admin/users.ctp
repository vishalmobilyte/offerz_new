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
					<h3><?php echo $total_connections; ?>
					  <p> CONNECTIONS </p>
					</h3>
			    </div>
			</div>
        </div>
        <div class="col-md-12 add_filter_blck">
			<div class=" add_influncer_text">
			    <ul class="nav nav-tabs nav_tab_w pause_offer">
					<li class="active"><a data-toggle="tab" href="#dashboard">Dashboard</a></li>
					<li><a href="<? echo SITE_URL;?>/admin/influencers">Mobile</a></li>

<div class="col-md-6 col-sm-6 filter_name pull-right ">
			    <div class="input-group pull-right">
				   <input type="text" aria-describedby="basic-addon2" placeholder="Filter by Name, Followers, Share %" class="form-control" id="searchbox">
				</div>
			</div>
			    </ul>
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
										<?php if($displayClient['screen_name'])
										{?>
										    <img alt="image" src="<?=$displayClient['twt_pic'];?>" style="border-radius:30px;">
										<?php }
										else{ ?>
											<img alt="image" src="<?= SITE_URL; ?>img/no_men.png" style="border-radius:30px;">
										<?php } ?>
											<p><?=$displayClient['name'];?><br>
											  <span class="twitter_name"><?=$displayClient['screen_name'];?></span><br></p>
											  
										</div>
										<?php echo 'Influencers:	'.count($displayClient['invites']);?>
									</td>
									<td>
									     <?=$displayClient['email'];?><br>
										  <span><?=date("m/d/Y",strtotime($displayClient['created_at'])); ?></span>
									</td>
									<td>
									   <?=$displayClient['twt_followers'];?>
									</td>
									<td>
									<?php 
									$total_offer_accepted=0;
									$total_offer_received=0;
									if($displayClient['offers_stat'])
									{
										// if($displayUsers['offers_stat'][0]['offer_accepted']!=0)
										// {
									foreach ($displayClient['offers_stat'] as $k) 
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
									
									
									
									</td>
									<td>
									<?php
									$mostRecent= 0;
									if($displayClient['offers_stat'])
									{
									foreach ($displayClient['offers_stat'] as $k) 
									{
										//pr($k);die;
										//pr($k['last_offer_date']);
										if($k['last_offer_date'])
										{
										//pr($k['last_offer_date']);
										$curDate = strtotime($k['last_offer_date']);
										  if ($curDate > $mostRecent)
												{
													 $mostRecent = $curDate;
												}
										}
										
										else
										{
											$mostRecent= $mostRecent;
										}
										
										
									}
									}
									else
									{
										$mostRecent= 0;
									}
									echo $mostRecent==0?' ':date('d/m/Y', $mostRecent);;
									?>
										
									</td>
									<td>
									     <a href="javascript:void(0);" onclick="del_users('<?=$displayClient['id'];?>')" >
										  <img alt="delt" src="<?= SITE_URL; ?>/img/delete_btn.png" title="Delete">
										   <?php echo $this->Html->link($this->Html->image('eyelogo.jpg',array('alt'=>'viewuser')), ['action' => 'viewuser',$displayClient['id']], array('target'=>'_blank','escape'=>false)); ?>
										  
										  </a>
									</td>	
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>	
				<span id="export"><?php echo $this->Html->link('EXPORT',[
			'controller' => 'Admin', 
			'action' => 'exportUsers'],
			['class' =>'export_btn']
			
				); ?>	</span>			
            </div>
			<div id="" class="row my_social_terms tab-pane fade">
			  
			</div>
			
	    </div>
		
	</div>
</div>
