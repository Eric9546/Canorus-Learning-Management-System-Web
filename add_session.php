<?php

    session_start ();

    // Declaring function for alert message //
    function alert ($msg)
    {

        echo "<script type='text/javascript'>alert('$msg'); window.location='index.php';</script>";

    }

     // Ensure that the user is logged in //
     if (!isset ($_SESSION ['id']))
     {

        header ("Location: login.php");

     }

     else
     {

        // Establishing connection to database //
        include ('dbcon.php');

        // Gathering the user input //
        $session = $_POST ['session'];

        // Validating the input //
        if (empty ($session))
        {

            alert ("Error Please Check Your Session!");

        }

        // Capitalize the session //
        $session = strtoupper ($session);

        // Query to check if session already exists //
        $path = 'Session/' . $session;
        $reference = $database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        // Logic to check if the session already exists //
        if (!is_null ($value))
        {

            alert ("Session Already Exists!");

        }

        else
        {

           // Inserting the data into the database table //
           $postData = [

                            'session' => $session,

                        ];

            $ref_table = "Session/" . $session;
            $postRef_result = $database->getReference($ref_table)->set($postData);

            $_SESSION ['log_id'] = $_SESSION ['id'];
            $_SESSION ['log_session'] = $session;

            header ("Location: log_add_session.php");

        }

     }

?>