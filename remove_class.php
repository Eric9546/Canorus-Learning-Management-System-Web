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
    $_SESSION ['program'] = $program;
    $_SESSION ['subId'] = $subId;

    // Query to delete the record from the database table //
    $path = $record_to_remove;
    $reference = $database->getReference($path)->remove();

    // Logic to check if the record was deleted successfully //
    if ($reference)
    {

       header ("Location: edit_class.php");     

    }

    else
    {

        alert ("Class Was Unable To Be Removed!");

    }

?>