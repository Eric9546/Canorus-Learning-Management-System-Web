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

    $record_to_approve = $_POST ['record_to_approve'];
    $id = $_POST ['id'];

    $program = $_POST ['program'];
    $session = $_POST ['session'];
    unset ($_SESSION ['program']);
    unset ($_SESSION ['session']);
    $_SESSION ['program'] = $program;
    $_SESSION ['session'] = $session;

    // Establishing connection to database //
    include ('dbcon.php');
      
    // Updating the data in the payment table //
    $updateData = [
    
                    'payStatus' => 'Approved',
                    
                ];

        $ref_table = $record_to_approve;
        $updateQuery = $database->getReference($ref_table)->update($updateData);

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

    header ("Location: edit_payment.php"); 

?>