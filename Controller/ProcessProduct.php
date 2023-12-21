<?php
require_once("ProductController.php");
require_once("ConnectDB.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_id = $_POST["category_id"];
    $product_name = $_POST["product_name"];
    $price_in = $_POST["price_in"];
    $price_out = $_POST["price_out"];
    $ram = $_POST["ram"];
    $storage = $_POST["storage"];
    $quantity = $_POST["quantity"];
    $display_size = $_POST["display_size"];
    $description = $_POST["description"];
    $image = $_FILES["image"];

    if ($image["error"] == UPLOAD_ERR_OK) {
        $uploadDir = "../Storage/Product_Image/";
        $uploadPath = $uploadDir . basename($image["name"]);

        move_uploaded_file($image["tmp_name"], $uploadPath);
        $productController = new ProductController($conn);
        $result = $productController->addProduct($category_id, $product_name, $price_in, $price_out, $ram, $storage, $quantity, $display_size, $description, $uploadPath);

        if ($result) {
            header("Location: ../View/admin/Product.php");
            exit();
        } else {
            header("Location: ../View/admin/addProduct.php");
            exit();
        }
    }
}
?>
