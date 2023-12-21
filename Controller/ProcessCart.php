<?php
require_once("CartController.php");
require_once("ConnectDB.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST["product_id"];
    $quantity = $_POST["quantity"];

    $cartController = new CartController($conn);

    $result = $cartController->addToCart($product_id, $quantity);

    $cart = $cartController->getCart();

    if ($result) {
        header("Location: ../View/customer/Cart.php");
        exit();
    }
}
?>
