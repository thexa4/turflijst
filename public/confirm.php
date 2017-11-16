<?php

include_once('../auth.php');
include_once("../config.php");
include_once("../transaction.php");

if (is_logged_in()) {
    header("Location: /list");
    exit();
}

if(!isset($_GET['payload']) || !isset($_GET['mac'])) {
    header("Location: /");
    exit();
}

require_once('../config.php');

$payload = base64_decode($_GET['payload']);
$comparison = hash_hmac($config['mac_type'], $payload, $config['mac_secret']);

if (!hash_equals($comparison, $_GET['mac'])) {
    echo("Fout tijdens controleren van link, probeer opnieuw");
    die();
}

$decoded = json_decode($payload);
if (!isset($decoded->date) || !isset($decoded->mail)) {
    echo("Missing fields.");
    print_r($decoded);
    die();
}

$delta = time() - $decoded->date;
if ($delta < 0 || $delta > 30*60) {
    echo "Link verlopen";
    die();
}

if (empty($config['emails'])) {
    // First user, make admin
    set_users([
        emails => [$decoded->mail],
        admins => [$decoded->mail],
    ]);
} else {
    if (!in_array($decoded->mail, $config['emails'])) {
        echo("Not authorized to log in.");
        die();
    }
}

$_SESSION['mail'] = $decoded->mail;

header('Location: /list')
?>
