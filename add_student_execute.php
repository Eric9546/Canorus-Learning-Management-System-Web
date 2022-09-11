<?php

session_start ();

// Declaring function for alert message //
function alert ($msg)
{

    echo "<script type='text/javascript'>alert('$msg'); window.location='index.php';</script>";

}

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
    include ('storagecon.php');

    // Gathering the user input //
    $access_level = "Student";
    $name = $_POST ['name'];
    $email = $_POST ['email'];
    $telno = $_POST ['telno'];
    $ic = $_POST ['ic'];
    $address = $_POST ['address'];
    $program = $_POST ['program'];
    $session = $_POST ['session'];

    if (empty ($access_level))
    {

        alert ("Error Please Check Your Access Level!");

    }

    else if (empty ($name))
    {

        alert ("Error Please Check Your Name!");

    }

    else if (is_numeric ($name))
    {

        alert ("Error Please Check Your Name!");

    }

    else if (empty ($email))
    {

        alert ("Error Please Check Your Email!");

    }

    else if (empty ($telno))
    {

        alert ("Error Please Check Your Phone!");

    }

    else if (!is_numeric ($telno))
    {

        alert ("Error Please Check Your Phone!");

    }

    else if (empty ($ic))
    {

        alert ("Error Please Check Your IC/Passport!");

    }

    else if (empty ($address))
    {

        alert ("Error Please Check Your Address!");

    }

    else if (empty ($program))
    {

        alert ("Error Please Check Your Program!");

    }

    else if (empty ($session))
    {

        alert ("Error Please Check Your Session!");

    }

    // Generate ID and password //
    date_default_timezone_set('Asia/Singapore');
    $logDate = date("Ymd");
    $logTime = date("is");
    $finalLogDate = mb_substr($logDate, 2, 6);

    $id = "S" . $finalLogDate . $logTime;
    $password = "s" . $ic;

    // Capitalize the id //
    $id = strtoupper ($id);

    // Query to check if ID already exists //
    $path = 'Registration/' . $id;
    $reference = $database->getReference($path);
    $snapshot = $reference->getSnapshot();
    $value = $snapshot->getValue();

    // Logic to check if the ID already exists //
    if (!is_null ($value))
    {

        alert ("Student ID Already Exists!");

    }

    else
    {

        // Handle the file storage //
        $filename = $_FILES['myfile']['name'];

        // Getting the file extension //
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
       
        // Logic to check the extension of the file //
        if (!in_array($extension, ['pdf'])) 
        {

            alert ("Your File Format Must Be In PDF!");

        } 

        else
        {

            // Upload the file //
            $newfilename = "STUDENT".  "_" . $id . "_" . $program . "_" . $session . ".pdf";

            // The physical file on a temporary uploads directory on the server //
            $file = $_FILES['myfile']['tmp_name'];       

            // Destination of the file on the server //
            $destination = 'uploads/' . $newfilename;

            // Move the file to the correct folder //
            move_uploaded_file($file, $destination);

            // Uploading file to cloud server storage //
            $bucketName = 'canorus-18990.appspot.com';
            $fileName = $destination;
            $bucket = $storage->bucket($bucketName);
            $object = $bucket->upload(
                                        fopen($fileName, 'r'),
                                        [
                                            'predefinedAcl' => 'publicRead'
                                        ]
                                    );
            
            // Clear local temp file //
            unlink ($destination);
            
            // Inserting the data into the database table //
            $postData = [

                            'id' => $id,
                            'password' => $password,
                            'access_level' => $access_level,
                            'name' => $name,
                            'email' => $email,
                            'telno' => $telno,
                            'ic' => $ic,
                            'address' => $address,
                            'program' => $program,
                            'session' => $session,
                            'filename' => $newfilename,

                        ];

            $ref_table = "Registration/" . $id;
            $postRef_result = $database->getReference($ref_table)->set($postData);

            // Sending the email to notify the student//
            $mail = new PHPMailer ();

            $mail -> isSMTP ();

            $mail -> Host = "smtp.mailgun.org";

            $mail -> SMTPAuth = "true";

            $mail -> SMTPSecure = "tls";

            $mail -> Port = "587";

            $mail -> Username = "postmaster@sandbox9a189234a5e64ef0a823c2cf47daaeba.mailgun.org";

            $mail -> Password = "87d79c294275468fec083d7839d383d4-1b237f8b-d24d52dc";

            $mail -> Subject = "Student Registration Successful";

            $mail -> setFrom ("postmaster@sandbox9a189234a5e64ef0a823c2cf47daaeba.mailgun.org", "Canorus Learning Management System");

            $mail -> Body = ("This Is To Inform You That The You Have Been Successfully Registered On The Canorus Learning Management System.
            Student Login ID: $id
            Student Login Password: $password
            Student Name: $name
            Student Program: $program
            Student Session: $session

            You May Access Your Student Account on https://canorus.epizy.com/login.php or the Canorus Android Mobile Application");

            $mail -> addAddress ("$email");

            $mail -> smtpClose ();

            if ($mail-> Send())
            {

                $_SESSION ['log_id'] = $_SESSION ['id'];
                $_SESSION ['log_stuId'] = $id;
                $_SESSION ['log_program'] = $program;
                $_SESSION ['log_session'] = $session;

                header ("Location: log_add_student.php");

            }

            else
            {

                alert ("Error Please Retry!");

            }

        }

    }

}

?>