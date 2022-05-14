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

    echo "<script type='text/javascript'>alert('$msg'); window.location='index.php';</script>";

}

// Gathering the input from user //
$program = $_POST ['program'];
$subId = $_POST ['subId'];
$section = $_POST ['section'];
$session = $_POST ['session'];
$record_to_view = $_POST ['record_to_view'];
$_SESSION ['program'] = $program;
$_SESSION ['subId'] = $subId;
$_SESSION ['section'] = $section;
$_SESSION ['session'] = $session;

// Establishing connection to database //
include ('dbcon.php');

// Inserting the data into the database table //
$updateData = [

                'attendStatus' => 'Closed',

              ];

$ref_table = $record_to_view;
$updateQuery = $database->getReference($ref_table)->update($updateData);

header ("Location: edit_attendance.php");


?>