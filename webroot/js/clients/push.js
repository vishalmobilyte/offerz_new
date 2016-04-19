
$(document).ready(function() {
	$("#noti_form").validate({
	submitHandler: function(form) {
		form.submit();
		},
		ignore: [],
		rules: {
		'character[]': {
			required: true
		},	
		},
		errorPlacement: function(error, element) {
		if(element.attr("name") == "character[]") {
		error.appendTo( ".errorTxt" );
		} 
		else {
		error.insertAfter(element);
		}
		}  	
		});
	});
