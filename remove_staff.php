<?php

    // Declaring function for alert message //
    function alert ($msg)
    {

        echo "<script type='text/javascript'>alert('$msg'); window.location='view_user.php';</script>";

    }

    // Establishing connection to database //
    include ('dbcon.php');

    // Gathering the input from user //
    $record_to_remove = $_POST ['record_to_remove'];
    $newId = $_POST ['newId'];
    $access_level = $_POST ['access_level'];

    // Query to delele the record from the database table //
    $path = 'Registration/' . $record_to_remove;
    $reference = $database->getReference($path)->remove();

    // Logic to check if the record was deleted successfully //
    if ($reference)
    {

        $_SESSION ['log_id'] = $_SESSION ['id'];
        $_SESSION ['log_newId'] = $newId;
        $_SESSION ['log_access_level'] = $access_level;

       header ("Location: log_remove_staff.php");

    }

    else
    {

        alert ("Staff Was Unable To Be Removed!");

    }

?>