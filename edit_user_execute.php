<?php

    session_start ();
    if (!isset ($_SESSION ['id']))
    {
        
        header ("Location: login.php");
              
    }

    $id = $_SESSION ['id'];

    // Declaring function for alert message //
    function alert ($msg)
    {

        echo "<script type='text/javascript'>alert('$msg'); window.location='view_user.php';</script>";

    }

    // Establishing connection to database //
    include ('dbcon.php');

    // Gathering the input from user //
    $record_to_edit = $_POST ['record_to_edit'];
    $password = $_POST ['password'];           
    $access_level = $_POST ['access_level'];
    $name = $_POST ['name'];
    $email = $_POST ['email'];
    $telno = $_POST ['telno'];  
    $ic = $_POST ['ic'];
    $address = $_POST ['address'];  
    $program = $_POST ['program'];
    $session = $_POST ['session'];

    $path = 'Registration/' . $record_to_edit;
    $reference = $database->getReference($path);
    $snapshot = $reference->getSnapshot();
    $value = $snapshot->getValue();

    if ($password == NULL)
    {

        $password = $value ['password'];
        
    }

    if ($name == NULL)
    {

        $name = $value ['name'];
        
    }

    if ($email == NULL)
    {

        $email = $value ['email'];

    }

    if ($telno == NULL)
    {

        $telno = $value ['telno'];
        
    }

    if ($ic == NULL)
    {

        $ic = $value ['ic'];
        
    }

    if ($address == NULL)
    {

        $address = $value ['address'];
        
    }

    // Updating the data into the database table //
    $path = 'Registration/' . $record_to_edit;
    $reference = $database->getReference($path)->remove();

    $postData = [
    
                            'id' => $record_to_edit,
                            'password' => $password,
                            'access_level' => $access_level,
                            'name' => $name,
                            'email' => $email,
                            'telno' => $telno,
                            'ic' => $ic,
                            'address' => $address,
                            'program' => $program,
                            'session' => $session,

                            
                        ];

    $ref_table = "Registration/" . $record_to_edit;
    $postRef_result = $database->getReference($ref_table)->set($postData);

    header ('Location:view_user.php');

?>