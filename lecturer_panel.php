<?php
    
    session_start ();
    if (!isset ($_SESSION ['id']))
    {
        
        header ("Location: login.php");
              
    }

    // Declaring function for alert message //
    function alert ($msg)
    {

        echo "<script type='text/javascript'>alert('$msg'); window.location='index.php';</script>";

    }

    // Establishing connection to database //
    include ('dbcon.php');

    $id = $_SESSION ['id'];

    // Redirect the user if other ID is detected //
    $path = 'Registration/' . $id;
    $reference = $database->getReference($path);
    $snapshot = $reference->getSnapshot();
    $value = $snapshot->getValue();

    if ($value ['access_level'] !== "Lecturer")
    {
        
        header ("Location:index.php");

    }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Home Page</title>
    <?php include('header.php'); ?>
    
  </head>
  <body>
  
  <div class="site-wrap">
    

    <div class="site-navbar bg-white py-2">

      <div class="search-wrap">
        <div class="container">
          <a href="#" class="search-close js-search-close"><span class="icon-close2"></span></a>
          <fo$ action="#" method="post">
            <input type="text" class="fo$-control" placeholder="Search keyword and hit enter...">
          </fo$>  
        </div>
      </div>

      <div class="container">
        <div class="d-flex align-items-center justify-content-between">
          <div class="logo">
            <div class="site-logo">
              <a href="index.php" class="js-logo-clone">Canorus</a>
            </div>
          </div>
          
          <div class="icons">
 
             <span class="icon-user">

              <?php 
                             
                    $id = $_SESSION ['id'];   
                    echo "<b>Welcome, $id </b><a href='logout.php' class='btn btn-primary btn-lg btn-block'><b>Logout</b></span></a>";
                          
              ?>
              
              </span>  
            
          </div>
        </div>
      </div>
    </div>
    
    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="title-section text-center mb-5 col-12">
            <h2 class="text-uppercase">Welcome To The Canorus Learning Management System!</h2>
          </div>
        </div>
        <div class="row">

            <div class="col-lg-4 col-md-6 item-entry mb-4">
            <a href="lecturer_timetable.php" class="product-item md-height bg-gray d-block" style="height:300px; width:300px">
              <img src="images/function3.jpg" alt="Image" class="img-fluid" height="250" width="250">
            </a>
            <h5 class="item-price"><a href="lecturer_timetable.php"><span class="icon-asterisk"> View Timetable</span></a></h5>
          </div>
          
            <div class="col-lg-4 col-md-6 item-entry mb-4">
            <a href="student_notes.php" class="product-item md-height bg-gray d-block" style="height:300px; width:300px">
              <img src="images/function12.jpg" alt="Image" class="img-fluid" height="250" width="250">
            </a>
            <h5 class="item-price"><a href="#"><span class="icon-asterisk"> Edit/Remove Notes</span></a></h5>
          </div>

            <div class="col-lg-4 col-md-6 item-entry mb-4">
            <a href="#" class="product-item md-height bg-gray d-block" style="height:300px; width:300px">
              <img src="images/function13.png" alt="Image" class="img-fluid" height="250" width="250">
            </a>
            <h5 class="item-price"><a href="#"><span class="icon-asterisk"> Edit/Remove Assignment</span></a></h5>
                <h5 class="item-price"><a href="#"><span class="icon-asterisk"> View Assignment</span></a></h5>
          </div>

            <div class="col-lg-4 col-md-6 item-entry mb-4">
            <a href="student_announcements.php" class="product-item md-height bg-gray d-block" style="height:300px; width:300px">
              <img src="images/function14.jpg" alt="Image" class="img-fluid" height="250" width="250">
            </a>
            <h5 class="item-price"><a href="#"><span class="icon-asterisk"> Edit/Remove Annoucements</span></a></h5>
          </div>

        </div>
      </div>
    </div>

    <footer class="site-footer custom-border-top">
        <div class="container">

            <div class="row pt-5 mt-5 text-center">
                <div class="col-md-12">
                    <p>

                        <?php include('footer.php'); ?>

                    </p>
                </div>

            </div>
        </div>
    </footer>

  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>

  </body>
</html>