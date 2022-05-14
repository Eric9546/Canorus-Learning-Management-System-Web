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

if ($value ['access_level'] !== "Student")
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
                <?php include('student_nav.php'); ?>
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
              
          }

          else
          {
              
              $subId = $_SESSION ['subId'];
              $program = $_SESSION ['program'];
              $section = $_SESSION ['section'];
              $session = $_SESSION ['session'];
              
          }
          
          ?>

          <div class="col-md-12">

            <div class="form-group row">
                <div class="col-md-6">
                    <span class="d-block text-primary h6 text-uppercase">Current Subject: </span>
                    <p class="mb-0"><?php echo $subId; ?></p>
                </div>

                <div class="col-md-6">
                    <span class="d-block text-primary h6 text-uppercase">Current Program: </span>
                    <p class="mb-0"><?php echo $program; ?></p>
                </div>
                    
            </div>

              <div class="form-group row">
                <div class="col-md-6">
                    <span class="d-block text-primary h6 text-uppercase">Current Session: </span>
                    <p class="mb-0"><?php echo $session; ?></p>
                </div>

                <div class="col-md-6">
                    <span class="d-block text-primary h6 text-uppercase">Current Section: </span>
                    <p class="mb-0"><?php echo $section; ?></p>
                </div>
                    
            </div>
                    
              <?php             

              $path = 'Attendance/' . $session . '/' . $subId . "/" .  $section;
              $reference = $database->getReference($path);
              $snapshot = $reference->getSnapshot();

              ?>

              <div class="site-blocks-table">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Class Date</th>
                    <th>Attendance Status</th>                                                            
                    <th>Enter Attendance Pin</th>                   
                  </tr>
                </thead>
                <tbody>

                    <?php

                    if (!$snapshot->exists())
                    {

                    }

                    else
                    {

                        $reference = $database->getReference($path)->getValue();

                        foreach ($reference as $key => $rows)
                        {

                        if ($rows ['attendStatus'] != "Closed")
                        {

                        $path2 = 'Attendance/' . $session . '/' . $subId . "/" .  $section . '/' . $key . '/' . $id;
                        $reference2 = $database->getReference($path2);
                        $snapshot2 = $reference2->getSnapshot();
                        $value = $snapshot2->getValue();                       

                    ?>

                  <tr>
                    <td><?php echo $key; ?></td>
                    <td><?php echo $value ['attendStatus']; ?></td>                     
                      
                    <td>
                      
                        <?php

                            $record_to_refer = 'Attendance/' . $session . '/' . $subId . "/" .  $section . '/' . $key;
                            $record_to_view = 'Attendance/' . $session . '/' . $subId . "/" .  $section . '/' . $key . '/' . $id;

                        ?>

                        <form action="student_attendance_update.php" method="post">
                                              
                            <input type="text" class="form-group" id="id" name="attendPin" required />

                            <input type="hidden" name="record_to_view" value="<?php echo $record_to_view; ?>" />
                            <input type="hidden" name="record_to_refer" value="<?php echo $record_to_refer; ?>" />
                            <input type="hidden" name="program" value="<?php echo $program; ?>" />
                            <input type="hidden" name="subId" value="<?php echo $subId; ?>" />
                            <input type="hidden" name="section" value="<?php echo $section; ?>" />
                            <input type='hidden' name='session' value='<?php echo $session; ?>' />                           
                            <input type="submit" name="view" value="Submit Pin" class="btn btn-primary height-auto btn-sm"/>

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