<!--[Notification area]-->
<div class="notification_blck">
  <div class="container">
    <div class="not-area">
      <h2>Notification</h2>
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="form-group not-lft">
          <?php
		echo  $this->Form->create();
		  
		echo $this->form->input('', ["type" => "textarea","rows" => "9", "cols" => "5", "placeholder" => "Enter text here", "required" => "true", "id" => "comment", "class" => "form-control"] );
			?>
          </div>
        </div>
		
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="not-rgt">
            <div class="radio radio-1">
              <p>Send Message Via</p>
			  <?php
              echo $this->Form->radio(
							'Sendmessagevia',
							[
								['value' => 'app', 'text' => 'In app Push'],
								['value' => 'email', 'text' => 'Email'],
								
							]
						);
				?>
            </div>
            <div class="radio radio-2">
              <p>Message Recipient</p>
            </div>
            <div class="not-search-user"> <a href="#"><i class="fa fa-search"></i></a>
			<?php
              echo $this->Form->input('selectuser', array(
									'options' => $options,
									'type' => 'select',
									
									'label' => 'Search Recipient',
									'multiple' => 'multiple'
								   )
								);
				?>
			  <?php
						
			echo $this->Form->submit('Send');
						
			echo $this->Form->end();
			 
			 ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--[/Notification area]--> 
	<!--mycode-->
