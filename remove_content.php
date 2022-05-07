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
    include ('storagecon.php');

    // Gathering the input from user //
    $record_to_remove = $_POST ['record_to_remove'];
    $subId = $_POST ['subId'];
    $_SESSION ['subId'] = $subId;

    // Remove the file //
    $path = $record_to_remove;
    $reference = $database->getReference($path);
    $snapshot = $reference->getSnapshot();

    $reference = $database->getReference($path)->getValue();
                    
    foreach ($reference as $key => $rows)
    {

        if ($key != "contentName")
        {

            $bucket = $storage->bucket('canorus-18990.appspot.com');
            $object = $bucket->object($rows ['fileName']);
 
            $object->delete();

        }

    }   

    // Query to delete the record from the database table //
    $path = $record_to_remove;
    $reference = $database->getReference($path)->remove();
   
    // Logic to check if the record was deleted successfully //
    if ($reference)
    {

       header ("Location: view_notes_filtered.php");     

    }

    else
    {

        alert ("Notes Was Unable To Be Removed!");

    }

?>