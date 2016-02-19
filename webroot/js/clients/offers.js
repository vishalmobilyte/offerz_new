$(document).ready(function(){

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
	alert("please reduce the lenght of Editable or Non Editable text by less than 121 Characters");
	}
});
});
// ------------- Trigger Click of ajax upload ---------------------------------------




 function update_pic(offer_id) {
	
	var chk_desc_lengh = parseInt($('.chars').text());
	$("#offer_id_temp").val('');
	if(chk_desc_lengh > 19){
	$("#offer_id_temp").val(offer_id);
	$( "#photoimg" ).trigger( "click" );
	}
	else{
	alert("please reduce the lenght of Editable or Non Editable text by less than 121 Characters");
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
