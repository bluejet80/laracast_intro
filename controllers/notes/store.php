<?php

use Core\Database;
use Core\Validator;


$config = require base_path("config.php");

$db = new Database($config['database'], $config['auth']['user'], $config['auth']['password']);

$errors = [];


if (!Validator::string($_POST['body'], 1, 1000)) {
    $errors['body'] = 'A body of not more than 1,000 characters is required!';
}

if (!empty($errors)) {

    //Validation issue return view
    return view("notes/create.view.php", [
        'pageTitle' => 'Create a Note',
        'errors' => $errors

    ]);

}

$db->query('INSERT INTO notes(body, user_id) VALUES(:body, :user_id)', [
    'body' => $_POST['body'],
    'user_id' => 1
]);

header('location: /notes');
die();


