<?php

include_once('../auth.php');
include_once("../config.php");
include_once('../transaction.php');

require_admin();

if (isset($_POST['remove']))
    foreach($_POST['remove'] as $encoded => $value) {
        $user = base64_decode($encoded);

        $users = $config['users'];
        $users = array_values(array_filter($users, function($i) use ($user) { return $i != $user; }));
        set_users($users);
        $config['users'] = $users;
    }


header("Location: /admin");
exit();
?>
