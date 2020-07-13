<?php

include_once('../auth.php');
include_once("../config.php");
include_once('../transaction.php');

require_admin();

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
<h1>Admin</h1>

<a href="/">Terug naar dranklijst</a>
<!--Dit is de link terug naar de dranklijst -->

<h2>Betaling toevoegen</h2>
<form action="/deposit" method="POST">
<select name="user">
<?php
foreach($config['users'] as $user) {
?>

  <option value="<?= $user ?>"><?= $user ?></option>
<?php
}
?>
</select> betaalt: 
<input name="payment" required type="number" placeholder="0.00" step="0.01" />
<input name="submit" type="submit" value="Toevoegen" />
</form>

<h2>Prijzen</h2>
<p>Pas op, dit verandert ook de prijzen van alle nog niet <a href="#reconcile">afgerekende</a> bier en fris. Als dit niet de bedoeling is, klik dan eerst op <a href="#reconcile">reken af</a>.
<form action="/prices" method="POST">
<div class="align">
<label for="fris">Fris:</label><input id="fris" name="price[fris]" type="number" step="0.01" placeholder="<?= number_format($config['prices']['fris'],2) ?>" value="<?= number_format($config['prices']['fris'],2) ?>" /><br>
<label for="bier">Bier:</label><input id="bier" name="price[bier]" type="number" step="0.01" placeholder="<?= number_format($config['prices']['bier'],2) ?>" value="<?= number_format($config['prices']['bier'],2) ?>" /> 
<input type="submit" name="submit" value="Instellen" />
</form>

<h2>Users</h2>
<form action="/users" method="POST">
<table>
    <thead><th>Name</th><th></th></thead>

<?php
foreach($config['users'] as $user) {
        $saldo = transaction_summary($user);
        $removable = $saldo['money'] == 0 && $saldo['bier'] == 0 && $saldo['fris'] == 0;
        ?>
        <tr>
        <td><?= $user ?></td>
        <td><input type="submit" name="remove[<?= base64_encode($user) ?>]" value="Remove" <?php if(!$removable) { ?> disabled <?php } ?> /> <?php if(!$removable) { ?> (Niet volledig afgerekend) <?php } ?></td>
        </tr>
        <?php
}
?>
</table>
</form>

<h2>Logins</h2>
<form action="/emails" method="POST">

<table>
    <thead><th>Email</th><th>&nbsp;</th></thead>

<?php
foreach($config['emails'] as $mail) {
        ?>
        <tr>
        <td><?= $mail ?></td>
        <td>
        <?php
        if ($_SESSION['mail'] != $mail) {
        ?>

        <?php
        if (in_array($mail, $config['admins'])) { ?>
            <input type="submit" name="remove_admin[<?= base64_encode($mail) ?>]" value="Verwijder administrator" />
            <input type="submit" name="remove[<?= base64_encode($mail) ?>]" value="Remove" disabled /> 
        <?php } else { ?>
            <input type="submit" name="add_admin[<?= base64_encode($mail) ?>]" value="Maak administrator" />
            <input type="submit" name="remove[<?= base64_encode($mail) ?>]" value="Remove" /> 
        <?php } ?>

        <?php } ?>
        </td></tr>
        <?php
}
?>
</table>
</form>

<h2 id="reconcile">Afrekenen</h2>
<form action="/reconcile" method="POST">
<input type="submit" name="submit" value="Reken af" />
</form>

<h2>Transacties</h2>
<table>
<thead><th>Email</th><th>Gebruiker</th><th>Bier</th><th>Fris</th><th>Betaling</th></thead>
<?php
foreach(array_reverse(get_transactions()) as $transaction)
{
    ?>
    <tr>
        <td><?= $transaction->owner ?></td>
        <td><?= $transaction->user ?></td>
        <td style="text-align: right"><?= $transaction->bier != 0 ? $transaction->bier : '' ?></td>
        <td style="text-align: right"><?= $transaction->fris != 0 ? $transaction->fris : '' ?></td>
        <td style="text-align: right"><?= $transaction->money != 0 ? number_format($transaction->money, 2) : '' ?></td>
    </tr>
    <?php
}
?>
</table>

</body>
</html>
