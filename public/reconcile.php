<?php

include_once('../auth.php');
include_once("../config.php");
include_once('../transaction.php');

require_admin();

if(isset($_POST['submit'])) {
    foreach($config['users'] as $user) {
        transaction_reconcile($_SESSION['mail'], $user);   
    }
}

header("Location: /admin");
exit();
?>
