<?php

include_once("../config.php");
include_once("../transaction.php");
include_once("../auth.php");

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
<p>Hier kun je voor iedereen bier strepen. Mocht je een foutje hebben gemaakt, klik dan op correcties.</p>
<a href="/admin">Administratie</a> - 
<a href="/newuser">Nieuwe Gebruiker</a> - 
<a href="https://github.com/thexa4/turflijst/issues">Problemen?</a>
<div class="tabs">
<strong>Strepen</strong> | <a href="/corrections">Correcties</a>
</div>
<form method="POST" action="/add">
<table>
<thead><th>Naam</th><th colspan="2">&nbsp;</th><th>Saldo</th></thead>
<?php
foreach($config['users'] as $user) {
    $saldo = transaction_summary($user);
?>
<tr>
<td><?= $user ?></td>
<td><input type="submit" name="bier[<?= base64_encode($user) ?>]" value="Bier (<?= number_format($saldo['bier'], 0) ?>) +1" /></td>
<td><input type="submit" name="fris[<?= base64_encode($user) ?>]" value="Fris (<?= number_format($saldo['fris'], 0) ?>) +1" /></td>
<td>(&euro;<?= number_format($saldo['money'], 2) ?>)</td>
</tr>
<?php
}
?>
</table>
</form>


</body>
</html>
