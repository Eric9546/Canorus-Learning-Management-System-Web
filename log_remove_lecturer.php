<?php

    session_start ();

    include ('logcon.php');

    // Gather the data //
    $id = $_SESSION ['log_id'];
    $lecId = $_SESSION ['log_lecId'];

    // Save the login data to logs //
    date_default_timezone_set('Asia/Singapore');
    $logDate = date("d-m-Y");
    $logTime = date("H:i:s");

    $collection = $firestore->collection($logDate . "-LECTURER");
    $log = $collection->document(uniqid());
    $logMsg = "Staff with the ID: " . $id . " removed the lecturer with ID: " . $lecId .
              " at " . $logTime ." HRS using the " . "WEB" . " platform";
    $log->set(['logMsg' => $logMsg]);

    header ("Location: view_lecturer.php");

?>