<?php

    session_start ();

    // Declaring function for alert message //
    function alert ($msg)
    {

        echo "<script type='text/javascript'>alert('$msg'); window.location='edit_enrolment_student.php';</script>";

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
        $subject = $_POST ['subject'];       
        $payStatus = $_POST ['payStatus'];
        $program = $_POST ['program'];
        $session = $_POST ['session'];
        $date = date ("d/m/Y");

        // Validating the input //
        if (empty ($id))
        {

            alert ("Error Please Check Your ID!");

        }

        else if (empty ($subject))
        {

            alert ("Error Please Check Your Subject ID!");

        }

        else if (empty ($payStatus))
        {

            alert ("Error Please Check Your Pay Status!");

        }

        $str_arr = explode (",", $subject);
        $subId = $str_arr[0];
        $section = $str_arr[1];
        $section = preg_replace('/\s+/', '', $section);

         // Query to check if subject already enrolled //
        $path = "Enrolment/" . $id . "/" . $subId;
        $reference = $database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        // Logic to check if the subId already exists //
        if (!is_null ($value))
        {

            alert ("You Already Enrolled This Subject!");
            exit(0);

        } 

        // Check for clashes //
        $clash = "False";
        $path = 'Class/' . $program . "/" . $subId;
        $reference = $database->getReference($path);
        $snapshot = $reference->getSnapshot();

        $reference = $database->getReference($path)->getValue();
                    
        foreach ($reference as $key => $rows)
        {

            if ($rows ['section'] == $section)
            {

                $path2 = 'Enrolment/' . $id;
                $reference2 = $database->getReference($path2);
                $snapshot2 = $reference2->getSnapshot();

                $reference2 = $database->getReference($path2)->getValue();

                foreach ($reference2 as $key2 => $rows2)
                {
                    
                    if ($rows2 ['subId'] !== $subId)
                    {           
                    
                        $path3 = 'Class/' . $program. "/" . $rows2 ['subId'];
                        $reference3 = $database->getReference($path3);
                        $snapshot3 = $reference3->getSnapshot();

                        $reference3 = $database->getReference($path3)->getValue();

                        foreach ($reference3 as $key3 => $rows3)
                        {

                            if ($rows ['day'] == $rows3 ['day'])
                            {
           
                                if ($rows ['timeStartIndex'] >= $rows3 ['timeStartIndex'] && $rows ['timeStartIndex'] < $rows3 ['timeEndIndex'])
                                {
                    
                                    $clash = "True";

                                }

                                else if ($rows ['timeStartIndex'] > $rows3 ['timeStartIndex'] && $rows ['timeStartIndex'] <= $rows3 ['timeEndIndex'])
                                {

                                    $clash = "True";

                                }

                                else
                                {
                                
                                    $clash = "False";

                                }

                            }

                        }

                    }

                }

            }

        }

        if ($clash == "True")
        {

            alert ("Class Clash!");
            exit(0);

        }

        // Get data from subject table //
        $path = 'Subject/' . $subId;
        $reference = $database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        $subName = $value ['subName'];
        $fee = $value ['fee'];        
        $lecId = $value ['lecId'];

        // Get data from lecturer table //
        $path = 'Lecturer/' . $lecId;
        $reference = $database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        $lecName = $value ['name'];

        // Inserting the data into the database table //
        $postData = [
    
                            'id' => $id,
                            'subId' => $subId,
                            'subName' => $subName,
                            'fee' => $fee,
                            'payStatus' => $payStatus,
                            'program' => $program,
                            'session' => $session,
                            'date' => $date,
                            'section' => $section,                   
                            'lecName' => $lecName,
                            
                        ];

        $ref_table = "Enrolment/" . $id . "/" . $subId;
        $postRef_result = $database->getReference($ref_table)->set($postData);

        $record_to_view = $_POST ['record_to_view']; 
        unset ($_SESSION ['record_to_view']);
        $_SESSION ['record_to_view'] = $id; 
        header ("Location: edit_enrolment_student.php");

     }

?>