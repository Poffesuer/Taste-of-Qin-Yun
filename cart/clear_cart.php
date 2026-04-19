<?php
/**
 * Authors: Harry, Hetarth, Braden, Leon, Uzair
 * Date: April 19
 * Description: Instantly empties all active items from the user's session cart.
 */
session_start();

unset($_SESSION['cart']);

header("Location: cart.php");
exit;
?>