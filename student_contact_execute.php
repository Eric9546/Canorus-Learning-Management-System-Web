<?php

    session_start ();

    // Declaring function for alert message //
    function alert ($msg)
    {

        echo "<script type='text/javascript'>alert('$msg'); window.location='index.php';</script>";

    }

    $id = $_SESSION ['id'];

    // Setting up PHPMailer//
    require 'phpmailer/PHPMailer.php';
    require 'phpmailer/SMTP.php';
    require 'phpmailer/Exception.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

     // Ensure that the user is logged in //
     if (!isset ($_SESSION ['id']))
     {
              
        header ("Location: login.php");
                    
     }

     else
     {

        // Establishing connection to database //
        include ('dbcon.php');

        // Gathering the user input //
        $lecId = $_POST ['lecId'];   
        $message = $_POST ['message'];

        // Validating the input //
        if (empty ($lecId))
        {

            alert ("Error Please Check Your Lecturer!");

        }

        else if (empty ($message))
        {

            alert ("Error Please Check Message!");

        }

        // Query to get lecturer email //
        $path = 'Lecturer/' . $lecId;
        $reference = $database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        $lecEmail = $value ['email'];

        // Query to get student email //
        $path = 'Registration/' . $id;
        $reference = $database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        $studentId = $value ['id'];
        $studentName = $value ['name'];
        $studentEmail = $value ['email'];
        $studentProgram = $value ['program'];

        // Sending the email //
        $mail = new PHPMailer ();

        $mail -> isSMTP ();

        $mail -> Host = "smtp.mailgun.org";

        $mail -> SMTPAuth = "true";

        $mail -> SMTPSecure = "tls";

        $mail -> Port = "587";

        $mail -> Username = "postmaster@sandbox9a189234a5e64ef0a823c2cf47daaeba.mailgun.org";

        $mail -> Password = "87d79c294275468fec083d7839d383d4-1b237f8b-d24d52dc";

        $mail -> Subject = "Student Message";

        $mail -> setFrom ("postmaster@sandbox9a189234a5e64ef0a823c2cf47daaeba.mailgun.org", "Canorus Learning Management System");

        $mail -> Body = ("This Is To Inform You That The Following Student Sent A Message To You.
        Student ID: $studentId 
        Student Name: $studentName
        Student Program: $studentProgram 
        Message: $message 
        You May Reply To This Email To Contact The Student");

        $mail -> addAddress ("$lecEmail");

        $mail -> addReplyTo("$studentEmail", "$studentName");

        $mail -> smtpClose ();

        if($mail-> Send()) 
        {

        header ("Location:user_success.php");

        } 

        else 
        {

        header ("Location:user_failure.php");

        }  

     }

?>