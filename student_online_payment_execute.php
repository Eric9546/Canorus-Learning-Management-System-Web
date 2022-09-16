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

        $id = $_SESSION ['id'];
        $session = $_SESSION ['session'];       

        // Establishing connection to database //
        include ('dbcon.php');       
      
        // Get data from table //
        $path = 'Registration/' . $id;
        $reference = $database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        $name = $value ['name'];
        $program = $value ['program'];
        $payStatus = "Approved";              

        // Insert the data into the database table //
        $postData = [
    
                        'id' => $id,
                        'name' => $name,
                        'program' => $program,
                        'session' => $session,
                        'filename' => "PAYMENT_PLACEHOLDER.pdf",
                        'payStatus' => $payStatus,
                        'payMode' => "Online",
                            
                    ];

        $ref_table = "Payment/" . $session . "/" . $id;
        $postRef_result = $database->getReference($ref_table)->set($postData);

         // Updating the data in the enrolment table //
        $updateData = [

                        'payStatus' => 'Paid',

                    ];

        $ref_table = "Enrolment/" . $id;
        $updateQuery = $database->getReference($ref_table)->getValue();
        foreach ($updateQuery as $key => $rows)
        {

            if ($rows ['session'] == $session )
            {

                $path = "Enrolment/" . $id . "/" . $key;
                $updateQuery = $database->getReference($path)->update($updateData);


            }

        }

        $_SESSION ['log_id'] = $id;
        $_SESSION ['log_program'] = $program;
        $_SESSION ['log_session'] = $session;
        $_SESSION ['log_filename'] = "PAYMENT_PLACEHOLDER.pdf";

        header ("Location: log_student_payment.php");
     
     }

?>