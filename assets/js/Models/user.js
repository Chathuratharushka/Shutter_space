var app = app || {};
app.models.User = Backbone.Model.extend({
	urlRoot:'/shutterSpace/index.php/api/User/',
	defaults: {
        first_name: "",
        last_name: "",
		user_id: null,
        email: "",
		password: "",
		create_at: "",
		profile_picture: null
	},
	url:'/shutterSpace/index.php/api/User/'
});