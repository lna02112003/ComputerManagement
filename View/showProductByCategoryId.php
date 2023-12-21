<?php
session_start();
require_once("../Controller/CategoryController.php");
require_once("../Controller/ProductController.php");
require_once("../Controller/ConnectDB.php");

$categoryController = new CategoryController($conn);
$productController = new ProductController($conn);

$categories = $categoryController->selectAllCategories();

if (isset($_GET['category_id'])) {
    $categoryId = $_GET['category_id'];
    $categorySelect = $categoryController->selectCategoryById($categoryId);
    $products = $categoryController->selectProductsByCategoryId($categoryId);
}

if (isset($_SESSION['customer'])) {
    $userType = $_SESSION['customer']['type'];
    $userId = $_SESSION['customer']['id'];
    if ($userType == 'customer') {
        $isLoggedIn = true;
    } 
} else {
    $isLoggedIn = false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="TemplateMo">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <title>Laptop e-commerce Website</title>
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/fontawesome.css">
    <link rel="stylesheet" href="../assets/css/templatemo-edu-meeting.css">
    <link rel="stylesheet" href="../assets/css/owl.css">
    <link rel="stylesheet" href="../assets/css/lightbox.css">
</head>

<body>
    <header class="header-area header-sticky">
      <div class="container">
          <div class="row">
              <div class="col-12">
                  <nav class="main-nav">
                      <a href="index.php" class="logo">
                          Laptop e-commerce Website
                      </a>
                      <ul class="nav">
                          <li class=""><a href="index.php" class="active">Home</a></li>
                          <li class="has-sub">
                              <a href="javascript:void(0)">Category</a>
                              <ul class="sub-menu">
                                <?php
                                  foreach ($categories as $category) {
                                  ?>
                                      <li><a href="showProductByCategoryId.php?category_id=<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></a></li>
                                  <?php
                                  }
                                ?>
                            </ul>
                          </li>
                          <li class=""><a href="#contact">Contact Us</a></li> 
                          <?php
                            if ($isLoggedIn) {
                              
                                echo '
                                  <li><a href="/ComputerManagement/View/customer/Cart.php">Cart</a></li>
                                  <li class=""><a href="../Controller/ProcessLogout.php">Logout</a></li>
                                ';

                            } else {
                                echo '<li class=""><a href="login.php">Sign In</a></li>';
                            }
                          ?>
                      </ul>        
                  </nav>
              </div>
          </div>
      </div>
  </header>

     <section class="our-courses" id="courses">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-heading">
                        <h2 class="text-center">Product By <?php echo ($categorySelect['category_name']); ?></h2>
                        <div class="mb-3">
                            <li class="d-none d-sm-block">
                                <form id="searchForm">
                                    <div class="app-search-box">
                                        <div class="input-group">
                                            <input type="hidden" id="categoryId" value="<?php echo $categorySelect['category_id']; ?>">
                                            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </li>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="row category-products">
                        <?php
                        foreach ($products as $product) {
                        ?>
                            <div class="col-lg-4">
                                <div class="meeting-item">
                                    <div class="thumb">
                                        <a href="showProduct.php?product_id=<?php echo $product['product_id']; ?>"><img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['product_name']; ?>" height="350px"></a>
                                    </div>
                                    <div class="down-content">
                                        <div class="date">
                                            <h6><?php echo $product['category_name']; ?></h6>
                                        </div>
                                        <a href="showProduct.php?product_id=<?php echo $product['product_id']; ?>"><h4><?php echo $product['product_name']; ?></h4></a><br>
                                        <div class="price">
                                            <span><?php echo $product['price_out']; ?>000đ</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="row" id="searchResults">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        document.getElementById('searchForm').addEventListener('submit', function (e) {
            e.preventDefault();
            var categoryId = document.getElementById('categoryId').value;
            var keyword = document.getElementById('searchInput').value;

            searchProducts(categoryId, keyword);
        });

        function searchProducts(categoryId, keyword) {
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function () {
                console.log(xhr.readyState, xhr.status); // Kiểm tra trạng thái và mã status
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(xhr.responseText); // Kiểm tra dữ liệu trả về
                    var hasResults = xhr.responseText.trim() !== '';

                    document.querySelector('.category-products').style.display = hasResults ? 'none' : 'block';
                    document.getElementById('searchResults').innerHTML = xhr.responseText;

                    if (!hasResults) {
                        document.querySelector('.category-products').style.display = 'block';
                    }
                }
            };

            xhr.open('GET', '../Controller/ProcessSearch.php?category_id=' + categoryId + '&query=' + keyword, true);
            xhr.send();
        }
    </script>
</body>

</html>
