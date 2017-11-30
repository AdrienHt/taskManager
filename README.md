# Task Manager

# Intallation 
1) Download the project
2) Put it in your server or in Mamp 
3) Go to the project url and enjoy the application (ex: http://localhost:8888/taskManager/)
  
  Note : Be sure to put the project in the right folder, to have an url like this : http://yourserver/taskManager/

# Usage
This app is used to manage tasks of a group. 

API endpoint

You can use the Restfull api with endpoints. Some of them aren't used for the font app. 
Enpoint avalaibles :

   -  GET :
        -   get all users: /user
        -   get a user by id : /user/{$id}
        -   get a task for a specific user: task/user/{$id}
        -   get a task by id : /task/{$id}
        -   get all the tasks : /task
    
   -    POST : 
        -   Add a user : /user/add
        -   Create a new task : /task/create
        
   -    Delete :
        -   Delete task by task ID : /task/delete/{$id}
        -   Delete a user AND all his tasks : /user/delete/{$id}
