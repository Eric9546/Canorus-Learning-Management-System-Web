<?php

    session_start ();

    if (!isset ($_SESSION ['id']))
    {
        
        header ("Location: login.php");
              
    }

    // Declaring function for alert message //
    function alert ($msg)
    {

        echo "<script type='text/javascript'>alert('$msg'); window.location='view_subject.php';</script>";

    }

    // Establishing connection to database //
    include ('dbcon.php');

    // Gathering the input from user //
    $record_to_edit = $_POST ['record_to_edit'];
    $subName = $_POST ['subName'];
    $program = $_POST ['program'];
    $fee = $_POST ['fee'];
    $lecId = $_POST ['lecId'];

    $path = 'Subject/' . $record_to_edit;
    $reference = $database->getReference($path);
    $snapshot = $reference->getSnapshot();
    $value = $snapshot->getValue();

    if ($subName == NULL)
    {

        $subName = $value ['subName'];
        
    }

    if ($fee == NULL)
    {

        $fee = $value ['fee'];

    }

    // Updating the data into the database table //
    $path = 'Subject/' . $record_to_edit;
    $reference = $database->getReference($path)->remove();

    $postData = [
    
                            'subId' => $record_to_edit,
                            'subName' => $subName,
                            'program' => $program,
                            'fee' => $fee,                          
                            'lecId' => $lecId,                     
                          
                        ];

    $ref_table = "Subject/" . $record_to_edit;
    $postRef_result = $database->getReference($ref_table)->set($postData);

    header ('Location:view_subject.php');

?>