<?php
    require_once("OrderController.php");
    require_once("ConnectDB.php");

    $orderController = new OrderController($conn);

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
        $order_id = $_GET["id"];

        $result = $orderController->deleteOrder($order_id);

        if ($result) {
            header("Location: ../View/admin/Order.php");
            exit();
        }
    } else {
        header("Location: ../View/admin/Order.php");
        exit();
    }
?>
