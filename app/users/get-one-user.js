$(document).ready(function(){
 	
 	$(document).on('click', '.get-one-user-button', function(){
		getUser($(this).attr('data-id'));
	});

});

function getUser(id){
	//var id = $(this).attr('data-id');
	var get_one_user_tasks_html="";
	var name = "" 

	$.getJSON("http://localhost:8888/taskmanager/api/user/" + id, function(data){

		// change page title
		changePageTitle("Manage " + data.name + "'s Tasks")
		name = data.name;
	});

	$.getJSON("http://localhost:8888/taskmanager/api/task/user/" + id, function(data){
	
		get_one_user_tasks_html+="<div id='get-users-button' class='btn btn-primary pull-left m-b-15px get-users-button'>";
		get_one_user_tasks_html+="<span class='glyphicon glyphicon-list'></span> List of users";
		get_one_user_tasks_html+="</div>";

		get_one_user_tasks_html+="<button class='btn btn-danger delete-user-button pull-right m-r-10px' data-id='" + id + "'>";
	    get_one_user_tasks_html+="<span class='glyphicon glyphicon-remove'></span> Delete this user";
	    get_one_user_tasks_html+="</button>";

		get_one_user_tasks_html+="<button id='get-users-button' class='btn btn-primary pull-right m-b-15px m-r-10px create-task-button' data-id='" + id + "' data-name='" + name + "'>";
		get_one_user_tasks_html+="<span class='glyphicon glyphicon-plus'></span> Add a new task";
		get_one_user_tasks_html+="</button>";


		// start table
		get_one_user_tasks_html+="<table class='table table-bordered table-hover'>";
	 
	    get_one_user_tasks_html+="<tr>";
    	get_one_user_tasks_html+="<th class='w-25-pct'>Title</th>";
        get_one_user_tasks_html+="<th class='w-25-pct'>Description</th>";
        get_one_user_tasks_html+="<th class='w-25-pct'>Creation date</th>";
        get_one_user_tasks_html+="<th class='w-25-pct text-align-center'>Status</th>";
        get_one_user_tasks_html+="<th class='w-25-pct text-align-center'>Action</th>";


	    get_one_user_tasks_html+="</tr>";
	     
		// loop through returned list of data
		$.each(data.tasks, function(key, val) {
	 
	    // creating new table row per record
		    get_one_user_tasks_html+="<tr>";

		 		get_one_user_tasks_html+="<td>" + val.title + "</td>";
		        get_one_user_tasks_html+="<td>" + val.description + "</td>";
		        get_one_user_tasks_html+="<td>" + val.creation_date + "</td>";
		        get_one_user_tasks_html+="<td>" + val.status + "</td>";


		        // delete button
		        get_one_user_tasks_html+="<td>";
		        get_one_user_tasks_html+="<button class='btn btn-danger delete-task-button' data-task-id='" + val.id + "' data-user-id='" + id + "'>";
		        get_one_user_tasks_html+="<span class='glyphicon glyphicon-remove'></span> Delete this task";
		        get_one_user_tasks_html+="</button>";
		        get_one_user_tasks_html+="</td>";
	 
	   		get_user_html+="</tr>";

		});

	    // end table
		get_user_html+="</table>";

		//inject html to 'page-content' of our app
		$("#page-content").html(get_one_user_tasks_html);
	});
}
