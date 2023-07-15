<?php

use Core\Authenticator;

use Http\Forms\LoginForm;


// Validate the Form
// Attempt to Authenticate the User

$form = LoginForm::validate($attributes = [
    'email' => $_POST['email'],
    'password' => $_POST['password']
]);

$signedIn = (new Authenticator)->attempt($attributes['email'], $attributes['password']);

if (! $signedIn) {
    $form->error('email',"No Matching Account found for email {$attributes['email']} and Password.")->throw();
}

redirect('/');







