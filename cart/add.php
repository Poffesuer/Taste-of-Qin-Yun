<?php
session_start();

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

$products = [
    1 => ["name" => "Bruschetta", "price" => 8],
    2 => ["name" => "Pizza", "price" => 12]
];

if ($id === false || !isset($products[$id])) {
    header("Location: menu.php");
    exit;
}

$product = $products[$id];

$_SESSION['cart'] = $_SESSION['cart'] ?? [];

$found = false;

foreach ($_SESSION['cart'] as &$item) {
    if ($item['name'] === $product['name']) {
        $item['qty'] = ($item['qty'] ?? 1) + 1;
        $found = true;
        break;
    }
}

if (!$found) {
    $_SESSION['cart'][] = [
        'name' => $product['name'],
        'price' => $product['price'],
        'qty' => 1
    ];
}

header("Location: ../menu.php");
exit;
?>