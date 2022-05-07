<?php

    session_start ();

    // Declaring function for alert message //
    function alert ($msg)
    {

        echo "<script type='text/javascript'>alert('$msg'); window.location='view_notes_filtered.php';</script>";

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
        $contentName = $_POST ['contentName'];
        $subId = $_POST ['subId'];
        $_SESSION ['subId'] = $subId;
          
        // Validating the input //
        if (empty ($contentName))
        {

            alert ("Error Please Check Your Content Name!");

        }

        else if (empty ($subId))
        {

            alert ("Error Please Check Your SubId!");

        }    

        
        // Query to check if content name already exists //
        $path = 'Note/' . $subId . '/' . $contentName;
        $reference = $database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        // Logic to check if the content name already exists //
        if (!is_null ($value))
        {

            alert ("Content Name Already Exists!");

        }
        
        else
        {

             // Inserting the data into the database table //
            $postData = [
    
                            'contentName' => $contentName,                          
                            
                        ];

            $ref_table = 'Note/' . $subId .'/' . $contentName;
            $postRef_result = $database->getReference($ref_table)->set($postData);

            header ("Location: view_notes_filtered.php");
            
        }
   
     }
     
?>