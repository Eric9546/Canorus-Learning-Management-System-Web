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

    if ($value ['access_level'] !== "Student")
    {
     
        alert ("You Do Not Have Access!");

    }

    // Check if the student is pending payment //
    $path = 'Payment/' . $session . "/" . $id;
    $reference = $database->getReference($path);
    $snapshot = $reference->getSnapshot();
    $value = $snapshot->getValue();

    if (!is_null ($value))
    {

        alert ("Your Payment Has Been Sent/Completed!");

    }

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Make Payment</title>
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
              <a href="student_panel.php" class="js-logo-clone">Canorus</a>
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
            <h2 class="text-uppercase">Make Payment</h2>
          </div>
        </div>
     
          <div class="col-md-12">       

              <div class="site-blocks-table">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Payment Infomation</th>                   
                  </tr>
                </thead>
                <tbody>

                    <tr>

                        <td>You can use your online banking facilities to transfer to the following account.
                        Once you have performed the online transfer, please click on 'Upload Payment' 
                        button to enter your payment details and upload the payment receipt.
                        <br /><br />
                        Bank Name: Super Bank Berhad
                        <br />
                        Account No:5XXXXXXXXXXX
                        <br />
                        Payee Name: Your Glorious Leader Kim Jong Un Sdn Bhd
                        <br /><br />
                        <p style="color:red"><b>Please specify your Student ID or IC/Passport as reference during payment transfer.</b></p>
                        </td>

                    </tr>
                    

                </tbody>  
                 <thead>
                  <tr>
                    <th>Terms and Conditions</th>                   
                  </tr>
                </thead>
                <tbody>

                    <tr>

                        <td>By paying you have agreed to our fee charges policy that apply.</td>

                    </tr> 
                    
                </tbody>  
              </table>
               </div>

              <form action="student_checkout_execute.php" method="post" enctype="multipart/form-data">

                <div class="form-group row">
                    <div class="col-lg-3">
                        <p><label for="c_subject" class="text-black">Attach Payment Statement (PDF)<span class="text-danger">*</span></label></p>
                        <input type="file" class="btn btn-primary btn-lg btn-block" name="myfile" required>
                    </div>

                    <div class="col-lg-3">       
                        <p style="visibility:hidden"><label for="c_subject" class="text-black"><span class="text-danger">*</span></label></p>
                        <input type="submit" class="btn btn-primary btn-lg btn-block" value="Upload Payment">
                    </div>

                     <div class="col-lg-3">       
                        <p style="visibility:hidden"><label for="c_subject" class="text-black"><span class="text-danger">*</span></label></p>
                        <button class="btn btn-primary btn-lg btn-block" onclick="window.location='student_online_payment.php'">Online Payment</button>
                    </div>

                    <div class="col-lg-3">       
                        <p style="visibility:hidden"><label for="c_subject" class="text-black"><span class="text-danger">*</span></label></p>
                        <button class="btn btn-primary btn-lg btn-block" onclick="window.location='index.php'">Cancel</button>
                    </div>

                </div>

              </form>


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