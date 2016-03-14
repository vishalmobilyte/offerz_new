//var dataTable='';
$(document).ready(function(){
$("#profile_div").slideUp();
		
$("#register_form").validate({
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
	
setTimeout(function(){
	
	var dataTable2 = $('.datatable').DataTable({
	
	"columns": [
    { "orderable": false },
    null,
    {"sType": "num"},
    null,
    null,
    { "orderable": false }
  
  ],
  
});

	// Search INput with datatable
	$("#searchbox").keyup(function() {
	dataTable2.search(this.value).draw();
	});
	},3000);
	
	$(".dropdown-menu li a").click(function(){

	var dropdowntext = ($(this).text()).toUpperCase();
 
	$("#dropdownMenu1").html(dropdowntext + ' <span class="caret"></span>');

	});	
	



	$(".dropdown-menu").click(function(){
	
		var sb = $("#dropdownMenu1").text();
		var bc = sb.trim();
	
		if (bc == "FOLLOWERS"){  
		$(".display-all").addClass("loading_body");
			var request = $.ajax({
			url: "get_followers_inf",
			method: "POST",
			data: {'test':'1'},
			dataType: "html",
			success: function(msg){
			$(".display-all").removeClass("loading_body");
			$("#most_pop_div").html('');
			$("#most_pop_div").html(msg);
			}
		});
			//$(".followers").siblings().hide();
			//$(".followers").show();
		}
		else if (bc == "MOST INFLUENCERS"){  
		$(".display-all").addClass("loading_body");
			var request = $.ajax({
			url: "get_influencers_inf",
			method: "POST",
			data: {'test':'1'},
			dataType: "html",
			success: function(msg){
			$(".display-all").removeClass("loading_body");
			$("#most_pop_div").html('');
			$("#most_pop_div").html(msg);
			}
		});
			//$(".followers").siblings().hide();
			//$(".followers").show();
		}
		else if (bc == "MOST CONNECTIONS"){  
		$(".display-all").addClass("loading_body");
			var request = $.ajax({
			url: "get_connections_inf",
			method: "POST",
			data: {'test':'1'},
			dataType: "html",
			success: function(msg){
			$(".display-all").removeClass("loading_body");
			$("#most_pop_div").html('');
			$("#most_pop_div").html(msg);
			}
		});
			//$(".followers").siblings().hide();
			//$(".followers").show();
		}
		else if (bc == "MOST OFFERZ"){  
		$(".display-all").addClass("loading_body");
			var request = $.ajax({
			url: "get_offers_inf",
			method: "POST",
			data: {'test':'1'},
			dataType: "html",
			success: function(msg){
			$(".display-all").removeClass("loading_body");
			$("#most_pop_div").html('');
			$("#most_pop_div").html(msg);
			}
		});
			//$(".followers").siblings().hide();
			//$(".followers").show();
		}
		else if (bc == "MOST % COMPLETE"){  
		$(".display-all").addClass("loading_body");
			var request = $.ajax({
			url: "get_most_share_per",
			method: "POST",
			data: {'test':'1'},
			dataType: "html",
			success: function(msg){
			$(".display-all").removeClass("loading_body");
			$("#most_pop_div").html('');
			$("#most_pop_div").html(msg);
			}
		});
			//$(".followers").siblings().hide();
			//$(".followers").show();
		}
		else if (bc == "LEAST INFLUENCERS"){  
		$(".display-all").addClass("loading_body");
			var request = $.ajax({
			url: "get_least_influencers_inf",
			method: "POST",
			data: {'test':'1'},
			dataType: "html",
			success: function(msg){
			$(".display-all").removeClass("loading_body");
			$("#most_pop_div").html('');
			$("#most_pop_div").html(msg);
			}
		});
			//$(".followers").siblings().hide();
			//$(".followers").show();
		}
		else if (bc == "LEAST OFFERZ"){  
		$(".display-all").addClass("loading_body");
			var request = $.ajax({
			url: "get_least_offers_inf",
			method: "POST",
			data: {'test':'1'},
			dataType: "html",
			success: function(msg){
			$(".display-all").removeClass("loading_body");
			$("#most_pop_div").html('');
			$("#most_pop_div").html(msg);
			}
		});
			//$(".followers").siblings().hide();
			//$(".followers").show();
		}
		
		else if (bc == "SHARE%") {	
			$(".display-all").addClass("loading_body");		
			var request = $.ajax({
			url: "get_share_perc_inf",
			method: "POST",
			data: {'test':'1'},
			dataType: "html",
			success: function(msg){
			$(".display-all").removeClass("loading_body");
			$("#most_pop_div").html('');
			$("#most_pop_div").html(msg);
			}
		});
		}
		else if (bc == "MOST DECLINES") {
				
			$(".display-all").addClass("loading_body");		
			var request = $.ajax({
			url: "get_most_delined_offers",
			method: "POST",
			data: {'test':'1'},
			dataType: "html",
			success: function(msg){
			$(".display-all").removeClass("loading_body");
			$("#most_pop_div").html('');
			$("#most_pop_div").html(msg);
			}
		});
		}
		});


	
}); // ----------  END DOCUMENT READY   ----------------------------


	// ============= DELETE INFLUEZER =================
	function del_influezer(invite_id){
	if(invite_id){
	var confirm_del = confirm("Are you sure to delete");
	if(confirm_del){

		var request = $.ajax({
		url: "delete_influncer",
		method: "POST",
		data: {invt_id:invite_id},
		dataType: "html",
		success: function(msg){
		if(msg="success"){
		$("#email_influencer").val("");
		$("#tr_"+invite_id).css('background-color','red');
		setTimeout(function(){
		$("#tr_"+invite_id).slideUp('slow');
		},2000);
		//alert("Invite Deleted Successfully");
		}
		}
		});
	}
	}
	}
	//	setTimeout(function(){$(".success").slideUp();},10000);
		function toggle_profile_div(){
		// alert('teee');
		$("#profile_div").slideToggle();
		}
		
		function add_influencer(){
		//alert('dd');
		var validate_form = $("#invites_form").valid();
		alert(validate_form);
		var form_data = $("#invites_form").serialize();
		if(validate_form){
		
		var request = $.ajax({
		url: "add_invite",
		method: "POST",
		data: form_data,
		dataType: "html",
		success: function(msg){
		if(msg="success"){
		$("#email_influencer").val("");
		alert("Invite Sent Successfully");
		}
		}
		});
		}
		}
		
