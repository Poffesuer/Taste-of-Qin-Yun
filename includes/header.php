<?php
$base_url = '';
if (strpos($_SERVER['REQUEST_URI'], '/taste-of-qin-yun') === 0) {
    $base_url = '/taste-of-qin-yun';
}
?>
<nav>
    <img src="<?php echo $base_url; ?>/images/logo.png" class="logo">
    <p>Taste Of Qinyun</p>
    <a href="<?php echo $base_url; ?>/index.php">Home</a>
    <a href="<?php echo $base_url; ?>/menu.php">Menu</a>
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="<?php echo $base_url; ?>/login/logout.php">Logout</a>
    <?php else: ?>
        <a href="<?php echo $base_url; ?>/login/login.php">Login</a>
    <?php endif; ?>
    <a href="<?php echo $base_url; ?>/cart/cart.php">
        <img src="<?php echo $base_url; ?>/images/cart.png" class="cart">
    </a>
</nav>