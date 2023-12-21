<?php

require_once("OrderController.php");
require_once("ConnectDB.php");

$orderController = new OrderController($conn);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $order_id = $_POST["order_id"];
    $total_order = $_POST["total_order"];
    $status = $_POST["status"];
    $description = $_POST["description"];
    $cleaned_total_order = preg_replace("/[^0-9.]/", "", $total_order);

    $cleaned_total_order = rtrim($cleaned_total_order, '0');

    $float_total_order = floatval($cleaned_total_order);
    if ($status == 'successful') {
        $status = 'Thanh toán thành công';
    }else{
        $status = 'Đang chờ thanh toán';
    }
    if ($description == 'cash'){
        $description = 'Thanh toán bằng tiền mặt';
    }else{
        $description = 'Thanh toán bằng VNPay';
    }

    $result = $orderController->updateOrder($order_id, $float_total_order, $status, $description);
    if ($result) {
        header("Location: ../View/admin/Order.php");
        exit();
    }else{
        header("Location: ../View/admin/editOrder.php");
        exit();
    }
} else {
    header("Location: ../View/admin/editOrder.php");
    exit();
}
?>
