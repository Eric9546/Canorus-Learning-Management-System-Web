<?php

    session_start ();

    if (!isset ($_SESSION ['id']))
    {

        header ("Location: login.php");

    }

    // Declaring function for alert message //
    function alert ($msg)
    {

        echo "<script type='text/javascript'>alert('$msg'); window.location='index.php';</script>";

    }

    // Establishing connection to database //
    include ('dbcon.php');
    include ('storagecon.php');

    // Gathering the input from user //
    $id = $_POST ['id'];
    $record_to_remove = $_POST ['record_to_remove'];
    $filename =  $_POST ['filename'];
    $program = $_POST ['program'];
    $session = $_POST ['session'];
    unset ($_SESSION ['program']);
    unset ($_SESSION ['session']);
    $_SESSION ['program'] = $program;
    $_SESSION ['session'] = $session;

    // Query to delete the record from the database table //
    $path = $record_to_remove;
    $reference = $database->getReference($path)->remove();

    // Remove the file //
    $bucket = $storage->bucket('canorus-18990.appspot.com');
    $object = $bucket->object($filename);

    $object->delete();

    // Updating the data in the enrolment table //
    $updateData = [

                    'payStatus' => 'Unpaid',

                ];

    $ref_table = "Enrolment/" . $id;
    $updateQuery = $database->getReference($ref_table)->getValue();
    foreach ($updateQuery as $key => $rows)
    {

        if ($rows ['session'] == $session )
        {

            $path = "Enrolment/" . $id . "/" . $key;
            $updateQuery = $database->getReference($path)->update($updateData);


        }

    }

    // Logic to check if the record was deleted successfully //
    if ($reference)
    {

        $_SESSION ['log_id'] = $_SESSION ['id'];
        $_SESSION ['log_stuId'] = $id;
        $_SESSION ['log_session'] = $session;
        $_SESSION ['log_program'] = $program;

        header ("Location: log_remove_payment.php");

    }

    else
    {

        alert ("Payment Was Unable To Be Removed!");

    }

?>