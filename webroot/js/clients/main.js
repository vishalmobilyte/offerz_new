//var dataTable='';
$(document).ready(function(){
		$("#profile_div").slideUp();
		
$("#register_form").validate({
    ignore: [],
    rules: {
	name: {
		required: true
		
	},
	username: {
		required: true
		
	},
	email: {
		required: true,
		remote: 'check_email'
	},
	password: "",
    vpassword: {
      equalTo: "#password"
    }
	},
	messages:{
	email: {
	remote: "Email Already Exists"
	}
	}
       
    });
	
	// Invites form Validations
	$("#invites_form").validate({
	ignore: [],
	onkeyup: function(element) {$(element).valid()},
    rules: {
	email_influencer: {
		required: true,
		email: true,
		remote: 'check_invite_email_exists'
		
	}
	},
	messages: {
	email_influencer: {
	remote: "Invites Already sent to this email"
	}
	}
	});
	
	var dataTable2 = $('.datatable').DataTable({
	"columns": [
    { "orderable": false },
    null,
    null,
    null,
    null,
    { "orderable": false }
  
  ],
  
});
	// Search INput with datatable
	$("#searchbox").keyup(function() {
	dataTable2.search(this.value).draw();
	});
	}); // ----------  END DOCUMENT READY   ----------------------------


	//	setTimeout(function(){$(".success").slideUp();},10000);
		function toggle_profile_div(){
		// alert('teee');
		$("#profile_div").slideToggle();
		}
		
		function add_influencer(){
		//alert('dd');
		var validate_form = $("#invites_form").valid();
		var form_data = $("#invites_form").serialize();
		if(validate_form){
		
		var request = $.ajax({
		url: "add_invite",
		method: "POST",
		data: form_data,
		dataType: "html",
		success: function(msg){
		if(msg="success"){
		alert("Invite Sent Successfully");
		}
		}
		});
		}
		}
		
		