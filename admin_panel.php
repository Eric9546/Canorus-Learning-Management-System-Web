<?php
    
    session_start ();

    // Declaring function for alert message //
    function alert ($msg)
    {

        echo "<script type='text/javascript'>alert('$msg'); window.location='index.php';</script>";

    }

    // Ensure that the user is logged in //
    if (!isset ($_SESSION ['id']))
    {
    
        header ("Location: login.php");
    
    }

    // Establishing connection to database //
    include ('dbcon.php');

    $id = $_SESSION ['id'];

    // Ensure that only staff members can access //
    $path = 'Registration/' . $id;
    $reference = $database->getReference($path);
    $snapshot = $reference->getSnapshot();
    $value = $snapshot->getValue();

    if ($value ['access_level'] == "Student" || $value ['access_level'] == "Lecturer")
    {

        alert ("You Do Not Have Access!");

    }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Admin Panel</title>
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
              <a href="admin_panel.php" class="js-logo-clone">Canorus</a>
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
            <a href="#" class="product-item md-height bg-gray d-block" style="height:300px; width:300px">
              <img src="images/function7.png" alt="Image" class="img-fluid" height="250" width="250">
            </a>
            <h5 class="item-price"><a href="add_user.php"><span class="icon-asterisk"> Add User</span></a></h5>
            <h5 class="item-price"><a href="view_user.php"><span class="icon-asterisk"> Edit/Remove User</span></a></h5>
            </div>

          <div class="col-lg-4 col-md-6 item-entry mb-4">
            <a href="#" class="product-item md-height bg-gray d-block" style="height:300px; width:300px">
              <img src="images/function8.png" alt="Image" class="img-fluid" height="250" width="250">
            </a>
            <h5 class="item-price"><a href="add_lecturer.php"><span class="icon-asterisk"> Add Lecturer</span></a></h5>
            <h5 class="item-price"><a href="view_lecturer.php"><span class="icon-asterisk"> Edit/Remove Lecturer</span></a></h5>
              <h5 class="item-price"><a href="view_lecturer_timetable.php"><span class="icon-asterisk"> View Lecturer Timetable</span></a></h5>
            
          </div>

          <div class="col-lg-4 col-md-6 item-entry mb-4">
            <a href="#" class="product-item md-height bg-gray d-block" style="height:300px; width:300px">
              <img src="images/function9.jpg" alt="Image" class="img-fluid" height="250" width="250">
            </a>
            <h5 class="item-price"><a href="add_subject.php"><span class="icon-asterisk"> Add Subject</span></a></h5>
            <h5 class="item-price"><a href="view_subject.php"><span class="icon-asterisk"> Edit/Remove Subject</span></a></h5>
              <h5 class="item-price"><a href="view_classes.php"><span class="icon-asterisk"> Edit/Remove Classes</span></a></h5>
            
          </div>
          <div class="col-lg-4 col-md-6 item-entry mb-4">
            <a href="view_result.php" class="product-item md-height bg-gray d-block" style="height:300px; width:300px">
              <img src="images/function2.jpg" alt="Image" class="img-fluid" height="250" width="250">
            </a>
            <h5 class="item-price"><a href="view_result.php"><span class="icon-asterisk"> Edit/Remove Result</span></a></h5>         
            
          </div>

          <div class="col-lg-4 col-md-6 item-entry mb-4">
            <a href="view_payment.php" class="product-item md-height bg-gray d-block" style="height:300px; width:300px">
              <img src="images/function4.png" alt="Image" class="img-fluid" height="250" width="250">
            </a>
            <h5 class="item-price"><a href="view_payment.php"><span class="icon-asterisk"> View Student Payments</span></a></h5>
          </div>
          <div class="col-lg-4 col-md-6 item-entry mb-4">
            <a href="#" class="product-item md-height bg-gray d-block" style="height:300px; width:300px">
              <img src="images/function1.jpg" alt="Image" class="img-fluid" height="250" width="250">
            </a>
            <h5 class="item-price"><a href="view_enrolment.php"><span class="icon-asterisk"> Edit/Remove Enrolment</span></a></h5>
            <h5 class="item-price"><a href="add_program_session.php"><span class="icon-asterisk"> Add Program/Session</span></a></h5>
            <h5 class="item-price"><a href="remove_program_session.php"><span class="icon-asterisk"> Remove Program/Session</span></a></h5>  
          </div>
            <div class="col-lg-4 col-md-6 item-entry mb-4">
            <a href="view_log.php" class="product-item md-height bg-gray d-block" style="height:300px; width:300px">
              <img src="images/function11.jpg" alt="Image" class="img-fluid" height="250" width="250">
            </a>
            <h5 class="item-price"><a href="view_log.php"><span class="icon-asterisk"> View Logs</span></a></h5>
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