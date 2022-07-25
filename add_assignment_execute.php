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
        $assignTitle = $_POST ['assignTitle'];
        $assignDesc = $_POST ['assignDesc'];
        $day = $_POST ['day'];
        $month = $_POST ['month'];
        $year = $_POST ['year'];
        $hour = $_POST ['hour'];
        $min = $_POST ['min'];
        $meridiem = $_POST ['meridiem'];
        $subId = $_POST ['subId'];
        $_SESSION ['subId'] = $subId;
        $dueDate = $day . "-" . $month . "-" . $year . ", " . $hour . ":" . $min . $meridiem;
        $filename = $_FILES['myfile']['name'];

        // Validating the input //
        if (empty ($assignTitle))
        {

            alert ("Error Please Check Your Assignment Title!");

        }

        else if (empty ($assignDesc))
        {

            alert ("Error Please Check Your Assignment Description!");

        }

        else if (empty ($day))
        {

            alert ("Error Please Check Your Day!");

        }


        else if (empty ($month))
        {

            alert ("Error Please Check Your Month!");

        }

        else if (empty ($year))
        {

            alert ("Error Please Check Your Year!");

        }

        else if (empty ($hour))
        {

            alert ("Error Please Check Your Hour!");

        }

        else if (empty ($min))
        {

            alert ("Error Please Check Your Minute!");

        }

        else if (empty ($meridiem))
        {

            alert ("Error Please Check Your Meridiem!");

        }
        // Getting the file extension //
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        // Query to check if assignment title already exists //
        $path = 'Assignment/' . $subId . '/Question/' . $assignTitle;
        $reference = $database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        // Logic to check if the file name already exists //
        if (!is_null ($value))
        {

            alert ("Assignment Title Already Exists!");

        }

        else
        {

            // Rename the file //
            $newfilename = "ASSIGNMENT_" . $subId . '_' . $assignTitle . "." . $extension;

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

                            'assignTitle' => $assignTitle,
                            'assignDesc' => $assignDesc,
                            'dueDate' => $dueDate,
                            'fileName' => $newfilename,

                        ];

            $ref_table = 'Assignment/' . $subId . '/Question/' . $assignTitle;
            $postRef_result = $database->getReference($ref_table)->set($postData);

            $_SESSION ['log_id'] = $_SESSION ['id'];
            $_SESSION ['log_subId'] = $subId;
            $_SESSION ['log_assignTitle'] = $assignTitle;

            header ("Location: log_add_assignment.php");

        }

     }

?>