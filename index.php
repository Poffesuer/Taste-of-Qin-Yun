<?php
/**
 * Authors: Harry, Hetarth, Braden, Leon, Uzair
 * Date: April 19
 * Description: Main landing page introducing Taste of Qin Yun.
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
    <title>Restaurant Home</title>
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <section class="home-top">
        <img src="images/cart.png" alt="background">
        <h1>Taste Of Qinyun</h1>

        <section class="display">

            <h3>Featured Dishes</h3>

            <section class="display-item">
                <img src="images/menu/1.png" class="item" onerror="this.src='images/cart.png'">
                <h2>Traditional Liangpi - $9.38</h2>
                <p>Traditional Liangpi, a classic Chinese cold skin noodle dish.</p>
            </section>

            <section class="display-item">
                <img src="images/menu/19.png" class="item" onerror="this.src='images/cart.png'">
                <h2>Lamb Mo - $10.63</h2>
                <p>Sizzling lamb meat brilliantly stuffed inside a traditional, crispy, warm Chinese flatbread bun wrapper.</p>
            </section>

            <section class="display-item">
                <img src="images/menu/18.png" class="item" onerror="this.src='images/cart.png'">
                <h2>Pulled Pork Mo - $7.50</h2>
                <p>Super tender pulled pork infused gracefully in a traditional sauce seamlessly served inside a fresh
                    bun.</p>
            </section>

            <section class="display-item">
                <img src="images/menu/20.png" class="item" onerror="this.src='images/cart.png'">
                <h2>Saucy Pork Mo - $8.75</h2>
                <p>Flavorful saucy seared pork presented steaming heavily in a freshly baked Chinese Mo bun wrapper.</p>
            </section>
        </section>
    </section>

    <section class="home-location" aria-labelledby="location-heading">
        <div class="home-location-inner">
            <div class="home-location-col home-location-info">
                <h2 id="location-heading">Taste of Qin Yun</h2>
                <address class="home-location-address">
                    23 Bonis Ave, Scarborough, ON<br>
                    Canada<br>
                    M1T 2T9
                </address>
                <p class="home-location-tel">Tel: <a href="tel:+14168396998">416-839-6998</a></p>
            </div>
            <div class="home-location-col home-location-hours-wrap" aria-labelledby="location-hours-heading">
                <h3 id="location-hours-heading" class="home-location-hours-title">Business Hours</h3>
                <ul class="home-location-hours">
                    <li><span class="home-location-day">Mon:</span> Closed</li>
                    <li><span class="home-location-day">Tue:</span> 11:00am - 6:30pm</li>
                    <li><span class="home-location-day">Wed:</span> 11:00am - 6:30pm</li>
                    <li><span class="home-location-day">Thu:</span> 11:00am - 6:30pm</li>
                    <li><span class="home-location-day">Fri:</span> 11:00am - 6:30pm</li>
                    <li><span class="home-location-day">Sat:</span> 11:00am - 6:30pm</li>
                    <li><span class="home-location-day">Sun:</span> 11:00am - 6:30pm</li>
                </ul>
            </div>
            <div class="home-location-col home-location-media">
                <img src="images/location.png" alt="Map and directions to Taste of Qin Yun" loading="lazy"
                    decoding="async">
            </div>
        </div>
    </section>
</body>

</html>