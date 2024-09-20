The ENV file is the .env file.

Because this project was mainly focused on the API management that's why I did not include any views. I mainly focused on the APIs.
About my approach, firstly I approached installed and setup Laravel Breeze which makes life easy in case of user authentication.
Then, I completed all the CRUD functions in the controller file like any other normal Laravel application but in API style.
Filtering wasn't too hard but I did have to do some research on this.
Also, I made sure that all the APIs can only be accessed by authenticated users. And the update and delete functions can only be done if the user is the owner of the task.
