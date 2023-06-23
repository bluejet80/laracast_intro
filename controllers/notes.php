<?php

$config = require "./config.php";

$db = new Database($config['database'], $config['auth']['user'],$config['auth']['password']);


$pageTitle = "User Notes";

$notes = $db->query('select * from notes where user_id = 1')->get();


require "views/notes.view.php";