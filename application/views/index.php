<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shutter Space</title>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"  type="text/javascript"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.3.3/backbone-min.js"  type="text/javascript"></script>

    <script src="../../../shutterSpace/assets/js/app.js" type="text/javascript"></script>
    <script src="../../../shutterSpace/assets/js/Models/user.js" type="text/javascript"></script>
    <script src="../../../shutterSpace/assets/js/Models/post.js" type="text/javascript"></script>
    <script src="../../../shutterSpace/assets/js/routers/approuter.js" type="text/javascript"></script>
    <script src="../../../shutterSpace/assets/js/views/loginView.js" type="text/javascript"></script>
    <script src="../../../shutterSpace/assets/js/views/signupView.js" type="text/javascript"></script>
    <script src="../../../shutterSpace/assets/js/views/navigationBarView.js" type="text/javascript"></script>
    <script src="../../../shutterSpace/assets/js/views/feedView.js" type="text/javascript"></script>
    <script src="../../../shutterSpace/assets/js/views/postCreateView.js" type="text/javascript"></script>
    <script src="../../../shutterSpace/assets/js/views/postView.js" type="text/javascript"></script>
    <!-- Bootstrap CSS -->
     <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
   
    <!--  Noty CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.css"/>
	<!--  Noty JavaScript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/noty/3.1.4/noty.min.js"></script>

    <link rel="stylesheet" href="../../../shutterSpace/assets/css/css_styling.css" />
    
    
</head>
<body>

<!-- Login template (Home view) -->
<script type="text/template" id="login_view_template">
    <div class="container mt-5 mb-3">
        <h2 class="text-center">Welcome to Shutter Space</h2>
        <p class="text-center">Please log in to access your account.</p>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <p id="errLogin" class="text-danger"></p>
                        <form action="login.php">
                            <div class="form-group">
                                <label for="email_login">Email:</label>
                                <input type="text" name="login_email" id="email_login" class="form-control" placeholder="Email" required>
                            </div>

                            <div class="form-group">
                                <label for="password_login">Password:</label>
                                <input type="password" name="login_password" id="password_login" class="form-control" placeholder="Password" required>
                            </div>

                            <div class="text-center"> <!-- Center the button -->
                                <button type="submit" id="LoginButton" class="btn btn-primary">Login</button>
                            </div>

                            <div class="text-center mt-3">
                                Don't you have an account? <br>
                                <button type="button" id="RedirectSignupButton" class="btn btn-link">Sign Up</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</script>


<!-- Signup Template -->
<script type="text/template" id="signup_view_template">
    <div class="container mt-5 mb-3">
        <h2 class="text-center">Welcome to Shutter Space</h2>
        <p class="text-center">Please sign up to create your account.</p>
    </div>
    <div class="container border p-4">
        <p id="errSignup"></p>
        <form action="#" method="post">
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input type="text" class="form-control" id="regFirstName" name="firstName" required>
            </div>
            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input type="text" class="form-control" id="regLastName" name="lastName" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="regEmail" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="regPassword" name="password" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" class="form-control" id="regConfirmPassword" name="confirmPassword" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary" id="signupButton">Sign Up</button>
            </div>
        </form>
        <div class="text-center">
        <p>Already have an account? </p>
        <button id="RedirectSigninButton" class="btn btn-secondary">Sign In</button>
        </div>
   </div>
</script>


<!-- Navigation Bar Template -->
<script type="text/template" id="navigation_bar_view_template">
    
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <a class="navbar-brand" href="#">Shutter Space</a>

        <div class="mx-auto order-0">
            <form class="form-inline">
                <input class="form-control search-input" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
            </form>
        </div>

        <button class="btn btn-primary ml-auto mr-3" id="postCreateButton">Create Post</button>

        <div id="navbar-list-4" class="ml-auto">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="https://s3.eu-central-1.amazonaws.com/bootstrapbaymisc/blog/24_days_bootstrap/fox.jpg" class="rounded-circle">
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" >View Profile</a>
                        <a class="dropdown-item" >Edit Profile</a>
                        <a class="dropdown-item" id="logoutButton" >Log Out</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

</script>

<!-- template for a post-->
<script type="text/template" id="post_view_template">
    <div class="post card">
        <div class="post-header card-header d-flex align-items-center">
            <img class="user-profile_picture rounded-circle mr-2" src="<%= userProfilePicture %>" alt="Profile Picture">
            <span class="user-name"><%= userName %></span>
        </div>
        <div class="post-body card-body d-flex">
            <img class="post-image img-fluid" src="<%= postImage %>" alt="Post Image">
            <div class="post-description ml-2"><%= postDescription %></div>
        </div>
        <div class="post-footer card-footer text-center">
            <div class="like-button-container d-flex align-items-center justify-content-center mb-2">
                <img src="like-icon.png" alt="Like" class="mr-2">
                <span class="post-reaction"><%= postReaction %></span>
            </div>
            <button class="show-comments btn btn-primary">Show Comments</button>
        </div>
    </div>
</script>




<!-- template for a post-->
<!-- <script type="text/template" id="post_view_template"> -->
        <!-- <div class="post">
            <div class="post-header">
                <img class="user-profile_picture">
                <span class="User-name">User 1</span>
            </div>
            <div class="post-body">
                <img class="post-image">
                <div class="post-description">Post Description</div>
            </div>
            <div class="post-footer">
                <div class="like-button-container">
                    <img src="like-icon.png" alt="Like">
                    <span class="post-reaction">34</span>
                </div>
                <button class="show-comments">Show Comments</button>
            </div>
        </div> -->
        <!-- <div class="post card">
            <div class="post-header card-header d-flex align-items-center">
                <img class="user-profile_picture rounded-circle mr-2">
                <span class="User-name">User 1</span>
            </div>
            <div class="post-body card-body d-flex">
                <img class="post-image img-fluid" alt="Post Image">
                <div class="post-description ml-2">Post Description</div>
            </div>
            <div class="post-footer card-footer text-center">
                <div class="like-button-container d-flex align-items-center justify-content-center mb-2">
                    <img src="like-icon.png" alt="Like" class="mr-2">
                    <span class="post-reaction">34</span>
                </div>
                <button class="show-comments btn btn-primary">Show Comments</button>
            </div>
        </div>
</script> -->

<!-- template for the post feed-->
<script type="text/template" id="feed_view_template">
    <!-- Container to render the Navigation Bar template-->
    <div id="navigation_container">

    </div>
    <br>
    <!-- <br>
    <br>
    <br>
    <h1>Hi</h1>  -->
    <div id="posts_feed_container">
    
    </div>
    
</script>


<script type="text/template" id="post_create_template">
    <div class="create-post-container">
        <div class="create-post">
            <div class="header-create-post">
                <h2 class="heading">Create Post</h2>
                <button id="close_button_create_post" class="close-btn">&times;</button>
            </div>
            <textarea id="createPostDescription" placeholder="Write Description......."></textarea>
            <div id="photo-input-create-post">
                <input type="file" class="form-control-file" id="postImageUpload" name="postImageUpload">
            </div>
            <div id="create_post_button_container">
                <button id="create_post_button">Post</button>
            </div>
            
        </div>
    </div>
</script>

<div id="container">
   
</div>

</body>
</html>
