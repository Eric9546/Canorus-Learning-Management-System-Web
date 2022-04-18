<?php

    // Declaring function for alert message //
    function alert ($msg)
    {

        echo "<script type='text/javascript'>alert('$msg'); window.location='edit_enrolment_student.php';</script>";

    }

    // Establishing connection to database //
    include ('dbcon.php');

    // Gathering the input from user //
    $record_to_remove = $_POST ['record_to_remove']; 
    $id = $_POST ['id'];  
    $record_to_view = $_POST ['record_to_view']; 
    unset ($_SESSION ['record_to_view']);
    $_SESSION ['record_to_view'] = $record_to_view; 

    // Query to delete the record from the database table //
    $path = $record_to_remove;
    $reference = $database->getReference($path)->remove();

    // Logic to check if the record was deleted successfully //
    if ($reference)
    {
      
       header ("Location: edit_enrolment_student.php");     

    }

    else
    {

        alert ("Subject Could Not Be Dropped!");

    }

?>