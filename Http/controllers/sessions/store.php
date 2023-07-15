<?php

use Core\Validator;
use Core\Authenticator;

use Http\Forms\LoginForm;

//Grab form Data

$email = $_POST['email'];
$password = $_POST['password'];


// Validate the Form
// Attempt to Authenticate the User

$form = new LoginForm();

if ($form->validate($email, $password)){

    if ((new Authenticator)->attempt($email, $password)) {
        redirect('/');
    }
    $form->error('email',"No Matching Account found for email {$email} and Password.");

}


return view('sessions/create.view.php',[
    'errors' => $form->errors()
]);


