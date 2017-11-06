<?php

function get_config($name, $default) {
    $path = __DIR__ . "/config/$name.json";

    if (file_exists($path)) {
        $data = file_get_contents($path);
        $parsed = json_decode($data);
        if ($parsed)
            return $parsed;
    }

    return $default;

}

function set_config($name, $data) {
    $path = __DIR__ . "/config/$name.json";
    
    $encoded = json_encode($data);
    file_put_contents($path . '.new', $encoded);
    rename($path . '.new', $path);
}

function get_prices() {
    return get_config('prices', [
        fris => 0.60,
        bier => 0.75,
    ]);
}

function set_prices($prices) {
    if(!is_array($prices) || !isset($prices['fris']) || !isset($prices['bier']))
        throw new Exception("Bad prices");

    set_config('prices', $prices);
}

function get_users() {
    return get_config('users', []);
}

function set_users($users) {
    if(empty($users))
        return;

    set_config('users', $users);
}

function get_login() {
    $result = get_config('login', false);
    if (!$result)
        return [
            emails => [],
            admins => [],
        ];

    return [
        emails => $result->emails,
        admins => $result->admins,
    ];
}

function set_login($data) {
    if (!isset($data['emails']) || !isset($data['admins']))
        throw new Exception("Bad login data");

    set_config('login', $data);
}

function get_misc() {
    $data = get_config('misc', false);
    if (!$data) {
        $data = new stdClass;
        $data->version = 1;
        $data->mac_secret = bin2hex(random_bytes(24));
        set_config('misc', $data);
    }
    return $data;
}

$config = [
    mac_secret => get_misc()->mac_secret,
    mac_type => 'ripemd256',
    
    prices => get_prices(),
    users => get_users(),

    emails => get_login()['emails'],
    admins => get_login()['admins'],
];

