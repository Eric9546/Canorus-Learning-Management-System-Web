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

    $id = $_SESSION ['id'];

    // Redirect the user if admin ID is detected //
    $path = 'Registration/' . $id;
    $reference = $database->getReference($path);
    $snapshot = $reference->getSnapshot();
    $value = $snapshot->getValue();

    if ($value ['access_level'] == "Student")
    {
        
        header ("Location:student_panel.php");

    }

    else if ($value ['access_level'] == "Lecturer")
    {
        
        header ("Location:lecturer_panel.php");

    }

    else
    {

        header ("Location:admin_panel.php");
    
    }

?>