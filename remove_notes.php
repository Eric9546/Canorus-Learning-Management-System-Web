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
    $fileName =  $_POST ['fileName'];
    $subId = $_POST ['subId'];
    $contentName = $_POST ['contentName'];
    $_SESSION ['subId'] = $subId;
    $_SESSION ['contentName'] = $contentName;  

    // Query to delete the record from the database table //
    $path = $record_to_remove;
    $reference = $database->getReference($path)->remove();

    // Remove the file //
    $bucket = $storage->bucket('canorus-18990.appspot.com');
    $object = $bucket->object($fileName);
 
    $object->delete();
   
    // Logic to check if the record was deleted successfully //
    if ($reference)
    {

       header ("Location: edit_notes.php");     

    }

    else
    {

        alert ("Notes Was Unable To Be Removed!");

    }

?>