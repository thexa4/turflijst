<?php

include_once('../auth.php');
include_once("../config.php");
include_once('../transaction.php');

require_admin();

print_r($_POST);
if(isset($_POST['user']) && isset($_POST['payment'])) {
    
    $user = $_POST['user'];
    $payment = (float)$_POST['payment'];

    if (in_array($user, $config['users']) && $payment > 0) {
        create_transaction($_SESSION['mail'], $user, 0, 0, $payment);
    }
}

header("Location: /admin");
exit();
?>
