<?php

    session_start ();

    include ('logcon.php');

    // Gather the data //
    $id = $_SESSION ['log_id'];
    $program = $_SESSION ['log_program'];
    $session = $_SESSION ['log_session'];
    $subId =  $_SESSION ['log_subId'];

    // Save the login data to logs //
    date_default_timezone_set('Asia/Singapore');
    $logDate = date("d-m-Y");
    $logTime = date("H:i:s");

    $collection = $firestore->collection($logDate . "-ATTENDANCE");
    $log = $collection->document(uniqid());
    $logMsg = "Student with the ID: " . $id . " enrolled under " . $program . " " . $session . " " . $subId . 
              " is PRESENT in class " . " at " . $logTime ." HRS using the " . "WEB" . " platform";
    $log->set(['logMsg' => $logMsg]);

    header ("Location: student_attendance.php");

?>