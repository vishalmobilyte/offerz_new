<div class="container-fluid social_teams">
  <div class="container"> 
    <!------accordian--------->
    <div class="row my_social_terms">
      <div class="col-md-12">
        <div class="col-md-7 col-sm-7">
          <h1>Influencers</h1>
        </div>
        <div class="col-md-2 col-sm-2">
          <div class="influnce_300">
            <img alt="influencer" src="<?= SITE_URL; ?>/img/influence_img.png">
            
            <h3> <?=$count_influencers;?>
              <p> INFLUENCERS </p>
            </h3>
          </div>
        </div>
        <div class="col-md-3 col-sm-3">
          <div class="connects_277">
            <img alt="influncer" src="<?= SITE_URL; ?>/img/influence_img_2.png">
            <h3><?=$total_connections?$total_connections:'0';?>
              <p> CONNECTIONS </p>
            </h3>
          </div>
        </div>
      </div>
      <div class="col-md-12 add_filter_blck">
        <div class="col-md-6 col-sm-6 add_influncer_text">
		<form id="invites_form">
        <div class="input-group">
		
			<input type="hidden" name="client_id" id="client_id" value="<?=$client_data->id;?>"/>
			
            <input type="text" id="email_influencer" aria-describedby="basic-addon2" placeholder="Recipient's email" name="email_influencer" class="form-control">
		</div>	
            <div class="input-group1">   <span id="basic-addon2" class="input-group-addon add_invite_span" onclick="add_influencer();">ADD</span> 
		</div>
		
		</form>
            
        </div>
        <div class="col-md-6 col-sm-6 filter_name">
          <div class="input-group">
            <input type="text" aria-describedby="basic-addon2" placeholder="Search" class="form-control" id="searchbox">
              </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="table-responsive influence_table">
          <table class="table table-striped datatable" id="exp_dtat">
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
             
				<?php 
				foreach($invites_data as $data_inf){
				$is_accepted = $data_inf['is_accepted'];
				if($data_inf['os']['total_offer_received'] >0){
				$offer_share_perc = intval(($data_inf['os']['offer_accepted']/$data_inf['os']['total_offer_received'])*100);
				}
				else{
				$offer_share_perc = 0;
				}
				?>
				<?php if($is_accepted == '0' || $is_accepted == '2'){ ?>
				<tr id="tr_<?=$data_inf['id'];?>">
                <td><div class="influence_col">
					<?php $img_invt = $is_accepted=='0'?'table_3.png':'table_10.png'; ?>
                    <img alt="table_1" src="<?= SITE_URL; ?>img/<?=$img_invt;?>" >
                    <p class="date"> <?=date("m/d/Y",strtotime($data_inf['created_at'])); ?></p>
                  </div></td>
                <td><?=$data_inf['email'];?></td>
                <td>0</td>
                <td></td>
                <td>&nbsp;</td>
                <td><a href="javascript:void(0);" onclick="del_influezer('<?=$data_inf['id'];?>')" >
                  <img alt="delt" src="<?= SITE_URL; ?>img/delete_btn.png">
                  </a></td>
              </tr>
				<?php } else{
				?>
			 <tr id="tr_<?=$data_inf['id'];?>">
                <td><div class="influence_col">
                    <img alt="image" src="<?=$data_inf['u']['twt_pic'];?>" style="border-radius:30px;">
                    <p><?=$data_inf['u']['name'];?><br>
                      <?=$data_inf['u']['screen_name'];?></p>
                  </div></td>
                <td><?=$data_inf['u']['email'];?><br>
                  <span><?=date("m/d/Y",strtotime($data_inf['u']['created_at'])); ?></span></td>
                <td><?=$data_inf['u']['twt_followers']?$data_inf['u']['twt_followers']:"0";?></td>
                <td><?=@$offer_share_perc;?>%</td>
                <td><?=$data_inf['os']['last_offer_date']?date('m/d/Y',strtotime($data_inf['os']['last_offer_date'])):'';?></td>
                <td><a href="javascript:void(0);" onclick="del_influezer('<?=$data_inf['id'];?>')" >
                  <img alt="delt" src="<?= SITE_URL; ?>/img/delete_btn.png" title="Delete">
                  </a></td>
              </tr>
            <?php }
			} ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-----end-accordian---------> 
    
  </div>
</div>