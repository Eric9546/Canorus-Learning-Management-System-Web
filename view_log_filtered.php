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
    
    if ($_SESSION ['access_level'] !== "Main" && $_SESSION ['access_level'] !== "Admin")
    {
     
        alert ("You Do Not Have Access!");

    }

    // Establish connection to the logs database //
    include ('logcon.php');
    $collection = $firestore->collection($_POST["day"] . "-" . $_POST["month"] . "-" . $_POST["year"] . "-" . $_POST["type"]);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>View Log</title>
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
            <h2 class="text-uppercase">View Logs</h2>
          </div>
        </div>

        <div class="row mb-5">
          <div class="col-md-12">
            <div class="site-blocks-table">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Logs Date: <?php echo $_POST["day"] . "-" . $_POST["month"] . "-" . $_POST["year"] . "-" . $_POST["type"]; ?></th>                   
                  </tr>
                </thead>
                <tbody>

                <?php foreach ($collection->documents() as $document) { ?>

                    <?php echo "<tr>"; ?> 

                        <?php echo "<td>"; ?> 
                   
                            <?php

                                    echo $document->data() ['logMsg'];
                               
                            ?>

                        <?php echo "</td>"; ?> 
  
                    <?php echo "</tr>"; ?> 
                    
                 <?php } ?>   

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