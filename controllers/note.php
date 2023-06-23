<?php

$config = require "./config.php";

$db = new Database($config['database'], $config['auth']['user'],$config['auth']['password']);


$pageTitle = "User Notes";
$currentUserId = 1;


$note = $db->query("select * from notes where id = :id", [
    'id' => $_GET['id']
])->findOrFail();

authorize($note['user_id'] === $currentUserId);


require "views/note.view.php";