<?php
/**
 * Authors: Harry, Hetarth, Braden, Leon, Uzair
 * Date: April 19
 * Description: Displays the main restaurant menu and product cards, allowing users to select and add items to their cart.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Menu</title>
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <main>
        <!-- Removed menu-top section as requested -->
        <section class="menu-layout">
            <aside class="sidebar-left">
                <a href="#all-items">All Items</a>
                <a href="#traditional-liangpi">Traditional Liangpi</a>
                <a href="#special-liangpi">Special Liangpi & Soups</a>
                <a href="#mo-buns">Mo (Buns)</a>
            </aside>

            <section class="menu">

                <div class="menu-category" id="traditional-liangpi">

                    <section class="menu-row">
                        <section class="menu-section">
                            <img src="images/menu/1.png" class="item" onerror="this.src='images/cart.png'">
                            <h2>Traditional Liangpi - $9.38</h2>
                            <p>Traditional Liangpi, a classic Chinese cold skin noodle dish.</p>
                            <form method="POST" action="cart/add.php">
                                <input type="hidden" name="id" value="1">
                                <button class="btn" type="submit">Add to Cart</button>
                            </form>
                        </section>

                        <section class="menu-section">
                            <img src="images/menu/2.png" class="item" onerror="this.src='images/cart.png'">
                            <h2>Traditional Wide Liangpi - $10.00</h2>
                            <p>Traditional Liangpi, a classic Chinese cold skin noodle dish featuring wide cut noodles.
                            </p>
                            <form method="POST" action="cart/add.php">
                                <input type="hidden" name="id" value="2">
                                <button class="btn" type="submit">Add to Cart</button>
                            </form>
                        </section>
                        <section class="menu-section">
                            <img src="images/menu/3.png" class="item" onerror="this.src='images/cart.png'">
                            <h2>Steamed Rice Noodle - $10.00</h2>
                            <p>Steamed rice noodles completely immersed in authentic spices and seasonings.</p>
                            <form method="POST" action="cart/add.php">
                                <input type="hidden" name="id" value="3">
                                <button class="btn" type="submit">Add to Cart</button>
                            </form>
                        </section>
                    </section>
                </div>

                <div class="menu-category" id="special-liangpi" hidden>
                    <section class="menu-row">
                        <section class="menu-section">
                            <img src="images/menu/7.png" class="item" onerror="this.src='images/cart.png'">
                            <h2>Spinach Liangpi - $10.00</h2>
                            <p>Cold spinach infused noodles served with a refreshing, robust house sauce.</p>
                            <form method="POST" action="cart/add.php">
                                <input type="hidden" name="id" value="4">
                                <button class="btn" type="submit">Add to Cart</button>
                            </form>
                        </section>
                        <section class="menu-section">
                            <img src="images/menu/8.png" class="item" onerror="this.src='images/cart.png'">
                            <h2>Liangpi in Sesame Sauce - $10.00</h2>
                            <p>Authentic cold skin noodles thoroughly mixed in a dense, rich sesame sauce profile.</p>
                            <form method="POST" action="cart/add.php">
                                <input type="hidden" name="id" value="5">
                                <button class="btn" type="submit">Add to Cart</button>
                            </form>
                        </section>
                        <section class="menu-section">
                            <img src="images/menu/10.png" class="item" onerror="this.src='images/cart.png'">
                            <h2>Liangpi in Minced Pork Soup - $12.50</h2>
                            <p>Spicy minced pork broth served intensely hot alongside classical Liangpi noodles.</p>
                            <form method="POST" action="cart/add.php">
                                <input type="hidden" name="id" value="6">
                                <button class="btn" type="submit">Add to Cart</button>
                            </form>
                        </section>
                    </section>
                </div>

                <div class="menu-category" id="mo-buns" hidden>
                    <section class="menu-row">
                        <section class="menu-section">
                            <img src="images/menu/18.png" class="item" onerror="this.src='images/cart.png'">
                            <h2>Pulled Pork Mo - $7.50</h2>
                            <p>Super tender pulled pork infused gracefully in a traditional sauce seamlessly served
                                inside a fresh bun.</p>
                            <form method="POST" action="cart/add.php">
                                <input type="hidden" name="id" value="7">
                                <button class="btn" type="submit">Add to Cart</button>
                            </form>
                        </section>
                        <section class="menu-section">
                            <img src="images/menu/19.png" class="item" onerror="this.src='images/cart.png'">
                            <h2>Lamb Mo - $10.63</h2>
                            <p>Sizzling lamb meat brilliantly stuffed inside a traditional, crispy, warm Chinese
                                flatbread bun wrapper.</p>
                            <form method="POST" action="cart/add.php">
                                <input type="hidden" name="id" value="8">
                                <button class="btn" type="submit">Add to Cart</button>
                            </form>
                        </section>
                        <section class="menu-section">
                            <img src="images/menu/20.png" class="item" onerror="this.src='images/cart.png'">
                            <h2>Saucy Pork Mo - $8.75</h2>
                            <p>Flavorful saucy seared pork presented steaming heavily in a freshly baked Chinese Mo bun
                                wrapper.</p>
                            <form method="POST" action="cart/add.php">
                                <input type="hidden" name="id" value="9">
                                <button class="btn" type="submit">Add to Cart</button>
                            </form>
                        </section>
                    </section>
                </div>

            </section>
        </section>
    </main>

    <script src="js/menu.js?v=<?php echo time(); ?>"></script>
    <script src="js/cart.js?v=<?php echo time(); ?>"></script>

</body>

</html>