<?php

    session_start ();

    // Declaring function for alert message //
    function alert ($msg)
    {

        echo "<script type='text/javascript'>alert('$msg'); window.location='edit_class.php';</script>";

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
        $subId = $_POST ['subject'];
        $program = $_POST ['program'];
        $day = $_POST ['day'];
        $timeStart = $_POST ['timeStart'];
        $timeEnd = $_POST ['timeEnd'];
        $room = $_POST ['room'];
        $section = $_POST ['section'];
        $type = $_POST ['type'];
        $lecId = $_POST ['lecId'];

        $_SESSION ['program'] = $program;
        $_SESSION ['subId'] = $subId;

        $uuid = uniqid();

        // Validating the input //
        if (empty ($subId))
        {

            alert ("Error Please Check Your Subject ID!");

        }

        else if (empty ($program))
        {

            alert ("Error Please Check Your Program!");

        }

        else if (empty ($day))
        {

            alert ("Error Please Check Your Day!");

        }

        else if (empty ($timeStart))
        {

            alert ("Error Please Check Your Time Start!");

        }

        else if (empty ($timeEnd))
        {

            alert ("Error Please Check Your Time End!");

        }

        else if (empty ($room))
        {

            alert ("Error Please Check Your Room!");

        }

        else if (empty ($section))
        {

            alert ("Error Please Check Your Section!");

        }

        else if (empty ($type))
        {

            alert ("Error Please Check Your Type!");

        }

        else if (empty ($lecId))
        {

            alert ("Error Please Check Your Lecturer ID!");

        }

        // Get sections //
        $sectionList = "";
        $count = count ($section);
        $i = 0;

        foreach ($section as $item)
        {

            if(++$i === $count)
            {

                $sectionList = $sectionList . $item;

            }

            else
            {

                $sectionList = $sectionList . $item . '-';

            }

        }

        // Capitalize the variables //
        $subId = strtoupper ($subId);
        $sectionList = strtoupper ($sectionList);

        // Find the timeStartIndex //
        $timeStartIndex = timeStartIndex ($timeStart);
        $timeEndIndex = timeEndIndex ($timeEnd);

        // Validate the time inputs //
        if ($timeEndIndex <= $timeStartIndex)
        {

            alert ("End Time Cannot Be Equal Or Earlier Than Start Time!");
            exit(0);

        }

        // Check for time clash //
        $path = 'Class/' . $program . "/" . $subId . "/";
        $reference = $database->getReference($path);
        $snapshot = $reference->getSnapshot();

        $reference = $database->getReference($path)->getValue();

        foreach ($reference as $key => $rows)
        {

            // Check the day //
            if ($day == $rows ['day'])
            {

                // Check the time //
                if ($timeStartIndex >= $rows ['timeStartIndex'] && $timeStartIndex < $rows ['timeEndIndex'])
                {

                    alert ("Clashes With The Class Start Time!");
                    exit(0);

                }

                else if ($timeEndIndex > $rows ['timeStartIndex'] && $timeEndIndex <= $rows ['timeEndIndex'])
                {

                    alert ("Clashes With The Class End Time!");
                    exit(0);

                }

            }

        }

        // Check for room and lecturer clash //
        $path = 'Class/';
        $reference = $database->getReference($path);
        $snapshot = $reference->getSnapshot();

        $reference = $database->getReference($path)->getValue();

        foreach ($reference as $key => $rows)
        {

            $path2 = 'Class/' . $key. "/";
            $reference2 = $database->getReference($path2);
            $snapshot2 = $reference2->getSnapshot();

            $reference2 = $database->getReference($path2)->getValue();

            foreach ($reference2 as $key2 => $rows2)
            {

                if ($key2 !== $subId)
                {

                    $path3 = 'Class/' . $key. "/" . $key2 . "/";
                    $reference3 = $database->getReference($path3);
                    $snapshot3 = $reference3->getSnapshot();

                    $reference3 = $database->getReference($path3)->getValue();

                    foreach ($reference3 as $key3 => $rows3)
                    {

                            // Check the day //
                           if ($day == $rows3 ['day'])
                            {

                                // Check the time //
                                if ($timeStartIndex >= $rows3 ['timeStartIndex'] && $timeStartIndex < $rows3 ['timeEndIndex'])
                                {

                                    // Check the room //
                                    if ($room == $rows3 ['room'])
                                    {

                                        alert ("Clashes With Room Availability! ($room)");
                                        exit(0);

                                    }

                                    // Check the lecturer //
                                    else if ($lecId == $rows3 ['lecId'])
                                    {

                                        alert ("Clashes With Lecturer Availability! ($lecId)");
                                        exit(0);

                                    }

                                }

                                else if ($timeEndIndex > $rows3 ['timeStartIndex'] && $timeEndIndex <= $rows3 ['timeEndIndex'])
                                {

                                    if ($room == $rows3 ['room'])
                                    {

                                        alert ("Clashes With Room Availability! ($room)");
                                        exit(0);

                                    }

                                    else if ($lecId == $rows3 ['lecId'])
                                    {

                                        alert ("Clashes With Lecturer Availability! ($lecId)");
                                        exit(0);

                                    }

                                }

                            }

                    }

                }

            }

        }


        // Inserting the data into the database table //
        $postData = [

                        'uuid' => $uuid,
                        'subId' => $subId,
                        'program' => $program,
                        'day' => $day,
                        'timeStart' => $timeStart,
                        'timeStartIndex' => $timeStartIndex,
                        'timeEndIndex' => $timeEndIndex,
                        'timeEnd' => $timeEnd,
                        'room' => $room,
                        'section' => $sectionList,
                        'type' => $type,
                        'lecId' => $lecId,

                    ];

        $ref_table = "Class/" . $program . "/" . $subId . "/" . $uuid;
        $postRef_result = $database->getReference($ref_table)->set($postData);

        header ("Location: edit_class.php");

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

?>