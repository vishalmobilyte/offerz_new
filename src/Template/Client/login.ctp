<!----content----->
<div class="container">
<div class="row Under_Armour">
		<div class="col-md-12" style="margin-bottom:50px;">
			
			<div class="col-md-4 col-sm-4">
			<h2>Corporate User Login</h2>
				<div class="input-group">
				<?php	
				echo $this->Form->create('Users', ['type' => 'post','id'=>'login_form']);
				echo $this->Form->input('username', ['required' => true]);
				// Password
				echo $this->Form->input('password',['type'=>'password' ,'label'=>'Password']);
				
				echo $this->Form->submit('submit');
				echo $this->Form->end();?>
				
				</div>
				<div style="margin-top: 50px;"><span>Don't have account?</span> <a href="" target="_blank">Sign Up here</a></div>
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
	name: {
		required: true
		
	},
	username: {
		required: true
		
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