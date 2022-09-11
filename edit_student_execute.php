<?php

session_start ();
if (!isset ($_SESSION ['id']))
{

    header ("Location: login.php");

}

$id = $_SESSION ['id'];

// Declaring function for alert message //
function alert ($msg)
{

    echo "<script type='text/javascript'>alert('$msg'); window.location='view_student.php';</script>";

}

// Establishing connection to database //
include ('dbcon.php');
include ('storagecon.php');

// Gathering the input from user //
$record_to_edit = $_POST ['record_to_edit'];
$password = $_POST ['password'];
$access_level = "Student";
$name = $_POST ['name'];
$email = $_POST ['email'];
$telno = $_POST ['telno'];
$ic = $_POST ['ic'];
$address = $_POST ['address'];
$program = $_POST ['program'];
$session = $_POST ['session'];
$filename = $_FILES['myfile']['name'];

$path = 'Registration/' . $record_to_edit;
$reference = $database->getReference($path);
$snapshot = $reference->getSnapshot();
$value = $snapshot->getValue();

if ($password == NULL)
{

    $password = $value ['password'];

}

if ($name == NULL)
{

    $name = $value ['name'];

}

if ($email == NULL)
{

    $email = $value ['email'];

}

if ($telno == NULL)
{

    $telno = $value ['telno'];

}

if ($ic == NULL)
{

    $ic = $value ['ic'];

}

if ($address == NULL)
{

    $address = $value ['address'];

}

if ($filename == "")
{
    
    $filename = $value ['filename'];

}

else
{
    
    // Getting the file extension //
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
       
    // Logic to check the extension of the file //
    if (!in_array($extension, ['pdf'])) 
    {

        alert ("Your File Format Must Be In PDF!");
        exit (0);

    }
    
    else
    {
          
            // Upload the file //
            $newfilename = "STUDENT".  "_" . $record_to_edit . "_" . $program . "_" . $session . ".pdf";

            $bucket = $storage->bucket('canorus-18990.appspot.com');
            $object = $bucket->object($newfilename);

            $object->delete();

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

            $filename = $newfilename;

    }

}

// Updating the data into the database table //
$path = 'Registration/' . $record_to_edit;
$reference = $database->getReference($path)->remove();

$postData = [

                        'id' => $record_to_edit,
                        'password' => $password,
                        'access_level' => $access_level,
                        'name' => $name,
                        'email' => $email,
                        'telno' => $telno,
                        'ic' => $ic,
                        'address' => $address,
                        'program' => $program,
                        'session' => $session,
                        'filename' => $filename,

                    ];

$ref_table = "Registration/" . $record_to_edit;
$postRef_result = $database->getReference($ref_table)->set($postData);

$_SESSION ['log_id'] = $_SESSION ['id'];
$_SESSION ['log_stuId'] = $record_to_edit;
$_SESSION ['log_program'] = $program;
$_SESSION ['log_session'] = $session;

header ('Location:log_edit_student.php');

?>