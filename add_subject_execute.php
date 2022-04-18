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
        $subId = $_POST ['subId'];
        $subName = $_POST ['subName'];
        $program = $_POST ['program'];
        $fee = $_POST ['fee'];       
        $lecId = $_POST ['lecId'];
        $section = $_POST ['section'];

        // Validating the input //
        if (empty ($subId))
        {

            alert ("Error Please Check Your Subject ID!");

        }

        else if (empty ($subName))
        {

            alert ("Error Please Check Your Subject Name!");

        }

        else if (empty ($program))
        {

            alert ("Error Please Check Your Program!");

        }

        else if (empty ($fee))
        {

            alert ("Error Please Check Your Fee!");

        }

        else if (!is_numeric ($fee))
        {

            alert ("Error Please Check Your Fee!");

        }
     
        else if (empty ($lecId))
        {

            alert ("Error Please Check Your Lecturer ID!");

        }

        else if (empty ($section))
        {

            alert ("Error Please Check Your Section!");

        }

        // Capitalize the variables //
        $subId = strtoupper ($subId);  
        $section = strtoupper ($section);  

        // Query to check if ID already exists //
        $path = 'Subject/' . $subId;
        $reference = $database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        // Logic to check if the ID already exists //
        if (!is_null ($value))
        {
         
            alert ("Subject ID Already Exists!");

        }

        else
        {

            // Inserting the data into the database table //
            $postData = [
    
                            'subId' => $subId,
                            'subName' => $subName,
                            'program' => $program,
                            'fee' => $fee,                           
                            'lecId' => $lecId,  
                            'section' => $section,                
                            
                        ];

            $ref_table = "Subject/" . $subId;
            $postRef_result = $database->getReference($ref_table)->set($postData);

            header ("Location: admin_success.php");
            
        }
   
     }
     
?>