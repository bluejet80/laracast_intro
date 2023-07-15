<?php

namespace Core;

use Core\App;
use Core\Database;
use Core\Session;

class Authenticator {

    public function attempt($email,$password) {
        $user = App::resolve(Database::class)->query('select * from users where email = :email', [
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

                $this->login($session_details);
                return true;
            }
        return false;
        }

    }

    public function login($user) {

        $_SESSION['user'] = $user;

        session_regenerate_id(true);

    }

    public function logout() {

        Session::destroy();
    }
}
