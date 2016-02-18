<div class="container-fluid social_teams">
  <div class="container"> 
<div class="row my_social_terms">
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
                <td><div class="influence_col">
                    <img alt="image" src="<?=$displayClient['twt_pic'];?>" style="border-radius:30px;">
                    <p><?=$displayClient['name'];?><br>
                      <?=$displayClient['screen_name'];?></p>
                  </div></td>
                <td><?=$displayClient['email'];?><br>
                  <span><?=date("m/d/Y",strtotime($displayClient['created_at'])); ?></span></td>
                <td><?=$displayClient['twt_followers'];?></td>
                <td></td>
                <td>10/12/2106</td>
                <td><a href="javascript:void(0);" onclick="del_influezer('<?=$displayClient['id'];?>')" >
                  <img alt="delt" src="<?= SITE_URL; ?>/img/delete_btn.png" title="Delete">
                  </a></td>
              </tr>
			<?php } ?>
			</tbody>
          </table>
    </div>
</div>
</div>
</div>
</div>