<?php

    session_start ();

    // Declaring function for alert message //
    function alert ($msg)
    {

        echo "<script type='text/javascript'>alert('$msg'); window.location='login.php';</script>";

    }

    // Gathering user input //
    $id = $_POST ['id'];
    $password = $_POST ['password'];

    // Validating the input //
    if (empty ($id))
    {

        alert ("Error Please Check Your Student ID!");

    }

    else if (empty ($password))
    {

        alert ("Error Please Check Your Password!");

    }

    else 
    {

        // Capitalize the id //
        $id = strtoupper ($id);    

        // Establishing connection to database //
        include ('dbcon.php');
        
        // Making the query to authenticate the user login // 
        $path = 'Registration/' . $id;
        $reference = $database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        // Logic to check if the authentication is successful or not //
        if (is_null ($value))
        {

            alert ("Please Check Your Login ID!");

        }

        else if  ($value ['password'] == $password)
        {
            
            $id_value = $value ['id'];
            $program_value = $value ['program'];
            $session_value = $value ['session'];
            $access_level = $value ['access_level'];
            $_SESSION ['id'] = $id_value;
            $_SESSION ['program'] = $program_value; 
            $_SESSION ['session'] = $session_value;
            $_SESSION ['access_level'] = $access_level;
        
            header ("Location: log_login.php");
                    
        } 

        else 
        {

            alert ("Please Check Your Login Password!");

        }
    
    }

?>