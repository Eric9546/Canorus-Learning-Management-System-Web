<?php

    sendNotification("New Notification!", "Sent From Web", "default", "AAAAnfSwSms:APA91bHzdrOgExVlwZM0Igsa-1wWKyzpL3b6QT1HDUMqpE2pPZRUfwbUwQz3EToo5PZYx_T3qrGZVWRJhJW3e8uIjTyatYtJhJ6753BwXJ-iBQLaT4NpqCG5Y8RLP5n4O_BnvtANTJas");

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