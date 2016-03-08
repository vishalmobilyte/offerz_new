<!--[Notification area]-->
<div class="notification_blck">
  <div class="container">
    <div class="not-area">
      <h2>Notification</h2>
		  <div class="row">
		  <?php echo $this->Form->create(); ?>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					  <div class="form-group not-lft">
					  <?php 
					  echo $this->form->input('notifications', ["type" => "textarea","rows" => "7", "cols" => "5", "placeholder" => "Enter text here", "required" => "true", "id" => "comment", "class" => "form-control"] );
					  ?>

						
							
					  <?php
					?>
					  </div>
					</div>
								
								
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<?php
							echo $this->Form->input('selectuser', array(
													'options' => $options,
													'type' => 'select',
													'id'=>'my-select',
													'label' => 'Search Recipient',
													'name'=>'character',
													'multiple' => true
												   )
												); 
												
								?>
						  <div class="not-rgt">
						  <div class="separator"></div>
							<div class="radio radio-1">
							  <p id="sendvia">Send Message Via</p>
							  <?php
							  echo $this->Form->radio(
											'Sendmessagevia',
											[
												['value' => 'app', 'text' => 'Push App'],
												['value' => 'email', 'text' => 'Email','checked'=>'checked'],
												
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
									
							<?php echo $this->Form->end(); ?>
							 
		</div>
  </div>
</div>
</div>
<!--[/Notification area]--> 
	<!--mycode-->
