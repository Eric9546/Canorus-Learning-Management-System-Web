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
        $record_to_submit = $_POST ['record_to_submit'];
        $id = $_POST ['id'];
        $assignTitle = $_POST ['assignTitle'];
        $subId = $_POST ['subId'];
        $_SESSION ['subId'] = $subId;
        $filename = $_FILES['myfile']['name'];

        // Get time stamp //
        date_default_timezone_set('Asia/Singapore');
        $logDate = date("d-m-Y");
        $logTime = date("h:ia");

        $submitDate = $logDate . ", " . $logTime;

        // Getting the file extension //
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        // Rename the file //
        $newfilename = "ASSIGNMENT_" . $subId . '_' . $assignTitle . '_' . $id . "." . $extension;

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

                        'id' => $id,
                        'status' => 'Submitted',
                        'grade' => 'N/A',
                        'comment' => 'N/A',
                        'submitDate' => $submitDate,
                        'fileName' => $newfilename,

                    ];

        $ref_table = $record_to_submit;
        $postRef_result = $database->getReference($ref_table)->set($postData);

        $_SESSION ['log_id'] = $id;
        $_SESSION ['log_subId'] = $subId;
        $_SESSION ['log_assignTitle'] = $assignTitle;
        $_SESSION ['log_fileName'] = $newfilename;

        header ("Location: log_student_assignment.php");

     }

?>