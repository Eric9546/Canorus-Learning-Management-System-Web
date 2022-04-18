<?php

    session_start ();

    if (!isset ($_SESSION ['id']))
    {
        
        header ("Location: login.php");
              
    }

    // Declaring function for alert message //
    function alert ($msg)
    {

        echo "<script type='text/javascript'>alert('$msg'); window.location='index.php';</script>";

    }

    // Establishing connection to database //
    include ('dbcon.php');

    // Gathering the input from user //
    $record_to_edit = $_POST ['record_to_edit'];
    $record_to_view = $_POST ['record_to_view'];
    unset ($_SESSION ['record_to_view']);
    $_SESSION ['record_to_view'] = $record_to_view;
    $grade = $_POST ['grade'];
    $date = date ("d/m/Y");

    // Inserting the data into the database table //
    $updateData = [
    
                    'grade' => $grade,
                    'date' => $date,
                    
                ];

    $ref_table = "Result/" . $record_to_edit;
    $updateQuery = $database->getReference($ref_table)->update($updateData);

    header ('Location:edit_result_student.php');

?>