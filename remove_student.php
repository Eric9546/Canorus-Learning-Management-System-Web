<?php

    session_start ();

    // Declaring function for alert message //
    function alert ($msg)
    {

        echo "<script type='text/javascript'>alert('$msg'); window.location='view_user.php';</script>";

    }

    // Establishing connection to database //
    include ('dbcon.php');

    // Gathering the input from user //
    $record_to_remove = $_POST ['record_to_remove'];
    $stuId = $_POST ['stuId'];
    $program = $_POST ['program'];
    $session = $_POST ['session'];

    // Query to delele the record from the database table //
    $path = 'Registration/' . $record_to_remove;
    $reference = $database->getReference($path)->remove();

    // Logic to check if the record was deleted successfully //
    if ($reference)
    {

        $_SESSION ['log_id'] = $_SESSION ['id'];
        $_SESSION ['log_stuId'] = $record_to_edit;
        $_SESSION ['log_program'] = $program;
        $_SESSION ['log_session'] = $session;

        header ("Location: log_remove_student.php");

    }

    else
    {

        alert ("Student Was Unable To Be Removed!");

    }

?>