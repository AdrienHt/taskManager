$(document).ready(function(){
 
    $(document).on('click', '.delete-user-button', function(){
    	var user_id = $(this).attr('data-id');

    	r = confirm("Are you sure to delete this user ? All his tasks will be deleted.");

    	if (r == true) {

        	$.ajax({
        		url: "http://localhost:8888/taskmanager/api/user/delete/" + user_id,
        		type : "DELETE",
		        success : function(result) {
		 		    showUsers();
		        },
		        error: function(xhr, resp, text) {
		            console.log(xhr, resp, text);
		        }

    		});
    	}
    });
});