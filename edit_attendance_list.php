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
    <title>Edit Attendance</title>
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
          <div class="title-section text-center mb-5 col-12">
            <h2 class="text-uppercase">Edit Attendance</h2>
          </div>
        </div>
        
          <?php

          if (isset ($_POST ['subId']))
          {

              $subId = $_POST ['subId'];
              $program = $_POST ['program'];
              $section = $_POST ['section'];
              $session = $_POST ['session'];
              $record_to_view = $_POST ['record_to_view'];
              $QRcode = $_POST ['QRcode'];
              $attendPin = $_POST ['attendPin'];

          }

          else
          {

              $subId = $_SESSION ['subId'];
              $program = $_SESSION ['program'];
              $section = $_SESSION ['section'];
              $session = $_SESSION ['session'];
              $record_to_view = $_SESSION ['record_to_view'];
              $QRcode = $_SESSION ['QRcode'];
              $attendPin = $_SESSION ['attendPin'];

          }

          ?>

          <div class="col-md-12">

              <div class="form-group row">
                  <div class="col-md-6">
                      <span class="d-block text-primary h6 text-uppercase">Current Subject: </span>
                      <p class="mb-0">
                          <?php echo $subId; ?>
                      </p>
                  </div>

                  <div class="col-md-6">
                      <span class="d-block text-primary h6 text-uppercase">Current Program: </span>
                      <p class="mb-0">
                          <?php echo $program; ?>
                      </p>
                  </div>

              </div>

              <div class="form-group row">
                  <div class="col-md-6">
                      <span class="d-block text-primary h6 text-uppercase">Current Session: </span>
                      <p class="mb-0">
                          <?php echo $session; ?>
                      </p>
                  </div>

                  <div class="col-md-6">
                      <span class="d-block text-primary h6 text-uppercase">Current Section: </span>
                      <p class="mb-0">
                          <?php echo $section; ?>
                      </p>
                  </div>

              </div>

              <div class="form-group row">

                  <form action="edit_attendance_list.php" method="post">

                      <div class="col-md-12">

                          <label for="text" class="text-black">
                              Search Students<span class="text-danger"></span>
                          </label>
                          <input type="text" class="form-control" id="search" name="search" placeholder="Enter Student Name" />
                          <br />

                          <input type="hidden" name="record_to_view" value="<?php echo $record_to_view; ?>" />
                          <input type="hidden" name="program" value="<?php echo $program; ?>" />
                          <input type="hidden" name="subId" value="<?php echo $subId; ?>" />
                          <input type="hidden" name="section" value="<?php echo $section; ?>" />
                          <input type='hidden' name='session' value='<?php echo $session; ?>' />
                          <input type='hidden' name='QRcode' value='<?php echo $QRcode; ?>' />
                          <input type='hidden' name='attendPin' value='<?php echo $attendPin; ?>' />
                          <input type="submit" class="btn btn-primary btn-lg btn-block" value="Search" />

                          <br />

                      </div>

                  </form>

              </div>

              <div class="form-group row">

                      <div class="col-md-6">

                          <div class="logo">
                            <div class="site-logo">
                              <a href="<?php echo $QRcode ?>" target="_blank" class="js-logo-clone">PIN: <?php echo $attendPin ?></a>
                                <br /><br />
                            </div>
                          </div>

                          <a href="<?php echo $QRcode ?>" target="_blank" class="btn btn-primary btn-lg btn-block">Show QR Code</></a>

                      </div>

              </div>
                    
              <?php

              $path = $record_to_view;
              $reference = $database->getReference($path);
              $snapshot = $reference->getSnapshot();

              ?>

              <div class="site-blocks-table">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Student ID</th>
                    <th>Student Name</th>                    
                    <th>Attendance</th>
                    <th>Set Present</th> 
                    <th>Set Absent</th>
                  </tr>
                </thead>
                <tbody>

                    <?php

                    if (isset ($_POST['search']))
                    {

                        $search =  $_POST['search'];

                    }

                    else
                    {

                        $search = "";

                    }

                    if (!$snapshot->exists())
                    {

                    }

                    else
                    {

                        $reference = $database->getReference($path)->getValue();

                        foreach ($reference as $key => $rows)
                        {

                        if ($key != "attendPin" && $key != "attendStatus" && $key != "classDateTime" && $key != "QRcode")
                        {

                        $string = strtoupper ($rows ['stuName']);

                        if (str_contains($string, strtoupper($search)))
                        {

                    ?>

                  <tr>
                    <td><?php echo $rows ['stuId']; ?></td>
                    <td><?php echo $rows ['stuName']; ?></td> 
                    <td><?php echo $rows ['attendStatus']; ?></td>           

                    <td>
                      
                        <?php

                            $present = $record_to_view . '/' . $key;

                        ?>

                        <form action="attendance_present.php" method="post">
                                              
                            <input type="hidden" name="record_to_update" value="<?php echo $present; ?>" />
                            <input type="hidden" name="record_to_view" value="<?php echo $record_to_view; ?>" />
                            <input type="hidden" name="program" value="<?php echo $program; ?>" />
                            <input type="hidden" name="subId" value="<?php echo $subId; ?>" />
                            <input type="hidden" name="section" value="<?php echo $section; ?>" />
                            <input type='hidden' name='session' value='<?php echo $session; ?>' />
                            <input type='hidden' name='QRcode' value='<?php echo $QRcode; ?>' />
                            <input type='hidden' name='attendPin' value='<?php echo $attendPin; ?>' />
                            <button type="submit" name="view" value="" class="btn btn-primary btn-lg btn-block"><span class="icon-check"></span></button>

                        </form>
                       

                    </td>

                      <td>

                          <?php

                            $absent = $record_to_view . '/' . $key;

                          ?>

                          <form action="attendance_absent.php" method="post">

                              <input type="hidden" name="record_to_update" value="<?php echo $absent; ?>" />
                              <input type="hidden" name="record_to_view" value="<?php echo $record_to_view; ?>" />
                              <input type="hidden" name="program" value="<?php echo $program; ?>" />
                              <input type="hidden" name="subId" value="<?php echo $subId; ?>" />
                              <input type="hidden" name="section" value="<?php echo $section; ?>" />
                              <input type='hidden' name='session' value='<?php echo $session; ?>' />
                              <input type='hidden' name='QRcode' value='<?php echo $QRcode; ?>' />
                              <input type='hidden' name='attendPin' value='<?php echo $attendPin; ?>' />
                            <button type="submit" name="view" value="" class="btn btn-primary btn-lg btn-block"><span class="icon-close"></span></button>

                          </form>


                      </td>

                  </tr>

                    <?php
                                                                               
                        }

                    ?> 

                    <?php
                        
                        }

                    ?>
                    
                    <?php

                        }

                    ?>

                    <?php

                    }

                    ?>

                </tbody>            
              </table>
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