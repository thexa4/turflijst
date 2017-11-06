<?php

session_start();
if(!isset($_SESSION['mail'])) {
    header("Location: /login");
    exit();
}

include_once("../config.php");
include_once("../transaction.php");

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
<h1>Dranklijst Scouting Hillegersberg</h1>
<p>Hier kan je de aantallen corrigeren, mocht je teveel bier of fris hebben aangeklikt.</p>
<a href="/list">Toevoegen</a>
<form method="POST" action="/subtract">
<table>
<thead><th>Naam</th><th colspan="2">&nbsp;</th><th>Saldo</th></thead>
<?php
foreach($config['users'] as $user) {
        $saldo = transaction_summary($user);
        ?>
        <tr>
        <td><?= $user ?></td>
        <td><input type="submit" name="bier[<?= base64_encode($user) ?>]" value="Bier (<?= number_format($saldo['bier'], 0) ?>) -1" /></td>
        <td><input type="submit" name="fris[<?= base64_encode($user) ?>]" value="Fris (<?= number_format($saldo['fris'], 0) ?>) -1" /></td>
        <td>(&euro;<?= number_format($saldo['money'], 2) ?>)</td>
        </tr>
        <?php
}
?>
</table>
</form>


</body>
</html>
