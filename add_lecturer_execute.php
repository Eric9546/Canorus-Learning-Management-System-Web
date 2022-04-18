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
        $lecId = $_POST ['lecId'];
        $name = $_POST ['name'];
        $email = $_POST ['email'];
        $telno = $_POST ['telno'];      

        // Validating the input //
        if (empty ($lecId))
        {

            alert ("Error Please Check Your Lecturer ID!");

        }

        else if (empty ($name))
        {

            alert ("Error Please Check Your Name!");

        }

        else if (is_numeric ($name))
        {

            alert ("Error Please Check Your Name!");

        }

        else if (empty ($email))
        {

            alert ("Error Please Check Your Email!");

        }

        else if (empty ($telno))
        {

            alert ("Error Please Check Your Phone!");

        }

        else if (!is_numeric ($telno))
        {

            alert ("Error Please Check Your Phone!");

        }

        // Capitalize the id //
        $lecId = strtoupper ($lecId);  

       // Query to check if ID already exists //
        $path = 'Lecturer/' . $lecId;
        $reference = $database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        // Logic to check if the ID already exists //
        if (!is_null ($value))
        {

            alert ("Lecturer ID Already Exists!");

        }
        
        else
        {

             // Inserting the data into the database table //
            $postData = [
    
                            'lecId' => $lecId,
                            'name' => $name,
                            'email' => $email,
                            'telno' => $telno,
                            
                        ];

            $ref_table = "Lecturer/" . $lecId;
            $postRef_result = $database->getReference($ref_table)->set($postData);

            header ("Location: admin_success.php");
            
        }
   
     }
     
?>