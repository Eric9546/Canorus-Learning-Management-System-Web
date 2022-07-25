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
    $record_to_remove2 = $_POST ['record_to_remove2'];
    $fileName =  $_POST ['fileName'];
    $subId = $_POST ['subId'];
    $assignTitle = $_POST ['assignTitle'];
    $_SESSION ['subId'] = $subId;

    // Query to delete the record from the database table //
    $path = $record_to_remove;
    $reference = $database->getReference($path)->remove();

    // Remove the file //
    $bucket = $storage->bucket('canorus-18990.appspot.com');
    $object = $bucket->object($fileName);

    $object->delete();

    // Remove the file //
    $path = $record_to_remove2;
    $reference = $database->getReference($path);
    $snapshot = $reference->getSnapshot();

    $reference = $database->getReference($path)->getValue();

    foreach ($reference as $key => $rows)
    {

        $bucket = $storage->bucket('canorus-18990.appspot.com');
        $object = $bucket->object($rows ['fileName']);

        $object->delete();

    }

    // Query to delete the record from the database table //
    $path = $record_to_remove2;
    $reference = $database->getReference($path)->remove();

    // Logic to check if the record was deleted successfully //
    if ($reference)
    {

        $_SESSION ['log_id'] = $_SESSION ['id'];
        $_SESSION ['log_subId'] = $subId;
        $_SESSION ['log_assignTitle'] = $assignTitle;

        header ("Location: log_remove_assignment.php");

    }

    else
    {

        alert ("Assignment Was Unable To Be Removed!");

    }

?>