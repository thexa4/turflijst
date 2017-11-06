<?php

include_once("../config.php");

function require_login() {
    global $config;
    session_start();
    if(!isset($_SESSION['mail'])) {
        header("Location: /login");
        exit();
    }

    if(!in_array($_SESSION['mail'], $config['emails'])) {
        session_destroy();
        header("Location: /login");
        exit();
    }
}
