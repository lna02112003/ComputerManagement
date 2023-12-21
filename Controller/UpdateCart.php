<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);

    $productId = $data['productId'];
    $quantity = $data['quantity'];

    $cart = isset($_COOKIE['cart']) ? json_decode($_COOKIE['cart'], true) : [];

    foreach ($cart as &$cartItem) {
        if (isset($cartItem['product_id']) && $cartItem['product_id'] == $productId) {
            $cartItem['quantity'] = $quantity;
        }
    }

    setcookie('cart', json_encode($cart), time() + (86400 * 30), "/");

    echo json_encode(['success' => true]);
}
?>
