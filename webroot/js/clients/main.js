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

}); // ----------  END DOCUMENT READY   ----------------------------

		
	//	setTimeout(function(){$(".success").slideUp();},10000);
		function toggle_profile_div(){
		// alert('teee');
		$("#profile_div").slideToggle();
		}