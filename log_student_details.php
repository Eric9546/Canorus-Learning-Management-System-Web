<?php
    
    session_start ();

    include ('logcon.php');

    // Gather the data //
    $id = $_SESSION ['id'];

    // Save the login data to logs //
    date_default_timezone_set('Asia/Singapore'); 
    $logDate = date("d-m-Y");
    $logTime = date("H:i:s");

    $collection = $firestore->collection($logDate . "-DETAILS");
    $log = $collection->document(uniqid());
    $logMsg = "User with the ID: " . $id . " updated their personal details at ". $logTime ." HRS using the " . "WEB" . " platform";
    $log->set(['logMsg' => $logMsg]);

    header ("Location: user_success.php");

?>