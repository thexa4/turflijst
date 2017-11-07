<?php

include_once("../auth.php");
include_once("../config.php");
include_once("../transaction.php");

require_login();

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
<?php if (is_admin()) { ?>
<a href="/admin">Administratie</a> - 
<?php } ?>
<a href="/newuser">Nieuwe Gebruiker</a> - 
<a href="https://github.com/thexa4/turflijst/issues">Problemen?</a>
<div class="tabs">
<a href="/list">Toevoegen</a> | <strong>Correcties</strong>
</div>
<form method="POST" action="/subtract">
<table class="alert">
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
