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

// Gathering the input from user //
$record_to_remove = $_POST ['record_to_remove'];
$program = $_POST ['program'];
$subId = $_POST ['subId'];
$section = $_POST ['section'];
$session = $_POST ['session'];
$QRcode = $_POST ['QRcode'];
$_SESSION ['program'] = $program;
$_SESSION ['subId'] = $subId;
$_SESSION ['section'] = $section;
$_SESSION ['session'] = $session;
$_SESSION ['QRcode'] = $QRcode;

// Delete the QR code file //
unlink ($QRcode);

// Query to delete the record from the database table //
$path = $record_to_remove;
$reference = $database->getReference($path)->remove();

// Logic to check if the record was deleted successfully //
if ($reference)
{

    header ("Location: edit_attendance.php");

}

else
{

    alert ("Attendance Was Unable To Be Removed!");

}

?>