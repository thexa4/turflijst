<?php

include_once('../auth.php');
include_once("../config.php");
include_once('../transaction.php');

require_admin();

if(isset($_POST['price']['fris']) && isset($_POST['price']['bier'])) {
    
    $fris = (float)$_POST['price']['fris'];
    $bier = (float)$_POST['price']['bier'];

    if ($fris > 0 && $bier > 0) {
        set_prices([
            fris => $fris,
            bier => $bier,
        ]);
    }
}

header("Location: /admin");
exit();
?>
