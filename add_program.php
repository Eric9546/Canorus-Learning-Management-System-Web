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
        $progCode = $_POST ['progCode'];
        $progName = $_POST ['progName'];

        // Validating the input //
        if (empty ($progCode))
        {

            alert ("Error Please Check Your Program Code!");

        }

        else if (empty ($progName))
        {

            alert ("Error Please Check Your Program Name!");

        }

        // Capitalize the progCode //
        $progCode = strtoupper ($progCode);

        // Query to check if progCode already exists //
        $path = 'Program/' . $progCode;
        $reference = $database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        // Logic to check if the progCode already exists //
        if (!is_null ($value))
        {

            alert ("Program Code Already Exists!");

        }

        else
        {

             // Inserting the data into the database table //
            $postData = [

                            'progName' => $progName,
                            'progCode' => $progCode,

                        ];

            $ref_table = "Program/" . $progCode;
            $postRef_result = $database->getReference($ref_table)->set($postData);

            $_SESSION ['log_id'] = $_SESSION ['id'];
            $_SESSION ['log_progName'] = $progName;
            $_SESSION ['log_progCode'] = $progCode;

            header ("Location: log_add_program.php");

        }

     }

?>