<?php

    session_start ();

    if (!isset ($_SESSION ['id']))
    {
        
        header ("Location: login.php");
              
    }

    // Declaring function for alert message //
    function alert ($msg)
    {

        echo "<script type='text/javascript'>alert('$msg'); window.location='view_lecturer.php';</script>";

    }

    // Establishing connection to database //
    include ('dbcon.php');

    // Gathering the input from user //
    $record_to_edit = $_POST ['record_to_edit'];
    $name = $_POST ['name'];
    $email = $_POST ['email'];
    $telno = $_POST ['telno'];  

    $path = 'Lecturer/' . $record_to_edit;
    $reference = $database->getReference($path);
    $snapshot = $reference->getSnapshot();
    $value = $snapshot->getValue();

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

    // Inserting the data into the database table //
    $path = 'Lecturer/' . $record_to_edit;
    $reference = $database->getReference($path)->remove();

    $postData = [
    
                    'lecId' => $record_to_edit,
                    'name' => $name,
                    'email' => $email,
                    'telno' => $telno,
                            
                ];

    $ref_table = "Lecturer/" . $record_to_edit;
    $postRef_result = $database->getReference($ref_table)->set($postData);

    header ('Location:view_lecturer.php');

?>