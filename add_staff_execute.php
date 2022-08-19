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
        $id = $_POST ['id'];
        $password = $_POST ['password'];
        $access_level = $_POST ['access_level'];
        $name = $_POST ['name'];
        $email = $_POST ['email'];
        $telno = $_POST ['telno'];
        $ic = $_POST ['ic'];
        $address = $_POST ['address'];
        $program = "N/A";
        $session = "N/A";

        // Validating the input //
        if (empty ($id))
        {

            alert ("Error Please Check Your Staff ID!");

        }

        else if (empty ($password))
        {

            alert ("Error Please Check Your Password!");

        }

        else if (empty ($access_level))
        {

            alert ("Error Please Check Your Access Level!");

        }

        else if (empty ($name))
        {

            alert ("Error Please Check Your Name!");

        }

        else if (is_numeric ($name))
        {

            alert ("Error Please Check Your Name!");

        }

        else if (empty ($email))
        {

            alert ("Error Please Check Your Email!");

        }

        else if (empty ($telno))
        {

            alert ("Error Please Check Your Phone!");

        }

        else if (!is_numeric ($telno))
        {

            alert ("Error Please Check Your Phone!");

        }

        else if (empty ($ic))
        {

            alert ("Error Please Check Your IC/Passport!");

        }

        else if (empty ($address))
        {

            alert ("Error Please Check Your Address!");

        }

        else if (empty ($program))
        {

            alert ("Error Please Check Your Program!");

        }

        else if (empty ($session))
        {

            alert ("Error Please Check Your Session!");

        }

        // Capitalize the id //
        $id = strtoupper ($id);

        // Query to check if ID already exists //
        $path = 'Registration/' . $id;
        $reference = $database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        // Logic to check if the ID already exists //
        if (!is_null ($value))
        {

            alert ("Staff ID Already Exists!");

        }

        else
        {

             // Inserting the data into the database table //
            $postData = [

                            'id' => $id,
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

            $ref_table = "Registration/" . $id;
            $postRef_result = $database->getReference($ref_table)->set($postData);

            if ($access_level == "Lecturer")
            {

                // Update the lecturer table //
                $postData = [

                                'lecId' => $id,
                                'name' => $name,
                                'email' => $email,
                                'telno' => $telno,

                            ];

                $ref_table = "Lecturer/" . $id;
                $postRef_result = $database->getReference($ref_table)->set($postData);

            }

            $_SESSION ['log_id'] = $_SESSION ['id'];
            $_SESSION ['log_newId'] = $id;
            $_SESSION ['log_access_level'] = $access_level;

            header ("Location: log_add_staff.php");

        }

     }

?>