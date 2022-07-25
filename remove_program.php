<?php

    session_start ();

    if (!isset ($_SESSION ['id']))
    {

        header ("Location: login.php");

    }

    // Declaring function for alert message //
    function alert ($msg)
    {

        echo "<script type='text/javascript'>alert('$msg'); window.location='admin_panel.php';</script>";

    }

    // Establishing connection to database //
    include ('dbcon.php');

    // Gathering the input from user //
    $record_to_remove = $_POST ['record_to_remove'];

    // Gather program details
    $path = 'Program/' . $record_to_remove;
    $reference = $database->getReference($path);
    $snapshot = $reference->getSnapshot();
    $value = $snapshot->getValue();

    $progName = $value ['progName'];

    // Query to delete the record from the database table //
    $path = 'Program/' . $record_to_remove;
    $reference = $database->getReference($path)->remove();

    // Logic to check if the record was deleted successfully //
    if ($reference)
    {

        $_SESSION ['log_id'] = $_SESSION ['id'];
        $_SESSION ['log_progCode'] = $record_to_remove;
        $_SESSION ['log_progName'] = $progName;

        header ("Location: log_remove_program.php");

    }

    else
    {

        alert ("Program Was Unable To Be Removed!");

    }

?>