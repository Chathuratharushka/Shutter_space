var app = app || {};
app.views = {};
app.routers = {};
app.models = {};
app.collections = {};

// Signup form validation
function signupFormValidation() {
	// console.log("in signupFormValidation method : [app.js]")
	var user = {
		"first_name": $("input#regFirstName").val(),
		"last_name": $("input#regLastName").val(),
		"email": $("input#regEmail").val(),
		"password": $("input#regPassword").val(),
		"confirmPassword": $("input#regConfirmPassword").val()
	};
	if (!user.first_name || !user.last_name|| !user.email|| !user.password || !user.confirmPassword) {
		return false;
	}
	return user;
}

// login form Validation
function LoginFormValidation(){
	var user ={
		"email": $("input#email_login").val(),
		"password": $("input#password_login").val()
	};
	if (!user.email || !user.password){
		return false;
	}
	return user;
}

// create post form validation
function createPostFormValidation(){
	var formData = new FormData();
    var description = $("textarea#createPostDescription").val();
    var post_picture = $("input#postImageUpload")[0].files[0];
	var user = JSON.parse(localStorage.getItem('user'));

	if (!description || !post_picture || !user || !user.user_id) {
        // If either description or postImage is missing, return false
        return false;
    }
	formData.append('description', description);
    formData.append('post_picture', post_picture);
	formData.append('user_id', user.user_id);
    return formData;
}

// Start of the routing. The starting point
$(document).ready(function () {
	app.appRouter = new app.routers.AppRouter();
	$(function () {
		Backbone.history.start();
	});
});

