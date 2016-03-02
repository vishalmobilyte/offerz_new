function del_users(user_id){
	
	if(user_id){
		
	var confirm_del = confirm("Are you sure to delete");
	
	if(confirm_del){
     
	 
		
		var request = $.ajax({
		url: "delete_users",
		
		method: "POST",
		data: {u_id:user_id},
		dataType: "html",
		success: function(msg){
		if(msg="success"){
		$("#email_influencer").val("");
		$("#tr_"+user_id).css('background-color','red');
		setTimeout(function(){
		$("#tr_"+user_id).slideUp('slow');
		},2000);
		//alert("Invite Deleted Successfully");
		}
		}
		});
		
		
	}
  }
}


function del_influ(user_id){
	
	if(user_id){
	var confirm_del = confirm("Are you sure to delete");
	if(confirm_del){
    //  alert("dgdg");
		var request = $.ajax({
		url: "delete_influencers",
		method: "POST",
		data: {u_id:user_id},
		dataType: "html",
		success: function(msg){
		if(msg="success"){
		$("#email_influencer").val("");
		$("#tr_"+user_id).css('background-color','red');
		setTimeout(function(){
		$("#tr_"+user_id).slideUp('slow');
		},2000);
		//alert("Invite Deleted Successfully");
		}
		}
		});
	}
  }
}

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