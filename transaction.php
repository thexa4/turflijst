<?php

/*
{
    "owner": "info@maxmaton.nl",
    "user": "Suzy",
    "bier": 1,
    "money": 4.25
}
*/
function get_transactions() {
    $transactions = scandir("../transactions/");

    $result = array();

    foreach($transactions as $transaction) {
        $contents = file_get_contents("../transactions/" . $transaction);
        $decoded = json_decode($contents);

        array_push($result, $decoded);
    }

    return $result;
}

$transaction_count = 0;
function create_transaction($owner, $user, $bier, $fris, $money) {
    global $transaction_count;
    $data = [
        owner => $owner,
        user => $user,
        bier => $bier,
        fris => $fris,
        money => $money,
    ];

    $encoded = json_encode($data);
    $name = time() . '_' . base64_encode($owner) . '-' . $transaction_count++ . '.json';
    file_put_contents("../transactions/$name", $encoded);
}

function transaction_summary($user) {
    $result = [
        bier => 0,
        fris => 0,
        money => 0,
    ];

    foreach(get_transactions() as $transaction) {
        if ($transaction->user != $user)
            continue;

        $result['bier'] += $transaction->bier;
        $result['fris'] += $transaction->fris;
        $result['money'] += $transaction->money;
    }

    return $result;
}

function transaction_reconcile($owner, $user) {
    global $config;

    $current = transaction_summary($user);
    $price = 0;
    $price += $current['bier'] * $config['prices']['bier'];
    $price += $current['fris'] * $config['prices']['fris'];

    create_transaction($owner, $user, -$current['bier'], -$current['fris'], -$price);
}
