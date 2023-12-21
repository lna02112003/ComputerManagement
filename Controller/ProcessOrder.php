<?php
    session_start();
    require_once("OrderController.php");
    require_once("ConnectDB.php");


    $orderController = new OrderController($conn);

    if (isset($_SESSION['customer'])) {
        $orderController->SaveOrder();
        header("Location: ../View/customer/Order.php");
        exit();
    } else {
        header("Location: ../View/login.php");
        exit();
    }
?>
