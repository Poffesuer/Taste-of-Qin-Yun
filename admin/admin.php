<?php
/**
 * Authors: Harry, Hetarth, Braden, Leon, Uzair
 * Date: April 19
 * Description: Secure administrator dashboard to manage incoming restaurant orders and analytics.
 */
session_start();

require __DIR__ . '/../includes/connect.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login/login.php');
    exit;
}

$adminStmt = $pdo->prepare('SELECT is_admin FROM login_details WHERE id = ?');
$adminStmt->execute([(int) $_SESSION['user_id']]);
$adminRow = $adminStmt->fetch(PDO::FETCH_ASSOC);

if (!$adminRow || empty((int) $adminRow['is_admin'])) {
    header('Location: ../login/dashboard.php');
    exit;
}

// Performs a bulk data extraction querying all recorded chronological transactions massively
$ordersStmt = $pdo->query(
    'SELECT order_id, customer_name, email, phone, address, total_price, payment_method, order_status, created_at
     FROM orders
     ORDER BY created_at DESC'
);
$orders = $ordersStmt->fetchAll(PDO::FETCH_ASSOC);

$orderItemsStmt = $pdo->query(
    'SELECT order_id, product_name, price, quantity
     FROM order_items
     ORDER BY item_id ASC'
);
$orderItemsRows = $orderItemsStmt->fetchAll(PDO::FETCH_ASSOC);
$orderItemsByOrderId = [];

// Explicit multidimensional restructuring tracking complex cart inventories per unique ID universally
foreach ($orderItemsRows as $itemRow) {
    $itemOrderId = (int) ($itemRow['order_id'] ?? 0);
    if (!isset($orderItemsByOrderId[$itemOrderId])) {
        $orderItemsByOrderId[$itemOrderId] = [];
    }
    $orderItemsByOrderId[$itemOrderId][] = $itemRow;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Orders</title>
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="admin-dashboard-main">
        <div class="admin-dashboard-inner">
            <h1 class="admin-dashboard-title">Orders</h1>
            <p class="admin-dashboard-meta">Signed in as
                <?php echo htmlspecialchars($_SESSION['username'] ?? '', ENT_QUOTES, 'UTF-8'); ?>.
            </p>

            <?php if (count($orders) === 0): ?>
                <p class="switch-text">No orders in the database yet.</p>
            <?php else: ?>
                <div class="admin-orders-scroll">
                    <table class="admin-orders-table">
                        <thead>
                            <tr>
                                <th scope="col">Details</th>
                                <th scope="col">Order #</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Address</th>
                                <th scope="col">Total</th>
                                <th scope="col">Payment</th>
                                <th scope="col">Status</th>
                                <th scope="col">Placed</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $o): ?>
                                <?php $orderId = (int) ($o['order_id'] ?? 0); ?>
                                <?php $orderItems = $orderItemsByOrderId[$orderId] ?? []; ?>
                                <tr>
                                    <td>
                                        <button type="button" class="btn order-items-toggle"
                                            data-target="order-items-<?php echo htmlspecialchars((string) $orderId, ENT_QUOTES, 'UTF-8'); ?>"
                                            aria-expanded="false">
                                            View Items
                                        </button>
                                    </td>
                                    <td><?php echo htmlspecialchars((string) ($o['order_id'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                    <td><?php echo htmlspecialchars((string) ($o['customer_name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                    <td><?php echo htmlspecialchars((string) ($o['email'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars((string) ($o['phone'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars((string) ($o['address'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                    <td>$<?php echo htmlspecialchars(number_format((float) ($o['total_price'] ?? 0), 2), ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                    <td><?php echo htmlspecialchars((string) ($o['payment_method'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                    <td><?php echo htmlspecialchars((string) ($o['order_status'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                    <td><?php echo htmlspecialchars((string) ($o['created_at'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                </tr>
                                <tr id="order-items-<?php echo htmlspecialchars((string) $orderId, ENT_QUOTES, 'UTF-8'); ?>"
                                    class="order-items-row">
                                    <td colspan="10">
                                        <div class="order-items-wrap">
                                            <?php if (count($orderItems) === 0): ?>
                                                <p>No items found for this order.</p>
                                            <?php else: ?>
                                                <table class="order-items-table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Product</th>
                                                            <th scope="col">Price</th>
                                                            <th scope="col">Quantity</th>
                                                            <th scope="col">Amount Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($orderItems as $item): ?>
                                                            <?php
                                                            $itemPrice = (float) ($item['price'] ?? 0);
                                                            $itemQuantity = (int) ($item['quantity'] ?? 0);
                                                            ?>
                                                            <tr>
                                                                <td><?php echo htmlspecialchars((string) ($item['product_name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?>
                                                                </td>
                                                                <td>$<?php echo htmlspecialchars(number_format($itemPrice, 2), ENT_QUOTES, 'UTF-8'); ?>
                                                                </td>
                                                                <td><?php echo htmlspecialchars((string) $itemQuantity, ENT_QUOTES, 'UTF-8'); ?>
                                                                </td>
                                                                <td>$<?php echo htmlspecialchars(number_format($itemPrice * $itemQuantity, 2), ENT_QUOTES, 'UTF-8'); ?>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <p class="switch-text" style="margin-top: 1.5rem;">
                <a href="../login/logout.php" class="btn"
                    style="display:inline-block; text-align:center; text-decoration:none;">Logout</a>
            </p>
        </div>
    </main>
    <script>
        const orderToggleButtons = document.querySelectorAll('.order-items-toggle');
        orderToggleButtons.forEach((button) => {
            button.addEventListener('click', () => {
                const targetId = button.getAttribute('data-target');
                const targetRow = targetId ? document.getElementById(targetId) : null;

                if (!targetRow) {
                    return;
                }

                const isExpanded = targetRow.style.display === 'table-row';
                targetRow.style.display = isExpanded ? 'none' : 'table-row';
                button.setAttribute('aria-expanded', isExpanded ? 'false' : 'true');
                button.textContent = isExpanded ? 'View Items' : 'Hide Items';
            });
        });
    </script>
</body>

</html>