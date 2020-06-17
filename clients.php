<?php
session_start();

// variables initialize
$alertAddMessage = $alertUpdateMessage = $alertDeleteMessage ='';

// if user is not logged in
if( !$_SESSION['loggedInUser'] ) {
    // redirect to login page
    header('location: index.php');
}

// userID
$loggedID = $_SESSION['loggedID'];

// connect to database
include('includes/connection.php');

// query user data and store result
$query = "SELECT * FROM clients WHERE user_id = $loggedID";
$result = mysqli_query( $conn, $query);

// check for query string
if( isset( $_GET['alert'] ) ) {

    if( $_GET['alert'] == 'new_acount_success' ) {// new user acount created

        $alertAddMessage = "<div class='alert alert-success'>Your acount created successfully! <a class='close' data-dismiss='alert'>&times;</a></div>";

    }elseif( $_GET['alert'] == 'add_success' ) {// new client added

        $alertAddMessage = "<div class='alert alert-success'>New client added! <a class='close' data-dismiss='alert'>&times;</a></div>";

    }elseif( $_GET['alert'] == 'update_success' ) {// client updated

        $alertUpdateMessage = "<div class='alert alert-success'>Client updated! <a class='close' data-dismiss='alert'>&times;</a></div>";
    }elseif( $_GET['alert'] == 'deleted' ) {// client deleted

        $alertDeleteMessage = "<div class='alert alert-success'>Client deleted! <a class='close' data-dismiss='alert'>&times;</a></div>";
    }
}

include('includes/header.php');
?>

<main>
  <div class='container'>
        <h1>Client Address Book</h1>

        <?php echo $alertAddMessage; ?>
        <?php echo $alertUpdateMessage; ?>
        <?php echo $alertDeleteMessage; ?>

          <table class="table table-bordered table-hover">
            <thead>
              <tr class="active">
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Company</th>
                <th>Notes</th>
                <th>Edit</th>
              </tr>
            </thead>
            <tbody>
              <?php

                if( mysqli_num_rows($result) > 0 ) {// we have data

                    // output the data in sexy table
                    echo "<tr>";
                      while( $row = mysqli_fetch_assoc($result)  ) {
                        echo "<tr><td>". $row['name']
                            ."</td><td>". $row['email']
                            ."</td><td>". $row['phone']
                            ."</td><td>". $row['address']
                            ."</td><td>". $row['company']
                            ."</td><td>". $row['notes']. "</td>";

                        echo '<td><a href="edit.php?id='. $row['id']. '" role="button"
                                 class="btn btn-primary btn-sm" >
                                <span class="glyphicon glyphicon-edit"></span>
                             </a></td>';
                    }
                    echo "</tr>";

                }else {// there are no data
                      echo "<div class='alert alert-danger'>Whoops!
                            you do not have any clients. You can add some.</div>";

                }

                // close database connection
                mysqli_close($conn);
             ?>

            </tbody>
            <tfoot>
            <!-- add button -->
                <td colspan="7" class="text-center"><a href="add.php" class="btn btn-success" role="button"><span class="glyphicon glyphicon-plus small"></span> Add Client</a></td>
            </tfoot>
          </table>

    </div><!--.container -->
</main>

<?php include('includes/footer.php'); ?>
