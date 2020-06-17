<?php
session_start();
// se all vars to null
$userName= $userEmail= $userPassword= $nameError= $emailError= $passwordError= '';

// connect to database
include('includes/connection.php');

// include functions file
include('includes/functions.php');

// if add button was submitted
if( isset( $_POST['createAcount'] ) ) {

    // check required fields
    if( !$_POST['userName'] ) {
        //Error Mess.
        $nameError = "Please enter a name";
    }else {
        // validate form data inputs and store
        $userName = validateFormData( $_POST['userName'] );
    }

    if( !$_POST['userEmail'] ) {
        //Error Mess.
        $emailError = "Please enter an email";
    }else {
        // validate form data inputs and store
        $userEmail = validateFormData( $_POST['userEmail'] );
    }

    if( !$_POST['userPassword'] ) {
        //Error Mess.
        $passwordError = "Please type password";
    }else {
        // validate form data inputs and store
        $userPassword = validateFormData( $_POST['userPassword'] );
        // password hash
        $userPassword = password_hash( $userPassword, PASSWORD_DEFAULT );
    }

    // if required field have data
    if( $userName && $userEmail &&  $userPassword) {

        // Query database to push data entered.
        $query = "INSERT INTO `users` (`id`,`name`,`email`, `password`, `signup_date`)
                 VALUES (NULL,'$userName', '$userEmail', '$userPassword', current_timestamp() )";

        $result =  mysqli_query( $conn, $query);

        // if query was success
        if( $result ) {
            // session
            $_SESSION['loggedInUser'] = $userName;

            // query userId
            $query  = "SELECT id FROM users WHERE email = '$userEmail'";
            $result =  mysqli_query( $conn, $query);
            $row    = mysqli_fetch_assoc( $result  );

            //share with session
            $_SESSION['loggedID'] = $row['id'];
            // redirect to clients page with query sting add_success
            header('location: clients.php?alert=new_acount_success');
        }else {
            // error
            echo "Error:". $query. "<br>". mysqli_error($conn);
        }
    }
}

// closee connection
mysqli_close($conn);

include('includes/header.php');
?>

<main>
<div class='container'>
    <h1>Create New Acount</h1>

    <form  action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post" class="row">
           <div class="form-group  col-sm-8">
               <label for="user-name">Name * <span class="text-danger"><?php echo $nameError?></span></label>
             <input type="text" name="userName"class="form-control input-lg" id="user-name" value="<?php echo $userName?>">
           </div>
           <div class="form-group  col-sm-8">
             <label for="user-email">Email * <span class="text-danger"><?php echo $emailError?></span></label>
             <input type="email" name="userEmail" class="form-control input-lg" id="user-email" value="<?php echo $userEmail?>">
           </div>
           <div class="form-group  col-sm-8">
             <label for="user-password" >Password *<span class="text-danger"><?php echo $passwordError?></span></label>
             <input type="password" name="userPassword" class="form-control input-lg" id="user-password" value="">
           </div>
         <div class=" col-sm-8">
            <a href="index.php" role="button" class="btn btn-lg btn-default" > Cancel</a>
            <button type="submit" class="btn btn-lg btn-success pull-right" name="createAcount">Create Acount</button>
         </div>
    </form>
</div><!--.container -->
</main>

<?php include('includes/footer.php'); ?>
