<?php
    require_once("ProductController.php");
    require_once("ConnectDB.php");

    $productController = new ProductController($conn);

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
        $productId = $_GET["id"];

        $result = $productController->deleteProduct($productId);

        if ($result) {
            header("Location: ../View/admin/Product.php");
            exit();
        }
    } else {
        header("Location: ../View/admin/Product.php");
        exit();
    }
?>
