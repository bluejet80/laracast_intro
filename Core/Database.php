<?php

// Connect to the database and execute a query

namespace Core;

use PDO;

class Database {

    public $connection;
    public $statement;

    public function __construct($config, $user, $password) {

        

        $dsn = 'mysql:' . http_build_query($config, '', ';');


         // New PDO Instance
         $this->connection = new PDO($dsn,$user,$password,[
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
         ]);

    }

    public function query($query,$params = []) {

       

        // Prepared a query Statement
        $this->statement = $this->connection->prepare($query);

        // Executed the Query Statement
        $this->statement->execute($params);

        // Fetched all the Results as an Associative Array
        return $this;

    }

    public function find() {
        // $statement->fetch();

        return $this->statement->fetch();

    }

    public function findOrFail() {
        $result = $this->find();

        if(! $result) {
            abort();
        }

        return $result;
    }

    public function get() {
        return $this->statement->fetchAll();
    }

}
