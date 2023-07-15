<?php


use Core\Database;
use Core\App;
use Core\Validator;

$db = App::resolve(Database::class);

$currentUserId = 1;

// find the corresponding note

$note = $db->query("select * from notes where id = :id", [
    'id' => $_POST['id']
])->findOrFail();

//authorize that the current user can edit the note

authorize($note['user_id'] === $currentUserId);

//validate the form

$errors = [];


if (!Validator::string($_POST['body'], 1, 1000)) {
    $errors['body'] = 'A body of not more than 1,000 characters is required!';
}

if (!empty($errors)) {

    //Validation issue return view
    return view("notes/edit.view.php", [
        'pageTitle' => 'Edit Note',
        'errors' => $errors,
        'note' => $note

    ]);

}

// no validation errors update the record in the database

$db->query('update notes set body = :body where id = :id',[
        'id' => $_POST['id'],
        'body' => $_POST['body']
]);

// redirect user

redirect('/notes');




