<?php
    
    session_start ();

    include ('logcon.php');

    // Gather the data //
    $access_level = $_SESSION ['access_level'];
    $id = $_SESSION ['id'];

    // Save the login data to logs //
    date_default_timezone_set('Asia/Singapore'); 
    $logDate = date("d-m-Y");
    $logTime = date("H:i:s");

    $collection = $firestore->collection($logDate . "-LOGIN");
    $log = $collection->document(uniqid());
    $logMsg = "User with the ID: " . $id . " with the access level of " . strtoupper($access_level) . 
              " logged in at " . $logTime . " HRS using the " . "WEB" . " platform";
    $log->set(['logMsg' => $logMsg]);

    header ("Location: index.php");

?>