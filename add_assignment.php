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
    <title>Add Assignment</title>
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
          <div class="col-md-12">
            <h2 class="h3 mb-3 text-black">Add Assignment</h2>

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

          </div>
          <div class="col-md-7">

            <form action="add_assignment_execute.php" method="post" enctype="multipart/form-data">
              
              <div class="p-3 p-lg-5 border">
                <div class="form-group row">
                  <div class="col-md-6">
                    <label for="text" class="text-black">Assignment Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="id" name="assignTitle" placeholder="Assignment Title" required>
                  </div>
                  <div class="col-md-6">
                    <label for="c_fname" class="text-black">Assignment Description <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="c_fname" name="assignDesc" placeholder="Assignment Description" required>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-12">
                    <label for="c_subject" class="text-black">Select The Due Date <span class="text-danger">*</span></label>
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
                  </div>
                </div>

                  <div class="form-group row">
                    <div class="col-md-12">                   
                    <label for="c_email" class="text-black">Time: </label>
                        
                    <select name="hour" >
                          <option value="01">1</option>
                          <option value="02">2</option>
                          <option value="03">3</option>
                          <option value="04">4</option>
                          <option value="05">5</option>
                          <option value="06">6</option>
                          <option value="07">7</option>
                          <option value="08">8</option>
                          <option value="09">9</option>
                          <option value="10">10</option>
                          <option value="11">11</option>
                          <option value="12">12</option>
                     </select>

                    <select name="min" >
                          <option value="00">00</option>
                          <option value="05">05</option>
                          <option value="10">10</option>
                          <option value="15">15</option>
                          <option value="20">20</option>
                          <option value="25">25</option>
                          <option value="30">30</option>
                          <option value="35">35</option>
                          <option value="40">40</option>
                          <option value="45">45</option>
                          <option value="50">50</option>
                          <option value="55">55</option>
                          <option value="59">59</option>
                     </select>

                    <select name="meridiem" >
                          <option value="AM">AM</option>
                          <option value="PM">PM</option>                        
                     </select>

                  </div>
                   
                </div>

                <div class="form-group row">
                  <div class="col-lg-12">
                    <label for="text" class="text-black">Attach Assignment File <span class="text-danger">*</span></label>
                    <input type="file" class="btn btn-primary btn-lg btn-block" name="myfile" required>
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-lg-12">
                    <input type="hidden" name="subId" value="<?php echo $subId; ?>" />
                    <input type="submit" class="btn btn-primary btn-lg btn-block" value="Add Assignment">
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="col-md-5 ml-auto">

            <div class="p-4 border mb-3">
                      
                <p><img src="images/function13.png" width="400" height="300"/></p>

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