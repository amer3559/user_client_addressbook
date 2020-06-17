<?php
session_start();

// set all variables to NULL
 $loginError = $formEmail = $_SESSION['loggedInUser'] =$_SESSION['loggedID']= $userID= '';

// if login form was submitted
if( isset($_POST['login'] ) ) {
    // validate form data
    include('includes/functions.php');
    $formEmail =validateFormData( $_POST['email'] );
    $formPass =validateFormData( $_POST['password'] );

    // connect to database
    include('includes/connection.php');

    // create query
    $query = "SELECT id, name, password FROM users WHERE email='$formEmail'";
    // store the result
    $result = mysqli_query( $conn, $query );

    // if user existed
    if( mysqli_num_rows( $result ) > 0) {
        // user exist ..copy of data
        while( $row = mysqli_fetch_assoc( $result ) ) {
            $userID = $row['id'];
            $userName = $row['name'];
            $userHashedPass = $row['password'];
        }

        // verify  hashed password with submitted
        if( password_verify( $formPass, $userHashedPass )) {
            // share data globaly
            // store data in SESSION Vars.
            $_SESSION['loggedInUser'] = $userName;
            $_SESSION['loggedID'] = $userID;

           // Redirect to a "clients page"
            header( "Location: clients.php" );

        }else{// Invalid password..Error Message
            $loginError = "<div class='alert alert-danger'>Wrong username / password combination. Try again.
                           <a class='close' data-dismiss='alert'>&times;</a></div>";
        }

    }else {// user is not exist show error message
        $loginError = "<div class='alert alert-info'>No such user in database. Please try again. <a class='close' data-dismiss='alert'>&times;</a></div>";
    }

   // close mysql connection
   mysqli_close($conn);

}

include('includes/header.php');

?>

<main>
    <div class='container col-sm-offset-2 col-sm-8 col-md-6 col-lg-offset-4 col-lg-5  '>
        <h1>Client Address Book</h1>
        <p class="lead">Log in to your account.</p>

        <?php  echo $loginError; ?>
        <form class="form-inline" action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post">

            <div class="form-group">
                <label for="email" class="sr-only">
                Email</label>
                <input type="text" class="form-control" id="email" placeholder="Email" name="email" value="<?php echo $formEmail; ?>">
            </div>

            <div class="form-group">
                <label for="password" class="sr-only">
                Password</label>
                <input type="password" class="form-control" id="password" placeholder="Password" name="password">
            </div>

            <button  type="submit" class="btn btn-primary" name="login">Login</button>

        </form>
        <br/>
        <p class="lead">I don't have an account... <a href="signUp.php" class="btn btn-default">Sign Up</a></p>
  </div><!--.container -->
</main>

<?php include('includes/footer.php'); ?>
