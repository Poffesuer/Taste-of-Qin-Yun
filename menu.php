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
                <a href="#appetizers">Appetizers</a>
                <a href="#main-courses">Main Courses</a>
                <a href="#desserts">Desserts</a>
                <a href="#drinks">Drinks</a>
            </aside>

            <section class="menu">

                <div class="menu-category" id="appetizers">
                    
                    <section class="menu-row">
                        <section class="menu-section">
                            <img src="images/menu/1.png" class="item" onerror="this.src='images/cart.png'">
                            <h2>Bruschetta - $8</h2>
                            <p>Toasted bread with tomatoes, garlic, and basil.</p>
                            <form method="POST" action="cart/add.php">
                                <input type="hidden" name="id" value="1">
                                <button class="btn" type="submit">Add to Cart</button>
                            </form>
                        </section>

                        <section class="menu-section">
                            <img src="images/menu/2.png" class="item" onerror="this.src='images/cart.png'">
                            <h2>Garlic Bread - $6</h2>
                            <p>Freshly baked bread with butter and garlic.</p>
                            <form method="POST" action="cart/add.php">
                                <input type="hidden" name="id" value="2">
                                <button class="btn" type="submit">Add to Cart</button>
                            </form>
                        </section>
                        <section class="menu-section">
                            <img src="images/menu/3.png" class="item" onerror="this.src='images/cart.png'">
                            <h2>Stuffed Mushrooms - $10</h2>
                            <p>Mushrooms stuffed with cheese and herbs.</p>
                            <form method="POST" action="cart/add.php">
                                <input type="hidden" name="id" value="3">
                                <button class="btn" type="submit">Add to Cart</button>
                            </form>
                        </section>
                    </section>
                </div>

                <div class="menu-category" id="main-courses" hidden>
                    <section class="menu-row">
                        <section class="menu-section">
                            <img src="images/menu/5.png" class="item" onerror="this.src='images/cart.png'">
                            <h2>Spaghetti Bolognese - $15</h2>
                            <p>Classic Italian pasta with rich meat sauce.</p>
                            <form method="POST" action="cart/add.php">
                                <input type="hidden" name="id" value="4">
                                <button class="btn" type="submit">Add to Cart</button>
                            </form>
                        </section>
                        <section class="menu-section">
                            <img src="images/menu/8.png" class="item" onerror="this.src='images/cart.png'">
                            <h2>Grilled Salmon - $22</h2>
                            <p>Fresh salmon served with roasted vegetables.</p>
                            <form method="POST" action="cart/add.php">
                                <input type="hidden" name="id" value="5">
                                <button class="btn" type="submit">Add to Cart</button>
                            </form>
                        </section>
                        <section class="menu-section">
                            <img src="images/menu/10.png" class="item" onerror="this.src='images/cart.png'">
                            <h2>Margherita Pizza - $14</h2>
                            <p>Wood-fired pizza with tomato, mozzarella, and basil.</p>
                            <form method="POST" action="cart/add.php">
                                <input type="hidden" name="id" value="6">
                                <button class="btn" type="submit">Add to Cart</button>
                            </form>
                        </section>
                    </section>
                </div>

                <div class="menu-category" id="desserts" hidden>
                    <section class="menu-row">
                        <section class="menu-section">
                            <img src="images/menu/18.png" class="item" onerror="this.src='images/cart.png'">
                            <h2>Tiramisu - $9</h2>
                            <p>Coffee-flavored Italian dessert.</p>
                            <form method="POST" action="cart/add.php">
                                <input type="hidden" name="id" value="7">
                                <button class="btn" type="submit">Add to Cart</button>
                            </form>
                        </section>
                        <section class="menu-section">
                            <img src="images/menu/19.png" class="item" onerror="this.src='images/cart.png'">
                            <h2>Cheesecake - $8</h2>
                            <p>Creamy New York style cheesecake.</p>
                            <form method="POST" action="cart/add.php">
                                <input type="hidden" name="id" value="8">
                                <button class="btn" type="submit">Add to Cart</button>
                            </form>
                        </section>
                    </section>
                </div>

                <div class="menu-category" id="drinks" hidden>
                    <section class="menu-row">
                        <section class="menu-section">
                            <img src="images/menu/20.png" class="item" onerror="this.src='images/cart.png'">
                            <h2>Red Wine - $7</h2>
                            <p>Glass of house red wine.</p>
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

    <script>
        (function () {
            var menu = document.querySelector('.menu');
            if (!menu) return;

            var panels = menu.querySelectorAll('.menu-category');
            var links = document.querySelectorAll('.sidebar-left a[href^="#"]');

            function syncFromHash() {
                var raw = location.hash.slice(1);
                var showAll = raw === 'all-items';
                var id = showAll
                    ? 'all-items'
                    : (raw && document.getElementById(raw) ? raw : 'appetizers');

                panels.forEach(function (panel) {
                    panel.hidden = showAll ? false : panel.id !== id;
                });

                links.forEach(function (a) {
                    var href = a.getAttribute('href');
                    var match = showAll ? href === '#all-items' : href === '#' + id;
                    a.classList.toggle('is-active', match);
                    if (match) a.setAttribute('aria-current', 'true');
                    else a.removeAttribute('aria-current');
                });
            }

            window.addEventListener('hashchange', syncFromHash);
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', syncFromHash);
            } else {
                syncFromHash();
            }
        })();
    </script>

</body>

</html>