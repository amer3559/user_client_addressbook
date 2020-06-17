<?php

session_start();

// variables initialization
$clientName= $clientEmail= $clientPhone= $clientAddress= $clientCompany = $clientNotes=
    $nameError= $emailError= $alertMessage = '';

// if user is not logged in 
if( !$_SESSION['loggedInUser'] ) {
    
    // redirect to login page
    header('location: index.php');
}

// get ID sent by colection or load when update button hit
$clientID = $_GET['id'];

// connect to database
include('includes/connection.php'); 

// include validation function
include('includes/functions.php');
  
// new database query & result
$query = "SELECT * FROM clients WHERE id=$clientID";
$result = mysqli_query( $conn, $query);

// check result and copy data
if( mysqli_num_rows( $result ) > 0 ) {// there are data
    // fetch client data
    while( $row = mysqli_fetch_assoc( $result) ) {
        // store basic data
        $clientName        = $row['name'];
        $clientEmail       = $row['email'];
        $clientPhone       = $row['phone'];
        $clientAddress     = $row['address'];
        $clientCompany     = $row['company'];
        $clientNotes       = $row['notes'];
        
    } 
}else {// ther are no data returned
    //show alert message
    $alertMessage = "<div class='alert alert-warning'>Nothing to see here! <a href='clients.php'>Head back</a></div>";   
}

// if update button was submitted
if( isset( $_POST['update'] ) ) {
    echo "clientName".  $_POST['clientName'];
    
    // check required fields
    if( !$_POST['clientName'] ) {
        //Error Mess.
        $nameError = "Can't empty name field";
    }else {
        // validate form data inputs and store
        $clientName = validateFormData( $_POST['clientName'] );
    }
    
    if( !$_POST['clientEmail'] ) {
        //Error Mess.
        $emailError = "Can't empty email field";
    }else {
        // validate form data inputs and store
        $clientEmail = validateFormData( $_POST['clientEmail'] );
    }

    // validate form data inputs and store
    $clientPhone     = validateFormData( $_POST['clientPhone'] );
    $clientAddress   = validateFormData( $_POST['clientAddress'] );
    $clientCompany   = validateFormData( $_POST['clientCompany'] );
    $clientNotes     = validateFormData( $_POST['clientNotes'] );
//    $loggedID = $_SESSION['loggedID'];
    // new database query & result
    $query = " UPDATE clients
               SET name         = '$clientName',
                   email        = '$clientEmail',
                   phone        = '$clientPhone',
                   address      = '$clientAddress',
                   company      = '$clientCompany',
                   notes        = '$clientNotes'
                 WHERE id       = '$clientID'";

    $result = mysqli_query( $conn, $query );
  
    // check result
    if( $result ) {//success

        // redirect to clients page with query string update_success 
        header('location:clients.php?alert=update_success');
    }else {//faild
        // error update message
        echo "Error updating record:". mysqli_error($conn);
    }
}

// if delete button was submitted
if( isset( $_POST['delete'] ) ) {
    
    $alertMessage = "<div class='alert alert-danger'>
                        <p>Are you sure you want to delete this client?</p><br>
                        
                        <form action='".htmlspecialchars( $_SERVER['PHP_SELF'] )."?id=$clientID' method='post'>
                            <input type='submit' class='btn btn-danger btn-sm' name='comfirm-delete'
                            value='Yes, delete!'>
                            <a type='button' class='btn btn-default btn-sm' data-dismiss='alert' >Oops, no thanks!</a>
                        </form>
                    </div>";
}

// if comfirm delete button was submitted
if( isset( $_POST['comfirm-delete'] ) ) {
    
    // new database query & result
    $query = "DELETE FROM clients WHERE id='$clientID'";
    $result = mysqli_query( $conn, $query);
    
    // check result
    if( $result ) {//success

        // redirect to clients page with query string deteted
        header('location:clients.php?alert=deleted');
    }else {//faild
        // error update message
        echo "Error updating record:". mysqli_error($conn);
    }
    
}

// close mysql connection
mysqli_close($conn);

include('includes/header.php'); 
?>
      
<main>
<div class='container'>
    <h1>Edit Client</h1> 
    <?php echo $alertMessage; ?>
    
    <form  action="<?php echo htmlspecialchars( $_SERVER['PHP_SELF'] ); ?>?id=<?php echo $clientID?>" method="post" class="row">
           <div class="form-group col-sm-6">
             <label for="client-name">Name * <span class="text-danger"><?php echo $nameError?></span></label>
             <input type="text" name="clientName"class="form-control input-lg" id="client-name" value="<?php echo $clientName; ?>">
           </div>
           <div class="form-group col-sm-6">
             <label for="client-email">Email * <span class="text-danger"><?php echo $emailError?></span></label>
             <input type="email" name="clientEmail" class="form-control input-lg" id="client-email" value="<?php echo $clientEmail; ?>">
           </div>
           <div class="form-group col-sm-6">
             <label for="client-phone" >Phone</label>
             <input type="text" name="clientPhone" class="form-control input-lg" id="client-phone" value="<?php echo $clientPhone; ?>">
           </div>
           <div class="form-group col-sm-6">
             <label for="client-address" >Address</label>
              <input type="text" name="clientAddress" class="form-control input-lg" id="client-address" value="<?php echo $clientAddress; ?>">
           </div> 
          <div class="form-group col-sm-6">
            <label for="client-copany" >Company</label>
            <input type="text" name="clientCompany" class="form-control input-lg" id="client-company" value="<?php echo $clientCompany; ?>">
          </div>  
          <div class=" form-group col-sm-6">
            <label for="client-notes">Notes</label>
            <textarea  type="text"  name="clientNotes" class="form-control input-lg" id="client-notes">
              <?php echo $clientNotes; ?></textarea>
         </div>
         <div class=" col-sm-12">
             <hr>
             <button type="submit" class="btn btn-lg btn-danger pull-left" name="delete"> Delete</button>
             <div class="pull-right">
                <a href="clients.php" role="button" class="btn btn-lg btn-default" > Cancel</a> 
                <button type="submit" class="btn btn-lg btn-success " name="update"> Update</button>
            </div>     
         </div>                
    </form>
</div><!--.container -->
</main>

<?php include('includes/footer.php'); ?>