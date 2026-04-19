<?php
/**
 * Authors: Harry, Hetarth, Braden, Leon, Uzair
 * Date: April 19
 * Description: Backend endpoint to process incoming requests and add distinct menu items to the session cart array via AJAX.
 */
session_start();

$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

$products = [
    1 => ["name" => "Traditional Liangpi", "price" => 9.38],
    2 => ["name" => "Traditional Wide Liangpi", "price" => 10.00],
    3 => ["name" => "Steamed Rice Noodle", "price" => 10.00],
    4 => ["name" => "Spinach Liangpi", "price" => 10.00],
    5 => ["name" => "Liangpi in Sesame Sauce", "price" => 10.00],
    6 => ["name" => "Liangpi in Minced Pork Soup", "price" => 12.50],
    7 => ["name" => "Pulled Pork Mo", "price" => 7.50],
    8 => ["name" => "Lamb Mo", "price" => 10.63],
    9 => ["name" => "Saucy Pork Mo", "price" => 8.75]
];

if ($id === false || !isset($products[$id])) {
    echo json_encode(["error" => "Invalid product"]);
    exit;
}

// Statically maps the targeted REST payload to robust backend dictionaries
$product = $products[$id];

// Instantiates pristine state containers recursively if none exists
$_SESSION['cart'] = $_SESSION['cart'] ?? [];

$found = false;

foreach ($_SESSION['cart'] as $index => $item) {
    if ($item['name'] === $product['name']) {
        $_SESSION['cart'][$index]['qty'] = ($_SESSION['cart'][$index]['qty'] ?? 1) + 1;
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

$cart_count = 0;
foreach ($_SESSION['cart'] as $item) {
    $cart_count += $item['qty'] ?? 1;
}

echo json_encode(["success" => true, "cart_count" => $cart_count]);
exit;
?>