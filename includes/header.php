<?php
$base_url = '';
if (strpos($_SERVER['REQUEST_URI'], '/taste-of-qin-yun') === 0) {
    $base_url = '/taste-of-qin-yun';
}
?>
<nav>
    <p>Restaurant</p>
    <a href="<?php echo $base_url; ?>/index.php">Home</a>
    <a href="<?php echo $base_url; ?>/menu.php">Menu</a>
    <a href="<?php echo $base_url; ?>/cart/cart.php">
        <img src="<?php echo $base_url; ?>/images/cart.png" class="cart">
    </a>
</nav>