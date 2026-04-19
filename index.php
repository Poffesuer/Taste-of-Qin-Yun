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
                <img src="images/location.png" alt="Map and directions to Taste of Qin Yun" loading="lazy" decoding="async">
            </div>
        </div>
    </section>
</body>

</html>