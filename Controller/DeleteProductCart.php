<?php
require_once("CartController.php");
require_once("ConnectDB.php");

if (isset($_GET["product_id"])) {
    $product_id = $_GET["product_id"];

    $cartController = new CartController($conn);

    $result = $cartController->deleteProduct($product_id);


    if ($result) {
        header("Location: ../View/customer/Cart.php");
        exit();
    } else {
        echo "Failed to delete product from cart.";
        exit();
    }
} else {
    header("Location: ../View/customer/Cart.php");
    exit();
}

?>
