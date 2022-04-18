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
    $session = $_SESSION ['session'];

    // Ensure that only student can access//
    $path = 'Registration/' . $id;
    $reference = $database->getReference($path);
    $snapshot = $reference->getSnapshot();
    $value = $snapshot->getValue();

    if ($value ['access_level'] !== "Teaching" && $value ['access_level'] !== "Admin")
    {
     
        alert ("You Do Not Have Access!");

    }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>View Lecturer Timetable</title>
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
            <h2 class="text-uppercase">View Lecturer Timetable</h2>
          </div>
        </div>
     
          <div class="col-md-12">
    
              <?php

                $lecId = $_POST ['lecId'];

                $path = 'Class/';
                $reference = $database->getReference($path);
                $snapshot = $reference->getSnapshot();

               ?>

              <div class="site-blocks-table">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Subject(s)</th>
                    <th>Section</th> 
                    <th>Day</th>              
                    <th>Time</th>                   
                    <th>Room</th>
                    <th>Type</th>                   
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
                    
                                $path2 = 'Class/' . $key . "/";
                                $reference2 = $database->getReference($path2);
                                $snapshot2 = $reference2->getSnapshot();
                            
                                $reference2 = $database->getReference($path2)->getValue();
                    
                                foreach ($reference2 as $key2 => $rows2)
                                {  

                                    $path4 = 'Subject/' . $key2;
                                    $reference4 = $database->getReference($path4);
                                    $snapshot4 = $reference4->getSnapshot();
                                    $value4 = $snapshot4->getValue();

                                    $subName = $value4 ['subName'];
                    
                                    $path3 = 'Class/' . $key . "/" . $key2;
                                    $reference3 = $database->getReference($path3);
                                    $snapshot3 = $reference3->getSnapshot();
                            
                                    $reference3 = $database->getReference($path3)->getValue();
                    
                                    foreach ($reference3 as $key3 => $rows3)
                                    {  

                                        if ($rows3 ['lecId'] == $lecId)
                                        {

                    ?>

                  <tr>
                    <td><?php echo $key2; ?> - <?php echo $subName; ?></td>
                    <td><?php echo $rows3 ['section']; ?></td>
                    <td><?php echo $rows3 ['day']; ?></td>
                    <td><?php echo $rows3 ['timeStart']; echo " - "; echo $rows3 ['timeEnd']; ?></td>                    
                    <td><?php echo $rows3 ['room']; ?></td>
                    <td><?php echo $rows3 ['type']; ?></td>                   
           
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