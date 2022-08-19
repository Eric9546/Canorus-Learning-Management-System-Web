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

        echo "<script type='text/javascript'>alert('$msg'); window.location='view_staff.php';</script>";

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
    $program = "N/A";
    $session = "N/A";

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

    // Update the lecturer database table //
    $updateData = [

                    'name' => $name,
                    'email' => $email,
                    'telno' => $telno,

                ];

    $ref_table = "Lecturer/" . $record_to_edit;
    $updateQuery = $database->getReference($ref_table)->update($updateData);

    $_SESSION ['log_id'] = $_SESSION ['id'];
    $_SESSION ['log_newId'] = $record_to_edit;
    $_SESSION ['log_access_level'] = $access_level;

    header ('Location:log_edit_staff.php');

?>