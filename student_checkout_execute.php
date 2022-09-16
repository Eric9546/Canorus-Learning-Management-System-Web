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

        $id = $_SESSION ['id'];
        $session = $_SESSION ['session'];
        $filename = $_FILES['myfile']['name'];

        // Establishing connection to database //
        include ('dbcon.php');
        include ('storagecon.php');
      
        // Getting the file extension //
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
       
        // Logic to check the extension of the file //
        if (!in_array($extension, ['pdf'])) 
        {

            alert ("Your File Format Must Be In PDF!");

        } 

        else 
        {

            // Get data from table //
            $path = 'Registration/' . $id;
            $reference = $database->getReference($path);
            $snapshot = $reference->getSnapshot();
            $value = $snapshot->getValue();

            $name = $value ['name'];
            $program = $value ['program'];
            $payStatus = "Unapproved";
            $newfilename = "PAYMENT_" . $id . "_" . $program . "_" . $session . ".pdf";

            // The physical file on a temporary uploads directory on the server //
            $file = $_FILES['myfile']['tmp_name'];       

            // Destination of the file on the server //
            $destination = 'uploads/' . $newfilename;

            // Move the file to the correct folder //
            move_uploaded_file($file, $destination);

            // Uploading file to cloud server storage //
            $bucketName = 'canorus-18990.appspot.com';
            $fileName = $destination;
            $bucket = $storage->bucket($bucketName);
            $object = $bucket->upload(
                                        fopen($fileName, 'r'),
                                        [
                                            'predefinedAcl' => 'publicRead'
                                        ]
                                    );
            
            // Clear local temp file //
            unlink ($destination);

            // Insert the data into the database table //
            $postData = [
    
                            'id' => $id,
                            'name' => $name,
                            'program' => $program,
                            'session' => $session,
                            'filename' => $newfilename,
                            'payStatus' => $payStatus,
                            'payMode' => "Bank In",
                            
                        ];

            $ref_table = "Payment/" . $session . "/" . $id;
            $postRef_result = $database->getReference($ref_table)->set($postData);

            $_SESSION ['log_id'] = $id;
            $_SESSION ['log_program'] = $program;
            $_SESSION ['log_session'] = $session;
            $_SESSION ['log_filename'] = $newfilename;

            header ("Location: log_student_payment.php");
               
        }

     }

?>