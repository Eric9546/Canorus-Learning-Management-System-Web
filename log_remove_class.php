<?php

    session_start ();

    include ('logcon.php');

    // Gather the data //
    $id = $_SESSION ['log_id'];
    $program = $_SESSION ['log_program'];
    $subId = $_SESSION ['log_subId'];
    $day = $_SESSION ['log_day'];
    $timeStart = $_SESSION ['log_timeStart'];
    $timeEnd = $_SESSION ['log_timeEnd'];

    // Save the login data to logs //
    date_default_timezone_set('Asia/Singapore');
    $logDate = date("d-m-Y");
    $logTime = date("H:i:s");

    $collection = $firestore->collection($logDate . "-CLASS");
    $log = $collection->document(uniqid());
    $logMsg = "Staff with the ID: " . $id . " removed the class for " . $program . "-" . $subId . " for " . $day . " " . $timeStart . "-" . $timeEnd .
              " at " . $logTime ." HRS using the " . "WEB" . " platform";
    $log->set(['logMsg' => $logMsg]);

    header ("Location: edit_class.php");

?>