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
    <title>Edit Notes</title>
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
            <h2 class="text-uppercase">Edit Notes</h2>
          </div>
        </div>
        
          <?php

            if (isset ($_POST ['subId']))
            {
        
                $subId = $_POST ['subId'];
                $contentName = $_POST ['contentName'];
        
            }

            else
            {
        
                $subId = $_SESSION ['subId'];
                $contentName = $_SESSION ['contentName'];
        
            }
            
           ?>

          <div class="col-md-12">
         
              <div class="form-group row">

                <form action="add_notes.php" method="post" enctype="multipart/form-data">

                    <div class="col-md-12">
                                   
                        <br />

                        <label for="text" class="text-black">File Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="id" name="fileTitle" placeholder="File Title" required>

                        <br />

                        <label for="text" class="text-black">File Description <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="id" name="fileDesc" placeholder="File Description" required>
                                            
                        <br />

                        <label for="text" class="text-black">Attach File <span class="text-danger">*</span></label>
                        <input type="file" class="btn btn-primary btn-lg btn-block" name="myfile" required>
                                            
                        <br />

                        <input type="hidden" name="subId" value="<?php echo $subId; ?>" />
                        <input type="hidden" name="contentName" value="<?php echo $contentName; ?>" />
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Add Notes">

                    </div>
            
                </form>

            </div>
                      
              <?php

                $path = 'Note/' . $subId . "/" . $contentName;
                $reference = $database->getReference($path);
                $snapshot = $reference->getSnapshot();

               ?>

              <div class="site-blocks-table">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>File Title</th>
                    <th>File Description</th>
                    <th>View</th> 
                    <th>Delete</th>
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
                    
                            if ($key != "contentName")
                            {
                              
                    ?>

                  <tr>
                    <td><?php echo $rows ['fileTitle']; ?></td> 
                    <td><?php echo $rows ['fileDesc']; ?></td> 
                    
                    <td>
                     
                        <a href="<?php echo 'https://firebasestorage.googleapis.com/v0/b/canorus-18990.appspot.com/o/' . $rows ['fileName'] . '?alt=media&'; ?>" target="_blank" class="btn btn-primary btn-lg btn-block"><span class="icon-open_in_new"></span></></a>

                    </td>

                    <td>

                        <?php

                           $record_to_remove = 'Note/' . $subId . "/" . $contentName . "/" . $rows ['fileTitle'];
                           
                        ?>

                        <form action="remove_notes.php" method="post">
                    
                            <input type="hidden" name="record_to_remove" value="<?php echo $record_to_remove; ?>" />
                            <input type="hidden" name="fileName" value="<?php echo $rows ['fileName']; ?>" />
                            <input type="hidden" name="subId" value="<?php echo $subId; ?>" />
                            <input type="hidden" name="contentName" value="<?php echo $contentName; ?>" />
                            <button type="submit" name="view" value="" class="btn btn-primary btn-lg btn-block"><span class="icon-delete"></span></button>

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