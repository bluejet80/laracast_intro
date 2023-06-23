<?php


// connect to the MySQL Database

//Connection String
$dsn = "mysql:host=localhost;port=3306;dbname=laracast_data1;user=bluejet;password=Afterlife1980!;charset=utf8mb4";

// New PDO Instance
$pdo = new PDO($dsn);

// Prepared a query Statement
$statement = $pdo->prepare("select * from posts");

// Executed the Query Statement
$statement->execute();

// Fetched all the Results as an Associative Array
$posts = $statement->fetchAll(PDO::FETCH_ASSOC);


// Displayed the results
foreach ($posts as $post) {
    echo "<li>" . $post['content'] . "</li>";
}

