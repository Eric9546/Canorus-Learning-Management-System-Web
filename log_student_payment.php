<?php
    
    session_start ();

    include ('logcon.php');

    // Gather the data //
    $id = $_SESSION ['log_id'];
    $program = $_SESSION ['log_program'];
    $session = $_SESSION ['log_session'];
    $newfilename = $_SESSION ['log_filename'];

    // Save the login data to logs //
    date_default_timezone_set('Asia/Singapore'); 
    $logDate = date("d-m-Y");
    $logTime = date("H:i:s");

    $collection = $firestore->collection($logDate . "-PAYMENT");
    $log = $collection->document(uniqid());
    $logMsg = "User with the ID: " . $id . " enrolled under " . $program . " " . $session . 
              " submitted their payment file titled " . $newfilename . " at " . $logTime ." HRS using the " . "WEB" . " platform";
    $log->set(['logMsg' => $logMsg]);

    header ("Location: user_success.php");

?>