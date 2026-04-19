<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Home</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <section class="home-top">
        <img src="images/cart.png" alt="background">
        <h1>Taste Of Qinyun</h1>

        <section class="display">
            
            <h3>Top Items</h3>
            
            <section class="display-item">
                <img src="images/cart.png" class="item">
                <h2>Bruschetta - $8</h2>
                <p>askjdsaldkjaslkdjdsklaj</p>
            </section>

            <section class="display-item">
                <img src="images/cart.png" class="item">
                <h2>Bruschetta - $8</h2>
                <p>askjdsaldkjaslkdjdsklaj</p>
            </section>

            <section class="display-item">
                <img src="images/cart.png" class="item">
                <h2>Bruschetta - $8</h2>
                <p>askjdsaldkjaslkdjdsklaj</p>
            </section>

            <section class="display-item">
                <img src="images/cart.png" class="item">
                <h2>Bruschetta - $8</h2>
                <p>askjdsaldkjaslkdjdsklaj</p>
            </section>
        </section>
    </section>
</body>

</html>