<!----content----->
<div class="container">
<div class="row Under_Armour">
		<div class="col-md-12" style="margin-bottom:50px;">
			<div class="col-md-4 col-sm-4">
			<div class="flash_msg"><?=$this->Flash->render();?></div>
			<h2>Corporate User Login</h2>
				<div class="input-group">
				<?php	
				echo $this->Form->create('Users', ['type' => 'post','id'=>'login_form']);
				echo $this->Form->input('username', ['required' => true,'label'=>'Email']);
				// Password
				echo $this->Form->input('password',['type'=>'password' ,'label'=>'Password']);
				
				echo $this->Form->submit('submit',['value'=>'Submit','class'=>'save_profile']);
				echo $this->Form->end();?>
				
				</div>
				</div>
			
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	setTimeout(function(){$("span.success").slideUp();},8000);
	setTimeout(function(){$("span.failed").slideUp();},8000);
	// -----------  VALIDATIONS  ---------------------
	//alert('eee');
	$("#login_form").validate({
    ignore: [],
    rules: {
	username: {
		required: true,
		email: true
		
	},
	email: {
		required: true
		
	},
	password: "required",
    vpass: {
      equalTo: "#password"
    }
		}
       
    });
	}); // END OF DOCUMENT READY
	</script>