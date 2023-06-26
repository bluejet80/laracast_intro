<?php

require base_path("Validator.php");

$config = require base_path("config.php");

$db = new Database($config['database'], $config['auth']['user'], $config['auth']['password']);

$errors = []

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    if (!Validator::string($_POST['body'], 1, 1000)) {
        $errors['body'] = 'A body of not more than 1,000 characters is required!';
    }

    if (empty($errors)) {
        $db->query('INSERT INTO notes(body, user_id) VALUES(:body, :user_id)', [
            'body' => $_POST['body'],
            'user_id' => 1
        ]);
    }
}

view("notes/create.view.php", [
    'pageTitle' => 'Create a Note',
    'errors' => $errors
]);