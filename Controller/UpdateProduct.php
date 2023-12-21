<?php
require_once("ProductController.php");
require_once("ConnectDB.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $productId = $_POST['product_id'];

    $productController = new ProductController($conn);

    $existingProduct = $productController->selectProductById($productId);

    $category_id = $_POST['category_id'];
    $product_name = $_POST['product_name'];
    $price_in = $_POST['price_in'];
    $price_out = $_POST['price_out'];
    $ram = $_POST['ram'];
    $storage = $_POST['storage'];
    $quantity = $_POST['quantity'];
    $display_size = $_POST['display_size'];
    $description = $_POST['description'];
    $hot = isset($_POST['hot']) ? $_POST['hot'] : 0;
    $image = $_FILES["image"];
    if (!empty($_FILES['image']['name'])) {
        $uploadDir = "../Storage/Product_Image/";
        $image_url = $uploadDir . basename($image["name"]);

        move_uploaded_file($image["tmp_name"], $image_url);
    } else {
        $image_url = $existingProduct['image_url'];
    }
    $success = $productController->updateProduct($productId, $category_id, $product_name, $price_in, $price_out, $ram, $storage, $quantity, $display_size, $description, $hot, $image_url);

    if ($success) {
        header("Location: ../View/admin/Product.php");
        exit();
    } else {
        echo "Error updating product.";
    }
} else {
    header("Location: ../View/admin/editProduct.php");
    exit();
}
?>
