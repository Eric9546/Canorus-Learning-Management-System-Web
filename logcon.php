<?php

    require __DIR__.'/firestore/autoload.php';

    use Morrislaptop\Firestore\Factory;
    use Kreait\Firebase\ServiceAccount;

    $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/canorus-18990-firebase-adminsdk-09hpb-11e196e59a.json');

    $firestore = (new Factory)
        ->withServiceAccount($serviceAccount)
        ->createFirestore();

?>