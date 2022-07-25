<?php

    // Declaring function for alert message //
    function alert ($msg)
    {

        echo "<script type='text/javascript'>alert('$msg'); window.location='view_subject.php';</script>";

    }

    // Establishing connection to database //
    include ('dbcon.php');

    // Gathering the input from user //
    $record_to_remove = $_POST ['record_to_remove'];
    $subId = $_POST ['subId'];
    $subName = $_POST ['subName'];
    $program = $_POST ['program'];

    // Query to delele the record from the database table //
    $path = 'Subject/' . $record_to_remove;
    $reference = $database->getReference($path)->remove();

    // Logic to check if the record was deleted successfully //
    if ($reference)
    {

        $_SESSION ['log_id'] = $_SESSION ['id'];
        $_SESSION ['log_subId'] = $subId;
        $_SESSION ['log_subName'] = $subName;
        $_SESSION ['log_program'] = $program;

        header ("Location: log_remove_subject.php");

    }

    else
    {

        alert ("Subject Was Unable To Be Removed!");

    }

?>