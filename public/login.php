<?php


include_once('../auth.php');
include_once("../config.php");
include_once("../transaction.php");

if (is_logged_in()) {
    header("Location: /list");
    exit();
}

if(!isset($_POST['email'])) {
    header("Location: /");
    exit();
}

// Only log in if user is known
if (empty($config['emails']) || in_array($_POST['email'], $config['emails'])) {

    $data = [
        "mail" => $_POST['email'],
        "date" => time(),
    ];
    $payload = json_encode($data);
    $mac = hash_hmac($config['mac_type'], $payload, $config['mac_secret']);
    if(!$mac) {
        die();
    }

    $url = 'https://dranklijst.maxmaton.nl/confirm?payload=' . base64_encode($payload) . '&mac=' . $mac;

    $message = "Hallo,

Dit is je link om in te loggen op de streeplijst: $url

Fijne dag!";

    mail($_POST['email'], "Dranklijst login", $message);

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Dranklijst</title>
<link rel="stylesheet" href="/style.css" />
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<?php
if (!in_array($_POST['email'], $config['emails'])) {
    ?>
<h2>Geen toegang tot lijst, vraag een admin om toegang.</h2>
<?php } else { ?>
<h2>Check je mail voor de login link.</h2>
<?php } ?>
</body>
</html>
