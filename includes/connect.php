<?php

try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=restaurant;charset=utf8mb4",
        "root",
        ""
    );

} catch (Exception $e) {
    die("ERROR: Couldn't connect. " . $e->getMessage());
}

?>