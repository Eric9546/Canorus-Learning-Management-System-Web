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

    echo "<script type='text/javascript'>alert('$msg'); window.location='student_attendance.php';</script>";

}

// Gathering the input from user //
$program = $_POST ['program'];
$subId = $_POST ['subId'];
$section = $_POST ['section'];
$session = $_POST ['session'];
$attendPin = $_POST ['attendPin'];
$record_to_view = $_POST ['record_to_view'];
$record_to_refer = $_POST ['record_to_refer'];
$_SESSION ['program'] = $program;
$_SESSION ['subId'] = $subId;
$_SESSION ['section'] = $section;
$_SESSION ['record_to_view'] = $record_to_view;
$_SESSION ['session'] = $session;

// Establishing connection to database //
include ('dbcon.php');

$path = $record_to_refer;
$reference = $database->getReference($path);
$snapshot = $reference->getSnapshot();
$value = $snapshot->getValue();

// Authenticate attendance pin //
if ($value ['attendPin'] == $attendPin)
{

    // Inserting the data into the database table //
    $updateData = [

                'attendStatus' => 'Present',

            ];

    $ref_table = $record_to_view;
    $updateQuery = $database->getReference($ref_table)->update($updateData);

    header ("Location: student_attendance.php");

}

else
{

    alert ("Attendance Pin Is Incorrect!");

}

?>