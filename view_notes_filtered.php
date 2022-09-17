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
    <title>View Notes</title>
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
            <h2 class="text-uppercase">View Notes</h2>
          </div>
        </div>
        
          <?php

            if (isset ($_POST ['subId']))
            {
        
                $subId = $_POST ['subId'];
        
            }

            else
            {
        
                $subId = $_SESSION ['subId'];
        
            }
   
           ?>

          <div class="col-md-12">

            <div class="form-group row">
                <div class="col-md-6">
                    <span class="d-block text-primary h6 text-uppercase">Current Subject: </span>
                    <p class="mb-0"><?php echo $subId; ?></p>
                </div>
                    
            </div>

            <div class="form-group row">

                <form action="view_notes_filtered.php" method="post">

                    <div class="col-md-12">
                        
                        <?php

                            $path = 'Subject/';
                            $reference = $database->getReference($path)->getValue();

                        ?>

                        <label for="c_email" class="d-block text-primary h6 text-uppercase">View Different Subject</label>
                                      
                        <br />
                        <select name="subId" required>

                            <?php

                                foreach ($reference as $key => $rows)
                                {

                                if ($rows ['lecId'] == $id)
                                {
                              
                            ?>
                    
                                <option value="<?php echo $rows ['subId'] ?>"><?php echo $rows ['subId']; ?> - <?php echo $rows ['subName']; ?></option>
                                    
                            <?php
           
                                }

                            ?> 

                            <?php
           
                                }

                            ?>

                        </select>

                        <br /><br />
                                            
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="View Notes">

                    </div>
            
                </form>

            </div>

              <div class="form-group row">

                <form action="add_content.php" method="post">

                    <div class="col-md-12">
                                   
                        <br />

                        <label for="text" class="text-black">Content Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="id" name="contentName" placeholder="Content Name" required>
                                            
                        <br />

                        <input type="hidden" name="subId" value="<?php echo $subId; ?>" />
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Add Content">

                    </div>
            
                </form>

            </div>
                      
              <?php

                $path = 'Note/' . $subId;
                $reference = $database->getReference($path);
                $snapshot = $reference->getSnapshot();

               ?>

              <div class="site-blocks-table">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Content Name</th>
                    <th>Edit</th> 
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
                              
                    ?>

                  <tr>
                    <td><?php echo $rows ['contentName']; ?></td> 
                    
                    <td>

                        <form action="edit_notes.php" method="post">
                    
                            <input type="hidden" name="contentName" value="<?php echo $rows ['contentName']; ?>" />
                            <input type="hidden" name="subId" value="<?php echo $subId; ?>" />
                            <button type="submit" name="view" value="" class="btn btn-primary btn-lg btn-block"><span class="icon-mode_edit"></span></button>

                        </form>

                    </td>

                    <td>

                        <?php

                           $record_to_remove = 'Note/' . $subId . "/" . $rows ['contentName'];
                           
                        ?>

                        <form action="remove_content.php" method="post">
                    
                            <input type="hidden" name="record_to_remove" value="<?php echo $record_to_remove; ?>" />
                            <input type="hidden" name="subId" value="<?php echo $subId; ?>" />
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