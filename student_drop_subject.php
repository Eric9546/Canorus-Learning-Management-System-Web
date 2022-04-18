<?php

    session_start ();    

    // Declaring function for alert message //
    function alert ($msg)
    {

        echo "<script type='text/javascript'>alert('$msg'); window.location='student_enrolment.php';</script>";

    }

    // Establishing connection to database //
    include ('dbcon.php');

    // Get user Id //
    $id = $_SESSION ['id'];

    // Gathering the input from user //
    $record_to_remove = $_POST ['record_to_remove'];   

    // Query to delele the record from the database table //
    $path = 'Enrolment/' . $id . "/" . $record_to_remove;
    $reference = $database->getReference($path)->remove();

    // Logic to check if the record was deleted successfully //
    if ($reference)
    {

       header ("Location: student_enrolment.php");     

    }

    else
    {

        alert ("Subject Could Not Be Dropped!");

    }

?>