$(document).ready(function(){
$("#offer_form_new").validate();
$("#offer_form_new").slideUp();
$( "#remove_image_offer" ).hide();

// ---------------------- DATEPICKER -------------------------------
$(".datepicker").datepicker({
dateFormat: 'yy-mm-dd',
 minDate: new Date(),
 constrainInput: false
});
$( "#datepicker").datepicker({
dateFormat: 'yy-mm-dd',
 minDate: new Date(),
 constrainInput: false,
  onSelect: function(dateText, inst) {
        var date = $(this).val();
		var time = $('#datepicker_val').val(date);
        //alert(date);
    //    alert('on select triggered');
    //    $("#start").val(date + time.toString(' HH:mm').toString());

    }
	
	});
	$( "#remove_image_offer" ).on( "click", function() {
		
$("#preview_ img").attr("src","/offerz_new/uploads/offers_images/no_img.jpg");
$("#preview_ #image_name").attr("value","");
$( "#remove_image_offer" ).hide();
	$( "#add_image_offer img" ).attr(
{
    src:"/offerz_new/img/symbol-upload.png", 
    title:"Upload Image"
});	
	
});
	$( "#add_image_offer" ).on( "click", function(e) {

	//$( "#add_image_offer" ).click(function() {
	//var chk_desc_lengh = parseInt($('.chars').text());
	var chk_desc_lengh = parseInt($(this).parents('form').find('.chars').text());
	
	$("#offer_id_temp").val('');
	//alert(chk_desc_lengh);
	if(chk_desc_lengh > 19){
	
	setTimeout(function(){
	
	$( "#photoimg" ).trigger( "click" );
	},1000);
	}
	else{
	alert("please reduce the length of Editable or Non Editable text by less than 121 Characters");
	}
});
// Fancy Box
	$('.fancybox').fancybox();
	
//$(".resume_offer_btn").removeAttr("onclick");
});
function toggle_div(sdf){

			$(sdf).toggleClass('fa-chevron-down fa-bars'); 
}
	
	
// ------------- Trigger Click of ajax upload ---------------------------------------

function create_new_offr(){
$("#offer_form_new").slideToggle();
}

function remove_pic(offer_id,site_url) {
	
$("div#preview_"+offer_id+" img").attr("src",site_url+"no_img.jpg");
$("div#preview_"+offer_id+" input#image_name").attr("value","");

		
}

 function update_pic(offer_id) {
	
	var chk_desc_lengh = parseInt($('.chars').text());
	$("#offer_id_temp").val('');
	if(chk_desc_lengh > 19){
	$("#offer_id_temp").val(offer_id);
	$( "#photoimg" ).trigger( "click" );
	}
	else{
	alert("please reduce the length of Editable or Non Editable text by less than 121 Characters");
	}
}

// =================== CHECK MAX LENGTH OF WORDS IN TEXTAREA =======================


function check_word_len(e) {
	//var img_val = $("#image_name").val();
	var img_val = $(e).parents('form').find("#image_name").val();
	if(typeof img_val === 'undefined' ){
	var maxLength=140;
	
	}
	else{
	var maxLength=120;
	}
	//var old_length = $("#not_editable_text").val().length;
	var old_length = $(e).parents('form').find("#not_editable_text").val().length;
	var new_val = maxLength-old_length;
	if(new_val > 0){
	//var length1 = $("#editable_text").attr("maxlength",new_val);
	var length1 = $(e).parents('form').find("#editable_text").attr("maxlength",new_val);
	}
		console.log("Not editable maxlenght--"+length1);
	//var length = $(e).val().length;
	run_counter(e);
	
};

function check_word_len_editable(e) {
	
	var img_val = $(e).parents('form').find("#image_name").val();
//	alert(img_val);
	if(typeof img_val === 'undefined' ){
	var maxLength=140;
//	alert(maxLength);
	}
	else{
	var maxLength=120;
	}
	//var old_length = $("#editable_text").val().length;
	var old_length = $(e).parents('form').find("#editable_text").val().length;
	var new_val = maxLength-old_length;
	if(new_val > 0){
	//	var length1 = $("#not_editable_text").attr("maxlength",new_val);
	var length1 = $(e).parents('form').find("#not_editable_text").attr("maxlength",new_val);
	}
	console.log("editable maxlenght--"+length1);
	//var length = $(e).val().length;
	run_counter(e);
	//var length_limit = maxLength-length;
	//$('.chars').text(length_limit);
};

function run_counter(e){
	
	var maxLength=140;
	var img_val = $(e).parents('form').find("#image_name").val();
//	alert(img_val);
	if(typeof img_val === 'undefined' ){
	var img_count=0;
//	alert(maxLength);
	}
	else{
	var img_count=20;
	}
	var editable_text = $(e).parents('form').find("#editable_text").val().length;
	var not_editable_text = $(e).parents('form').find("#not_editable_text").val().length;
	// img_count; // default 20
	
	var length = parseInt(editable_text+not_editable_text+img_count);
	var length_limit = maxLength-length;
	$(e).parents('form').find(".chars").text(length_limit);
	//alert(parseInt($('.chars').text()));
}

function editOffer(e){
	var offer_id = $(e).parents('form').find("#offer_id").val();
	//alert(offer_id);
	if(offer_id!=''){
	var data_form = $(e).parents('form').serialize();
	var request = $.ajax({
		url: "edit_offer",
		method: "POST",
		data: data_form,
		dataType: "html",
		success: function(msg){
		if(msg="success"){
		alert("Offer Edited Successfully");
		window.location.href='offers';
		}
		else{
		alert("Failed to edit offer");
		}
		}
		});
	}
	else{
	alert("invalid offer");
	}
		
}

function pauseOffer(e,offer_id,obj){

	var is_paused = e;
	if(is_paused=='1'){
	//alert("eee");
	$(obj).removeAttr("class");
	//$(obj).removeAttr("onclick");
	$(obj).addClass("resume_offer_btn");
	$(obj).parents('ul').find('#pause_btn').removeAttr('class');
	$(obj).parents('ul').find('#pause_btn').addClass('pause_offer_btn');
	
	}
	else{
	$(obj).removeAttr("class");
	$(obj).addClass("resume_offer_btn");
	// $(obj).removeAttr("onclick");
	$(obj).parents('ul').find('#resume_btn').removeAttr('class');
	$(obj).parents('ul').find('#resume_btn').addClass('pause_offer_btn');
	}
	//$(".resume_offer_btn").removeAttr("onclick");
	var request = $.ajax({
		url: "pause_offer",
		method: "POST",
		data: {'is_paused':is_paused,'offer_id':offer_id},
		dataType: "html",
		success: function(msg){
		if(msg="success"){
		//alert("Offer Edited Successfully");
		}
		else{
		alert("Failed to edit offer");
		}
		}
		});
	
	
		
	
}

function delete_offer(offer_id) {
var confirmm = confirm("Are you sure to delete this offer?");
	if(confirmm){
	//var data_form = $(e).parents('form').serialize();
	var request = $.ajax({
		url: "delete_offer",
		method: "POST",
		data: {'offer_id':offer_id},
		dataType: "html",
		success: function(msg){
		if(msg="success"){
		$("#offer_row_"+offer_id).parent().css("background","red");
		$("#panel-element-"+offer_id).css("background","red");
		
		setTimeout(function(){
			$("#offer_row_"+offer_id).parent().slideUp('slow');
			$("#panel-element-"+offer_id).slideUp('slow');
			
		
		},2000);
		setTimeout(function(){
			
			$("#panel-element-"+offer_id).parent().remove();
			window.location.href='offers';
		
		},3000);
		//alert("Offer Edited Successfully");
		}
		else{
		alert("Failed to edit offer");
		}
		}
		});
		}
}

// OFFER NUDGE 

function send_offer_nudge(offer_id,e){
	//alert(e);
	$(e).text("Sending...");
	$(e).attr('disabled','disabled')
	var request = $.ajax({
		url: "offer_nudge",
		method: "POST",
		data: {'offer_id':offer_id},
		dataType: "html",
		success: function(msg){
		alert(msg);
		if(msg=='success'){
		alert("Nudge Sent Successfully");
		$(e).text("Send Nudge");
		}
		else{
		alert("Failed to Send Nudge");
		}
		},
		beforeSuccess: function(){
		$(e).text("Sending...");
		}
		});
}
