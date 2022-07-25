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

    if ($value ['access_level'] !== "Admin")
    {
     
        alert ("You Do Not Have Access!");

    }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Edit/Remove Staff</title>
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
    
    <?php

    $role = $_POST ['role'];

    $path = 'Registration/';
    $reference = $database->getReference($path);
    $snapshot = $reference->getSnapshot();

   ?>

   <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="title-section text-center mb-5 col-12">
            <h2 class="text-uppercase">View Staff</h2>
          </div>
        </div>

          <div class="form-group row">

                <form action="view_staff_filtered.php" method="post">

                    <div class="col-md-12">
                
                        <label for="text" class="text-black">Search Staff<span class="text-danger"></span></label>
                        <input type="text" class="form-control" id="search" name="search" placeholder="Enter Staff Name">
                        <br />

                        <input type="hidden" name="program" value="<?php echo $program; ?>" />
                        <input type="hidden" name="session" value="<?php echo $session; ?>" />
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Search">

                    </div>
            
                </form>

            </div>     

        <div class="row mb-5">
          <div class="col-md-12">
            <div class="site-blocks-table">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Password</th>
                    <th>Access Level</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>IC/Passport</th>
                    <th>Address</th> 
                    <th>Program</th>
                    <th>Session</th>
                    <th>Edit</th>
                    <th>Remove</th>
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

                            if ($rows ['access_level'] == $role)
                            {

                            $string = strtoupper ($rows ['name']);

                            if (str_contains($string, strtoupper($search)))
                            {

                    ?>

                        <tr>
               
                        <td><?php echo $rows ['id']; ?></td>
                        <td><?php echo $rows ['password']; ?></td>
                        <td><?php echo $rows ['access_level']; ?></td>
                        <td><?php echo $rows ['name']; ?></td>
                        <td><?php echo $rows ['email']; ?></td>
                        <td><?php echo $rows ['telno']; ?></td>
                        <td><?php echo $rows ['ic']; ?></td>
                        <td><?php echo $rows ['address']; ?></td>
                        <td><?php echo $rows ['program']; ?></td>
                        <td><?php echo $rows ['session']; ?></td>

                    <td>

                        <?php

                            $record_to_edit = $rows ['id'];
                            
                        ?>

                        <form action="edit_staff.php" method="post">

                            <input type="hidden" name="record_to_edit" value="<?php echo $record_to_edit; ?>" />                           
                            <input type="submit" name="edit" value="Edit" class="btn btn-primary btn-lg btn-block"/>

                        </form>                   

                    </td>

                    <td>

                        <?php

                            $record_to_remove = $rows ['id'];
                            
                        ?>

                        <form action="remove_staff.php" method="post">

                            <input type="hidden" name="record_to_remove" value="<?php echo $record_to_remove; ?>" />
                            <input type="hidden" name="newId" value="<?php echo $rows ['id']; ?>" />
                            <input type="hidden" name="access_level" value="<?php echo $rows ['access_level']; ?>" />
                            <input type="submit" name="delete" value="Remove" class="btn btn-primary btn-lg btn-block"/>

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