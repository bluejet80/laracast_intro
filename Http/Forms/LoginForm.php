<?php

namespace Http\Forms;

use Core\Validator;

class LoginForm {

    protected $errors = [];

    function validate($email, $password) {
        
        if (!Validator::email($email)) {
              $this->errors['email'] = 'Please provide a VALID Email Address.';
        }
        if (!Validator::string($password,10)) {
              $this->errors['password'] = 'Please provide a valid password.';
        }
        
        return empty($this->errors);
    }

    function errors() {

        return $this->errors;
    }

    function error($field, $message) {
        $this->errors[$field] = $message;
    }
}

