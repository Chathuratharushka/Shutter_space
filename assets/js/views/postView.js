var app = app || {};

app.views.PostView = Backbone.View.extend({
    initialize: function () {
        this.template = _.template($('#post_view_template').html()); // Get the navigation bar template
        this.render();
    },
    render: function () {
        // Render the post view template
        this.$el.html(this.template({
            userProfilePicture: this.model.get('user_details').profile_picture,
            userName: this.model.get('user_details').first_name + ' ' + this.model.get('user_details').last_name,
            postImage: this.model.get('post_picture'),
            postDescription: this.model.get('description'),
            postReaction: this.model.get('reaction_count')
        }));
    
        return this;
    },
})