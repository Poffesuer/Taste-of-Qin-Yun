<?php
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

$ordersStmt = $pdo->query(
    'SELECT order_id, customer_name, email, phone, address, total_price, payment_method, order_status, created_at
     FROM orders
     ORDER BY created_at DESC'
);
$orders = $ordersStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Orders</title>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>
    <?php include __DIR__ . '/../includes/header.php'; ?>

    <main class="admin-dashboard-main">
        <div class="admin-dashboard-inner">
            <h1 class="admin-dashboard-title">Orders</h1>
            <p class="admin-dashboard-meta">Signed in as <?php echo htmlspecialchars($_SESSION['username'] ?? '', ENT_QUOTES, 'UTF-8'); ?>.</p>

            <?php if (count($orders) === 0): ?>
                <p class="switch-text">No orders in the database yet.</p>
            <?php else: ?>
                <div class="admin-orders-scroll">
                    <table class="admin-orders-table">
                        <thead>
                            <tr>
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
                                <tr>
                                    <td><?php echo htmlspecialchars((string) ($o['order_id'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars((string) ($o['customer_name'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars((string) ($o['email'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars((string) ($o['phone'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars((string) ($o['address'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td>$<?php echo htmlspecialchars(number_format((float) ($o['total_price'] ?? 0), 2), ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars((string) ($o['payment_method'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars((string) ($o['order_status'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td><?php echo htmlspecialchars((string) ($o['created_at'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <p class="switch-text" style="margin-top: 1.5rem;">
                <a href="../login/logout.php" class="btn" style="display:inline-block; text-align:center; text-decoration:none;">Logout</a>
            </p>
        </div>
    </main>
</body>

</html>
