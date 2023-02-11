<?php

include('connection.php');

$stmt = $conn->prepare("SELECT * FROM products WHERE prod_category=3 LIMIT 4");

$stmt->execute(); //executes the sql query

$skirts = $stmt->get_result(); //stores result into a variable as array (its an array of result)

?> 