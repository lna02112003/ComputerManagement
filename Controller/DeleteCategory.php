<?php
    require_once("CategoryController.php");
    require_once("ConnectDB.php");

    $categoryController = new CategoryController($conn);

    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["id"])) {
        $categoryId = $_GET["id"];

        $result = $categoryController->deleteCategory($categoryId);

        if ($result) {
            header("Location: ../View/admin/Category.php");
            exit();
        }
    } else {
        header("Location: ../View/admin/Category.php");
        exit();
    }
?>
