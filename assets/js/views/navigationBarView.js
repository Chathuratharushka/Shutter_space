var app = app || {};

app.views.NavigationBarView = Backbone.View.extend({
	initialize: function () {
        this.template = _.template($('#navigation_bar_view_template').html()); // Get the navigation bar template
        this.listenTo(app.appRouter, 'route', this.render);
        this.render();
    },
    render: function () {
        this.$el.html(this.template()); // Render the navigation bar template
        return this;
    },
    events:{
        "click #logoutButton": "logoutFromApp",
        "click #postCreateButton": "openPostCreateView"
    },
    logoutFromApp: function(event){
        event.preventDefault(); // Prevent the default action
        event.stopPropagation(); // Stop the event from propagating further
        localStorage.clear();
        window.location.href = ''; // Navigate to the login route
    },
    openPostCreateView: function(event){
        event.preventDefault(); // Prevent the default action
        event.stopPropagation(); // Stop the event from propagating further
        app.appRouter.navigate("/post/create", {trigger: true});

    }
});
