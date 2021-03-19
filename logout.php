<?php

    include('./config.php');

    // $googleClient->revokeToken($_SESSION['access_token']);

    session_destroy();

    header('location:index.php');