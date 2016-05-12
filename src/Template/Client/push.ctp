<!--[Notification area]-->

<div class="notification_blck" style="float: none;">
  <div class="container noti_cont">
    <div class="not-area">
      <h2>Notification</h2>
	 <?php if(!empty($options))
						{
							?>
		  <?php echo $this->Form->create('',['id' => 'noti_form']); ?>
		  <div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					
				
					  <div class="form-group not-lft">
					  <?php 
					  echo $this->form->input('notifications', ["type" => "textarea","rows" => "7", "cols" => "5", "placeholder" => "Enter text here", "required" => "true", "id" => "comment", "class" => "form-control"] );
					  ?>
						
						
							
					  <?php
					?>
					  </div>
					</div>
								
								
								
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" >
						
							<div class="flash_msg"><?=$this->Flash->render();?></div>
						<?php
						
							echo $this->Form->input('selectuser', array(
													'options' => $options,
													'type' => 'select',
													'id'=>'my-select',
													'class'=>'myDropdown',
													'label' => 'Search Recipient',
													'name'=>'character',
													// 'default'=>'',
													// 'required' => true,
													'multiple' => true
												   )
												); 
						
												
								?>
						  <div class="not-rgt">
						  <span class="errorTxt"></span>
						  <div class="separator"></div>
							<div class="radio radio-1">
							  <p id="sendvia">Send Message Via</p>
							  <?php
							  echo $this->Form->radio(
											'Sendmessagevia',
											[
												['value' => 'app', 'text' => 'Push App'],
												['value' => 'email', 'text' => 'Email', 'checked'=>'checked'],
												
											]
										);
								?>
							</div>
							<div class="separator"></div>
							<div class="not-search-user"> 
							
							  <?php
										
							echo $this->Form->submit('SEND',['class'=>'send_notification']);
						
							 ?>
						
						  </div>
						</div>
					  </div>
									
							 
		</div>
							<?php echo $this->Form->end(); ?>
		<?php }
						else
						{
							echo '<h3>No Records Found...</h3>';
						}
						?>
  </div>
</div>
</div>
<!--[/Notification area]--> 
	<!--mycode-->