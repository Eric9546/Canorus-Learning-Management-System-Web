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
    $program = $_SESSION ['program'];

    // Ensure that only staff members can access //
    $path = 'Registration/' . $id;
    $reference = $database->getReference($path);
    $snapshot = $reference->getSnapshot();
    $value = $snapshot->getValue();

    if ($value ['access_level'] !== "Registry" && $value ['access_level'] !== "Admin")
    {
     
        alert ("You Do Not Have Access!");

    }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Edit Enrolment</title>
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
                <?php include('admin_nav.php'); ?>
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
            <h2 class="text-uppercase">Edit Enrolment</h2>
          </div>
        </div>
        
          <?php

            if (isset ($_POST ['session']) && isset ($_POST ['program']))
            {
        
                $program = $_POST ['program'];
                $session = $_POST ['session'];
        
            }

            else
            {
        
                $program = $_SESSION ['program'];
                $session = $_SESSION ['session'];
        
            }   

           ?>

          <div class="col-md-12">

            <div class="form-group row">
                <div class="col-md-6">
                    <span class="d-block text-primary h6 text-uppercase">Current Program: </span>
                    <p class="mb-0"><?php echo $program; ?></p>
                </div>
            
                <div class="col-md-6">
                    <span class="d-block text-primary h6 text-uppercase">Current Session: </span>
                    <p class="mb-0"><?php echo $session; ?></p>
                </div>
            </div>

            <div class="form-group row">

                <form action="edit_enrolment.php" method="post">

                    <div class="col-md-12">

                         <?php

                            $path = 'Program/';
                            $reference = $database->getReference($path)->getValue();

                        ?>
                        
                        <label for="c_email" class="d-block text-primary h6 text-uppercase">View Different Enrolment: </label>
                                      
                        <br />
                        <select name="program" required>

                            <?php

                                foreach ($reference as $key => $rows)
                                {
                              
                            ?>
                    
                                <option value="<?php echo $rows ['progCode'] ?>"><?php echo $rows ['progCode']; ?></option>
                                    
                            <?php
           
                                }

                        ?> 

                        </select>

                        <?php

                            $path = 'Session/';
                            $reference = $database->getReference($path)->getValue();

                        ?>

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

                        <br /><br />
                      
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="View Enrolments">

                    </div>
            
                </form>

            </div> 
              
            <div class="form-group row">

                <form action="edit_enrolment.php" method="post">

                    <div class="col-md-12">
                
                        <label for="text" class="text-black">Search Students<span class="text-danger"></span></label>
                        <input type="text" class="form-control" id="search" name="search" placeholder="Enter Student Name">
                        <br />

                        <input type="hidden" name="program" value="<?php echo $program; ?>" />
                        <input type="hidden" name="session" value="<?php echo $session; ?>" />
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Search">

                    </div>
            
                </form>

            </div>     

              <?php

                $path = 'Registration/';
                $reference = $database->getReference($path);
                $snapshot = $reference->getSnapshot();

               ?>

              <div class="site-blocks-table">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Student ID</th>
                    <th>Name</th>
                    <th>Program</th>
                    <th>Session</th>
                    <th>View Subjects</th>
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
                    
                            if ($rows ['program'] == $program && $rows ['session'] == $session)
                            {
                    
                            $string = strtoupper ($rows ['name']);

                            if (str_contains($string, strtoupper($search)))
                            {
                              
                    ?>

                  <tr>
                    <td><?php echo $rows ['id']; ?></td> 
                    <td><?php echo $rows ['name']; ?></td>        
                    <td><?php echo $rows ['program']; ?></td>
                    <td><?php echo $rows ['session']; ?></td>

                    <td>

                        <?php

                           $_SESSION ['record_to_view'] = $rows ['id'];
                           
                        ?>

                        <form action="edit_enrolment_student.php" method="post">
                    
                            <input type="hidden" name="record_to_view" value="<?php echo $rows ['id']; ?>" />
                            <input type="submit" name="delete" value="View" class="btn btn-primary height-auto btn-sm"/>

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