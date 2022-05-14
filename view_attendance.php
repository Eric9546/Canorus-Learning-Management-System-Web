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

// Ensure that only staff members can access //
$path = 'Registration/' . $id;
$reference = $database->getReference($path);
$snapshot = $reference->getSnapshot();
$value = $snapshot->getValue();

if ($value ['access_level'] !== "Lecturer")
{
    
    alert ("You Do Not Have Access!");

}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>View Attendance</title>
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
          
        <div class="main-nav d-none d-lg-block">
            <nav class="site-navigation text-right text-md-center" role="navigation">
                <?php include('lecturer_nav.php'); ?>
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
            <h2 class="h3 mb-3 text-black">View Attendance</h2>
          </div>
          <div class="col-md-7">

            <form action="view_attendance_filtered.php" method="post">
              
              <div class="p-3 p-lg-5 border">
                <div class="form-group row">

                     <?php

                     $path = 'Subject/';
                     $reference = $database->getReference($path)->getValue();

                     ?>

                  <div class="col-md-6">
                    <label for="c_email" class="text-black">Subject <span class="text-danger">*</span></label>
                      <br />
                          <select name="subId" required>

                            <?php

                            foreach ($reference as $key => $rows)
                            {

                                if ($rows ['lecId'] == $id)
                                {
                                    
                            ?>
                    
                                <option value="<?php echo $rows ['subId'] ?>"><?php echo $rows ['subId']; ?> - <?php echo $rows ['subName']; ?></option>
                                    
                            <?php
                                                                                                                     
                                }

                            ?> 

                            <?php
                                
                            }

                            ?>
        
                        </select>
                  </div>         
                  
                    <?php

                    $path = 'Session/';
                    $reference = $database->getReference($path)->getValue();

                    ?>

                  <div class="col-md-6">
                    <label for="c_email" class="text-black">Program <span class="text-danger">*</span></label>
                      <br />
                          <select name="session" required>

                        <?php

                        foreach ($reference as $key => $rows)
                        {
                            
                        ?>
                    
                            <option value="<?php echo $rows ['session'] ?>"><?php echo $rows ['session']; ?></option>
                                    
                        <?php
                                                                                  
                        }

                        ?> 

                        </select>    
                  </div>
                    
                </div>
                
                <div class="form-group row">
                  <div class="col-lg-12">
                    <input type="submit" class="btn btn-primary btn-lg btn-block" value="View Attendance">
                  </div>
                </div>
              </div>
            </form>
          </div>
            
          <div class="col-md-5 ml-auto">

            <div class="p-4 border mb-3">
                      
                <p><img src="images/function15.jpg" width="400" height="300"/></p>

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