$(document).ready(function(){
 
    showUsers();
 
});

function showUsers(){
	
	// get list of user from the API
	$.getJSON("http://localhost:8888/taskmanager/api/user", function(data){

		get_user_html="";
		 
		get_user_html+="<div id='create-user' class='btn btn-primary pull-right m-b-15px m-r-10px create-user-button'>";
		get_user_html+="<span class='glyphicon glyphicon-plus'></span> Create User";
		get_user_html+="</div>";

		get_user_html+="<table class='table table-bordered table-hover'>";
		 
	    get_user_html+="<tr>";
    	//get_user_html+="<th class='w-25-pct'>ID</th>";
        get_user_html+="<th class='w-25-pct'>Name</th>";
        get_user_html+="<th class='w-25-pct'>email</th>";
        get_user_html+="<th class='w-25-pct text-align-center'>Action</th>";

	    get_user_html+="</tr>";
		     
		$.each(data.users, function(key, val) {
		 
		    get_user_html+="<tr>";

		 		//get_user_html+="<td>" + val.id + "</td>";
		        get_user_html+="<td>" + val.name + "</td>";
		        get_user_html+="<td>" + val.email + "</td>";

		        // buttons
		        get_user_html+="<td>";

		        get_user_html+="<button class='btn btn-danger delete-user-button pull-right' data-id='" + val.id + "'>";
		        get_user_html+="<span class='glyphicon glyphicon-remove'></span> Delete";
		        get_user_html+="</button>";

		         get_user_html+="<button class='btn btn-primary m-r-10px get-one-user-button pull-right' data-id='" + val.id + "'>";
		        get_user_html+="<span class='glyphicon glyphicon-eye-open'></span> Tasks";
		        get_user_html+="</button>";
		        get_user_html+="</td>";
		 
		    get_user_html+="</tr>";
		 
		});
		
		// end table
		get_user_html+="</table>";

		$("#page-content").html(get_user_html);
	});
	changePageTitle("Users");
}

$(document).on('click', '.get-users-button', function(){
    showUsers();
});