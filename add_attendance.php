<?php

    session_start ();

    // Declaring function for alert message //
    function alert ($msg)
    {

        echo "<script type='text/javascript'>alert('$msg'); window.location='edit_attendance.php';</script>";

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
        $day = $_POST ['day'];
        $month = $_POST ['month'];
        $year = $_POST ['year'];
        $timeStart = $_POST ['timeStart'];
        $timeEnd = $_POST ['timeEnd'];

        $program = $_POST ['program'];
        $subId = $_POST ['subId'];
        $section = $_POST ['section'];
        $session = $_POST ['session'];
        $_SESSION ['program'] = $program;
        $_SESSION ['subId'] = $subId;
        $_SESSION ['section'] = $section;
        $_SESSION ['session'] = $session;

        $classDateTime = $day . "-" . $month . "-" . $year . "-" . $timeStart . "-" . $timeEnd;

        // Validating the input //
        if (empty ($day))
        {

            alert ("Error Please Check Your Day");

        }

        else if (empty ($month))
        {

            alert ("Error Please Check Your Month!");

        }

        else if (empty ($year))
        {

            alert ("Error Please Check Your Year!");

        }

        else if (empty ($timeStart))
        {

            alert ("Error Please Check Your Starting Time!");

        }

        else if (empty ($timeEnd))
        {

            alert ("Error Please Check Your Ending Time!");

        }

        function timeStartIndex ($timeStart)
        {

            if ($timeStart == "8:00am")
            {
                $index = 8;
            }

            else if ($timeStart == "9:00am")
            {
                $index = 9;
            }

            else if ($timeStart == "10:00am")
            {
                $index = 10;
            }

            else if ($timeStart == "11:00am")
            {
                $index = 11;
            }

            else if ($timeStart == "12:00pm")
            {
                $index = 12;
            }

            else if ($timeStart == "1:00pm")
            {
                $index = 13;
            }

            else if ($timeStart == "2:00pm")
            {
                $index = 14;
            }

            else if ($timeStart == "3:00pm")
            {
                $index = 15;
            }

            else if ($timeStart == "4:00pm")
            {
                $index = 16;
            }

            else if ($timeStart == "5:00pm")
            {
                $index = 17;
            }

            return $index;

        }

        function timeEndIndex ($timeEnd)
        {

            if ($timeEnd == "9:00am")
            {
                $index = 9;
            }

            else if ($timeEnd == "10:00am")
            {
                $index = 10;
            }

            else if ($timeEnd == "11:00am")
            {
                $index = 11;
            }

            else if ($timeEnd == "12:00pm")
            {
                $index = 12;
            }

            else if ($timeEnd == "1:00pm")
            {
                $index = 13;
            }

            else if ($timeEnd == "2:00pm")
            {
                $index = 14;
            }

            else if ($timeEnd == "3:00pm")
            {
                $index = 15;
            }

            else if ($timeEnd == "4:00pm")
            {
                $index = 16;
            }

            else if ($timeEnd == "5:00pm")
            {
                $index = 17;
            }

            else if ($timeEnd == "6:00pm")
            {
                $index = 18;
            }

            return $index;

        }

        $timeStartIndex = timeStartIndex ($timeStart);
        $timeEndIndex = timeEndIndex ($timeEnd);

        if ($timeEndIndex <= $timeStartIndex)
        {

            alert ("End Time Cannot Be Earlier Or Equal To Start Time!");
            exit (0);

        }

        // Query to check if attendance item already exists //
        $path = 'Attendance/' . $session . '/' . $subId . '/' . $section . '/' . $classDateTime;
        $reference = $database->getReference($path);
        $snapshot = $reference->getSnapshot();
        $value = $snapshot->getValue();

        // Logic to check if the content name already exists //
        if (!is_null ($value))
        {

            alert ("Attendance Item Already Exists!");

        }

        else
        {

            // Generate 6 digit pin //
            $attendPin = rand(100000,999999);
            $attendPin = strval($attendPin);

            // Generate QR Code //
            include 'phpqrcode/qrlib.php';

            $QRcode = 'qr/' . $attendPin . '.png';
            $ecc = 'L';
            $pixel_size = 76;
            $frame_size = 10;

            // Generates QR Code and Stores it in directory given
            QRcode::png($attendPin, $QRcode, $ecc, $pixel_size, $frame_size);

             // Inserting the data into the database table //
            $postData = [

                            'classDateTime' => $classDateTime,
                            'attendPin' => $attendPin,
                            'attendStatus' => 'Opened',
                            'QRcode' => $QRcode,

                        ];

            $ref_table = 'Attendance/' . $session .  '/' . $subId . '/' . $section . '/' . $classDateTime;
            $postRef_result = $database->getReference($ref_table)->set($postData);

            // Inserting student list //
            $path = 'Enrolment/';
            $reference = $database->getReference($path);
            $snapshot = $reference->getSnapshot();

            $reference = $database->getReference($path)->getValue();

            // Retrieve student enrolement details //
            foreach ($reference as $key => $rows)
            {

                $path2 = 'Enrolment/' . $key;
                $reference2 = $database->getReference($path2);
                $snapshot2 = $reference2->getSnapshot();

                $reference2 = $database->getReference($path2)->getValue();

                foreach ($reference2 as $key2 => $rows2)
                {

                    // Retrieve student personal details //
                    $path3 = 'Registration/' . $key;
                    $reference3 = $database->getReference($path3);
                    $snapshot3 = $reference3->getSnapshot();
                    $value = $snapshot3->getValue();

                    $stuName = $value ['name'];

                    if ($key2 == $subId)
                    {

                        $path4 = 'Enrolment/' . $key . '/' . $key2;
                        $reference4 = $database->getReference($path4);
                        $snapshot4 = $reference4->getSnapshot();
                        $value2 = $snapshot4->getValue();

                        // Check for session and section match //
                        if (str_contains($section, $value2 ['section']) && $value2 ['session'] == $session)
                        {

                            $postData = [

                                            'stuId' => $key,
                                            'stuName' => $stuName,
                                            'attendStatus' => 'Absent',

                                        ];

                            $ref_table = 'Attendance/' . $session . '/' . $subId . '/' . $section . '/' . $classDateTime . '/' . $key;
                            $postRef_result = $database->getReference($ref_table)->set($postData);

                        }

                    }

                }

            }

            header ("Location: edit_attendance.php");

        }

     }

?>