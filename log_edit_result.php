<?php

    session_start ();

    include ('logcon.php');

    // Gather the data //
    $id = $_SESSION ['log_id'];
    $stuId = $_SESSION ['log_stuId'];
    $grade = $_SESSION ['log_grade'];
    $program = $_SESSION ['log_program'];
    $subId = $_SESSION ['log_subId'];

    // Save the login data to logs //
    date_default_timezone_set('Asia/Singapore');
    $logDate = date("d-m-Y");
    $logTime = date("H:i:s");

    $collection = $firestore->collection($logDate . "-RESULT");
    $log = $collection->document(uniqid());
    $logMsg = "Staff with the ID: " . $id . " updated the grade to " . $grade . " for the student: " . $stuId . " in " .
              $program . " " . $subId . " at " . $logTime ." HRS using the " . "WEB" . " platform";
    $log->set(['logMsg' => $logMsg]);

    header ("Location: edit_result_student.php");

?>