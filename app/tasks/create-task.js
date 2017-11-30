$(document).ready(function(){
 	
 	var id =""

    $(document).on('click', '.create-task-button', function(){

    	id = $(this).attr('data-id');
    	var name = $(this).attr('data-name');

		var create_task_html="";
		var date = new Date();
		date = (date.getFullYear()+"-"+ date.getMonth()+"-"+date.getDate());

		// chage page title
		changePageTitle("Add a New Task for " + name);
		console.log(name);

		create_task_html+="<div id='get-users-button' class='btn btn-primary pull-left m-b-15px get-users-button'>";
		create_task_html+="<span class='glyphicon glyphicon-list'></span> List of users";
		create_task_html+="</div>";

		create_task_html+="<form id='create-task-form' action='#' method='post' border='0'>";
		    create_task_html+="<table class='table table-hover table-responsive table-bordered'>";
		 
		       // user_id field
		        create_task_html+="<input type='hidden' name='user_id' class='form-control' value='" + id + "'/>";

		        // Title field
		        create_task_html+="<tr>";
		            create_task_html+="<td>Title</td>";
		            create_task_html+="<td><input type='text' name='title' class='form-control' required /></td>";
		        create_task_html+="</tr>";
		 
		        // description field
		        create_task_html+="<tr>";
		            create_task_html+="<td>Description</td>";
		            create_task_html+="<td><input type='text' name='description' class='form-control' required /></td>";
		        create_task_html+="</tr>";

		        // status field
		        create_task_html+="<tr>";
		            create_task_html+="<td>Status</td>";
		            create_task_html+="<td><input type='text' name='status' class='form-control' required /></td>";
		        create_task_html+="</tr>";
		 		
		 		// date field
		        create_task_html+="<input type='hidden' name='creation_date' class='form-control' value='" + date + "'/>";

		        // button to submit form
		        create_task_html+="<tr>";
		            create_task_html+="<td></td>";
		            create_task_html+="<td>";
		                create_task_html+="<button type='submit' class='btn btn-primary pull-right'>";
		                    create_task_html+="<span class='glyphicon glyphicon-plus'></span> Create User";
		                create_task_html+="</button>";
		            create_task_html+="</td>";
		        create_task_html+="</tr>";
		 
		    create_task_html+="</table>";
		create_task_html+="</form>";

		// inject html to 'page-content' of our app
		$("#page-content").html(create_task_html);	

	});

	$(document).on('submit', '#create-task-form', function(){

		$.ajax({
		    url: "http://localhost:8888/taskmanager/api/task/create",
		    type : "POST",
		    data : $("#create-task-form").serialize(),
		    success : function(data) {
		    	//If sucess
		    	if (jQuery.type(data) === "string" && data === "202 : Success"){
		   			alert("Task created !");
		   			getUser(id);

		    	} else {
		    		var errors = "";
		    	
			    	$.each(data, function(key, val) {
			    		errors += val + "\n \n";

			    	});
			    	alert(errors);
		    	}
		    },
		    error: function(xhr, resp, text) {
		        // show error to console
		        console.log(xhr, resp, text);
		    }
		});
		return false;	
	});	
});