<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Menu</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main>
        <section class="menu-top">
            <img src="images/cart.png" alt="background">
            <h1>Our Menu</h1>
        </section>

        <section class="menu-layout">
            <aside class="sidebar-left">
                <a href="#">Appetizers</a>
                <a href="#">Main Courses</a>
                <a href="#">Desserts</a>
                <a href="#">Drinks</a>
            </aside>

            <section class="menu">

                <section class="menu-row">
                    <section class="menu-section">
                        <img src="images/cart.png" class="item">
                        <h2>Bruschetta - $8</h2>
                        <p>askjdsaldkjaslkdjdsklaj</p>
                        <form method="POST" action="cart/add.php">
                            <input type="hidden" name="id" value = 1>
                            <input type="hidden" name="price">
                            <button class="btn" type="submit">Add to Cart</button>
                        </form>
                    </section>
                    <section class="menu-section"> 
                        <img src="images/cart.png" class="item">
                        <h2>Bruschetta - $8</h2>
                        <p>askjdsaldkjaslkdjdsklaj</p>
                    </section>
                    <section class="menu-section">
                        <img src="images/cart.png" class="item">
                        <h2>Bruschetta - $8</h2>
                        <p>askjdsaldkjaslkdjdsklaj</p>
                    </section>
                </section>

                <section class="menu-row">
                    <section class="menu-section">
                        <img src="images/cart.png" class="item">
                        <h2>Bruschetta - $8</h2>
                        <p>askjdsaldkjaslkdjdsklaj</p>
                    </section>
                    <section class="menu-section">
                        <img src="images/cart.png" class="item">
                        <h2>Bruschetta - $8</h2>
                        <p>askjdsaldkjaslkdjdsklaj</p>
                    </section>
                    <section class="menu-section">
                        <img src="images/cart.png" class="item">
                        <h2>Bruschetta - $8</h2>
                        <p>askjdsaldkjaslkdjdsklaj</p>
                    </section>
                </section>

                <section class="menu-row">
                    <section class="menu-section">
                        <img src="images/cart.png" class="item">
                        <h2>Bruschetta - $8</h2>
                        <p>askjdsaldkjaslkdjdsklaj</p>
                    </section>
                    <section class="menu-section">
                        <img src="images/cart.png" class="item">
                        <h2>Bruschetta - $8</h2>
                        <p>askjdsaldkjaslkdjdsklaj</p>
                    </section>
                    <section class="menu-section">
                        <img src="images/cart.png" class="item">
                        <h2>Bruschetta - $8</h2>
                        <p>askjdsaldkjaslkdjdsklaj</p>
                    </section>
                </section>

            </section>
        </section>
    </main>

</body>
</html>