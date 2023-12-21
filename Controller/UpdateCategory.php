<?php

require_once("CategoryController.php");
require_once("ConnectDB.php");

$categoryController = new CategoryController($conn);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $categoryId = $_POST["category_id"];
    $categoryName = $_POST["category_name"];
    $description = $_POST["description"];

    // Validate and sanitize the input data as needed

    $result = $categoryController->updateCategory($categoryId, $categoryName, $description);

    if ($result) {
        header("Location: ../View/admin/Category.php");
        exit();
    } else {
        header("Location: ../View/admin/editCategory.php");
        exit();
    }
} else {
    header("Location: ../View/admin/editCategory.php");
    exit();
}
?>
