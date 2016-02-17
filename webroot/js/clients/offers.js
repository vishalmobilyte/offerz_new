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
alert('this');

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