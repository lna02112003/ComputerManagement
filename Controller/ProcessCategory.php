<?php
require_once("CategoryController.php");
require_once("ConnectDB.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $categoryName = $_POST["category_name"];
    $description = $_POST["description"];


    $categoryController = new CategoryController($conn);

    $result = $categoryController->addCategory($categoryName, $description);

    if ($result) {
        header("Location: ../View/admin/Category.php");
        exit();
    } else {
        header("Location: ../View/admin/addCategory.php");
        exit();
    }
}
?>
