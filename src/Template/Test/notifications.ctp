<!--[Notification area]-->

          
<?php
echo  $this->Form->create();

echo $this->form->input('notifications', ["type" => "textarea","rows" => "9", "cols" => "5", "placeholder" => "Enter text here", "required" => "true", "id" => "comment", "class" => "form-control"] );

 echo $this->Form->input('selectuser', array(
									'options' => $options,
									'type' => 'select',
									'id'=>'my-select',
									'label' => 'Search Recipient',
									'name'=>'character',
									'multiple' => true
								   )
								); ?>
	<?php
 
								
				/* 
              echo $this->Form->input('selectuser', array(
									'options' => $options,
									'type' => 'select',
									'id'=>'my-select',
									'label' => 'Search Recipient',
									
									'multiple' => true
								   )
								); */
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
			); */
			
				?>
          
<div class="radio radio-1">
<p>Send Message Via</p>
<?php
echo $this->Form->radio(
'Sendmessagevia',
[ 
['value' => 'app', 'text' => 'In app Push'],
['value' => 'email', 'text' => 'Email','checked'=>'checked'],

]
); 
?>
</div>
<div class="radio radio-2">
<p>Message Recipient</p>
</div>


<?php

echo $this->Form->submit('Send');

echo $this->Form->end();
?>


<!--[/Notification area]--> 
	<!--mycode-->
