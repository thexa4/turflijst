<?php

include_once('../auth.php');
include_once("../config.php");
include_once('../transaction.php');

require_admin();

if (isset($_POST['add_admin']))
    foreach($_POST['add_admin'] as $encoded => $value) {
        $mail = base64_decode($encoded);

        $admins = $config['admins'];
        array_push($admins, $mail);
        $admins = array_values(array_unique($admins));
        set_login([
            emails => $config['emails'],
            admins => $admins,
        ]);
        $config['admins'] = $admins;
    }

if (isset($_POST['remove_admin']))
    foreach($_POST['remove_admin'] as $encoded => $value) {
        $mail = base64_decode($encoded);

        $admins = $config['admins'];
        $admins = array_values(array_filter($admins, function($i) use ($mail) { return $i != $mail; }));
        set_login([
            emails => $config['emails'],
            admins => $admins,
        ]);
        $config['admins'] = $admins;
    }

if (isset($_POST['remove']))
    foreach($_POST['remove'] as $encoded => $value) {
        $mail = base64_decode($encoded);

        $emails = $config['emails'];
        $emails = array_values(array_filter($emails, function($i) use ($mail) { return $i != $mail; }));
        set_login([
            emails => $emails,
            admins => $config['admins'],
        ]);
        $config['emails'] = $emails;
    }


header("Location: /admin");
exit();
?>
