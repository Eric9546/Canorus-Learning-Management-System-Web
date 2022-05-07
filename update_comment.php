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
    $comment = $_POST ['comment'];
    $record_to_update = $_POST ['record_to_update'];
    $record_to_view = $_POST ['record_to_view'];
    $subId = $_POST ['subId'];
    $assignTitle = $_POST ['assignTitle'];
    $_SESSION ['record_to_view'] = $record_to_view;
    $_SESSION ['subId'] = $subId;
    $_SESSION ['assignTitle'] = $assignTitle;

    // Validating the input //
    if (empty ($comment))
    {

        alert ("Error Please Check Your Comment!");

    }


    // Inserting the data into the database table //
    $updateData = [

                    'comment' => $comment,

                ];

    $ref_table = $record_to_update;
    $updateQuery = $database->getReference($ref_table)->update($updateData);

    header ("Location: edit_submission.php");

}

?>