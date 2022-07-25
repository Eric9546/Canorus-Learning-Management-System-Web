<?php

    session_start ();

    include ('logcon.php');

    // Gather the data //
    $id = $_SESSION ['log_id'];
    $subId = $_SESSION ['log_subId'];
    $assignTitle = $_SESSION ['log_assignTitle'];

    // Save the login data to logs //
    date_default_timezone_set('Asia/Singapore');
    $logDate = date("d-m-Y");
    $logTime = date("H:i:s");

    $collection = $firestore->collection($logDate . "-ASSIGNMENT");
    $log = $collection->document(uniqid());
    $logMsg = "Lecturer with the ID: " . $id . " removed the assignment titled " . $assignTitle . " for the subject " . $subId .
              " at " . $logTime ." HRS using the " . "WEB" . " platform";
    $log->set(['logMsg' => $logMsg]);

    header ("Location: view_assignment_filtered.php");

?>