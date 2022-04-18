<?php

    require __DIR__.'/vendor/autoload.php';
 
    use Google\Cloud\Storage\StorageClient;

    $storage = new StorageClient([
                'keyFilePath' => 'canorus-18990-firebase-adminsdk-09hpb-11e196e59a.json',

            ]);

            
?>