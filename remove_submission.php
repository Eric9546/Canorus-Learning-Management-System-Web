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
$record_to_remove = $_POST ['record_to_remove'];
$fileName =  $_POST ['fileName'];
$record_to_view = $_POST ['record_to_view'];
$subId = $_POST ['subId'];
$assignTitle = $_POST ['assignTitle'];
$_SESSION ['record_to_view'] = $record_to_view;
$_SESSION ['subId'] = $subId;
$_SESSION ['assignTitle'] = $assignTitle;

// Query to delete the record from the database table //
$path = $record_to_remove;
$reference = $database->getReference($path)->remove();

// Remove the file //
$bucket = $storage->bucket('canorus-18990.appspot.com');
$object = $bucket->object($fileName);

$object->delete();

// Logic to check if the record was deleted successfully //
if ($reference)
{

    header ("Location: edit_submission.php");

}

else
{

    alert ("Submission Was Unable To Be Removed!");

}

?>