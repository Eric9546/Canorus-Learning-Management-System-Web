<?php

    session_start ();

    // Declaring function for alert message //
    function alert ($msg)
    {

        echo "<script type='text/javascript'>alert('$msg'); window.location='index.php';</script>";

    }

     // Ensure that the user is logged in //
     if (!isset ($_SESSION ['id']))
     {

        header ("Location: login.php");

     }

     else
     {

        // Establishing connection to database //
        include ('dbcon.php');

        // Gathering the user input //
        $grade = $_POST ['grade'];
        $record_to_update = $_POST ['record_to_update'];
        $record_to_view = $_POST ['record_to_view'];
        $subId = $_POST ['subId'];
        $stuId = $_POST ['stuId'];
        $assignTitle = $_POST ['assignTitle'];
        $_SESSION ['record_to_view'] = $record_to_view;
        $_SESSION ['subId'] = $subId;
        $_SESSION ['assignTitle'] = $assignTitle;

        // Validating the input //
        if (empty ($grade))
        {

            alert ("Error Please Check Your Grade!");

        }


        // Inserting the data into the database table //
        $updateData = [

                        'grade' => $grade,

                    ];

        $ref_table = $record_to_update;
        $updateQuery = $database->getReference($ref_table)->update($updateData);

        $_SESSION ['log_id'] = $_SESSION ['id'];
        $_SESSION ['log_stuId'] = $stuId;
        $_SESSION ['log_grade'] = $grade;
        $_SESSION ['log_subId'] = $subId;
        $_SESSION ['log_assignTitle'] = $assignTitle;

        header ("Location: log_update_grade.php");

     }

?>