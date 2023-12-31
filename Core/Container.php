<?php

namespace Core;

class Container {

    protected $bindings = [];

    public function bind($key, $resolver) {

        $this->bindings[$key] = $resolver;

        }

    public function resolve($key) {
        if (!array_key_exists($key, $this->bindings)) {
            throw new \Exception("You stupid piece of shit! {$key} does not exist!");

            }
        $resolver = $this->bindings[$key];
        //then we call the function
        return call_user_func($resolver);
        }

    }
