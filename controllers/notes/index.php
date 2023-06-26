<?php

use Core\Database;

$config = require base_path("config.php");

$db = new Database($config['database'], $config['auth']['user'],$config['auth']['password']);


$notes = $db->query('select * from notes where user_id = 1')->get();


view("notes/index.view.php", [
    'pageTitle' => 'User Notes',
    'notes' => $notes
]);
