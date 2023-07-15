<?php

use Core\Validator;
use Core\App;
use Core\Database;
use Http\Forms\LoginForm;

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

// validate the form inputs

$form = new LoginForm();

if (! $form->validate($email, $password)){
    return view('sessions/create.view.php',[
        'errors' => $form->errors()
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
    redirect('/sessions');
} else {
    // If no, save one to the database, and then log the user in, and redirect

$db->query('INSERT INTO users(name, email, password) VALUES(:name, :email, :password)', [
    'name' => $name,
    'email' => $email,
    'password' => password_hash($password, PASSWORD_DEFAULT)
]);

    // mark that the user has logged in


login($user);

redirect('/')
}

