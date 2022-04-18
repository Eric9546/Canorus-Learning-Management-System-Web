<?php

    require __DIR__.'/vendor/autoload.php';

    use Kreait\Firebase\Factory;

    $factory = (new Factory)
        ->withServiceAccount('canorus-18990-firebase-adminsdk-09hpb-11e196e59a.json')
        ->withDatabaseUri('https://canorus-18990-default-rtdb.asia-southeast1.firebasedatabase.app/');

    $database = $factory->createDatabase();

?>