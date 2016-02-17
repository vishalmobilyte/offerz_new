<div class="Offerz_blck"> 
<div class="container">
  <div class="row my_shared_offerz">
  <div class="flash_msg"><?=$this->Flash->render();?></div>
  <form class="form-group" method="POST">
    <div class="col-md-12">
      <div class="col-md-6 col-sm-6">
        <h1>Offerz</h1>
      </div>
      <div class="col-md-6 col-sm-6">
        <button class="create_new">CREATE NEW</button>
      </div>
    </div>
    <div class="col-md-12 editable_user">
      <div class="col-md-9 col-sm-9">
        <div class="row">
          <div class="col-md-12 col-sm-12 campaign_blck">
            
              <input type="text" class="form-control" placeholder="Campaign title here" name="offer_title"/>
            
          </div>
        </div>
        <div class="row">
          <div class="col-md-2 col-sm-2">
            <div id="preview_">
              <img src="<?= SITE_URL; ?>/img/upload_img.jpg" alt="upload_img" class="img-responsive"/>
              <p class="add_photo"><span class="right_nmbr"></span></p>
            </div>
          </div>
          <div class="col-md-10 col-sm-10">
            
           
            <textarea  class="form-control custom-control edit_blck" rows="3" placeholder="EDITABLE BY USER"  name="editable_text" id="editable_text" maxlength="124" minlength="0"  onkeyup="check_word_len_editable(this);"></textarea> 
			<textarea  class="form-control custom-control enter_blck" rows="3" placeholder="Not EDITABLE BY USER" name="not_editable_text" id="not_editable_text" minlength="0" maxlength="124" onkeyup="check_word_len(this);"></textarea> 
              <p class="numb_blck"> 140 </p>
			  <p class="add_photo" ><span id="add_image_offer">ADD PHOTO</span><span class="right_nmbr chars">140</span></p>
            
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
    </div>
    
    <div class="col-md-12">
      <div class="col-md-6 col-sm-6">
   
      </div>
      <div class="col-md-6 col-sm-6">
        <button class="submit_btn">SUBMIT</button>
      </div>
    </div>
	 </form>
  </div>
  <div class]="row">
    <div class="col-md-12">
      <div class="panel-group" id="panel-527391"> 
        
        <!------accordian-7-------->
        <div class="panel panel-default">
          <div class="panel-heading bottom_accordion">
            <div class="row">
              <div class="col-md-2 col-sm-2">
                <img class="img-responsive" src="<?= SITE_URL; ?>/img/according_first_img.jpg">
              </div>
              <div class="col-md-3 col-sm-3">
                <div class="big_friest_text">
                  <h5>Big Fries on Fridays! </h5>
                  <p>January 17, 2016</p>
                </div>
              </div>
              <div class="col-md-3 col-sm-3">
                <div class="impression_text">
                  <h5>32,336 </h5>
                  <p>IMPRESSIONS</p>
                </div>
              </div>
              <div class="col-md-3 col-sm-3">
                <div class="complete_text">
                  <h5>91% </h5>
                  <p>COMPLETE</p>
                </div>
              </div>
              <div class="col-md-1 col-sm-1"> <a aria-expanded="false" class="panel-title collapsed" data-toggle="collapse" data-parent="#panel-527391" href="#panel-element-260016yyy"> <i class="fa cu_toggle fa-bars"></i> </a> </div>
            </div>
          </div>
          <div aria-expanded="false" style="height: 0px;" id="panel-element-260016yyy" class="panel-collapse collapse">
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
                          <img src="<?= SITE_URL; ?>/img/delete_btn.png" class="img-responsive" alt="del">
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
                  <!-- Nav tabs -->
                  <ul role="tablist" class="nav nav-tabs pause_offer">
                    <li class="active" role="presentation"><a data-toggle="tab" role="tab" aria-controls="home" href="#home" aria-expanded="true">Shared By</a></li>
                    <li role="presentation" class=""><a data-toggle="tab" role="tab" aria-controls="profile" href="#profile1" aria-expanded="false">Not Shared</a></li>
                    <li role="presentation" class=""><a data-toggle="tab" role="tab" aria-controls="profile" href="#profile2" aria-expanded="false">Edit Offer</a></li>
                  </ul>
                  <ul class="nav pause_offer_1">
                    <li role="presentation"><a href="#" class="resume_offer_btn">Resume Offer <i class="fa fa-play"></i></a></li>
                    <li role="presentation"><a href="#" class="pause_offer_btn"> Pause offer <i class="fa fa-pause"></i></a></li>
                  </ul>
                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div id="home" class="tab-pane active" role="tabpanel">
                      <div class="table-responsive shared_table">
                        <table class="table table-striped">
                          <thead>
                            <tr>
                              <th width="16%"> <div class="shared_blk">
                                  <img alt="influncer" src="<?= SITE_URL; ?>/img/table_2.png">
                                  <h3>Steven Strange </h3>
                                  <span>@Wizardtime </span> </div></th>
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
                          </thead>
                        </table>
                      </div>
                    </div>
                    <div id="profile1" class="tab-pane" role="tabpanel">
                      <div class="table-responsive shared_table">
                        <table class="table table-striped">
                          <thead>
                           
                            
                            <tr>
                              <th width="20%"> <div class="shared_blk">
                                  <img alt="influncer" src="<?= SITE_URL; ?>/img/table_2.png">
                                  <h3>Steven Strange </h3>
                                  <span>@Wizardtime </span> </div></th>
                                  
                                  <th width="20%"> <div class="shared_blk">
                                  <img alt="influncer" src="<?= SITE_URL; ?>/img/table_2.png">
                                  <h3>Steven Strange </h3>
                                  <span>@Wizardtime </span> </div></th>
                              
                                  <th width="20%"> <div class="shared_blk">
                                  <img alt="influncer" src="<?= SITE_URL; ?>/img/table_2.png">
                                  <h3>Steven Strange </h3>
                                  <span>@Wizardtime </span> </div></th>
                            
                                 <th width="20%"> <div class="shared_blk">
                                  <img alt="influncer" src="<?= SITE_URL; ?>/img/table_2.png">
                                  <h3>Steven Strange </h3>
                                  <span>@Wizardtime </span> </div></th>
                                 <th width="20%"> <div class="shared_blk">
                                  <img alt="influncer" src="<?= SITE_URL; ?>/img/table_2.png">
                                  <h3>Steven Strange </h3>
                                  <span>@Wizardtime </span> </div></th>
                                  
                             
                            
                            </tr>
                            
                            
                            
                          </thead>
                          
                           
                          
                          
                        
                        </table>
                      </div>
                    </div>
                    
                    <div id="profile2" class="tab-pane" role="tabpanel">
                      <div class="col-md-12 editable_user">
      <div class="col-md-9 col-sm-9">
        <div class="row">
          <div class="col-md-12 col-sm-12">
            <form class="form-group campaign_blck">
              <input type="text" class="form-control" placeholder="Big Fries on Fridays!"/>
              
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
            </form>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2 col-sm-2">
            <form class="form-group">
              <img src="<?= SITE_URL; ?>/img/upload_img.jpg" alt="upload_img" class="img-responsive"/>
              <p class="add_photo"><span class="right_nmbr"></span></p>
            </form>
          </div>
          <div class="col-md-10 col-sm-10">
            <form class="form-group">
              <textarea class="form-control custom-control edit_blck" placeholder="These look great!" rows="3"></textarea>
              <textarea class="form-control custom-control enter_blck" placeholder="#Big Fries www.bigfries.com" rows="3"></textarea>
              <p class="numb_blck"> 89 </p>
            </form>
          </div>
        </div>
      </div>
      <div class="col-md-3 col-sm-3">
        <form role="form" class="start_immediate_blck">
          <div class="radio">
            <label class="text_radio_b">
              <input type="radio" name="optradio">
              START IMMEDIATELY</label>
          </div>
          <div class="radio">
            <label class="text_radio_b">
              <input type="radio" name="optradio">
              CHOOSE START DATE</label>
          </div>
        </form>
        <img alt="" class="img-responsive f_l" src="<?= SITE_URL; ?>/img/calender.png">
      </div>
    </div>
    
    <div class="col-md-12">
      <div class="col-md-6 col-sm-6">
   
      </div>
      <div class="col-md-6 col-sm-6">
        <button class="submit_btn">SUBMIT</button>
      </div>
    </div>
                    </div>
                  </div>
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
        
        
        
        
        <!-----end-accordian-7--------> 
        
        <!------accordian-8--------> 
        
        <!-----end-accordian-8--------> 
        
      </div>
    </div>
  </div>
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