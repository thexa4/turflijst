<?php

include_once('../auth.php');
include_once("../config.php");
include_once("../transaction.php");

require_login();

$owner = $_SESSION['mail'];

if (isset($_POST['fris']))
    foreach($_POST['fris'] as $enc_user => $value) {
        $user = base64_decode($enc_user);
        if (!in_array($user, $config['users'])) {
            echo "Gebruiker bestaat niet.";
            die();
        }

        create_transaction($owner, $user, 0, 1, 0);
    }

if (isset($_POST['bier']))
    foreach($_POST['bier'] as $enc_user => $value) {
        $user = base64_decode($enc_user);
        if (!in_array($user, $config['users'])) {
            echo "Gebruiker bestaat niet.";
            die();
        }

        create_transaction($owner, $user, 1, 0, 0);
    }

header("Location: /list");
?>
