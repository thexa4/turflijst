<?php

session_start();
if(!isset($_SESSION['mail'])) {
    header("Location: /login");
    exit();
}

include_once("../config.php");

?>

<h2>Betaling toevoegen:</h2>
<form action="POST" method="deposit">
<select>
<?php
foreach($config['users'] as $user) {
?>

  <option value="<?= $user ?>"><?= $user ?></option>
<?php
}
?>
</select> betaalt: 
<input required type="number" placeholder="0.00" step="0.01" />
<input type="submit" value="Toevoegen" />

</body>
</html>
