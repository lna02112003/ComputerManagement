<?php
    require_once("OrderController.php");
    require_once("ConnectDB.php");

    $order_id = $_GET["order_id"];

    $orderController = new OrderController($conn);

    $result = $orderController->MoneyPay($order_id);

    if ($result){
        header("Location: ../View/index.php");
        exit();
    }else{
        header("Location: ../View/customer/Order.php");
        exit();
    }
?>
