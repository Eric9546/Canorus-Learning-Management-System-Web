<?php

session_start ();
if (!isset ($_SESSION ['id']))
{

    header ("Location: login.php");

}

$id = $_SESSION ['id'];

// Declaring function for alert message //
function alert ($msg)
{

    echo "<script type='text/javascript'>alert('$msg'); window.location='edit_attendance_list.php';</script>";

}

// Gathering the input from user //
$record_to_update = $_POST ['record_to_update'];
$program = $_POST ['program'];
$subId = $_POST ['subId'];
$section = $_POST ['section'];
$session = $_POST ['session'];
$QRcode = $_POST ['QRcode'];
$attendPin = $_POST ['attendPin'];
$record_to_view = $_POST ['record_to_view'];
$_SESSION ['program'] = $program;
$_SESSION ['subId'] = $subId;
$_SESSION ['section'] = $section;
$_SESSION ['record_to_view'] = $record_to_view;
$_SESSION ['session'] = $session;
$_SESSION ['QRcode'] = $QRcode;
$_SESSION ['attendPin'] = $attendPin;

// Establishing connection to database //
include ('dbcon.php');

// Inserting the data into the database table //
$updateData = [

            'attendStatus' => 'Absent',

        ];

$ref_table = $record_to_update;
$updateQuery = $database->getReference($ref_table)->update($updateData);

header ("Location: edit_attendance_list.php");


?>