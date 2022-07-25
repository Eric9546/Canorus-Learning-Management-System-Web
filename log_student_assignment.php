<?php

    session_start ();

    include ('logcon.php');

    // Gather the data //
    $id = $_SESSION ['log_id'];
    $subId = $_SESSION ['log_subId'];
    $assignTitle = $_SESSION ['log_assignTitle'];
    $newfilename = $_SESSION ['log_fileName'];

    // Save the login data to logs //
    date_default_timezone_set('Asia/Singapore');
    $logDate = date("d-m-Y");
    $logTime = date("H:i:s");

    $collection = $firestore->collection($logDate . "-ASSIGNMENT");
    $log = $collection->document(uniqid());
    $logMsg = "Student with the ID: " . $id . " submitted their file titled " . $newfilename . " for " . $subId . "-" . $assignTitle .
              " at " . $logTime ." HRS using the " . "WEB" . " platform";
    $log->set(['logMsg' => $logMsg]);

    header ("Location: student_assignment_filtered.php");

?>