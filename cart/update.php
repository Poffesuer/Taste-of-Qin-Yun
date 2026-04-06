<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $index = filter_input(INPUT_POST, 'index', FILTER_VALIDATE_INT);
    $action = $_POST['action'] ?? '';

    if (isset($_SESSION['cart'][$index])) {
        if ($action === 'add') {
            $_SESSION['cart'][$index]['qty']++;
        } elseif ($action === 'minus') {
            $_SESSION['cart'][$index]['qty']--;
            if ($_SESSION['cart'][$index]['qty'] <= 0) {
                unset($_SESSION['cart'][$index]);
                // Reindex array to prevent gaps
                $_SESSION['cart'] = array_values($_SESSION['cart']);
            }
        }
    }
}

header('Location: cart.php');
exit;
?>