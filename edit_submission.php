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
    <title>View Assignment Submission</title>
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
            <h2 class="text-uppercase">View Assignment Submission</h2>
          </div>
        </div>
        
          <?php

            if (isset ($_POST ['subId']))
            {
        
                $subId = $_POST ['subId'];
                $assignTitle = $_POST ['assignTitle'];
        
            }

            else
            {
        
                $subId = $_SESSION ['subId'];
                $assignTitle = $_SESSION ['assignTitle'];
        
            }
   
           ?>

          <div class="col-md-12">

            <div class="form-group row">
                <div class="col-md-6">
                    <span class="d-block text-primary h6 text-uppercase">Current Subject: </span>
                    <p class="mb-0"><?php echo $subId; ?> - <?php echo $assignTitle; ?></p>
                </div>
                    
            </div>

            <?php

                if (isset ($_POST ['record_to_view']))
                {

                    $path = $_POST ['record_to_view'];

                }

                else
                {
                
                    $path = $_SESSION ['record_to_view'];

                }

            ?>

            <div class="form-group row">

                <form action="edit_submission.php" method="post">

                    <div class="col-md-12">
                
                        <label for="text" class="text-black">Search Student ID<span class="text-danger"></span></label>
                        <input type="text" class="form-control" id="search" name="search" placeholder="Enter Student ID">
                        <br />

                        <input type="hidden" name="record_to_view" value="<?php echo $path; ?>" />
                        <input type="hidden" name="subId" value="<?php echo $subId; ?>" />
                        <input type="hidden" name="assignTitle" value="<?php echo $assignTitle; ?>" />
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Search">

                    </div>
            
                </form>

            </div>

            <div class="form-group row">

                <form action="edit_submission.php" method="post">

                    <div class="col-md-12">
                         
                        <input type="hidden" name="filter" value="N/A" />
                        <input type="hidden" name="record_to_view" value="<?php echo $path; ?>" />
                        <input type="hidden" name="subId" value="<?php echo $subId; ?>" />
                        <input type="hidden" name="assignTitle" value="<?php echo $assignTitle; ?>" />
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Hide Graded Assignments">

                    </div>
            
                </form>

            </div>
            
              <?php

                $reference = $database->getReference($path);
                $snapshot = $reference->getSnapshot();

              ?>

              <div class="site-blocks-table">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Student ID</th>
                    <th>Student Submission</th>                     
                    <th>Grade</th>
                    <th>Comment</th>                   
                    <th>Delete</th>
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
                        
                        if (isset ($_POST['filter'])) 
                        {

                            $filter =  $_POST['filter'];

                        }

                        else
                        {
                            
                            $filter = "";

                        }   

                        if (!$snapshot->exists())
                        {
                                              
                        }

                        else
                        {

                            $reference = $database->getReference($path)->getValue();
                    
                            foreach ($reference as $key => $rows)
                            {
                                
                            if (str_contains($rows ['id'], strtoupper($search)))
                            {

                            if (str_contains($rows ['grade'], strtoupper($filter)))
                            {
                              
                    ?>

                  <tr>
                    
                    <td><?php echo $rows ['id']; ?></td>
                    <td>
                     
                        <a href="<?php echo 'https://storage.googleapis.com/canorus-18990.appspot.com/' . $rows ['fileName']; ?>" target="_blank" class="btn btn-primary btn-lg btn-block">View</></a>

                    </td>

                    <?php

                        $record_to_update = 'Assignment/' . $subId . '/Submit/' . $assignTitle . '/' . $rows ['id'];
                                
                    ?>

                    <td>

                        <form action="update_grade.php" method="post">
                            <span><?php echo $rows ['grade']; ?><br/></span>                          
                            <br />
                            <input type="text" class="form-control" id="id" name="grade" placeholder="Update Grade" >                            
                            <input type="hidden" name="record_to_update" value="<?php echo $record_to_update; ?>" />
                            <input type="hidden" name="record_to_view" value="<?php echo $path; ?>" />
                            <input type="hidden" name="subId" value="<?php echo $subId; ?>" />
                            <input type="hidden" name="assignTitle" value="<?php echo $assignTitle; ?>" />
                            <br />
                            <input type="submit" name="update" value="Update" class="btn btn-primary btn-lg btn-block"/>   
                        </form>

                    </td>

                    <td>
                        <form action="update_comment.php" method="post">
                            <span><?php echo $rows ['comment']; ?><br/></span> 
                            <br />
                            <input type="text" class="form-control" id="id" name="comment" placeholder="Update Comment">                          
                            <input type="hidden" name="record_to_update" value="<?php echo $record_to_update; ?>" />
                            <input type="hidden" name="record_to_view" value="<?php echo $path; ?>" />
                            <input type="hidden" name="subId" value="<?php echo $subId; ?>" />
                            <input type="hidden" name="assignTitle" value="<?php echo $assignTitle; ?>" />
                            <br />
                            <input type="submit" name="update" value="Update" class="btn btn-primary btn-lg btn-block"/> 
                        </form>
                    </td>

                      

                    <td>

                        <?php

                                $record_to_remove = 'Assignment/' . $subId . '/Submit/' . $assignTitle . '/' . $rows ['id'];        
                                
                        ?>

                        <form action="remove_submission.php" method="post">
                    
                            <input type="hidden" name="record_to_remove" value="<?php echo $record_to_remove; ?>" />
                            <input type="hidden" name="record_to_view" value="<?php echo $path; ?>" />
                            <input type="hidden" name="subId" value="<?php echo $subId; ?>" />
                            <input type="hidden" name="assignTitle" value="<?php echo $assignTitle; ?>" />
                            <input type="hidden" name="fileName" value="<?php echo $rows ['fileName']; ?>" />
                            <input type="submit" name="delete" value="Delete" class="btn btn-primary btn-lg btn-block"/>

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