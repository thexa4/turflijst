<?php

session_start();
if(isset($_SESSION['mail'])) {
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
</head>
<body>
<h1>Dranklijst Scouting Hillegersberg</h1>
<p> Log hier in met je e-mailadres. </p>
<form method="POST" action="/login">
<input type="email" name="email" placeholder="rikki_tikki_tavi@scoutinghillegersberg.nl">
<input type="submit" name="submit" value="Log in">
</form>
</body>
</html>

