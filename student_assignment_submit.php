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
    <title>Submit Assignment</title>
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
            <h2 class="text-uppercase">Submit Assignment</h2>
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
                    <span class="d-block text-primary h6 text-uppercase">Current Assignment: </span>
                    <p class="mb-0"><?php echo $subId; ?> - <?php echo $assignTitle; ?></p>
                </div>
                    
            </div>   
                    
              <?php

                $path = $_POST ['record_to_submit'];
                $reference = $database->getReference($path);
                $snapshot = $reference->getSnapshot();
                $value = $snapshot->getValue();

               ?>

              <div class="site-blocks-table">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Assignment Question</th>
                    <th>Submission Date</th> 
                    <th>Status</th>
                    <th>Grade</th>
                    <th>Comment</th>
                    <th>Submission</th>
                  </tr>
                </thead>
                <tbody>

                    

                  <tr>
                    <td>
                     
                        <a href="<?php echo 'https://firebasestorage.googleapis.com/v0/b/canorus-18990.appspot.com/o/' . $value ['fileName'] . '?alt=media&'; ?>" target="_blank" class="btn btn-primary btn-lg btn-block"><span class="icon-open_in_new"></span></></a>

                    </td>                  

                    <?php

                        $path2 = 'Assignment/' . $subId . '/Submit/' . $assignTitle . '/' . $id;
                        $reference2 = $database->getReference($path2);
                        $snapshot2 = $reference2->getSnapshot();
                        $value2 = $snapshot2->getValue();

                        // Logic to check if the ID already exists //
                        if (is_null ($value2))
                        {

                    ?>

                    <td>Not Submitted</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>N/A</td>
                    <td>

                        <?php

                           $record_to_submit = 'Assignment/' . $subId . '/Submit/' . $assignTitle . '/' . $id;
                           
                        ?>

                        <form action="student_assignment_submit_execute.php" method="post" enctype="multipart/form-data">
                    
                            <input type="file" class="btn btn-primary btn-lg btn-block" name="myfile" required>
                            <br />
                            <input type="hidden" name="record_to_submit" value="<?php echo $record_to_submit; ?>" /> 
                            <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            <input type="hidden" name="subId" value="<?php echo $subId; ?>" />
                            <input type="hidden" name="assignTitle" value="<?php echo $assignTitle; ?>" />
                            <input type="submit" name="view" value="Submit" class="btn btn-primary btn-lg btn-block"/>

                        </form>

                    </td>

                    
                    <?php

                        }

                        else
                        {
                      
                    ?>

                    <td><?php echo $value2 ['submitDate']; ?></td>
                    <td><?php echo $value2 ['status']; ?></td>
                    <td><?php echo $value2 ['grade']; ?></td>
                    <td><?php echo $value2 ['comment']; ?></td>
                    <td>
                     
                        <a href="<?php echo 'https://firebasestorage.googleapis.com/v0/b/canorus-18990.appspot.com/o/' . $value2 ['fileName'] . '?alt=media&'; ?>" target="_blank" class="btn btn-primary btn-lg btn-block">View</></a>

                    </td>
                      
                    <?php

                        }
                           
                    ?>                   
                    
                  </tr>
      
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