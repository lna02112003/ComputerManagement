<?php
    require_once("OrderController.php");
    require_once("ConnectDB.php");

    $order_id = $_GET["order_id"];

    $orderController = new OrderController($conn);

    $result = $orderController->VNPay($order_id);
    header('Location: ' . $result);

?>