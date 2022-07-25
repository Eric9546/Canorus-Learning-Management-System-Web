<?php

    session_start ();

    // Declaring function for alert message //
    function alert ($msg)
    {

        echo "<script type='text/javascript'>alert('$msg'); window.location='edit_result_student.php';</script>";

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
        $id = $_POST ['id'];
        $subId = $_POST ['subId'];
        $grade = $_POST ['grade'];
        $program = $_POST ['program'];
        $session = $_POST ['session'];
        $date = date ("d/m/Y");

        // Validating the input //
        if (empty ($id))
        {

            alert ("Error Please Check Your ID!");

        }

        else if (empty ($subId))
        {

            alert ("Error Please Check Your Subject ID!");

        }

        else if (empty ($grade))
        {

            alert ("Error Please Check Your Pay Status!");

        }

         // Query to check if subject already has result //
        $path = "Result/" . $id . "/" . $subId;
        $reference = $database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        // Logic to check if the ID already exists //
        if (!is_null ($value))
        {

            alert ("This Subject Already Has Results!");

        }

        // Get subject data //
        $path = 'Subject/' . $subId;
        $reference = $database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        $subName = $value ['subName'];

        // Inserting the data into the database table //
        $postData = [

                            'id' => $id,
                            'subId' => $subId,
                            'subName' => $subName,
                            'program' => $program,
                            'session' => $session,
                            'grade' => $grade,
                            'date' => $date,

                        ];

            $ref_table = "Result/" . $id . "/" . $subId;
            $postRef_result = $database->getReference($ref_table)->set($postData);


        $_SESSION ['record_to_view'] = $id;
        $_SESSION ['log_id'] = $_SESSION ['id'];
        $_SESSION ['log_stuId'] = $id;
        $_SESSION ['log_grade'] = $grade;
        $_SESSION ['log_program'] = $program;
        $_SESSION ['log_subId'] = $subId;

        header ("Location: log_add_result.php");


     }

?>