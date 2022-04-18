<?php

    session_start ();
    if (!isset ($_SESSION ['id']))
    {
        
        header ("Location: login.php");
              
    }

    $id = $_SESSION ['id'];

    // Declaring function for alert message //
    function alert ($msg)
    {

        echo "<script type='text/javascript'>alert('$msg'); window.location='change_details.php';</script>";

    }

    // Gathering the input from user //
    $password1 = $_POST ['password1'];
    $password2 = $_POST ['password2'];
    $email = $_POST ['email'];
    $telno = $_POST ['telno'];
    $address = $_POST ['address'];

    // To ensure that the 2 passwords match //
    if ($password1 == $password2)
    {

         // Establishing connection to database //
        include ('dbcon.php');

        $path = 'Registration/' . $id;
        $reference = $database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        if ($password1 == NULL)
        {

            $password1 = $value ['password'];
        
        }

        if ($email == NULL)
        {

            $email = $value ['email'];

        }

        if ($telno == NULL)
        {

            $telno = $value ['telno'];
        
        }

        if ($address == NULL)
        {

            $address = $value ['address'];
        
        }

        // Inserting the data into the database table //
        $updateData = [
    
                    'password' => $password1,
                    'email' => $email,
                    'telno' => $telno,
                    'address' => $address,
                    
                ];

        $ref_table = "Registration/" . $id;
        $updateQuery = $database->getReference($ref_table)->update($updateData);

        header ("Location: log_student_details.php");

    }

    else
    {

        alert ("Passwords Do No Match!");

    }

?>