$(document).ready(function(){
 
    $(document).on('click', '.create-user-button', function(){

		var create_user_html="";
			 
		create_user_html+="<div id='get-users-button' class='btn btn-primary pull-left m-b-15px get-users-button'>";
		create_user_html+="<span class='glyphicon glyphicon-list'></span> List of users";
		create_user_html+="</div>";

		create_user_html+="<form id='create-user-form' action='#' method='post' border='0'>";
		    create_user_html+="<table class='table table-hover table-responsive table-bordered'>";
		 
		        // Name field
		        create_user_html+="<tr>";
		            create_user_html+="<td>Name</td>";
		            create_user_html+="<td><input type='text' name='name' class='form-control' required /></td>";
		        create_user_html+="</tr>";
		 
		        // Email field
		        create_user_html+="<tr>";
		            create_user_html+="<td>Email</td>";
		            create_user_html+="<td><input type='text' name='email' class='form-control' required /></td>";
		        create_user_html+="</tr>";

		        // button to submit form
		        create_user_html+="<tr>";
		            create_user_html+="<td></td>";
		            create_user_html+="<td>";
		                create_user_html+="<button type='submit' class='btn btn-primary pull-right'>";
		                    create_user_html+="<span class='glyphicon glyphicon-plus'></span> Create User";
		                create_user_html+="</button>";
		            create_user_html+="</td>";
		        create_user_html+="</tr>";
		 
		    create_user_html+="</table>";
		create_user_html+="</form>";

		// inject html to 'page-content' of our app
		$("#page-content").html(create_user_html);

		// chage page title
		changePageTitle("Create User");	

	});

	$(document).on('submit', '#create-user-form', function(){

		$.ajax({
		    url: "http://localhost:8888/taskmanager/api/user/add",
		    type : "POST",
		    data : $("#create-user-form").serialize(),
		    success : function(data) {
		    	//If sucess
		    	if (jQuery.type(data) === "string" && data === "202 : Success"){
		   			alert("User created !");
		   			showUsers();

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