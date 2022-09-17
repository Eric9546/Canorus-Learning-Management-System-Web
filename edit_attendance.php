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
    <title>Edit Attendance</title>
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
            <h2 class="text-uppercase">Edit Attendance</h2>
          </div>
        </div>
        
          <?php

          if (isset ($_POST ['subId']))
          {
              
              $subId = $_POST ['subId'];
              $program = $_POST ['program'];
              $section = $_POST ['section'];
              $session = $_POST ['session'];
              
          }

          else
          {
              
              $subId = $_SESSION ['subId'];
              $program = $_SESSION ['program'];
              $section = $_SESSION ['section'];
              $session = $_SESSION ['session'];
              
          }
          
          ?>

          <div class="col-md-12">

            <div class="form-group row">
                <div class="col-md-6">
                    <span class="d-block text-primary h6 text-uppercase">Current Subject: </span>
                    <p class="mb-0"><?php echo $subId; ?></p>
                </div>

                <div class="col-md-6">
                    <span class="d-block text-primary h6 text-uppercase">Current Program: </span>
                    <p class="mb-0"><?php echo $program; ?></p>
                </div>
                    
            </div>

              <div class="form-group row">
                <div class="col-md-6">
                    <span class="d-block text-primary h6 text-uppercase">Current Session: </span>
                    <p class="mb-0"><?php echo $session; ?></p>
                </div>

                <div class="col-md-6">
                    <span class="d-block text-primary h6 text-uppercase">Current Section: </span>
                    <p class="mb-0"><?php echo $section; ?></p>
                </div>
                    
            </div>

            <div class="form-group row">

                <form action="add_attendance.php" method="post">

                    <div class="col-md-12">

                        <label for="c_email" class="d-block text-primary h6 text-uppercase">Add Attendance Item: </label>
                                      
                        <br />

                        <label for="c_subject" class="text-black">Select The Class Date <span class="text-danger">*</span></label>
                    <br />
                    <label for="c_email" class="text-black">Date: </label>
                        <select name="day" required>
                              <option value="1">1</option>
                              <option value="2">2</option>
                              <option value="3">3</option>
                              <option value="4">4</option>
                              <option value="5">5</option>
                              <option value="6">6</option>
                              <option value="7">7</option>
                              <option value="8">8</option>
                              <option value="9">9</option>
                              <option value="10">10</option>
                              <option value="11">11</option>
                              <option value="12">12</option>
                              <option value="13">13</option>
                              <option value="14">14</option>
                              <option value="15">15</option>
                              <option value="16">16</option>
                              <option value="17">17</option>
                              <option value="18">18</option>
                              <option value="19">19</option>
                              <option value="20">20</option>
                              <option value="21">21</option>
                              <option value="22">22</option>
                              <option value="23">23</option>
                              <option value="24">24</option>
                              <option value="25">25</option>
                              <option value="26">26</option>
                              <option value="27">27</option>
                              <option value="28">28</option>
                              <option value="29">29</option>
                              <option value="30">30</option>
                              <option value="31">31</option>
                         </select>
                      
                        <select name="month" required>
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option>
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option>
                            <option value="9">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                         </select> 

                      <select name="year" >
                          <option value="2030">2030</option>
                          <option value="2029">2029</option>
                          <option value="2028">2028</option>
                          <option value="2027">2027</option>
                          <option value="2026">2026</option>
                          <option value="2025">2025</option>
                          <option value="2024">2024</option>
                          <option value="2023">2023</option>
                          <option value="2022">2022</option>
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
                        
                       

                        <br /><br />
                        <input type='hidden' name='program' value='<?php echo $program; ?>' />
                        <input type='hidden' name='subId' value='<?php echo $subId; ?>' /> 
                        <input type='hidden' name='section' value='<?php echo $section; ?>' /> 
                        <input type='hidden' name='session' value='<?php echo $session; ?>' />
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Add Attendance">

                        <br /><br />
         
                    

                </form>

            </div> 
                    
              <?php             

              $path = 'Attendance/' . $session . '/' . $subId . "/" .  $section;
              $reference = $database->getReference($path);
              $snapshot = $reference->getSnapshot();

              ?>

              <div class="site-blocks-table">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Class Date</th>
                    <th>Attendance Status</th>                    
                    <th>Attendance Pin</th>
                    <th>Set Open</th>
                    <th>Set Close</th>
                    <th>View Student List</th>
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
                    <td><?php echo $key; ?></td>
                    <td><?php echo $rows ['attendStatus']; ?></td> 
                    <td><?php echo $rows ['attendPin']; ?></td>  
                      
                    <td>
                      
                        <?php

                            $record_to_view = 'Attendance/' . $session . '/' . $subId . "/" .  $section . '/' . $key;

                        ?>

                        <form action="attendance_open.php" method="post">
                                              
                            <input type="hidden" name="record_to_view" value="<?php echo $record_to_view; ?>" />
                            <input type="hidden" name="program" value="<?php echo $program; ?>" />
                            <input type="hidden" name="subId" value="<?php echo $subId; ?>" />
                            <input type="hidden" name="section" value="<?php echo $section; ?>" />
                            <input type='hidden' name='session' value='<?php echo $session; ?>' />                           
                            <input type="submit" name="view" value="Set Open" class="btn btn-primary height-auto btn-sm"/>

                        </form>
                       

                    </td>

                    <td>
                      
                        <?php

                            $record_to_view = 'Attendance/' . $session . '/' . $subId . "/" .  $section . '/' . $key;

                        ?>

                        <form action="attendance_close.php" method="post">
                                              
                            <input type="hidden" name="record_to_view" value="<?php echo $record_to_view; ?>" />
                            <input type="hidden" name="program" value="<?php echo $program; ?>" />
                            <input type="hidden" name="subId" value="<?php echo $subId; ?>" />
                            <input type="hidden" name="section" value="<?php echo $section; ?>" />
                            <input type='hidden' name='session' value='<?php echo $session; ?>' />
                            <input type="submit" name="view" value="Set Close" class="btn btn-primary height-auto btn-sm"/>

                        </form>
                       

                    </td>

                    <td>
                      
                        <?php

                            $record_to_view = 'Attendance/' . $session . '/' . $subId . "/" .  $section . '/' . $key;

                        ?>

                        <form action="edit_attendance_list.php" method="post">
                                              
                            <input type="hidden" name="record_to_view" value="<?php echo $record_to_view; ?>" />
                            <input type="hidden" name="program" value="<?php echo $program; ?>" />
                            <input type="hidden" name="subId" value="<?php echo $subId; ?>" />
                            <input type="hidden" name="section" value="<?php echo $section; ?>" />
                            <input type='hidden' name='session' value='<?php echo $session; ?>' />
                            <input type='hidden' name='QRcode' value='<?php echo $rows ['QRcode']; ?>' />
                            <input type='hidden' name='attendPin' value='<?php echo $rows ['attendPin']; ?>' />
                            <button type="submit" name="view" value="" class="btn btn-primary btn-lg btn-block"><span class="icon-open_in_new"></span></button>

                        </form>
                       

                    </td>

                    <td>
                      
                        <?php

                            $record_to_remove = 'Attendance/' . $session . '/' . $subId . "/" .  $section . '/' . $key;

                        ?>

                        <form action="remove_attendance.php" method="post">
                                              
                            <input type="hidden" name="record_to_remove" value="<?php echo $record_to_remove; ?>" />
                            <input type="hidden" name="program" value="<?php echo $program; ?>" />
                            <input type="hidden" name="subId" value="<?php echo $subId; ?>" />
                            <input type="hidden" name="section" value="<?php echo $section; ?>" />
                            <input type='hidden' name='session' value='<?php echo $session; ?>' />
                            <input type='hidden' name='QRcode' value='<?php echo $rows ['QRcode']; ?>' />
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