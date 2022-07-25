<?php

    session_start ();

    include ('logcon.php');

    // Gather the data //
    $id = $_SESSION ['log_id'];
    $session = $_SESSION ['log_session'];

    // Save the login data to logs //
    date_default_timezone_set('Asia/Singapore');
    $logDate = date("d-m-Y");
    $logTime = date("H:i:s");

    $collection = $firestore->collection($logDate . "-SESSION");
    $log = $collection->document(uniqid());
    $logMsg = "Staff with the ID: " . $id . " removed the session " . $session .
              " at " . $logTime ." HRS using the " . "WEB" . " platform";
    $log->set(['logMsg' => $logMsg]);

    header ("Location: admin_success.php");

?>