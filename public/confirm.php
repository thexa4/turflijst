<?php

session_start();
if(isset($_SESSION['mail'])) {
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

$_SESSION['mail'] = $decoded->mail;

header('Location: /list')
?>
