<?php
/**
 * Authors: Harry, Hetarth, Braden, Leon, Uzair
 * Date: April 19
 * Description: Generates the digital receipt containing precise transaction totals and sub-item lists.
 */
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login/login.php");
    exit;
}

require "../includes/connect.php";

$order_id = filter_input(INPUT_GET, 'order_id', FILTER_VALIDATE_INT);
if (!$order_id) {
    header("Location: ../menu.php");
    exit;
}

// Harvest explicit order metadata from database natively
$stmt = $pdo->prepare("SELECT * FROM orders WHERE order_id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    header("Location: ../menu.php");
    exit;
}

// Gather array of exact purchased line items
$itemsStmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
$itemsStmt->execute([$order_id]);
$items = $itemsStmt->fetchAll(PDO::FETCH_ASSOC);

// Structurally rebuild the fractional price constraints accurately 
$total_price = (float) $order['total_price'];
$subtotal = $total_price / 1.1;
$tax = $total_price - $subtotal;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #
        <?= htmlspecialchars($order_id) ?>
    </title>
    <link rel="stylesheet" href="../css/style.css?v=<?= time() ?>">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        .receipt-wrapper {
            max-width: 600px;
            margin: 60px auto;
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border: 2px solid var(--primary);
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px dashed #ddd;
            padding-bottom: 20px;
        }

        .receipt-header h1 {
            color: var(--primary);
            margin-bottom: 10px;
            font-size: 2.2rem;
        }

        .receipt-details {
            margin-bottom: 30px;
        }

        .receipt-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 15px;
        }

        .receipt-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .receipt-table th,
        .receipt-table td {
            text-align: left;
            padding: 12px 5px;
            border-bottom: 1px solid #eee;
        }

        .receipt-table th {
            font-weight: 600;
            color: var(--primary);
        }

        .receipt-totals {
            width: 100%;
            border-top: 2px solid var(--primary);
            padding-top: 20px;
        }

        .receipt-totals .receipt-row {
            font-weight: 500;
            font-size: 16px;
        }

        .receipt-totals .grand-total {
            font-weight: 700;
            font-size: 20px;
            color: var(--primary);
            margin-top: 15px;
        }

        .receipt-actions {
            text-align: center;
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <?php include '../includes/header.php'; ?>
    <main>
        <div class="receipt-wrapper">
            <div class="receipt-header">
                <h1>Payment Successful</h1>
                <p>Thank you for dining with Taste of Qin Yun!</p>
            </div>

            <div class="receipt-details">
                <div class="receipt-row">
                    <span><strong>Order #:</strong>
                        <?= htmlspecialchars($order_id) ?>
                    </span>
                    <span><strong>Date:</strong>
                        <?= htmlspecialchars(date('M d, Y g:i A', strtotime($order['created_at']))) ?>
                    </span>
                </div>
                <div class="receipt-row">
                    <span><strong>Customer:</strong>
                        <?= htmlspecialchars($order['customer_name']) ?>
                    </span>
                    <span><strong>Payment:</strong>
                        <?= htmlspecialchars($order['payment_method']) ?>
                    </span>
                </div>
            </div>

            <table class="receipt-table">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th style="text-align: center;">Qty</th>
                        <th style="text-align: right;">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($items as $item): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($item['product_name']) ?>
                            </td>
                            <td style="text-align: center;">
                                <?= htmlspecialchars($item['quantity']) ?>
                            </td>
                            <td style="text-align: right;">$
                                <?= number_format($item['price'], 2) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="receipt-totals">
                <div class="receipt-row">
                    <span>Subtotal</span>
                    <span>$
                        <?= number_format($subtotal, 2) ?>
                    </span>
                </div>
                <div class="receipt-row">
                    <span>Tax (10%)</span>
                    <span>$
                        <?= number_format($tax, 2) ?>
                    </span>
                </div>
                <div class="receipt-row grand-total">
                    <span>Total Paid</span>
                    <span>$
                        <?= number_format($total_price, 2) ?>
                    </span>
                </div>
            </div>

            <div class="receipt-actions">
                <a href="../login/dashboard.php" class="btn"
                    style="text-decoration:none; display:inline-block; max-width:250px;">View Order History</a>
            </div>
        </div>
    </main>
</body>

</html>