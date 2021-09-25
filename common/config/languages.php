<?php

function get_languages() {
    $db = require(__DIR__ . '/main-local.php');

    $connection  = new yii\db\Connection([
        'dsn' => $db['components']['db']['dsn'],
        'username' => $db['components']['db']['username'],
        'password' => $db['components']['db']['password'],
        'charset' => $db['components']['db']['charset'],
    ]);


    $sql = "SELECT * FROM languages WHERE active = '1'";

    $command = $connection->createCommand($sql);

    $find_languages = $command->queryAll();

    $languages = [];
    foreach ($find_languages as $lang) {
        $languages[$lang['name']] =  $lang['code'];
    }

    return $languages;
}