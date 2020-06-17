<?php 

// did the user's browser send a cookie for the session
if( isset( $_COOKIE[ session_name() ]) ) {
    //empty the cookie
    setcookie( session_name(), '', time()-86400, '/' );
}
    
session_start();

$_SESSION['loggedInUser'] ='';

include( 'includes/header.php');

// clear all session variables
session_unset();

// destroy session
session_destroy();

?>

<div class="container">
    
    <h1>Logged Out</h1>

    <p class="lead">you have been logged out, hope see you soon!</p>
    
    <a href="index.php"  role="button" class="btn btn-lg btn-info col-xs-offset-4 col-xs-4 col-sm-offset-3 col-sm-3  ">Log In</a>
    
</div>

<?php
include( 'includes/footer.php');
?>