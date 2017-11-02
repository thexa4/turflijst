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
</head>
<body>
<h1>Dranklijst Scouting Hillegersberg</h1>
<p>Hier kun je voor iedereen bier strepen. Mocht je een foutje hebben gemaakt, klik dan op correcties.</p>
<a href="/corrections">Correcties</a>
<a href="/admin">Administratie</a>
<form method="POST" action="/add">

<?php
foreach($config['users'] as $user) {
    $saldo = transaction_summary($user);
?>
<p><?= $user ?>
<input type="submit" name="bier[<?= base64_encode($user) ?>]" value="Bier (<?= number_format($saldo['bier'], 0) ?>) +1" />
<input type="submit" name="fris[<?= base64_encode($user) ?>]" value="Fris (<?= number_format($saldo['fris'], 0) ?>) +1" />
(&euro;<?= number_format($saldo['money'], 2) ?>)
<?php
}
?>
</form>


</body>
</html>
