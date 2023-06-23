<?php

$id = $_GET['id'];

$query = "select * from posts where id = ?";

// we also added a parameter to the execute() method
// it accepts an array of values
// this is where the query properties meet up with the query itself
// when we pass the [$id] it gets inputed into where the '?' is in the query
// NEVER NEVER inline direct user inputs into the query

$posts = $db->query($query, [$id])->fetchAll();