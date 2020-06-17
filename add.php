<?php 
session_start();
    // se all vars to null
    $clientName= $clientEmail= $clientPhone= $clientAddress= $clientCompany = $clientNotes=
    $nameError= $emailError='';

// if user is not logged in 
if( !$_SESSION['loggedInUser'] ) {
    
    // redirect to login page
    header('location: index.php');
}


// connect to database
include('includes/connection.php'); 

// include functions file
include('includes/functions.php'); 

// if add button was submitted
if( isset( $_POST['add'] ) ) {

    // check required fields
    if( !$_POST['clientName'] ) {
        //Error Mess.
        $nameError = "Please enter a name";
    }else {
        // validate form data inputs and store
        $clientName = validateFormData( $_POST['clientName'] );
    }
    
    if( !$_POST['clientEmail'] ) {
        //Error Mess.
        $emailError = "Please enter an email";
    }else {
        // validate form data inputs and store
        $clientEmail = validateFormData( $_POST['clientEmail'] );
    }
    
    // validate form data inputs and store
    $clientPhone     = validateFormData( $_POST['clientPhone'] );
    $clientAddress   = validateFormData( $_POST['clientAddress'] );
    $clientCompany   = validateFormData( $_POST['clientCompany'] );
    $clientNotes     = validateFormData( $_POST['clientNotes'] );
    
    // if required field have data
    if( $clientName && $clientEmail ) {
        // userID
        $loggedID =  $_SESSION['loggedID'] ; 
        // Query database to push data entered. 
        $query = "INSERT INTO `clients` (`id`,`user_id`,`name`,`email`,`phone`,`address`, `company`, `notes`, `date-added`)
                 VALUES (NULL,'$loggedID','$clientName', '$clientEmail',' $clientPhone ', '$clientAddress', '$clientCompany','$clientNotes', current_timestamp() )";
        
        $result =  mysqli_query( $conn, $query);
        
        // if query was success
        if( $result ) {
            // redirect to clients page with query sting add_success
            header('location: clients.php?alert=add_success');
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
    <h1>Add Client</h1> 

    <form  action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>" method="post" class="row">
           <div class="form-group col-sm-6">
               <label for="client-name">Name * <span class="text-danger"><?php echo $nameError?></span></label>
             <input type="text" name="clientName"class="form-control input-lg" id="client-name" value="">
           </div>
           <div class="form-group col-sm-6">
             <label for="client-email">Email * <span class="text-danger"><?php echo $emailError?></span></label>
             <input type="email" name="clientEmail" class="form-control input-lg" id="client-email" value="">
           </div>
           <div class="form-group col-sm-6">
             <label for="client-phone" >Phone</label>
             <input type="text" name="clientPhone" class="form-control input-lg" id="client-phone" value="">
           </div>
           <div class="form-group col-sm-6">
             <label for="client-address" >Address</label>
              <input type="text" name="clientAddress" class="form-control input-lg" id="client-address" value="">
           </div> 
          <div class="form-group col-sm-6">
            <label for="client-copany" >Company</label>
            <input type="text" name="clientCompany" class="form-control input-lg" id="client-company" value="">
          </div>  
          <div class=" form-group col-sm-6">
            <label for="client-notes">Notes</label>
            <textarea  type="text"  name="clientNotes" class="form-control input-lg" id="client-notes"></textarea>
         </div>
         <div class=" col-sm-12">
            <a href="clients.php" role="button" class="btn btn-lg btn-default" > Cancel</a> 
            <button type="submit" class="btn btn-lg btn-success pull-right" name="add"> Add Client</button>  
         </div>                
    </form>
</div><!--.container -->
</main>

<?php include('includes/footer.php'); ?>