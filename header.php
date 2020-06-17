<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Client Address Book</title>

        <!-- Bootstrap CSS  CDN-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <!--If CDN fails to load, server up the local version  -->
       <script > window.bootstrap || document.write('<link rel="stylesheet" href="includes/framework/bootstrap/css/bootstrap.min.css">')</script>


          <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>
        <!--   Navbar     -->
        <nav class="navbar navbar-inverse " >
          <div class="container-fluid">
            <div class="navbar-header ">
                <a class="navbar-brand" href="#"><span class="text-uppercase">client<strong>manager</strong></span></a>
            </div>
            <?php
              if($_SESSION['loggedInUser'] ) {//user logged in
            ?>
            <ul class="nav navbar-nav">
                  <li><a href="clients.php">My Clients</a></li>
                  <li><a href="add.php">Add Client</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
             <!--   show greeting message  -->
              <p class="navbar-text">Aloha, <?php echo $_SESSION['loggedInUser'];?></p>
              <li><a href="logout.php">Log out</a></li>
            </ul>
            <?php
              }else{//user logged out
            ?>
            <ul class="nav navbar-nav navbar-right">
              <li><a href="index.php">Log in</a></li>
            </ul>
            <?php
              }
            ?>
          </div>
        </nav>

