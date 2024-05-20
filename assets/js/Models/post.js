var app = app || {};
app.models.Post = Backbone.Model.extend({
	urlRoot: '/shutterSpace/index.php/api/Post/',
	defaults: {
        post_id: null,
        user_id: null,
        reaction_count: null,
        reaction_count: 0,
        description: null,
        post_picture:null,
        user_details: {} // Initialize as an empty object to avoid null references
	},
    initialize: function() {
        if (!this.get('user_details')) {
            this.set('user_details', new app.models.User().toJSON());
        } else {
            this.set('user_details', new app.models.User(this.get('user_details')).toJSON());
        }
    },
	url: '/shutterSpace/index.php/api/Post/'
});

app.collections.PostCollection = Backbone.Collection.extend({
	model: app.models.Post,
	url: '/shutterSpace/index.php/api/Post/',
});