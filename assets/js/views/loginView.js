var app = app || {};

app.views.LoginPageView = Backbone.View.extend({
   
    initialize: function () {
        this.template = _.template($('#login_view_template').html()); // Get the login template
        this.render();
    },

    events:{
        "click #RedirectSignupButton": "redirectToSignup", // Event handler for the signup button
        "click #LoginButton": "loginToApp"
    },

    render: function () {
        this.$el.html(this.template()); // Render the login template into the container
        return this;
    },
    clearFormInputs: function () {
        this.$('#email_login').val('');
        this.$('#password_login').val('');
    },
    redirectToSignup: function (event) {
        event.preventDefault(); // Prevent the default action
        Backbone.history.navigate('signup', { trigger: true }); // Navigate to the signup route
    },
    loginToApp: function(event){
        // Prevent the default form submission action
        event.preventDefault();
        // Stop the event from propagating further
        event.stopPropagation();

        var validatedForm = LoginFormValidation();
        if(!validatedForm){
            new Noty({
				type: 'error',
				text: 'Please Enter the Cridential',
				timeout: 2100
			}).show();
            $("#errLogin").html("Please fill the form")
        }else {
            this.model.set(validatedForm);
            var apiEndpoint = this.model.url + "login";
            this.model.save(this.model.attributes, {
                "url": apiEndpoint,
                success: function(model, response){
                    new Noty({
						type: 'success',
						text: 'Successfully logged in.',
						timeout: 2100
					}).show();
                    // $("#logout").show();
                    localStorage.setItem('user', JSON.stringify(model));
                    app.appRouter.navigate("feed", {trigger: true});
                },
                error: function (model, xhr){
                    if(xhr.status=400){
						$("#errLogin").html("Email or Password Incorrect");
						new Noty({
							type: 'error',
							text: 'Email or Password Incorrect',
							timeout: 2100
						}).show();
					}
                }
            });
        }
        this.clearFormInputs();
    }
});