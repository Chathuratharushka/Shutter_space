var app = app || {};

app.routers.AppRouter = Backbone.Router.extend({
	routes:{
		"": "showHome",
		"signup": "showSignup",
        "feed": "showFeed",
        "post/create": "postCreate"
	},

	initialize: function() {
        // Ensure the container element is set correctly
        this.container = $("#container");

        // Check if the container is found
        if (!this.container.length) {
            throw new Error("Container element not found");
        }
    },

	showHome: function(){
		if (this.currentView) {
            this.currentView.remove(); // Remove the current view if it exists
        }

		userJson = JSON.parse(localStorage.getItem("user"));
        if (userJson == null) {
            if (!app.loginView) {
                app.user = new app.models.User();
                // Initialize the login view only if it doesn't exist
                app.loginView = new app.views.LoginPageView({model: app.user});
                this.currentView = app.loginView;
            }
        }else{
            this.showFeed();
        }
        // Append the new view's element to the container
        this.container.append(this.currentView.el);
	},

	showSignup: function(){
		if (this.currentView) {
            this.currentView.remove(); // Remove the current view if it exists
        }
        userJson = JSON.parse(localStorage.getItem("user"));
        if (userJson == null) {
            app.user = new app.models.User();
            app.signupView = new app.views.SignupPageView({model: app.user});
            this.currentView = app.signupView;
        }else{
            this.showFeed();
        }
        // Append the new view's element to the container
        this.container.append(this.currentView.el);
	},
    showFeed: function(){
        if (this.currentView) {
            this.currentView.remove(); // Remove the current view if it exists
        }

        app.feedView = new app.views.postFeedView({collection: new app.collections.PostCollection()});
        var endpoint = app.feedView.collection.url + "displayAllPosts";

        app.feedView.collection.fetch({
            reset: true,
				"url": endpoint,
				success: function(collection, response){
					console.log("Fetched collection: ", JSON.stringify(collection.toJSON(), null, 2));
                    console.log("Response: ", JSON.stringify(response, null, 2));
                    
					this.currentView = app.feedView;
                    this.container.append(this.currentView.el); 
				},
                error: function(model, xhr, options){
					if(xhr.status == 404){
						console.log("error 404");
						this.currentView = app.feedView;
                        this.container.append(this.currentView.el); 
					}
					// console.log("error");
				}
        });
        
    },
    postCreate: function(){
        if (this.currentView) {
            this.currentView.remove(); // Remove the current view if it exists
        }
        app.post = new app.models.Post();
        app.postCreateView = new app.views.postCreateView({model: app.post}); // 
        this.currentView = app.postCreateView; // Assign the new view to currentView
        this.container.append(this.currentView.el); // Append the new view's element to the container
    }
});