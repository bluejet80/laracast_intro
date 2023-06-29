<?php

use Core\Validator;
use Core\App;
use Core\Database;

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// validate the form inputs

$errors = [];

if (!Validator::email($email)) {
      $errors['email'] = 'Please provide a VALID Email Address.';
}
if (!Validator::string($password, 7,255)) {
      $errors['password'] = 'Please provide a password between 7 and 255 chars long.';
}

if (! empty($errors)) {
    return view('registration/create.view.php',[
        'errors' => $errors
    ]);
    }

// check if the account already exists


$db = App::resolve(Database::class);

$user = $db->query('select * from users where email = :email', [
    'email' => $email
])->find();


if($user) {
    //Someone with that email already exists
    // If yes redirect to login page

    header('location: /login');
    exit();
} else {
    // If no, save one to the database, and then log the user in, and redirect

$db->query('INSERT INTO users(name, email, password) VALUES(:name, :email, :password)', [
    'name' => $name,
    'email' => $email,
    'password' => $password
]);

    // mark that the user has logged in



header('location: /notes');
die();
}

