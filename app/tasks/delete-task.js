$(document).ready(function(){
 
    $(document).on('click', '.delete-task-button', function(){
    	var task_id = $(this).attr('data-task-id');
        var user_id = $(this).attr('data-user-id');

    	r = confirm("Are you sure to delete this task ?");

    	if (r == true) {

        	$.ajax({
        		url: document.origin+"/taskmanager/api/task/delete/" + task_id,
        		type : "DELETE",
		        success : function(result) {
		 		    getUser(user_id);
		        },
		        error: function(xhr, resp, text) {
		            console.log(xhr, resp, text);
		        }

    		});
    	}
    });
});