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
    $session = $_SESSION ['session']; 

    if (isset ($_POST ['record_to_view']))
    {
        
        $record_to_view = $_POST ['record_to_view'];
        $_SESSION ['record_to_view'] = $record_to_view; 
        
    }

    else
    {
        
        $record_to_view = $_SESSION ['record_to_view'];
        
    }

    // Ensure that only staff members can access //
    $path = 'Registration/' . $id;
    $reference = $database->getReference($path);
    $snapshot = $reference->getSnapshot();
    $value = $snapshot->getValue();

    if ($value ['access_level'] !== "Program Officer" && $value ['access_level'] !== "Admin")
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
            <h2 class="text-uppercase">Subject Add/Drop</h2>
          </div>
        </div>
        
          <?php

            $path = 'Registration/' . $record_to_view;
            $reference = $database->getReference($path);
            $snapshot = $reference->getSnapshot();
            $value = $snapshot->getValue();

            $stuId = $value ['id'];

           ?>

          <div class="col-md-12">

            <div class="form-group row">
                <div class="col-md-6">
                    <span class="d-block text-primary h6 text-uppercase">Student ID: </span>
                    <p class="mb-0"><?php echo $value ['id']; ?></p>
                </div>
            
                <div class="col-md-6">
                    <span class="d-block text-primary h6 text-uppercase">Name: </span>
                    <p class="mb-0"><?php echo $value ['name']; ?></p>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <span class="d-block text-primary h6 text-uppercase">Email: </span>
                    <p class="mb-0"><?php echo $value ['email']; ?></p>
                </div>
            
                <div class="col-md-6">
                    <span class="d-block text-primary h6 text-uppercase">Phone: </span>
                    <p class="mb-0"><?php echo $value ['telno']; ?></p>
                </div>
            </div>

              <div class="form-group row">
                <div class="col-md-6">
                    <span class="d-block text-primary h6 text-uppercase">IC/Passport: </span>
                    <p class="mb-0"><?php echo $value ['ic']; ?></p>
                </div>
            
                <div class="col-md-6">
                    <span class="d-block text-primary h6 text-uppercase">Address: </span>
                    <p class="mb-0"><?php echo $value ['address']; ?></p>
                </div>
            </div>

              <div class="form-group row">
                <div class="col-md-6">
                    <span class="d-block text-primary h6 text-uppercase">Program: </span>
                    <p class="mb-0"><?php echo $value ['program']; $program = $value ['program']; ?></p>
                </div>
                <div class="col-md-6">
                    <span class="d-block text-primary h6 text-uppercase">Session: </span>
                    <p class="mb-0"><?php echo $value ['session']; $session = $value ['session']; ?></p>
                </div>
            
            </div>

              <div class="form-group row">

                <?php

                    $path = 'Subject/';
                    $reference = $database->getReference($path)->getValue();

                ?>

                <form action="admin_add_subject.php" method="post">

                    <div class="col-md-12">
                        
                        <label for="c_email" class="d-block text-primary h6 text-uppercase">Select Subject To Add: </label>
                    
                        <br />
                        <select name="subject" required>

                            <?php

                                foreach ($reference as $key => $rows)
                                {

                                if ($rows ['program'] == $program)
                                {

                                $str_arr = explode (",", $rows ['section']);

                                foreach ($str_arr as $secKey => $section)
                                {
                              
                            ?>

                            <option value="<?php echo $rows ['subId'] ?>,<?php echo $section ?> "><?php echo $rows ['subId']; echo " - "; echo $rows ['subName']; echo " ("; echo $section;  echo ")" ?></option>                          

                            <?php
           
                                }

                            ?> 

                            <?php
           
                                }

                            ?> 

                            <?php

                                }
                      
                            ?>

                        </select>

                        <br /><br />
                        <input type="hidden" id="custId" name="id" value="<?php echo $value ['id']; ?>">
                        <input type="hidden" id="custId" name="program" value="<?php echo $program; ?>"> 
                        <input type="hidden" id="custId" name="session" value="<?php echo $session; ?>">     
                        <input type="hidden" id="custId" name="payStatus" value="Unpaid">
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Add Subject">

                    </div>
            
                </form>

            </div> 
              
            <div class="form-group row">

                <form action="edit_enrolment_student.php" method="post">

                    <div class="col-md-12">
                
                        <label for="text" class="text-black">Search Subjects<span class="text-danger"></span></label>
                        <input type="text" class="form-control" id="search" name="search" placeholder="Enter Subject ID">
                        <br />

                        <input type="hidden" name="record_to_view" value="<?php echo $record_to_view; ?>" />                        
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Search">

                    </div>
            
                </form>

            </div>     

              <?php

                $path = 'Enrolment/' . $stuId;
                $reference = $database->getReference($path);
                $snapshot = $reference->getSnapshot();             

               ?>

              <div class="site-blocks-table">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Enrolled Subject(s)</th>
                    <th>Fee</th>
                    <th>Date</th>
                    <th>Section</th>
                    <th>Drop</th>
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
                    
                            if ($rows ['session'] == $session)
                            {
                    
                            if (str_contains($rows ['subId'], strtoupper($search)))
                            {
                              
                    ?>

                  <tr>
                    <td><?php echo $rows ['subId']; echo " - "; echo $rows ['subName']; ?></td>                  
                    <td>RM <?php echo $rows ['fee']; ?></td>
                    <td><?php echo $rows ['date']; ?></td>
                    <td><?php echo $rows ['section']; ?></td>

                    <td>

                        <?php

                            $record_to_remove = 'Enrolment/' . $stuId . "/" . $rows ['subId'];
                           
                        ?>

                        <form action="admin_drop_subject.php" method="post">

                            <input type="hidden" name="record_to_remove" value="<?php echo $record_to_remove; ?>" />
                            <input type="hidden" id="custId" name="program" value="<?php echo $program; ?>"> 
                            <input type="hidden" id="custId" name="session" value="<?php echo $session; ?>">     
                            <input type="hidden" id="custId" name="record_to_view" value="<?php echo $rows ['id']; ?>">
                            <input type="submit" name="delete" value="X" class="btn btn-primary height-auto btn-sm"/>

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