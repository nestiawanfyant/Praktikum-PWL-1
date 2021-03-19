<?php
    require './vendor/autoload.php';

    $client = new Google_Client();
    $client->setClientId('340220671624-j21dmbqrgd68aksu8pc6acrdnoc4qeuk.apps.googleusercontent.com');
    $client->setClientSecret('1hdysY-ynvH2Hseg-cEHTzOR');
    $client->setRedirectUri('http://localhost/Nazla_PWL_OAuth/index.php');
    $client->addScope('email');
    $client->addScope('profile');

    session_start();