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

function is_admin() {
    global $config;
    return in_array($_SESSION['mail'], $config['admins']);
}

function require_admin() {
    require_login();

    if(!is_admin()) {
        header("Location: /list");
        exit();
    }
}
