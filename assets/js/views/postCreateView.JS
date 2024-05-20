var app = app || {};

app.views.postCreateView = Backbone.View.extend({
    initialize: function () {
        this.template = _.template($('#post_create_template').html()); // Get the feed view template
        this.render();
    },
    render: function () {
        this.$el.html(this.template()); // Render the feed view template into the container
        return this;
    },
    events:{
        "click #create_post_button": "createPost",
        "click #close_button_create_post": "closeCreatePostView"
    },
    createPost: function(event){
        // Prevent the default form submission action
        event.preventDefault();
        // Stop the event from propagating further
        event.stopPropagation();

        var formData = createPostFormValidation();
        if (!formData) {
            console.log("If block of postCreateView.js");
			new Noty({
				type: 'error',
				text: 'Both fields should be filled: Description and Post Image.',
				timeout: 2100
			}).show();
		}else{
            $.ajax({
                url: this.model.url + 'createpost',
                type: 'POST',
                data: formData,
                processData: false, // Prevent jQuery from processing the data
                contentType: false, // Prevent jQuery from setting contentType
                success: function(response) {
                    // Handle success
                    new Noty({
                        type: 'success',
                        text: 'Post created successfully.',
                        timeout: 2100
                    }).show();
                    // Redirect to feed page
                    window.location.href = '#feed'; 
                },
                error: function(xhr) {
                    // Handle error
                    new Noty({
                        type: 'error',
                        text: 'Error creating post: ' + xhr.statusText,
                        timeout: 2100
                    }).show();
                }
            });
           
        }
    },
    closeCreatePostView: function(event){
         // Prevent the default form submission action
         event.preventDefault();
         // Stop the event from propagating further
         event.stopPropagation();
         
         window.location.href = '#feed'; 
    }
})