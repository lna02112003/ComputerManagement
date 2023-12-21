<?php
require_once("ProductController.php");
require_once("ConnectDB.php");

$productController = new ProductController($conn);

if (isset($_GET['category_id']) && isset($_GET['query'])) {
    $categoryId = $_GET['category_id'];
    $query = $_GET['query'];
    $result = $productController->searchProductByCategoryId($categoryId, $query);

    if (!empty($result)) {
        foreach ($result as $product) {
            echo '<div class="col-lg-6">';
            echo '<div class="meeting-item">';
            echo '<div class="thumb">';
            echo '<div class="price">';
            echo '<span>' . $product['price_in'] . '000đ</span>';
            echo '</div>';
            echo '<a href="meeting-details.html"><img src="../' . $product['image_url'] . '" alt="' . $product['product_name'] . '" height="350px"></a>';
            echo '</div>';
            echo '<div class="down-content">';
            echo '<div class="date">';
            echo '<h6>' . $product['category_name'] . '</h6>';
            echo '</div>';
            echo '<a href="meeting-details.html"><h4>' . $product['product_name'] . '</h4></a><br>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo 'Không có kết quả tìm kiếm.';
    }
}
?>
