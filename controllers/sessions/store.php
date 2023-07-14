<?php

use Core\App;
use Core\Database;
use Core\Validator;

//initalize DB
$db = App::resolve(Database::class);

//Grab form Data

$email = $_POST['email'];
$password = $_POST['password'];


// Validate the Form

$errors = [];

if (!Validator::email($email)) {
      $errors['email'] = 'Please provide a VALID Email Address.';
}
if (!Validator::string($password)) {
      $errors['password'] = 'Please provide a valid password.';
}

if (! empty($errors)) {
    return view('sessions/create.view.php',[
        'errors' => $errors
    ]);
    }

// match the credentials
//
// Check if user exists

$user = $db->query('select * from users where email = :email', [
    'email' => $email
])->find();

if($user) {

// validate the password

if(password_verify($password, $user['password'])) {

    // login the user is the credentials match
        $session_details = [
            'email' => $user['email'],
            'name' => $user['name'],
            'isLoggedIn' => true
        ];


        login($session_details);

        header('location: /');
        exit();
    }
}

return view('sessions/create.view.php',[
    'errors' => [
        'email' => "No Matching Account found for email {$email} and Password."]
]);


