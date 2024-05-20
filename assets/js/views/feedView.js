var app = app || {};

app.views.postFeedView = Backbone.View.extend({
    initialize: function () {
        this.template = _.template($('#feed_view_template').html()); // Get the feed view template
        this.listenTo(this.collection, 'reset', this.render);
        this.listenTo(this.collection, 'sync', this.render);
        this.render();
    },
    render: function () {
        this.$el.html(this.template()); // Render the feed view template into the container
        // Render the navigation bar into the #navigation_container
        console.log("render");
        this.renderNavigationBar();
        console.log("Collection length: " + this.collection.length);
        this.collection.each((post)=>{
            console.log("hi");
			var postView = new app.views.PostView({model: post});
			this.$('#posts_feed_container').append(postView.el);
		})
        console.log("render after");
        return this;
    },
    renderNavigationBar: function () {
        var navigationBarView = new app.views.NavigationBarView(); // Create a new instance of NavigationBarView
        this.$('#navigation_container').html(navigationBarView.el); // Render the navigation bar view into the navigation_container
    },
    
})