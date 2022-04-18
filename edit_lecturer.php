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
    $record_to_edit = $_POST ['record_to_edit'];

    // Ensure that only staff members can access //
    $path = 'Registration/' . $id;
    $reference = $database->getReference($path);
    $snapshot = $reference->getSnapshot();
    $value = $snapshot->getValue();

    if ($value ['access_level'] !== "Main" && $value ['access_level'] !== "Admin")
    {
     
        alert ("You Do Not Have Access!");

    }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Edit Lecturer</title>
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
              <a href="admin_panel.php" class="js-logo-clone">Artemis</a>
            </div>
          </div>
          
        <div class="main-nav d-none d-lg-block">
            <nav class="site-navigation text-right text-md-center" role="navigation">
                <ul class="site-menu js-clone-nav d-none d-lg-block">
                    <li><a href="admin_panel.php">Home</a></li>
                    <li class="has-children ">
                        <a href="#">Student</a>
                        <ul class="dropdown">
                            <li><a href="add_user.php">Add User</a></li>
                            <li><a href="view_user.php">Edit/Remove User</a></li>                        
                        </ul>
                    </li>
                     <li class="has-children ">
                        <a href="#">Lecturer</a>
                        <ul class="dropdown">
                            <li><a href="add_lecturer.php">Add Lecturer</a></li>
                            <li><a href="view_lecturer.php">Edit/Remove Lecturer</a></li>                          
                        </ul>
                    </li>
                    <li class="has-children ">
                        <a href="#">Subject</a>
                        <ul class="dropdown">
                            <li><a href="add_subject.php">Add Subject</a></li>
                            <li><a href="view_subject.php">Edit/Remove Subject</a></li>                           
                        </ul>
                    </li>
                    <li class="has-children ">
                        <a href="#">Result</a>
                        <ul class="dropdown">
                            <li><a href="view_result.php">Edit/Remove Result</a></li>                       
                        </ul>
                    </li>
                    <li class="has-children ">
                        <a href="#">Payment</a>
                        <ul class="dropdown">
                            <li><a href="view_payment.php">View Student Payment</a></li>
                        </ul>
                    </li>
                    <li class="has-children ">
                        <a href="#">Enrolment</a>
                        <ul class="dropdown">
                            <li><a href="view_enrolment.php">Edit/Remove Enrolment</a></li>
                            <li><a href="add_program_session.php">Add Program/Session</a></li>
                            <li><a href="remove_program_session.php">Remove Program/Session</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
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
          <div class="col-md-12">
            <h2 class="h3 mb-3 text-black">Edit Lecturer</h2>
          </div>
          <div class="col-md-7">

            <form action="edit_lecturer_execute.php" method="post">
              
            <?php

                $path = 'Lecturer/' . $record_to_edit;
                $reference = $database->getReference($path);
                $snapshot = $reference->getSnapshot();
                $value = $snapshot->getValue();

             ?>

              <div class="p-3 p-lg-5 border">
                <div class="form-group row">
                  <div class="col-md-6">
                    <label for="text" class="text-black">Lecturer ID To Be Edited:</label>
                    <label for="text" class="text-black"><?php echo "$record_to_edit"; ?></label> 
                     <input type='hidden' name='record_to_edit' value='<?php echo "$record_to_edit"; ?>' />
                  </div>
                  <div class="col-md-6">
                    <label for="c_fname" class="text-black">Name <span class="text-danger"></span></label>
                    <input type="text" class="form-control" id="c_fname" name="name" placeholder="<?php echo $value ['name']; ?>">
                  </div>
                </div>
                
                <div class="form-group row">
                  <div class="col-md-6">
                    <label for="c_subject" class="text-black">Email <span class="text-danger"></span></label>
                    <input type="email" class="form-control" id="c_subject" name="email" placeholder="<?php echo $value ['email']; ?>">
                  </div>
                    <div class="col-md-6">
                      <label for="c_phone" class="text-black">Phone <span class="text-danger"></span></label>
                      <input type="text" pattern="[0-9]{10}" class="form-control" id="c_phone" name="telno" placeholder="<?php echo $value ['telno']; ?>">
                    </div>

                </div>
        
                <div class="form-group row">
                  <div class="col-lg-12">
                    <input type="submit" class="btn btn-primary btn-lg btn-block" value="Edit Lecturer">
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="col-md-5 ml-auto">

            <div class="p-4 border mb-3">
                      
                <p><img src="images/function8.png" width="400" height="300"/></p>

            </div>
                    
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