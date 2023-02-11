<?php

include('connection.php');

$stmt = $conn->prepare("SELECT * FROM products LIMIT 4");

$stmt->execute(); //executes the sql query

$featured_products = $stmt->get_result(); //stores result into a variable as array (its an array of result)
?>