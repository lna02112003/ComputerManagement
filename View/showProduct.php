<?php
    session_start();
    require_once("../Controller/CategoryController.php");
    require_once("../Controller/ProductController.php");
    require_once("../Controller/ConnectDB.php");

    $categoryController = new CategoryController($conn);

    $productController = new ProductController($conn);

    $productsHot = $productController->selectProductHot();

    
    if (isset($_SESSION['customer'])) {
        $userType = $_SESSION['customer']['type'];
        $userId = $_SESSION['customer']['id'];
        if ($userType == 'customer') {
            $isLoggedIn = true;
        } 
    } else {
        $isLoggedIn = false;
    }

    $categories = $categoryController->selectAllCategories();
    if (isset($_GET['product_id'])) {
        $product_id = $_GET['product_id'];
        $product = $productController->getProductById($product_id);
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
    <link rel="stylesheet" href="../assets/css/product.css">
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
            <div class="data">
                <div class="data_img">
                    <p>
                        <?php 
                            echo $product['category_name'] . " > " . $product['product_name'];
                        ?>
                    </p>
                    <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['product_name']; ?>">
                </div>
                <div class="data_content">
                    <div>
                        <p class="product_data"><?php echo($product['product_name']);?></p>
                        <p class="price_data"><?php echo number_format($product['price_out'], 0, '', ','); ?>,000đ</p>
                        <p class="ram_data"></p><span class="span_title">Ram:</span> <?php echo($product['ram']); ?></p>
                        <p class="storage_data"><span class="span_title">Storage:</span> <?php echo($product['storage']); ?></p>
                        <p class="display_data"><span class="span_title">Display Size:</span> <?php echo($product['display_size']); ?> px</p> 
                        <div class="div-flex">
                            <div class="div-flex-1">
                                <form action="../Controller/ProcessCart.php" method="POST" class="form_quantity" id="quantityForm">
                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                    <button type="button" name="btn_decending" class="btn_decending" onclick="changeQuantity(-1)">-</button>
                                    <input type="text" name="quantity" value="1" class="input_quantity" id="quantityInput" readonly>
                                    <button type="button" name="btn_acending" class="btn_acending" onclick="changeQuantity(1)">+</button>
                                </form>
                            </div>
                            <div class="div-flex-2">
                                <a href="#" class="btn btn-success btn-add" onclick="submitForm()">Add To Cart</a>
                            </div>
                        </div>
                        <div class="tabs">
                            <div class="tab-labels">
                                <span data-id="1" class="span_title">Description</span>
                            </div>
                            <div class="tab-slides">
                                <div id="tab-slide-1" itemprop="description"  class="slide active">
                                    <p><?php echo($product['description']);?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="product-other">
                <section class="upcoming-meetings1" id="meetings">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="section-heading">
                                    <h2 class="product_content">More Products</h2>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="row">
                                    <?php
                                    foreach ($productsHot as $product) {
                                        ?>
                                        <div class="col-lg-4 col-product">
                                            <div class="meeting-item">
                                                <div class="thumb">
                                                    <div class="price">
                                                        <span><?php echo $product['price_out']; ?>000đ</span>
                                                    </div>
                                                    <a href="showProduct.php?product_id=<?php echo $product['product_id']; ?>"><img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['product_name']; ?>" height="350px"></a>
                                                </div>
                                                <div class="down-content">
                                                    <div class="date">
                                                        <h6><?php echo $product['category_name']; ?></h6>
                                                    </div>
                                                    <a href="showProduct.php?product_id=<?php echo $product['product_id']; ?>"><h4><?php echo $product['product_name']; ?></h4></a><br>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        
    </section>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="assets/js/isotope.min.js"></script>
    <script src="assets/js/owl-carousel.js"></script>
    <script src="assets/js/lightbox.js"></script>
    <script src="assets/js/tabs.js"></script>
    <script src="assets/js/video.js"></script>
    <script src="assets/js/slick-slider.js"></script>
    <script src="assets/js/custom.js"></script>
    <script>
        function submitForm() {
            var isLoggedIn = <?php echo $isLoggedIn ? 'true' : 'false'; ?>;

            if (isLoggedIn) {
                var form = document.getElementById('quantityForm');
                form.submit();
            } else {
                window.location.href = 'login.php';
            }
        }
        function changeQuantity(amount) {
            var quantityInput = document.getElementById('quantityInput');
            var currentQuantity = parseInt(quantityInput.value);

            if (currentQuantity + amount > 0) {
                quantityInput.value = currentQuantity + amount;
            }
        }
    </script>
</body>

</html>
