<?php
    require_once("UserController.php");
    require_once("ConnectDB.php");

    $userController = new UserController($conn);

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
        $customer_id = $_GET["id"];

        $result = $userController->deleteCustomer($customer_id);

        if ($result) {
            header("Location: ../View/admin/AccountCustomer.php");
            exit();
        }
    } else {
        header("Location: ../View/admin/AccountCustomer.php");
        exit();
    }
?>
