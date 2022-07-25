<?php

    session_start ();

    include ('logcon.php');

    // Gather the data //
    $id = $_SESSION ['log_id'];
    $stuId = $_SESSION ['log_stuId'];
    $program = $_SESSION ['log_program'];
    $session = $_SESSION ['log_session'];

    // Save the login data to logs //
    date_default_timezone_set('Asia/Singapore');
    $logDate = date("d-m-Y");
    $logTime = date("H:i:s");

    $collection = $firestore->collection($logDate . "-DETAILS");
    $log = $collection->document(uniqid());
    $logMsg = "Staff with the ID: " . $id . " added student with ID: " . $stuId . " enrolled under " . $program . " " . $session . 
              " at " . $logTime ." HRS using the " . "WEB" . " platform";
    $log->set(['logMsg' => $logMsg]);

    header ("Location: admin_success.php");

?>