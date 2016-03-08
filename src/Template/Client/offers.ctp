<div class="Offerz_blck"> 
<h3 style="text-align:center; background:yellow;">In progress Section...</h3>
<div class="container">
  <div class="row my_shared_offerz">
  <div class="flash_msg"><?=$this->Flash->render();?></div>
  
    <div class="col-md-12">
      <div class="col-md-6 col-sm-6">
        <h1>Offerz</h1>
      </div>
      <div class="col-md-6 col-sm-6">
        <button class="create_new" onclick="create_new_offr();">CREATE NEW</button>
      </div>
    </div>
	<form class="form-group" method="POST" id="offer_form_new">
    <div class="col-md-12 editable_user" id="new_offer_div">
      <div class="col-md-9 col-sm-9">
        <div class="row">
          <div class="col-md-12 col-sm-12">
				<div class="form-group campaign_blck">
              <input type="text" class="form-control" placeholder="Campaign title here" name="offer_title" required/>
				</div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2 col-sm-2">
            <div id="preview_">
              <img src="<?= SITE_URL; ?>/img/upload_img.jpg" alt="upload_img" class="img-responsive"/>
            </div>
              <p class="add_photo"><span id="add_image_offer" class="right_nmbr">ADD PHOTO</span></p>
          </div>
          <div class="col-md-10 col-sm-10">
            
           
            <textarea  required class="form-control custom-control edit_blck" rows="4" placeholder="EDITABLE BY USER"  name="editable_text" id="editable_text" maxlength="124" minlength="0"  onkeyup="check_word_len_editable(this);"></textarea> 
			<textarea required class="form-control custom-control enter_blck" rows="2" placeholder="Not EDITABLE BY USER" name="not_editable_text" id="not_editable_text" minlength="0" maxlength="124" onkeyup="check_word_len(this);"></textarea> 
              <p class="numb_blck "> <span class="right_nmbr chars">140</span> </p>
			  
            
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-3">
        
          <div class="radio">
            <label class="text_radio_b">
              <input type="radio" required value="now" name="start_date">
              START IMMEDIATELY</label>
          </div>
          <div class="radio">
            <label class="text_radio_b">
               <input type="radio" required name="start_date" value="later">
              CHOOSE START DATE</label>
          </div>
        
        <div id='datepicker'></div>
		<input type="hidden" id="datepicker_val" name="date_send_on" />
      </div>
    <div class="col-md-6 col-sm-6 pull-right">
        <button class="submit_btn">SUBMIT</button>
      </div>
	 </form>
    </div>
    
  </div>
  
  <!-- ================== ROW STARTS ========================= -->
	<?php foreach($all_offer_data as $data_offer){
	$offer_id = $data_offer['id'];
	$offer_title = $data_offer['title'];
	$offer_editable = $data_offer['editable_text'];
	$is_paused = $data_offer['is_paused'];
	$offer_not_editable = $data_offer['not_editable_text'];
	$img_name = $data_offer['image_name']?$data_offer['image_name']:'no_img.jpg';
		  
	?>
 
	<div class="row" id="offer_row_<?=$offer_id;?>">
    <div class="col-md-12">
      <div class="panel-group" id="panel-527391"> 
        
        <!------accordian-7-------->
        <div class="panel panel-default">
          <div class="panel-heading bottom_accordion">
            <div class="row">
              <div class="col-md-2 col-sm-2">
                <a class="fancybox" href="<?=SITE_URL;?><?=OFFER_IMG_PATH;?><?=$img_name;?>"> <img class="img-responsive" src="<?=SITE_URL;?><?=OFFER_IMG_PATH;?><?=$img_name;?>" width="120" height="120"></a>
              </div>
              <div class="col-md-3 col-sm-3">
                <div class="big_friest_text">
                  <h5><?=$data_offer['title'];?> </h5>
                  <p><?=date('F d, Y',strtotime($data_offer['created_at']));?></p>
                </div>
              </div>
              <div class="col-md-3 col-sm-3">
                <div class="impression_text">
                  <h5><?=round($data_offer['followers_count'],0);?> </h5>
                  <p>IMPRESSIONS</p>
                </div>
              </div>
              <div class="col-md-3 col-sm-3">
                <div class="complete_text">
                  <h5><?=round($data_offer['comp_perc'],0);?>% </h5>
                  <p>COMPLETE</p>
                </div>
              </div>
              <div class="col-md-1 col-sm-1"> <a aria-expanded="false" class="panel-title collapsed" data-toggle="collapse" data-parent="#panel-527391" href="#panel-element-<?=$data_offer['id'];?>"> <i class="fa cu_toggle fa-bars"></i> </a> </div>
            </div>
          </div>
          <div aria-expanded="false" style="height: 0px;" id="panel-element-<?=$data_offer['id'];?>" class="panel-collapse collapse">
            <div class="row">
              <div class="table-responsive min_table">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th width="14%"> <div class="connects_34">
                          <img alt="influncer" src="<?= SITE_URL; ?>/img/face_table_min.png" class="img-responsive">
                          <h3>34,544
                            <p>likes </p>
                          </h3>
                        </div></th>
                      <th width="10%"> <div class="connects_34">
                          <h3>3,763
                            <p>shares</p>
                          </h3>
                        </div></th>
                      <th width="17%"> <div class="connects_34">
                          <img alt="influncer" src="<?= SITE_URL; ?>/img/twitter_table_min.png" class="img-responsive">
                          <h3>124,872
                            <p>retweets </p>
                          </h3>
                        </div></th>
                      <th width="11%"><div class="connects_34">
                          <h3>21,635
                            <p> likes </p>
                          </h3>
                        </div></th>
                      <th width="15%"><div class="connects_34">
                          <img alt="influncer" src="<?= SITE_URL; ?>/img/instagram_table_min.png" class="img-responsive">
                          <h3>17,827
                            <p>likes</p>
                          </h3>
                        </div></th>
                      <th width="6%"> <div class="connects_34">
                          <h3>2,837
                            <p>comments</p>
                          </h3>
                        </div></th>
                      <th width="6%"> <div class="connects_34">
                          <a href="javascript:void(0);" onclick="delete_offer(<?=$offer_id;?>);" title="Delete Offer"><img src="<?= SITE_URL; ?>/img/delete_btn.png" class="img-responsive" alt="del"></a>
                        </div>
                      </th>
                    </tr>
                  </thead>
                </table>
              </div>
            </div>
            <div class="row offerz_tabs">
              <div class="col-md-12">
                <div> 
                  <!-- ====================== NAV TABS ==========================  -->
                  <ul role="tablist" class="nav nav-tabs pause_offer">
                    <li class="active" role="presentation"><a data-toggle="tab" role="tab" aria-controls="home_<?=$data_offer['id'];?>" href="#home_<?=$data_offer['id'];?>" aria-expanded="true">Shared By</a></li>
                    <li role="presentation" class=""><a data-toggle="tab" role="tab" aria-controls="profile_<?=$data_offer['id'];?>" href="#profile1_<?=$data_offer['id'];?>" aria-expanded="false">Not Shared</a></li>
                    <li role="presentation" class=""><a data-toggle="tab" role="tab" aria-controls="profile_<?=$data_offer['id'];?>" href="#profile2_<?=$data_offer['id'];?>" aria-expanded="false">Edit Offer</a></li>
                  </ul>
				  <!-- ============ Nav tabs ENds ============= -->
                  <ul class="nav pause_offer_1">
                    <li role="presentation"><a href="javascript:void(0);" onclick="pauseOffer(1,<?=$offer_id;?>,this );" class="<?=$is_paused=='1'?'resume_offer_btn':'pause_offer_btn';?>" id="resume_btn">Resume Offer <i class="fa fa-play"></i></a></li>
                    <li role="presentation"><a href="javascript:void(0);" onclick="pauseOffer(0, <?=$offer_id;?>,this );" class="<?=$is_paused=='0'?'resume_offer_btn':'pause_offer_btn';?>" id="pause_btn"> Pause offer <i class="fa fa-pause"></i></a></li>
                  </ul>
                  <!-- Tab panes -->
                  <div class="tab-content">
					<!-- =================== SHARED BY USERS DETAILS ============= -->
                    <div id="home_<?=$data_offer['id'];?>" class="tab-pane active" role="tabpanel">
                      <div class="table-responsive shared_table">
                        <table class="table table-striped">
                          <thead>
							<!-- ========= LOOP TO SHOW USER WHO SHARED OFFER ============= -->
							<?php 
							$i=0;
							foreach($data_offer['user_offers'] as $users_data){
							if($users_data['status']=='1'){ // User shared offer
							$i++;
							?>
                            <tr>
                              <th width="16%"> <div class="shared_blk">
                                  <img class="twt_small_pic" alt="influncer" src="<?=$users_data['user']['twt_pic'];?>">
                                  <h3><?=$users_data['user']['name'];?> </h3>
                                  <span><?=$users_data['user']['screen_name'];?> </span> </div></th>
                              <th width="10%"> <div class="shared_blk_1">
                                  <img alt="influncer" src="<?= SITE_URL; ?>/img/shared_facebook_icon.png">
                                  <h3>10,544
                                    <p>likes </p>
                                  </h3>
                                </div></th>
                              <th width="10%"> <div class="shared_blk_1">
                                  <h3>521
                                    <p>shares</p>
                                  </h3>
                                </div></th>
                              <th width="12%"> <div class="shared_blk_1">
                                  <img alt="influncer" src="<?= SITE_URL; ?>/img/shared_twitter_icon.png">
                                  <h3>18,872
                                    <p>retweets </p>
                                  </h3>
                                </div></th>
                              <th width="11%"><div class="shared_blk_1">
                                  <h3>5,821
                                    <p> likes </p>
                                  </h3>
                                </div></th>
                              <th width="10%"><div class="shared_blk_1">
                                  <img alt="influncer" src="<?= SITE_URL; ?>/img/shared_instagram_icon.png">
                                  <h3>1,473
                                    <p>likes</p>
                                  </h3>
                                </div></th>
                              <th width="6%"> <div class="shared_blk_1">
                                  <h3>334
                                    <p>comments</p>
                                  </h3>
                                </div></th>
                            </tr>
							<?php } }
							if($i==0){
							echo "<tr><th><h3>No User has shared offer yet!</h3></th></tr>";
							}
							?>
                          </thead>
                        </table>
                      </div>
                    </div>
					
					<!-- ================ NOT SHARED BY USERS DETAILS HERE =================== -->
                    <div id="profile1_<?=$data_offer['id'];?>" class="tab-pane" role="tabpanel">
                      <div class="table-responsive shared_table">
                        <table class="table table-striped">
                          <thead>
     
                            <tr>
							<?php foreach($data_offer['user_offers'] as $users_data){
							if($users_data['status']!='1'){ ?>
                              <th width="20%"> <div class="shared_blk">
                                  <img class="twt_small_pic" alt="influncer" src="<?=$users_data['user']['twt_pic'];?>">
                                  <h3><?=$users_data['user']['name'];?> </h3>
                                  <span><?=$users_data['user']['screen_name'];?> </span> </div></th>
                                  
                                  <?php } } ?>
    
                            </tr>

                          </thead>
                        </table>
                      </div>
                    </div>
					
                    <!-- ================== EDIT OFFERS HERE ==================== -->
                    <div id="profile2_<?=$data_offer['id'];?>" class="tab-pane" role="tabpanel">
					 <form class="form-group campaign_blck" style="width:100%;">
                      <div class="col-md-12 editable_user">
      <div class="col-md-9 col-sm-9">
        <div class="row">
          <div class="col-md-12 col-sm-12">
           
              <input required type="text" class="form-control" placeholder="Title" id="offer_title" name="offer_title" value="<?php echo $offer_title; ?>"/>
              
              <ul>
              	
                <li> <a href="#" class="active1"> <i class="fa fa-twitter"></i>
Twitter</a> </li>
                
                <li>
                 <a href="#"> <i class="fa fa-facebook"></i> Facebook </a>
                </li>

                <li>
               <a href="#"> <i class="fa fa-instagram"></i>  Instagram </a>
                </li>                                
                
              
              
              </ul>
            
          </div>
        </div>
        <div class="row">
          <div class="col-md-2 col-sm-2">
		  
           <div id="preview_<?php echo $offer_id;?>">
		   <?php
		   $img_name = $data_offer['image_name']?$data_offer['image_name']:'no_img.jpg';
		   ?>
						<img alt="No Image" class="img-responsive f_l gallery_img" id="gallery_img<?php echo $offer_id; ?>" src="<?=SITE_URL;?><?=OFFER_IMG_PATH;?><?=$img_name;?>"/>
						</div>
              <p class="add_photo" onclick="update_pic(<?php echo $offer_id;?>);"><span id="add_image_offer<?php echo $offer_id; ?>">CHANGE PHOTO</span></p>
            
          </div>
          <div class="col-md-10 col-sm-10">
           
             <textarea  required class="form-control custom-control edit_blck" rows="3" placeholder="EDITABLE BY USER"  name="editable_text" id="editable_text" maxlength="124" minlength="0"  onkeyup="check_word_len_editable(this);" style="height:auto;" ><?=$offer_editable;?></textarea> 
			<textarea required class="form-control custom-control enter_blck" rows="2" placeholder="Not EDITABLE BY USER" name="not_editable_text" id="not_editable_text" minlength="0" maxlength="124" onkeyup="check_word_len(this);" style="height:auto;"><?=$offer_not_editable;?></textarea> 
			<input type="hidden" id="offer_id" name="offer_id" value="<?php echo $offer_id;?>"/>
                <p><span>
				<?=$data_offer['start_date']=='now'?$data_offer['date_send_on']:$data_offer['created_at'];?>
				</span></p><p class="numb_blck"> <span class="right_nmbr chars">140</span> </p>
           
          </div>
        </div>
      </div>
     
    </div>
    
    <div class="col-md-12">
      
      <div class="col-md-6 col-sm-6">
	  <a href="javascript:void(0);" class="submit_btn" onclick="editOffer(this);">SUBMIT</a>
        
      </div>
	   </form>
    </div>
                    </div>
					
					<!-- ================== EDIT OFFERS ENDS HERE ================ -->
                  </div>
					<!-- ================== ENDS TABS CONTENTE ENDS HERE ================ -->
                </div>
              </div>
            </div>
            
            
            
            
            <div class="row offerz_tabs">
              <div class="col-md-12">
                <a class="export_btn" href="#"> EXPORT </a>
              </div>
            </div>
          </div>
        </div>
        
        
      </div>
    </div>
  </div>
  <?php } ?>
  <?php if($this->Paginator->numbers()){
  ?>
	<div id="pagination_div">
	<?= $this->Paginator->prev('« Previous') ?>
		<?php echo $this->Paginator->numbers();?>
		
		<?= $this->Paginator->next('Next »') ?>
	</div>
<?php  } ?>
  <!-- ================================= ROW ENDS HERE ======================== -->
</div>
</div>
<div id="ajax_form" >
<form id="imageform" method="post" enctype="multipart/form-data" action='uploadfile' style="clear:both">

<div id='imageloadstatus' style='display:none'><img src="loader.gif" alt=""/></div>
<div id='imageloadbutton'>
<div class="file-wrap">
 <input type="file" name="photos[]" id="photoimg" />
</div>

<input type="hidden" name="offer_id_temp" id="offer_id_temp" />
</div>
</form>
</div>