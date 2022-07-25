<?php

    session_start ();

    include ('logcon.php');

    // Gather the data //
    $id = $_SESSION ['log_id'];
    $subId = $_SESSION ['log_subId'];
    $subName = $_SESSION ['log_subName'];
    $program = $_SESSION ['log_program'];

    // Save the login data to logs //
    date_default_timezone_set('Asia/Singapore');
    $logDate = date("d-m-Y");
    $logTime = date("H:i:s");

    $collection = $firestore->collection($logDate . "-SUBJECT");
    $log = $collection->document(uniqid());
    $logMsg = "Staff with the ID: " . $id . " updated the subject details for " . $subId . "-" . $subName . " under the program " . $program .
              " at " . $logTime ." HRS using the " . "WEB" . " platform";
    $log->set(['logMsg' => $logMsg]);

    header ("Location: view_subject.php");

?>