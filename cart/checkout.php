<?php
/**
 * Authors: Harry, Hetarth, Braden, Leon, Uzair
 * Date: April 19
 * Description: Secures the checkout flow, displays the order summary, and handles user payment validation.
 */
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}
$cart = $_SESSION['cart'] ?? [];

$total = 0;
foreach ($cart as $item) {
    $qty = $item['qty'] ?? 1;
    $total += $item['price'] * $qty;
}

require "../includes/connect.php";

$success_message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $contact = $_POST['contact'] ?? '';
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $customer_name = trim($first_name . ' ' . $last_name);
    $address = $_POST['address'] ?? '';
    $total_price = $total * 1.1;

    $stmt = $pdo->prepare("INSERT INTO orders (customer_name, email, address, total_price, payment_method, order_status) VALUES (?, ?, ?, ?, 'Credit Card', 'Pending')");
    $stmt->execute([$customer_name, $contact, $address, $total_price]);

    $order_id = $pdo->lastInsertId();

    $item_stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_name, price, quantity) VALUES (?, ?, ?, ?)");
    foreach ($cart as $item) {
        $qty = $item['qty'] ?? 1;
        $item_stmt->execute([$order_id, $item['name'], $item['price'], $qty]);
    }

    $_SESSION['cart'] = [];
    $cart = [];
    $success_message = "Thank you for your purchase! Your order has been placed successfully.";
}

$prefill_email = $_SESSION['email'] ?? '';
$prefill_first = '';
$prefill_last = '';
if (!empty($_SESSION['username'])) {
    $parts = explode(' ', $_SESSION['username']);
    $prefill_first = $parts[0] ?? '';
    $prefill_last = $parts[1] ?? '';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <div class="checkout-wrapper">
            <h1 class="checkout-title">Checkout</h1>
            <?php if ($success_message): ?>
                <div class="success-message">
                    <h2><?= htmlspecialchars($success_message) ?></h2>
                    <a href="../menu.php" class="cart-button"
                        style="text-decoration:none; display:inline-block; margin-top:20px;">Back to Menu</a>
                </div>
            <?php else: ?>
                <form method="post" action="checkout.php" class="checkout-container">
                    <div class="checkout-left">
                        <section class="checkout-section">
                            <h2>Contact</h2>
                            <div class="checkout-input-group full">
                                <input type="text" name="contact" id="contact" placeholder="Email or phone number"
                                    value="<?= htmlspecialchars($prefill_email) ?>" required>
                                <span class="error-msg" id="error-contact"></span>
                            </div>
                            <div class="checkout-row">
                                <div class="checkout-input-group half">
                                    <input type="text" name="first_name" id="first_name" placeholder="First Name"
                                        value="<?= htmlspecialchars($prefill_first) ?>" required>
                                    <span class="error-msg" id="error-first_name"></span>
                                </div>
                                <div class="checkout-input-group half">
                                    <input type="text" name="last_name" id="last_name" placeholder="Last Name"
                                        value="<?= htmlspecialchars($prefill_last) ?>" required>
                                    <span class="error-msg" id="error-last_name"></span>
                                </div>
                            </div>
                        </section>
                        <section class="checkout-section">
                            <h2>Address</h2>
                            <div class="checkout-input-group full">
                                <input type="text" name="address" id="address" placeholder="Address" required>
                                <span class="error-msg" id="error-address"></span>
                            </div>
                        </section>
                        <section class="checkout-section">
                            <h2>Credit Card</h2>
                            <div class="checkout-box">
                                <div class="checkout-input-group full">
                                    <input type="text" name="cc_number" id="cc_number" placeholder="Card number" required>
                                    <span class="error-msg" id="error-cc_number"></span>
                                </div>
                                <div class="checkout-row">
                                    <div class="checkout-input-group half">
                                        <input type="text" name="cc_exp" id="cc_exp" placeholder="Expiration date (MM/YY)"
                                            required>
                                        <span class="error-msg" id="error-cc_exp"></span>
                                    </div>
                                    <div class="checkout-input-group half">
                                        <input type="text" name="cc_cvc" id="cc_cvc" placeholder="Security code" required>
                                        <span class="error-msg" id="error-cc_cvc"></span>
                                    </div>
                                </div>
                                <div class="checkout-input-group full">
                                    <input type="text" name="cc_name" id="cc_name" placeholder="Name on card" required>
                                    <span class="error-msg" id="error-cc_name"></span>
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="checkout-right">
                        <div class="checkout-summary-box">
                            <?php foreach ($cart as $index => $item): ?>
                                <?php $qty = $item['qty'] ?? 1; ?>
                                <div class="summary-item">
                                    <div class="summary-img-box">
                                        <img src="<?= htmlspecialchars($item['image'] ?? '../images/cart.png') ?>" alt="item">
                                    </div>
                                    <div class="summary-details">
                                        <div class="summary-name"><?= htmlspecialchars($item['name']) ?></div>
                                        <div class="summary-desc"></div>
                                    </div>
                                    <div class="summary-price-qty">
                                        <div class="summary-price">$<?= number_format($item['price'] * $qty, 2) ?></div>
                                        <div class="summary-qty-indicator">Qty: <?= $qty ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div class="summary-totals">
                                <div class="summary-total-row">
                                    <span>Subtotal</span>
                                    <span>$<?= number_format($total, 2) ?></span>
                                </div>
                                <div class="summary-total-row">
                                    <span>Tax</span>
                                    <span>$<?= number_format($total * 0.1, 2) ?></span>
                                </div>
                                <div class="summary-total-row grand-total">
                                    <span>Total</span>
                                    <span>$<?= number_format($total * 1.1, 2) ?></span>
                                </div>
                            </div>
                            <button type="submit" class="cart-button big checkout-purchase-btn">Purchase</button>
                        </div>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </main>
    <script src="../js/checkout-validator.js"></script>
</body>

</html>