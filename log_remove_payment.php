<?php

    session_start ();

    include ('logcon.php');

    // Gather the data //
    $id = $_SESSION ['log_id'];
    $stuId = $_SESSION ['log_stuId'];
    $session = $_SESSION ['log_session'];
    $program = $_SESSION ['log_program'];

    // Save the login data to logs //
    date_default_timezone_set('Asia/Singapore');
    $logDate = date("d-m-Y");
    $logTime = date("H:i:s");

    $collection = $firestore->collection($logDate . "-PAYMENT");
    $log = $collection->document(uniqid());
    $logMsg = "Staff with the ID: " . $id . " removed the payment for student with ID: " . $stuId . " enrolled under: " . $program . " " . $session .
              " at " . $logTime ." HRS using the " . "WEB" . " platform";
    $log->set(['logMsg' => $logMsg]);

    header ("Location: edit_payment.php");

?>