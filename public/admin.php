<?php

session_start();
if(!isset($_SESSION['mail'])) {
    header("Location: /login");
    exit();
}

include_once("../config.php");

?>

<select>

<?php
foreach($config['users'] as $user) {
?>

  <option value="<?= $user ?>"><?= $user ?></option>
<?php
}
?>
</select>

</body>
</html>
