<?php
/**
 * Authors: Harry, Hetarth, Braden, Leon, Uzair
 * Date: April 19
 * Description: Establishes a secure global, reusable PDO connection to the MySQL database backend.
 */

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