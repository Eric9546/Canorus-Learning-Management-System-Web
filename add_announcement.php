<?php

    session_start ();

    // Declaring function for alert message //
    function alert ($msg)
    {

        echo "<script type='text/javascript'>alert('$msg'); window.location='view_notes_filtered.php';</script>";

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
        $announceTitle = $_POST ['announceTitle'];
        $announceDetail = $_POST ['announceDetail'];
        $subId = $_POST ['subId'];
        $_SESSION ['subId'] = $subId;

        // Validating the input //
        if (empty ($announceTitle))
        {

            alert ("Error Please Check Your Announcement Title!");

        }

        else if (empty ($announceDetail))
        {

            alert ("Error Please Check Your Announcement Details!");

        }

        else if (empty ($subId))
        {

            alert ("Error Please Check Your SubId!");

        }


        // Get time stamp //
        date_default_timezone_set('Asia/Singapore');
        $logDate = date("d-m-Y");
        $logTime = date("H:i:s");
        $indexTime = $logDate . "-" . $logTime;

        $logTime = date("h:ia");
        $datePublished = $logDate . ", " . $logTime;

        // Inserting the data into the database table //
        $postData = [

                        'announceTitle' => $announceTitle,
                        'announceDetail' => $announceDetail,
                        'datePublished' => $datePublished,

                    ];

        $ref_table = 'Announcement/' . $subId .'/' . $indexTime;
        $postRef_result = $database->getReference($ref_table)->set($postData);

        // Send push notification to mobile platform //
        sendNotification("New Announcement From " . $subId, $announceTitle, $subId, "AAAAnfSwSms:APA91bHzdrOgExVlwZM0Igsa-1wWKyzpL3b6QT1HDUMqpE2pPZRUfwbUwQz3EToo5PZYx_T3qrGZVWRJhJW3e8uIjTyatYtJhJ6753BwXJ-iBQLaT4NpqCG5Y8RLP5n4O_BnvtANTJas");

        header ("Location: view_announcements_filtered.php");

     }

     function sendNotification($title = "", $body = "", $topic = "", $serverKey = "")
     {
         if($serverKey != ""){
             ini_set("allow_url_fopen", "On");
             $data =
             [
                 "to" => '/topics/'.$topic,
                 "notification" => [
                     "body" => $body,
                     "title" => $title,

                 ],

             ];

             $options = array(
                 'http' => array(
                     'method'  => 'POST',
                     'content' => json_encode( $data ),
                     'header'=>  "Content-Type: application/json\r\n" .
                                 "Accept: application/json\r\n" .
                                 "Authorization:key=".$serverKey
                 )
             );

             $context  = stream_context_create( $options );
             $result = file_get_contents( "https://fcm.googleapis.com/fcm/send", false, $context );
             return json_decode( $result );
         }

         return false;
     }

?>