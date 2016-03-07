<!--[Notification area]-->
<div class="notification_blck">
  <div class="container">
    <div class="not-area">
      <h2>Notification</h2>
      <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
          <div class="form-group not-lft">
		  <?php echo $this->Form->create();?>
       		<?php echo '<select id="my-select" name="character[]" multiple="multiple">'; 
										
										echo '<option value="Peter">Peter Griffin</option>';
										echo '<option value="jai">jai </option>';
										echo '<option value="hai">hai</option>';
										
										echo '</select>';?>
										<?php
						
				echo '<div><span class="labels">';echo $this->Form->label('email');echo '</span> <span class="fields">';echo $this->Form->text('email');echo '</span></div>';
				echo '<div><span class="labels">';echo $this->Form->label('password');echo '</span> <span class="fields">';echo $this->Form->password('password');echo '</span></div>';
				
				echo '<span class="fields">';echo $this->Form->button('Submit');echo '</span>';
				
				echo $this->Form->end(); ?>
				
          <?php
		//echo  $this->Form->create();
		  
		//echo $this->form->input('notifications', ["type" => "textarea","rows" => "9", "cols" => "5", "placeholder" => "Enter text here", "required" => "true", "id" => "comment", "class" => "form-control"] );
			?>
          </div>
        </div>
		<?php ?>
		<?php /* echo '<select id="my-select" name="character" multiple="multiple">'; 
								
								foreach ($options as $user)
								{
								echo '<option value=' . $user .'>'.$user.'</option>';
								}
								
								echo '</select>'; */
								?>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
		<?php
            /*   echo $this->Form->input('selectuser', array(
									'options' => $options,
									'type' => 'select',
									'id'=>'my-select',
									'label' => 'Search Recipient',
									'name'=>'character',
									'multiple' => true
								   )
								); 
			 */					
			
								/* echo '<select id="my-select" name="character" multiple="multiple">'; ?>
								<?php
								foreach ($options as $user)
								{
								echo '<option value=' . $user .'>'.$user.'</option>';
								}
								echo '</select>';
								 */
			/* echo $this->Form->input('character', array(
									'options' => $options,
									
									'id'=>'my-select',
									'label' => 'Search Recipient',
									'multiple' => true
								   )
								); */
		/* echo $this->Form->select(
		'character',
		$options,
		['id'=>'my-select',
									'label' => 'Search Recipient','multiple' => true]
		);
			 */
				?>
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
            <div class="not-search-user"> 
			
			  <?php
						
			//echo $this->Form->submit('Send');
						
			//echo $this->Form->end();
			 
			 ?>
            
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!--[/Notification area]--> 
	<!--mycode-->
