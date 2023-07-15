<?php

namespace Http\Forms;

use Core\Validator;
use Core\ValidationException;

class LoginForm {

    protected $errors = [];
    public $attributes;

    public function __construct($attributes) {
        $this->attributes = $attributes;

        if (!Validator::email($attributes['email'])) {
              $this->errors['email'] = 'Please provide a VALID Email Address.';
        }
        if (!Validator::string($attributes['password'])) {
              $this->errors['password'] = 'Please provide a valid password.';
        }

    }

    public static function validate($attributes) {

        $instance = new static($attributes);

        return $instance->failed() ? $instance->throw() : $instance;

    }

    public function throw() {

        ValidationException::throw($this->errors(), $this->attributes);

    }

    public function failed() {
        return count($this->errors);
    }

    function errors() {

        return $this->errors;
    }

    function error($field, $message) {
        $this->errors[$field] = $message;

        return $this;
    }
}

