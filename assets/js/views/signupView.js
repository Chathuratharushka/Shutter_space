var app = app || {};

app.views.SignupPageView = Backbone.View.extend({

    initialize: function () {
        this.template = _.template($('#signup_view_template').html()); // Get the signup template
        this.render();
    },
    events:{
        "click #RedirectSigninButton": "redirectToSignin", // Event handler for the signin button
        "click #signupButton": "userSignup"
    },

    render: function () {
        this.$el.html(this.template()); // Render the login template into the container
        return this;
    },
    redirectToSignin: function (event) {
        event.preventDefault(); // Prevent the default action
        Backbone.history.navigate('', { trigger: true }); // Navigate to the login route
    },
    userSignup: function (event){
        // console.log("signup button has clicked");
        // Prevent the default form submission action
        event.preventDefault();
        // Stop the event from propagating further
        event.stopPropagation();

        var validatedForm=signupFormValidation();
        if(!validatedForm){
            $("#errSignup").html("Please fill the form")
        }else {
            this.model.set(validatedForm);
            var apiEndpoint=this.model.url + "signup";
            this.model.save(this.model.attributes, {
                "url": apiEndpoint,
                success: function (model, response){
                    new Noty({
						type: 'success',
						text: 'Registration successful',
						timeout: 2100
					}).show();
                    console.log("Registeration Completed");
                    app.appRouter.navigate("#", {trigger: true, replace: true}); // Navigate to login page
                },
                error:function (model, xhr){
                // console.log("Model attributes when request failed:", model.attributes);
                var errorMessage = "An unknown error occurred";
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    // If validation errors, display them
                    var errors = xhr.responseJSON.errors;
                    errorMessage = "";
                    for (var key in errors) {
                        errorMessage += key + ": " + errors[key] + "<br>";
                    }
                } else if (xhr.responseText) {
                    new Noty({
						type: 'error',
						text: xhr.responseText,
						timeout: 2100
					}).show();
                    errorMessage = xhr.responseText;
                }
                $("#errSignup").html(errorMessage);
                }
            })
        }
        $('regFirstName').val('');
        $('regLastName').val('');
        $('regEmail').val('');
        $('regPassword').val('');
        $('regConfirmPassword').val('');
    }
});