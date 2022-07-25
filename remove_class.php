<?php

    session_start ();

    // Declaring function for alert message //
    function alert ($msg)
    {

        echo "<script type='text/javascript'>alert('$msg'); window.location='edit_result_student.php';</script>";

    }

    // Establishing connection to database //
    include ('dbcon.php');

    // Gathering the input from user //
    $record_to_remove = $_POST ['record_to_remove'];
    $program = $_POST ['program'];
    $subId = $_POST ['subId'];
    $day = $_POST ['day'];
    $timeStart = $_POST ['timeStart'];
    $timeEnd = $_POST ['timeEnd'];
    $_SESSION ['program'] = $program;
    $_SESSION ['subId'] = $subId;

    // Query to delete the record from the database table //
    $path = $record_to_remove;
    $reference = $database->getReference($path)->remove();

    // Logic to check if the record was deleted successfully //
    if ($reference)
    {

        $_SESSION ['log_id'] = $_SESSION ['id'];
        $_SESSION ['log_program'] = $program;
        $_SESSION ['log_subId'] = $subId;
        $_SESSION ['log_day'] = $day;
        $_SESSION ['log_timeStart'] = $timeStart;
        $_SESSION ['log_timeEnd'] = $timeEnd;

        header ("Location: log_remove_class.php");

    }

    else
    {

        alert ("Class Was Unable To Be Removed!");

    }

?>