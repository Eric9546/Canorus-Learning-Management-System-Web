<?php

    session_start ();

    include ('logcon.php');

    // Gather the data //
    $id = $_SESSION ['log_id'];
    $newId = $_SESSION ['log_newId'];
    $access_level = $_SESSION ['log_access_level'];

    // Save the login data to logs //
    date_default_timezone_set('Asia/Singapore');
    $logDate = date("d-m-Y");
    $logTime = date("H:i:s");

    $collection = $firestore->collection($logDate . "-STAFF");
    $log = $collection->document(uniqid());
    $logMsg = "Staff with the ID: " . $id . " added user with ID: " . $newId . " with access level: " .
              $access_level . " at " . $logTime ." HRS using the " . "WEB" . " platform";
    $log->set(['logMsg' => $logMsg]);

    header ("Location: admin_success.php");

?>