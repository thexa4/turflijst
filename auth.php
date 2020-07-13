<?php

include_once("../config.php");

function is_logged_in() {
    global $config;
    session_start(array(
        'cookie_httponly' => true,
        'cookie_secure' => true,
        'cookie_path' => '/; SameSite=Lax',
	'cookie_lifetime' => 2*365*24*60*60,
    ));
    if(!isset($_SESSION['mail'])) {
        return false;
    }

    if(!in_array($_SESSION['mail'], $config['emails'])) {
        session_destroy();
        return false;
    }
    return true;
}

function require_login() {
    global $config;
    if (!is_logged_in()) {
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
