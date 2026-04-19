<?php
session_start();
$cart = $_SESSION['cart'] ?? [];

$total = 0;
foreach ($cart as $item) {
    $qty = $item['qty'] ?? 1;
    $total += $item['price'] * $qty;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body>

    <?php include '../includes/header.php'; ?>

    <main>

        <div id="cart-container">

            <h1>Your Basket</h1>

            <div id="item-container">

                <?php if (empty($cart)): ?>
                    <p>Your cart is empty.</p>
                <?php else: ?>

                    <?php foreach ($cart as $index => $item): ?>
                        <?php $qty = $item['qty'] ?? 1; ?>

                        <div class="cart-item">

                            <div class="col">
                                <div class="cart-item-name"><?= htmlspecialchars($item['name']) ?></div>
                                <div class="cart-item-desc"></div>
                            </div>

                            <div class="col right">
                                <div class="money-display">
                                    $<?= number_format($item['price'] * $qty, 2) ?>
                                </div>

                                <form method="post" action="update.php" class="quantity-container">

                                    <input type="hidden" name="index" value="<?= $index ?>">

                                    <button name="action" value="minus" class="minus">-</button>

                                    <span class="quantity"><?= $qty ?></span>

                                    <button name="action" value="add" class="add">+</button>

                                </form>

                            </div>

                        </div>


                    <?php endforeach; ?>

                <?php endif; ?>

            </div>

            <!-- TOTAL -->
            <div id="total-cost-container">

                <div class="col">
                    <h2>Total</h2>
                    <p>Subtotal</p>
                    <p>Tax</p>
                </div>

                <div class="col">
                    <h2>$<?= number_format($total * 1.1, 2) ?></h2>
                    <div>$<?= number_format($total, 2) ?></div>
                    <div>$<?= number_format($total * 0.1, 2) ?></div>
                </div>

                <div class="col">
                    <a href="checkout.php" class="cart-button big"
                        style="display:inline-block; text-align:center; text-decoration:none; box-sizing: border-box;">Checkout</a>
                    <form method="post" action="clear_cart.php">
                        <button type="submit" class="cart-button">Clear Cart</button>
                    </form>
                </div>

            </div>

        </div>

    </main>

</body>

</html>