<?php

include_once("../config.php");
include_once("../transaction.php");
include_once("../auth.php");

require_login();

if (isset($_POST['submit'])) {

    $mails = $config['emails'];
    $users = $config['users'];

    if (!empty(trim($_POST['email']))) {
        array_push($mails, $_POST['email']);
        set_login([
            emails => $mails,
            admins => $config['admins'],
        ]);
    }

    if (!empty(trim($_POST['name']))) {
        array_push($users, $_POST['name']);
        set_users($users);
    }

    header("Location: /list");
    exit();
}

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
<p>Hier kun je een nieuwe gebruiker toevoegen:
<form method="POST" action="/newuser">
<div class="align">
<label for="name">Naam:</label> <input id="name" type="text" name="name" /><br>
<label for="email">Email:</label> <input id="email" type="email" name="email" /></br>
</div>
<input type="submit" name="submit" value="Toevoegen" />
</form>


</body>
</html>
