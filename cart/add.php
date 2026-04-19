<?php
session_start();

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

$products = [
    1 => ["name" => "Bruschetta", "price" => 8],
    2 => ["name" => "Garlic Bread", "price" => 6],
    3 => ["name" => "Stuffed Mushrooms", "price" => 10],
    4 => ["name" => "Spaghetti Bolognese", "price" => 15],
    5 => ["name" => "Grilled Salmon", "price" => 22],
    6 => ["name" => "Margherita Pizza", "price" => 14],
    7 => ["name" => "Tiramisu", "price" => 9],
    8 => ["name" => "Cheesecake", "price" => 8],
    9 => ["name" => "Red Wine", "price" => 7]
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