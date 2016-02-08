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
            <h3>2,773,873
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
			
            <input type="text" aria-describedby="basic-addon2" placeholder="Recipient's username" name="email_influencer" class="form-control">
		</div>	
            <div class="input-group1">   <span id="basic-addon2" class="input-group-addon add_invite_span" onclick="add_influencer();">ADD</span> 
		</div>
		
		</form>
            
        </div>
        <div class="col-md-6 col-sm-6 filter_name">
          <div class="input-group">
            <input type="text" aria-describedby="basic-addon2" placeholder="Filter by Name, Followers, Share %, last" class="form-control" id="searchbox">
              </div>
        </div>
      </div>
      <div class="col-md-12">
        <div class="table-responsive influence_table">
          <table class="table table-striped datatable">
            <thead>
              <tr>
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
				foreach($invites_data as $data_inf){ ?>
				<?php if($data_inf['invites']['is_accepted'] == '0' || $data_inf['invites']['is_accepted'] == '2'){ ?>
				<tr>
                <td><div class="influence_col">
                    <img alt="table_1" src="<?= SITE_URL; ?>img/table_3.png">
                    <p class="date"> 10/15/2016</p>
                  </div></td>
                <td><?=$data_inf['invites']['email'];?></td>
                <td>&nbsp;</td>
                <td></td>
                <td>&nbsp;</td>
                <td><a href="#">
                  <img alt="delt" src="<?= SITE_URL; ?>img/delete_btn.png">
                  </a></td>
              </tr>
				<?php } else{
				?>
			 <tr>
                <td><div class="influence_col">
                    <img alt="table_1" src="<?= SITE_URL; ?>/img/table_1.png">
                    <p><?=$data_inf['u']['name'];?><br>
                      @TheMandrake</p>
                  </div></td>
                <td><?=$data_inf['u']['email'];?><br>
                  <span>10/10/2016</span></td>
                <td>865,767</td>
                <td>82%</td>
                <td>10/12/2106</td>
                <td><a href="#">
                  <img alt="delt" src="<?= SITE_URL; ?>/img/delete_btn.png">
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