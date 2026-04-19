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
        <section class="menu-top">
            <img src="images/cart.png" alt="background">
            <h1>Our Menu</h1>
        </section>

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
                            <img src="images/cart.png" class="item">
                            <h2>Bruschetta - $8</h2>
                            <p>askjdsaldkjaslkdjdsklaj</p>
                            <form method="POST" action="cart/add.php">
                                <input type="hidden" name="id" value=1>
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
                </div>

                <div class="menu-category" id="main-courses" hidden>
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
                </div>

                <div class="menu-category" id="desserts" hidden>
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
                    </section>
                </div>

                <div class="menu-category" id="drinks" hidden>
                    <section class="menu-row">
                        <section class="menu-section">
                            <img src="images/cart.png" class="item">
                            <h2>Bruschetta - $8</h2>
                            <p>askjdsaldkjaslkdjdsklaj</p>
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