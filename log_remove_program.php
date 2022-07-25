<?php

    session_start ();

    include ('logcon.php');

    // Gather the data //
    $id = $_SESSION ['log_id'];
    $progName = $_SESSION ['log_progName'];
    $progCode = $_SESSION ['log_progCode'];

    // Save the login data to logs //
    date_default_timezone_set('Asia/Singapore');
    $logDate = date("d-m-Y");
    $logTime = date("H:i:s");

    $collection = $firestore->collection($logDate . "-PROGRAM");
    $log = $collection->document(uniqid());
    $logMsg = "Staff with the ID: " . $id . " removed the program " . $progCode . "-" . $progName .
              " at " . $logTime ." HRS using the " . "WEB" . " platform";
    $log->set(['logMsg' => $logMsg]);

    header ("Location: admin_success.php");

?>