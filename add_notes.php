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
        include ('storagecon.php');

        // Gathering the user input //
        $fileTitle = $_POST ['fileTitle'];
        $fileDesc = $_POST ['fileDesc'];
        $subId = $_POST ['subId'];
        $contentName = $_POST ['contentName'];
        $_SESSION ['subId'] = $subId;
        $_SESSION ['contentName'] = $contentName;
        $filename = $_FILES['myfile']['name'];
          
        // Validating the input //
        if (empty ($fileTitle))
        {

            alert ("Error Please Check Your File Title!");

        }

        else if (empty ($fileDesc))
        {

            alert ("Error Please Check Your File Description!");

        }   

        // Getting the file extension //
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
     
        // Query to check if content name already exists //
        $path = 'Note/' . $subId . '/' . $contentName . '/' . $fileTitle;
        $reference = $database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        // Logic to check if the file name already exists //
        if (!is_null ($value))
        {

            alert ("File Name Already Exists!");

        }
        
        else
        {

            // Get the timestamp //
            date_default_timezone_set('Asia/Singapore'); 
            $logDate = date("dmY");
            $logTime = date("His");

            // Rename the file //
            $newfilename = "NOTES_" . $logDate . $logTime . "." . $extension;

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

             // Inserting the data into the database table //
            $postData = [
    
                            'fileTitle' => $fileTitle,
                            'fileDesc' => $fileDesc,
                            'fileName' => $newfilename,                         
                            
                        ];

            $ref_table = 'Note/' . $subId . '/' . $contentName . '/' . $fileTitle;
            $postRef_result = $database->getReference($ref_table)->set($postData);

            header ("Location: edit_notes.php");
            
        }
   
     }
     
?>