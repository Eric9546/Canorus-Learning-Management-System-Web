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

    if ($value ['access_level'] !== "Program Officer" && $value ['access_level'] !== "Admin")
    {
     
        alert ("You Do Not Have Access!");

    }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Edit Classes</title>
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
            <h2 class="text-uppercase">View Classes</h2>
          </div>
        </div>
        
          <?php

            if (isset ($_POST ['subId']) && isset ($_POST ['program']))
            {
        
                $program = $_POST ['program'];
                $subId = $_POST ['subId'];
        
            }

            else
            {
        
                $program = $_SESSION ['program'];
                $subId = $_SESSION ['subId'];
        
            }   

           ?>

          <div class="col-md-12">

            <div class="form-group row">
                <div class="col-md-6">
                    <span class="d-block text-primary h6 text-uppercase">Current Program: </span>
                    <p class="mb-0"><?php echo $program; ?></p>
                </div>
            
                <div class="col-md-6">
                    <span class="d-block text-primary h6 text-uppercase">Current Subject: </span>
                    <p class="mb-0"><?php echo $subId; ?></p>
                </div>
            </div>

              <div class="form-group row">

                <form action="add_class.php" method="post">

                    <div class="col-md-12">

                        <label for="c_email" class="d-block text-primary h6 text-uppercase">Add Class: </label>
                                      
                        <br />

                        <label for="c_email" class="text-black">Day: </label>
                        <select name="day" required>

                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            
                        </select>
                        
                        <label for="c_email" class="text-black"></label>
                        <label for="c_email" class="text-black">Time Start: </label>
                        <select name="timeStart" required>

                            <option value="8:00am">8.00am</option>
                            <option value="9:00am">9.00am</option>
                            <option value="10:00am">10.00am</option>
                            <option value="11:00am">11.00am</option>
                            <option value="12:00pm">12.00pm</option>
                            <option value="1:00pm">1.00pm</option>
                            <option value="2:00pm">2.00pm</option>
                            <option value="3:00pm">3.00pm</option>
                            <option value="4:00pm">4.00pm</option>
                            <option value="5:00pm">5.00pm</option>
                            
                        </select>
                        
                        <label for="c_email" class="text-black"></label>
                        <label for="c_email" class="text-black">Time End: </label>
                        <select name="timeEnd" required>

                            <option value="9:00am">9.00am</option>
                            <option value="10:00am">10.00am</option>
                            <option value="11:00am">11.00am</option>
                            <option value="12:00pm">12.00pm</option>
                            <option value="1:00pm">1.00pm</option>
                            <option value="2:00pm">2.00pm</option>
                            <option value="3:00pm">3.00pm</option>
                            <option value="4:00pm">4.00pm</option> 
                            <option value="5:00pm">5.00pm</option>
                            <option value="6:00pm">6.00pm</option>

                        </select>
                        
                        <label for="c_email" class="text-black"></label>
                        <label for="c_email" class="text-black">Type: </label>
                        <select name="type" required>

                            <option value="Lecture">Lecture</option>
                            <option value="Tutorial">Tutorial</option>
                            <option value="Practical">Practical</option>
                            <option value="Online">Online</option>

                        </select>
                        
                        <?php

                            $path = 'Subject/' . $subId;
                            $reference = $database->getReference($path);
                            $snapshot = $reference->getSnapshot();
                            $value = $snapshot->getValue();

                            $str_arr = explode (",", $value ['section']);
                            $lecId = $value ['lecId'];

                        ?>
                     
                        <label for="c_email" class="text-black"></label>
                        <label for="c_email" class="text-black">Section <span class="text-danger"></span></label>                                                                 

                        <?php

                            foreach ($str_arr as $key => $rows)
                            {
                              
                        ?>
                    
                            <input type="checkbox" class="form-group" name="section[]" value="<?php echo $rows; ?>">
                            <label for="c_email" class="text-black"><?php echo $rows; ?></label>
                                    
                        <?php
           
                            }

                        ?> 
                       
                        <br /><br />
                        
                        <label for="c_email" class="text-black">Room: </label>
                        <input type="text" class="form-control" id="c_address" name="room" placeholder="Room" required>

                        <br />
                        <input type='hidden' name='program' value='<?php echo $program; ?>' />
                        <input type='hidden' name='subject' value='<?php echo $subId; ?>' />
                        <input type='hidden' name='lecId' value='<?php echo $lecId; ?>' />
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Add Class">

                        <br /><br />
         
                </form>

            </div> 
                     

              <?php

                $path = 'Class/' . $program . "/" .  $subId;
                $reference = $database->getReference($path);
                $snapshot = $reference->getSnapshot();

               ?>

              <div class="site-blocks-table">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Day</th>
                    <th>Time</th>                    
                    <th>Room</th>
                    <th>Type</th>
                    <th>Section</th>
                    <th>Lecturer ID</th>
                    <th>Remove</th>
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
                    <td><?php echo $rows ['day']; ?></td> 
                    <td><?php echo $rows ['timeStart']; ?> - <?php echo $rows ['timeEnd']; ?></td>        
                    <td><?php echo $rows ['room']; ?></td>
                    <td><?php echo $rows ['type']; ?></td>
                    <td><?php echo $rows ['section']; ?></td>
                    <td><?php echo $rows ['lecId']; ?></td>

                    <td>

                        <?php

                           $record_to_remove = 'Class/' . $program . "/" . $subId . "/" . $rows ['uuid'];
                           
                        ?>

                        <form action="remove_class.php" method="post">
                    
                            <input type="hidden" name="record_to_remove" value="<?php echo $record_to_remove; ?>" />
                            <input type="hidden" name="program" value="<?php echo $program; ?>" />
                            <input type="hidden" name="subId" value="<?php echo $subId; ?>" />
                            <input type="hidden" name="day" value="<?php echo $rows ['day']; ?>" />
                            <input type="hidden" name="timeStart" value="<?php echo $rows ['timeStart']; ?>" />
                            <input type="hidden" name="timeEnd" value="<?php echo $rows ['timeEnd']; ?>" />
                            <input type="submit" name="delete" value="Remove" class="btn btn-primary height-auto btn-sm"/>

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