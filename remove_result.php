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
    $record_to_view = $_POST ['record_to_view']; 
    unset ($_SESSION ['record_to_view']);
    $_SESSION ['record_to_view'] = $record_to_view; 

    // Query to delele the record from the database table //
    $path = 'Result/' . $record_to_remove;
    $reference = $database->getReference($path)->remove();

    // Logic to check if the record was deleted successfully //
    if ($reference)
    {

       header ("Location: edit_result_student.php");     

    }

    else
    {

        alert ("Result Was Unable To Be Removed!");

    }

?>