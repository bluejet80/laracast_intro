<?php

use Core\App;
use Core\Database;
use Core\Validator;

use Http\Forms\LoginForm;

//initalize DB
$db = App::resolve(Database::class);

//Grab form Data

$email = $_POST['email'];
$password = $_POST['password'];


// Validate the Form

$form = new LoginForm();

if (! $form->validate($email, $password)){
    return view('sessions/create.view.php',[
        'errors' => $form->errors()
    ]);
}


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


